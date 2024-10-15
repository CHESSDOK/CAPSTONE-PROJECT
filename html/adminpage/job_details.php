<?php
include '../../php/conn_db.php';

// Get the job_id from the URL
$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : 0;

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
    <form id="optionsForm" action="update_job_process.php" method="post">
    <input type="hidden" name="job_id" value="<?php echo $job_id; ?>"> <!-- hidden job_id field -->
    <table>
        <tr>
            <td>
                <div>
                    <label for="company" class="form-label">Copmany hiring:</label>
                    <input type="text" class="form-control" name="company" id="company" value="<?php echo isset($row['company_name']) ? htmlspecialchars($row['company_name']) : ''; ?>" required>
                </div>
            </td>
            <td>
                <div>
                    <label for="job_title" class="form-label">Job Title:</label>
                    <input type="text" class="form-control" name="job_title" id="job_title" value="<?php echo htmlspecialchars($row['job_title']); ?>" required>
                </div>
            </td>
            <td>
                <div>
                    <label for="vacant" class="form-label">Job Vacant:</label>
                    <input type="number" class="form-control" name="vacant" id="vacant" value="<?php echo htmlspecialchars($row['vacant']); ?>" required>
                </div>
            </td>
            <td>
                <div>
                <label for="dynamicSelect">Choose one or more options:</label>
                    <select id="dynamicSelect"  name="other_skills[]" multiple>
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

                    <div id="newOptionContainer">
                    <input type="text" id="newOption" placeholder="Enter new option">
                    <button id="addButton" type="button">Add Option</button> <!-- Ensure type="button" here -->
                    </div>
                    <input type="hidden" name="selectedOptions" id="selectedOptionsHidden">
                    <div id="selectedOptionsContainer">
                    <h3>Selected Options:</h3>
                    <ul id="selectedOptionsList"></ul>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div>
                    <label for="salary" class="form-label">Salary:</label>
                    <input type="text" name="salary" id="salary" class="form-control" value="<?php echo htmlspecialchars($row['salary']); ?>" required>
                </div>
            </td>
        </tr>
        <tr>
              <td colspan="3">
                <div class="mb-3">
                <label for="education_background" class="form-label">Education Background</label>
                  <select class="form-select" id="education_background" name="education_background" required>
                    <option value=""<?php echo ($row['education'] == '' ? 'selected' : ''); ?>>Select Educational Attainment</option>
                    <option value="High School Graduate"<?php echo ($row['education'] == 'High School Graduate' ? 'selected' : ''); ?>>High School Graduate</option>
                    <option value="Undergraduate"<?php echo ($row['education'] == 'Undergraduate' ? 'selected' : ''); ?>>Undergraduate (College Level)</option>
                    <option value="College Graduate"<?php echo ($row['education'] == 'College Graduate' ? 'selected' : ''); ?>>College Graduate</option>
                    <option value="Vocational Course Certificate"<?php echo ($row['education'] == 'Vocational Course Certificate' ? 'selected' : ''); ?>>Vocational Course Graduate</option>
                  </select>
                </div>
              </td>
            </tr>
        <tr>
            <td colspan="3">
                <div>
                    <label for="job_description" class="form-label">Job Description:</label>
                    <textarea name="job_description" id="job_description" class="form-control" required><?php echo htmlspecialchars($row['job_description']); ?></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div>
                    <label for="jobtype" class="form-label">Job Type:</label>
                    <select class="form-select" id="jobtype" name="jobtype" required>
                        <option value="Part time" <?php echo ($row['job_type'] == 'Part time' ? 'selected' : ''); ?>>Part time</option>
                        <option value="Prelance" <?php echo ($row['job_type'] == 'Prelance' ? 'selected' : ''); ?>>Prelance</option>
                        <option value="Fulltime" <?php echo ($row['job_type'] == 'Fulltime' ? 'selected' : ''); ?>>Fulltime</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div>
                    <label for="req" class="form-label">Qualification/Requirements:</label>
                    <textarea name="req" id="req" class="form-control"><?php echo htmlspecialchars($row['requirment']); ?></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>
                    <label for="loc" class="form-label">Work Location:</label>
                    <input type="text" class="form-control" name="loc" id="loc" value="<?php echo htmlspecialchars($row['work_location']); ?>">
                </div>
            </td>
            <td>
                <div>
                    <label for="rem" class="form-label">Remarks:</label>
                    <input type="text" class="form-control" name="rem" id="rem" value="<?php echo htmlspecialchars($row['remarks']); ?>">
                </div>
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
