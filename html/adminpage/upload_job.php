<?php
include '../../php/conn_db.php';
$sql = "SELECT DISTINCT specialization FROM applicant_profile WHERE specialization IS NOT NULL";
$result = $conn->query($sql);

echo "
        <form action='post_job_process.php' method='post'>
                <tr>
                    <td>
                        <label for='job_title' class='form-label'>Job Title:</label>
                        <input type='text' class='form-control' name='job_title' id='job_title' required>
                    </td>
                    <td>
                        <label for='vacant' class='form-label'>Job Vacant:</label>
                        <input type='number' class='form-control' name='vacant' id='vacant' required>
                    </td>
                    <td>
                        <label for='spe' class='form-label'>Expert Requirement</label>
                        <select id='spe' name='spe' class='form-select'>
                            <option value=''>Select a specialization</option>";
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='".$row['specialization']."'>".$row['specialization']."</option>";
                                }
                            } else {
                                echo "<option value=''>No specialization found</option>";
                            }
echo "                  </select>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <label for='salary' class='form-label'>Salary:</label>
                        <input type='text' name='salary' id='salary' class='form-control' required>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <label for='education_background' class='form-label'>Education Background</label>
                        <select class='form-select' id='education_background' name='education_background' required>
                            <option value='' disabled selected>Select Educational Attainment</option>
                            <option value='High School Graduate'>High School Graduate</option>
                            <option value='Undergraduate'>Undergraduate (College Level)</option>
                            <option value='College Graduate'>College Graduate</option>
                            <option value='Vocational Course Certificate'>Vocational Course Graduate</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <label for='job_description' class='form-label'>Job Description:</label>
                        <textarea name='job_description' id='job_description' class='form-control' required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <label for='job_type' class='form-label'>Job type:</label>
                        <select class='form-select' id='jobtype' name='jobtype' required>
                            <option value='Part time'>Part time</option>
                            <option value='Prelance'>Prelance</option>
                            <option value='Fulltime'>Fulltime</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan='3'>
                        <label for='req' class='form-label'>Qualification/Requirements</label>
                        <textarea name='req' id='req' class='form-control'>• </textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <label for='loc' class='form-label'>Work Location</label>
                        <input type='text' class='form-control' name='loc' id='loc'>
                    </td>
                    <td>
                        <label for='rem' class='form-label'>Remarks</label>
                        <input type='text' class='form-control' name='rem' id='rem'>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <button type='submit' class='btn btn-primary'>Post Job</button>
                    </td>
                </tr>
            </table>
        </form>
";
echo"</div>";
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