<?php
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

include_once "../../php/conn_db.php";

$user_id = checkSession();
$eid = $_GET['q_id'];

// Fetch questions and user answers
$question_sql = "
    SELECT q.id AS question_id, q.question, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_answer, ua.answer 
    FROM question q
    INNER JOIN user_answers ua ON q.id = ua.question_id 
    WHERE ua.answer IS NOT NULL AND ua.answer != ''
    AND ua.user_id = $user_id AND ua.quiz_id = $eid
";

$question_result = $conn->query($question_sql);

$score_sql = "SELECT * FROM user_score WHERE user_id = $user_id AND quiz_id = $eid";
$score_result = $conn->query($score_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Exam Results</title>
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

<div class="table-container">
<?php
if ($score_result->num_rows > 0) {
    $score_data = $score_result->fetch_assoc();

    echo "
    <div class='container mt-4'>
        <div class='results'>
            <h1 class='text-center mb-5'></h1>
            <div class='row text-center'>
                <div class='col-md-4 result-box'>
                    <p class='display-7 text-primary'><strong>Your Score:</strong></p>
                    <p class='display-3 text-success'>" . $score_data['score'] . "</p>
                </div>
                <div class='col-md-4 result-box'>
                    <p class='display-7 text-primary'><strong>Correct Answers:</strong></p>
                    <p class='display-3 text-success'>" . $score_data['correct_answers'] . "</p>
                </div>
                <div class='col-md-4 result-box'>
                    <p class='display-7 text-primary'><strong>Wrong Answers:</strong></p>
                    <p class='display-3 text-danger'>" . $score_data['wrong_answers'] . "</p>
                </div>
            </div>

            <h2 class='mt-5 text-left'>Quiz Result</h2>
        </div>
    </div>";


    // Loop through the questions
    while ($question_row = $question_result->fetch_assoc()) {
        $question_id = $question_row['question_id'];
        $correct_answer = $question_row['correct_answer'];
        $user_answer = $question_row['answer'];
    
        // Determine the content of the user's answer and correct answer
        $correct_answer_content = '';
        $user_answer_content = '';
    
        switch ($correct_answer) {
            case 'a':
                $correct_answer_content = 'a). ' .$question_row['option_a'];
                break;
            case 'b':
                $correct_answer_content = 'b). ' .$question_row['option_b'];
                break;
            case 'c':
                $correct_answer_content = 'c). ' .$question_row['option_c'];
                break;
            case 'd':
                $correct_answer_content = 'd). ' .$question_row['option_d'];
                break;
        }
    
        switch ($user_answer) {
            case 'a':
                $user_answer_content = 'a). ' .$question_row['option_a'];
                break;
            case 'b':
                $user_answer_content = 'b). ' .$question_row['option_b'];
                break;
            case 'c':
                $user_answer_content = 'c). ' .$question_row['option_c'];
                break;
            case 'd':
                $user_answer_content = 'd). ' .$question_row['option_d'];
                break;
        }
    
        // Determine if the user's answer is correct
        $result_class = ($user_answer == $correct_answer) ? 'text-success' : 'text-danger';
        $result = ($user_answer == $correct_answer) ? 'Correct' : 'Incorrect';
    
        // Display the question and results
        echo "
        <div class='question-result mt-4'>
            <div class='row'>
                <div class='col-md-12'>
                    <p><strong>Question:</strong> " . htmlspecialchars($question_row['question'] ?? 'N/A') . "</p>
                </div>
            </div>
            <div class='row'>";
    
        // Only display 'Your Answer' if the user's answer is incorrect
        if ($user_answer != $correct_answer) {
            echo "
                <div class='col-md-6'>
                    <p class='rslt'><strong>Your Answer:</strong> " . htmlspecialchars($user_answer_content ?? 'N/A') . "</p>
                </div>";
        }
    
        echo "
                <div class='col-md-6'>
                    <p class='rslt'><strong>Correct Answer:</strong> " . htmlspecialchars($correct_answer_content ?? 'N/A') . "</p>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <p class='$result_class'><strong>Result:</strong> " . $result . "</p>
                </div>
            </div>
            <hr>
        </div>";
    }
}
?>
</div>
</body>
</html>
