<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/modal-form.css">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../../css/nav_float.css">
  <link rel="stylesheet" href="../../css/employer.css">
  </head>
<body>
<?php 
include '../../php/conn_db.php';
session_start();
                $userId = $_SESSION['id'];
                $sql = "SELECT * FROM empyers WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if (!$result) {
                   die("Invalid query: " . $conn->error); 
                }
                
                $row = $result->fetch_assoc();
                if (!$row) {
                   die("User not found in applicant_profile.");
                }
                
                echo "
                <form  action='../../php/employer/profile_update.php' method='post'>
                        <input type='hidden'  name='id' value='".$userId."'>

                    <div class='mb-3'>
                        <label for='Email1' class='form-label'>Email address</label>
                        <input type='email' class='form-control' name='email' id='email' aria-describedby='emailHelp' value='" . (isset($row['email']) ? htmlspecialchars($row['email']) : '') . "'>
                        <div id='emailHelp' class='form-text'>We\'ll never share your email with anyone else.</div>
                    </div>
                    <div class='mb-3'>
                        <label for='text1' class='form-label'>First Name</label>
                        <input type='text' class='form-control' name='fname' id='fName' value='" . (isset($row['Fname']) ? htmlspecialchars($row['Fname']) : '') . "'>
                    </div>
                    <div class='mb-3'>
                        <label for='text2' class='form-label'>Last Name</label>
                        <input type='text' class='form-control' name='lname' id='lName' value='" . (isset($row['Lname']) ? htmlspecialchars($row['Lname']) : '') . "'>
                    </div>
                    <div class='mb-3'>
                        <label for='date1' class='form-label'>Birthdate</label>
                        <input type='date' class='form-control' name='bdate' id='bdate' value='" . (isset($row['Bdate']) ? htmlspecialchars($row['Bdate']) : '') . "'>
                    </div>
                    <div class='mb-3'>
                        <label for='date1' class='form-label'>Contact Number</label>
                        <input type='tel' class='form-control' name='contact' id='contact' value='" . (isset($row['contact']) ? htmlspecialchars($row['contact']) : '') . "'>
                    </div>
                    <button type='submit' class='btn btn-primary'>Submit</button>
                </form>";
                ?>
</body>