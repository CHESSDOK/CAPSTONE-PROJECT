function clusterJobs(jobData) {
    // Log the received job data
    console.log("Job Data received for clustering:", jobData);

    // Check if jobData is an array
    if (!Array.isArray(jobData)) {
        console.error("Expected jobData to be an array, but got:", typeof jobData, jobData);
        return; // Exit the function if it's not an array
    }

    // Prepare job features for clustering
    const jobFeatures = jobData.map(job => {
        const salary = parseFloat(job.salary);
        // Check if salary is a valid number
        if (isNaN(salary)) {
            console.error("Invalid salary for job:", job);
            return null; // Skip this job if salary is not a valid number
        }
        return [salary]; // Create an array for clustering
    }).filter(feature => feature !== null); // Remove any null entries

    console.log("Job Features prepared for clustering:", jobFeatures);

    // Proceed with KMeans if there are valid job features
    if (jobFeatures.length === 0) {
        console.error("No valid job features found for clustering.");
        return; // Exit if there are no valid features
    }

    // Initialize KMeans clustering
    const kmeans = ml5.kmeans({ k: 3 }, modelReady); // Specify the number of clusters

    function modelReady() {
        console.log("KMeans model is ready!");

        // Train the model with the job features
        kmeans.train(jobFeatures, () => {
            try {
                // After training, get the clusters
                const clusters = kmeans.predict(jobFeatures); // Use predict instead of cluster
                console.log("Clusters: ", clusters);
                updateUI(clusters, jobData); // Update the UI with the cluster results
            } catch (error) {
                console.error("Error while predicting clusters:", error);
            }
        });
    }
}

// Make the clusterJobs function globally accessible
window.clusterJobs = clusterJobs; // Ensure this line is present

function updateUI(clusters, jobData) {
    const jobContainer = document.getElementById('recommended-jobs');
    jobContainer.innerHTML = ''; // Clear previous recommendations

    // Ensure clusters is an array and iterate over it
    if (Array.isArray(clusters)) {
        clusters.forEach((clusterId, index) => {
            const job = jobData[index]; // Get the job corresponding to this index
            const jobElement = document.createElement('div');
            jobElement.classList.add('col-md-4'); // Bootstrap class for grid layout
            jobElement.innerHTML = `
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">${job.job_title}</h5>
                        <p class="card-text">${job.job_description}</p>
                        <p class="card-text">Salary: ${job.salary}</p>
                        <p class="card-text">Location: ${job.work_location}</p>
                    </div>
                </div>
            `;
            jobContainer.appendChild(jobElement);
        });
    } else {
        console.error("Clusters is not an array or empty:", clusters);
    }
}
