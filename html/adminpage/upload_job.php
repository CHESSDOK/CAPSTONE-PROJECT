<?php
include '../../php/conn_db.php';
$sql = "SELECT DISTINCT specialization FROM applicant_profile WHERE specialization IS NOT NULL";
$result = $conn->query($sql);

echo "
        <form action='post_job_process.php' method='post'>
            <table>
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
echo "                      </select>
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
                            <label for='req' class='form-label'>Qualification/Requirements</label>
                            <textarea name='req' id='req' class='form-control'></textarea>
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

?>
