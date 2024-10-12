<?php
include "../../php/conn_db.php";
function checkSession() {
    session_start(); // Start the session

    // Check if the session variable 'id' is set
    if (!isset($_SESSION['id'])) {
        // Redirect to login page if session not found
        header("Location: ../login.html");
        exit();
    } else {
        // If session exists, store the session data in a variable
        return $_SESSION['id'];
    }
}
$userId = checkSession();
$q_id = $_GET['q_id'];
$module_id = $_GET['module_id'];
$module_title = $_GET['q_title'];

$questions_query = "SELECT * FROM question WHERE quiz_id='$q_id' ORDER BY RAND() LIMIT 20";
$questions_result = mysqli_query($conn, $questions_query);

$sql = "SELECT * FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();

if (!$res) {
    die("Invalid query: " . $conn->error); 
}

$row = $res->fetch_assoc();
if (!$row) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../css/nav_float.css">
    <link rel="stylesheet" href="../../css/module_quiz.css">
</head>
<body>
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <div class='text-center'>
        <button class='btn btn-primary' onclick='window.close()'>
            <i class='bi bi-x-lg'></i> Close
        </button>
    </div>
</nav>

<form class="form-box p-4 border rounded" action="../../php/applicant/submit_ans.php" method="POST">
    <div class="table-container">
        <input type="hidden" name="q_id" value="<?php echo htmlspecialchars($q_id); ?>">
        <input type="hidden" name="module_id" value="<?php echo htmlspecialchars($module_id); ?>">
        
        <!-- Display module name with Bootstrap styling -->
        <p class="label h5 text-center mb-4"><?php echo htmlspecialchars($module_title); ?></p>
        
        <?php
        $q_number = 1;
       
        while ($question = mysqli_fetch_assoc($questions_result)) {
            echo "
            <div class='mb-4'>
                <input type='hidden' name='questions[]' value='{$question['id']}'>
                <p class='fw-bold'>{$q_number}: " . htmlspecialchars($question['question']) . "</p>

                <div class='form-check'>
                    <label class='form-check-label'>
                       A).<input type='radio' class='form-check-input' name='answers[{$question['id']}]' value='a'> " . htmlspecialchars($question['option_a']) . "
                    </label>
                </div>

                <div class='form-check'>
                    <label class='form-check-label'>
                        B).<input type='radio' class='form-check-input' name='answers[{$question['id']}]' value='b'> " . htmlspecialchars($question['option_b']) . "
                    </label>
                </div>

                <div class='form-check'>
                    <label class='form-check-label'>
                        C).<input type='radio' class='form-check-input' name='answers[{$question['id']}]' value='c'> " . htmlspecialchars($question['option_c']) . "
                    </label>
                </div>

                <div class='form-check'>
                    <label class='form-check-label'>
                        D).<input type='radio' class='form-check-input' name='answers[{$question['id']}]' value='d'> " . htmlspecialchars($question['option_d']) . "
                    </label>
                </div>
            </div>
            ";
            $q_number++;
        }
        ?>
        <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Submit</button>
    </div>
</form>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../../javascript/script.js"></script> 
</body>
</html>
