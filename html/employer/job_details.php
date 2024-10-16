<?php
include '../../php/conn_db.php';

// Get the job_id from the URL
$job_id  = isset($_GET['job_id']) ? $_GET['job_id'] : 0;

// If no job_id is provided, show an error
if ($job_id == 0) {
    echo "No job ID provided.";
    exit;
}

// SQL query to fetch the job posting with the specific job_id
$sql = "SELECT * FROM job_postings WHERE j_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $job_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the job exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch data for the job
?>
    <form id="optionsForm" action="../../php/employer/update_job_process.php" method="post">
    <input type="hidden" name="job_id" value="<?php echo $job_id; ?>"> <!-- hidden job_id field -->
    <div class="container">
    <div class="row mb-3">
    <div class="col-md-6 d-flex align-items-stretch">
        <div class="w-100">
            <label for="job_title" class="form-label">Job Title:</label>
            <input type="text" class="form-control" name="job_title" id="job_title" value="<?php echo htmlspecialchars($row['job_title']); ?>">
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-stretch">
        <div class="w-100">
            <label for="vacant" class="form-label">Job Vacant:</label>
            <input type="number" class="form-control" name="vacant" id="vacant" value="<?php echo htmlspecialchars($row['vacant']); ?>" required>
        </div>
    </div>
</div>


        <div class="row mb-3">
            <div class="col-md-12">
                <label for="dynamicSelect" class="form-label">Choose one or more options:</label>
                <select id="dynamicSelect" name="other_skills[]" class="form-select hover-select" multiple>
                    <option value="add">Add a new option...</option>
                    <option value="Auto Mechanic">Auto Mechanic</option>
                    <option value="Beautician">Beautician</option>
                    <option value="Carpentry Work">Carpentry Work</option>
                    <option value="Computer Literate">Computer Literate</option>
                    <option value="Domestic Chores">Domestic Chores</option>
                    <option value="Driver">Driver</option>
                    <option value="Electrician">Electrician</option>
                    <option value="Embroidery">Embroidery</option>
                    <option value="Gardening">Gardening</option>
                    <option value="Masonry">Masonry</option>
                    <option value="Painter/Artist">Painter/Artist</option>
                    <option value="Painting Jobs">Painting Jobs</option>
                    <option value="Photography">Photography</option>
                    <option value="Plumbing">Plumbing</option>
                    <option value="Sewing">Sewing Dresses</option>
                    <option value="Stenography">Stenography</option>
                    <option value="Tailoring">Tailoring</option>
                </select>
                <div id="newOptionContainer" class="mt-2">
                    <input type="text" id="newOption" class="form-control" placeholder="Enter new option">
                    <button id="addButton" class="btn btn-secondary mt-2" type="button">Add Option</button>
                </div>
                <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
                <div id="selectedOptionsContainer" class="mt-3">
                    <h3>Selected Options:</h3>
                    <ul id="selectedOptionsList"></ul>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="salary" class="form-label">Salary:</label>
                <input type="text" name="salary" id="salary" class="form-control" value="<?php echo htmlspecialchars($row['salary']); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="education_background" class="form-label">Education Background:</label>
                <select class="form-select" id="education_background" name="education_background" required>
                    <option value="" <?php echo ($row['education'] == '' ? 'selected' : ''); ?>>Select Educational Attainment</option>
                    <option value="High School Graduate" <?php echo ($row['education'] == 'High School Graduate' ? 'selected' : ''); ?>>High School Graduate</option>
                    <!-- more options -->
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="job_description" class="form-label">Job Description:</label>
                <textarea name="job_description" id="job_description" class="form-control" required><?php echo htmlspecialchars($row['job_description']); ?></textarea>
            </div>
        </div>

        <!-- Separated Job Type and Work Location -->
        <div class="row mb-3 separated-row">
            <div class="col-md-6">
                <label for="jobtype" class="form-label">Job Type:</label>
                <select class="form-select" id="jobtype" name="jobtype" required>
                    <option value="Part time" <?php echo ($row['job_type'] == 'Part time' ? 'selected' : ''); ?>>Part time</option>
                    <!-- more options -->
                </select>
            </div>
            <div class="col-md-6">
                <label for="loc" class="form-label">Work Location:</label>
                <input type="text" class="form-control" name="loc" id="loc" value="<?php echo htmlspecialchars($row['work_location']); ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="req" class="form-label">Qualification/Requirements:</label>
                <textarea name="req" id="req" class="form-control"><?php echo htmlspecialchars($row['requirment']); ?></textarea>
            </div>
        </div>

        <!-- Changed Remarks to Textarea -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="rem" class="form-label">Remarks:</label>
                <textarea name="rem" id="rem" class="form-control"><?php echo htmlspecialchars($row['remarks']); ?></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Update Job</button>
            </div>
        </div>
    </div>
</form>


<?php
} else {
    echo "No job found for this ID.";
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('req');
        textarea.value = '• '; 
        textarea.setSelectionRange(2, 2); 
    });

    document.getElementById('req').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            const textarea = event.target;
            const cursorPosition = textarea.selectionStart;

            const beforeText = textarea.value.slice(0, cursorPosition);
            const afterText = textarea.value.slice(cursorPosition);

            textarea.value = `${beforeText}\n• ` + afterText;

            event.preventDefault();
            textarea.setSelectionRange(cursorPosition + 3, cursorPosition + 3);
        }
    });
</script>
