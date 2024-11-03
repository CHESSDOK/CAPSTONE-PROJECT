<?php
// Database connection function
function getDbConnection() {
    $host = 'localhost'; // Database host
    $db = 'peso';        // Database name
    $user = 'root';      // Database user
    $pass = '';          // Database password

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        return null;
    }
}

// Fetch applicant profiles from the database
function fetchApplicantProfiles($conn) {
    $query = "SELECT * FROM applicant_profile";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch job postings from the database
function fetchJobPostings($conn) {
    $query = "SELECT * FROM job_postings WHERE is_active = 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fuzzy matching function
function fuzzyMerge($applicantOccupations, $jobTitles, $threshold = 80) {
    $matches = [];
    foreach ($applicantOccupations as $occupation) {
        foreach ($jobTitles as $jobTitle) {
            similar_text($occupation, $jobTitle, $percent);
            if ($percent >= $threshold) {
                $matches[] = [
                    'preferred_occupation' => $occupation,
                    'job_title' => $jobTitle,
                    'similarity' => $percent
                ];
            }
        }
    }
    return $matches;
}

// Main function to get job recommendations for the logged-in user
function getJobRecommendations($loggedInUserId) {
    $conn = getDbConnection();
    if ($conn === null) {
        return json_encode(["error" => "Failed to connect to the database"]);
    }

    $applicantProfiles = fetchApplicantProfiles($conn);
    $jobPostings = fetchJobPostings($conn);

    if (empty($applicantProfiles) || empty($jobPostings)) {
        return json_encode(["error" => "No data available for applicants or job postings"]);
    }

    // Normalize the columns and split preferred occupations
    $applicantOccupations = [];
    foreach ($applicantProfiles as $profile) {
        $occupations = array_map('trim', explode(',', strtolower($profile['preferred_occupation'])));
        foreach ($occupations as $occupation) {
            $applicantOccupations[] = [
                'occupation' => $occupation,
                'user_id' => $profile['user_id'],
                'expected_salary' => $profile['expected_salary'] // Assuming this field exists
            ];
        }
    }

    $jobTitles = array_map(function($job) {
        return strtolower(trim($job['job_title']));
    }, $jobPostings);

    // Perform fuzzy matching
    $matched = fuzzyMerge(array_column($applicantOccupations, 'occupation'), array_unique($jobTitles));

    if (empty($matched)) {
        return json_encode(["error" => "No fuzzy matches found between applicants and job postings"]);
    }

    // Prepare recommendations
    $recommendations = [];
    foreach ($matched as $match) {
        foreach ($applicantOccupations as $profile) {
            if ($profile['occupation'] == $match['preferred_occupation'] && $profile['user_id'] == $loggedInUserId) {
                $recommendations[] = [
                    'preferred_occupation' => $match['preferred_occupation'],
                    'job_title' => $match['job_title'],
                    'salary' => $profile['expected_salary'] // Assuming this field exists
                ];
            }
        }
    }

    return json_encode($recommendations);
}

// Execute script
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.html");
    exit();
}

$userId = $_SESSION['id'];
$recommendations = getJobRecommendations($userId);
echo $recommendations;
?>
