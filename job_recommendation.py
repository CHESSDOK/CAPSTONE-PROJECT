from sklearn.cluster import DBSCAN
from sklearn.impute import SimpleImputer
import pandas as pd
from sqlalchemy import create_engine
import json
from rapidfuzz import process, fuzz
import sys

# MySQL database connection using SQLAlchemy
def get_db_connection():
    try:
        # Update the connection string as per your MySQL configuration
        engine = create_engine('mysql+mysqlconnector://root:@localhost/peso')
        connection = engine.connect()
        return connection
    except Exception as err:
        print(json.dumps({"error": f"Database connection error: {err}"}))
        sys.exit(1)

# Fetch applicant profiles from the database
def fetch_applicant_profiles(conn):
    try:
        query = "SELECT * FROM applicant_profile"
        return pd.read_sql(query, conn)
    except Exception as e:
        print(json.dumps({"error": f"Error fetching applicant profiles: {e}"}))
        return pd.DataFrame()  # Return an empty DataFrame on error

# Fetch job postings from the database
def fetch_job_postings(conn):
    try:
        query = "SELECT * FROM job_postings WHERE is_active = 1"
        return pd.read_sql(query, conn)
    except Exception as e:
        print(json.dumps({"error": f"Error fetching job postings: {e}"}))
        return pd.DataFrame()  # Return an empty DataFrame on error

# Function to perform fuzzy matching
def fuzzy_merge(applicant_occupations, job_titles, threshold=80):
    matches = []
    for occupation in applicant_occupations:
        match = process.extractOne(occupation, job_titles, scorer=fuzz.token_sort_ratio)
        if match and match[1] >= threshold:
            matches.append({'preferred_occupation': occupation, 'job_title': match[0], 'similarity': match[1]})
    return pd.DataFrame(matches)

# Main function to get job recommendations for the logged-in user
def get_logged_in_applicant_recommendations(logged_in_user_id):
    conn = get_db_connection()
    if conn is None:
        return json.dumps({"error": "Failed to connect to the database"})

    try:
        # Fetch data
        applicant_profiles = fetch_applicant_profiles(conn)
        job_postings = fetch_job_postings(conn)

        if applicant_profiles.empty or job_postings.empty:
            return json.dumps({"error": "No data available for applicants or job postings"})

        # Normalize the columns before processing
        applicant_profiles['preferred_occupation'] = applicant_profiles['preferred_occupation'].str.lower().str.strip()
        job_postings['job_title'] = job_postings['job_title'].str.lower().str.strip()

        # Split 'preferred_occupation' into multiple rows
        applicant_profiles = applicant_profiles.assign(
            preferred_occupation=applicant_profiles['preferred_occupation'].str.split(',')
        ).explode('preferred_occupation')

        # Further normalize after splitting
        applicant_profiles['preferred_occupation'] = applicant_profiles['preferred_occupation'].str.lower().str.strip()

        # Perform fuzzy matching
        matched_df = fuzzy_merge(applicant_profiles['preferred_occupation'].unique(), job_postings['job_title'].unique(), threshold=80)

        if matched_df.empty:
            return json.dumps({"error": "No fuzzy matches found between applicants and job postings"})

        # Merge applicant_profiles with matched_df to filter relevant applicants
        applicant_matched = pd.merge(applicant_profiles, matched_df, on='preferred_occupation', how='inner')
        data = pd.merge(applicant_matched, job_postings, left_on='job_title', right_on='job_title', how='inner')

        if data.empty:
            return json.dumps({"error": "No matches found between applicants and job postings after fuzzy matching"})

        # Handle missing or NaN values
        data['age'] = pd.to_numeric(data['age'], errors='coerce')
        data['expected_salary'] = pd.to_numeric(data['expected_salary'], errors='coerce')
        data['salary'] = pd.to_numeric(data['salary'], errors='coerce')

        # For clustering, use 'age' and 'expected_salary'
        data_cleaned = data[['age', 'expected_salary']].copy()

        # Imputation for missing data
        imputer = SimpleImputer(strategy='mean')
        data_cleaned[['age', 'expected_salary']] = imputer.fit_transform(data_cleaned[['age', 'expected_salary']])

        # Prepare data for clustering
        features = data_cleaned[['age', 'expected_salary']]

        # Apply DBSCAN clustering
        dbscan = DBSCAN(eps=5, min_samples=2)
        clusters = dbscan.fit_predict(features)
        data_cleaned['cluster'] = clusters

        # Assign cluster back to the merged data
        data = data.assign(cluster=data_cleaned['cluster'])

        # Find the logged-in user's cluster
        logged_in_user_data = data[data['user_id'] == logged_in_user_id]

        if not logged_in_user_data.empty:
            user_clusters = logged_in_user_data['cluster'].unique()
            user_clusters = [cluster for cluster in user_clusters if cluster != -1]

            if not user_clusters:
                return json.dumps({"error": "Logged-in user does not belong to any cluster"})

            recommendations = data[data['cluster'].isin(user_clusters)][['preferred_occupation', 'job_title', 'salary']].drop_duplicates().to_dict(orient='records')
            recommendations = [rec for rec in recommendations if pd.notna(rec['salary'])]

            if not recommendations:
                return json.dumps({"error": "No job recommendations found in the user's cluster(s)"})

            return json.dumps(recommendations, ensure_ascii=False)
        else:
            return json.dumps({"error": "Logged-in user not found in applicant profiles"})
    finally:
        conn.close()

if __name__ == "__main__":
    if len(sys.argv) > 1:
        logged_in_user_id = int(sys.argv[1])
        recommendations = get_logged_in_applicant_recommendations(logged_in_user_id)
        print(recommendations)
    else:
        print(json.dumps({"error": "User ID not provided"}))
        sys.exit(1)
