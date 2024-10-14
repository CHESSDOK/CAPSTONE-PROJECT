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
    <form action="../../php/employer/update_job_process.php" method="post">
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>"> <!-- hidden job_id field -->
        <table>
            <tr>
                <td>
                    <label for="job_title" class="form-label">Job Title:</label>
                    <input type="text" class="form-control" name="job_title" id="job_title" value="<?php echo htmlspecialchars($row['job_title']); ?>">
                </td>
                <td>
                    <label for="vacant" class="form-label">Job Vacant:</label>
                    <input type="number" class="form-control" name="vacant" id="vacant" value="<?php echo htmlspecialchars($row['vacant']); ?>" required>
                </td>
                <td>
                    <label for="spe" class="form-label">Expert Requirement:</label>
                    <select id="spe" name="spe" class="form-select">
                        <option value="">Select a specialization</option>
                        <option value="<?php echo htmlspecialchars($row['specialization']); ?>" selected><?php echo htmlspecialchars($row['specialization'] ?  $row['specialization'] : 'No specialization selected'); ?></option>

                    </select>
                </td>
            </tr>
            <tr>
            <td colspan="3">
                <div class="mb-3">
                <label for="salary" class="form-label">Salary:</label>
                <input type="text" name="salary" id="salary" class="form-control" value="<?php echo htmlspecialchars($row['salary']); ?>" required></textarea>
                </div>
            </td>
            </tr>
            <tr>
              <td colspan="3">
                <div class="mb-3">
                <label for="education_background" class="form-label">Education Background</label>
                  <select class="form-select" id="education_background" name="education_background" required>
                    <option value="" disabled selected>Select Educational Attainment</option>
                    <option value="High School Graduate">High School Graduate</option>
                    <option value="Undergraduate">Undergraduate (College Level)</option>
                    <option value="College Graduate">College Graduate</option>
                    <option value="Vocational Course Certificate">Vocational Course Graduate</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="job_description" class="form-label">Job Description:</label>
                    <textarea name="job_description" id="job_description" class="form-control" required><?php echo htmlspecialchars($row['job_description']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <label for="jobtype" class="form-label">Job Type:</label>
                    <select class="form-select" id="jobtype" name="jobtype" required>
                        <option value="Part time" <?php echo ($row['job_type'] == 'Part time' ? 'selected' : ''); ?>>Part time</option>
                        <option value="Prelance" <?php echo ($row['job_type'] == 'Prelance' ? 'selected' : ''); ?>>Prelance</option>
                        <option value="Fulltime" <?php echo ($row['job_type'] == 'Fulltime' ? 'selected' : ''); ?>>Fulltime</option>
                    </select>
                </td>
            </tr>
            <tr>
            <td colspan="3">
                <label for="req" class="form-label">Qualification/Requirements:</label>
                <textarea name="req" id="req" class="form-control"><?php echo htmlspecialchars($row['requirment']); ?></textarea>
            </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="loc" class="form-label">Work Location:</label>
                    <input type="text" class="form-control" name="loc" id="loc" value="<?php echo htmlspecialchars($row['work_location']); ?>">
                </td>
                <td>
                    <label for="rem" class="form-label">Remarks:</label>
                    <input type="text" class="form-control" name="rem" id="rem" value="<?php echo htmlspecialchars($row['remarks']); ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </td>
            </tr>
        </table>
    </form>

<?php
} else {
    echo "No job found for this ID.";
}
?>

<script>
    // Function to add an initial bullet point when the page loads
    function addInitialBullet() {
        const textarea = document.getElementById('req');
        textarea.value = '• '; // Add a bullet point
        textarea.setSelectionRange(2, 2); // Set the cursor position right after the bullet
    }

    // Call the function when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        addInitialBullet();
    });

    document.getElementById('req').addEventListener('keydown', function (event) {
        // Check if the "Enter" key was pressed
        if (event.key === 'Enter') {
            const textarea = event.target;
            const cursorPosition = textarea.selectionStart; // Get cursor position

            // Split the content into lines by the newline character
            const beforeText = textarea.value.slice(0, cursorPosition);
            const afterText = textarea.value.slice(cursorPosition);

            // Add a bullet point at the new line
            textarea.value = `${beforeText}\n• ` + afterText;

            // Prevent default behavior (such as a plain new line without a bullet)
            event.preventDefault();

            // Move the cursor right after the bullet point
            textarea.setSelectionRange(cursorPosition + 3, cursorPosition + 3);
        }
    });
</script>
