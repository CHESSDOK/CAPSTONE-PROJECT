<?php
include 'conn_db.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $eid = mysqli_real_escape_string($conn, $_POST['eid']);
    $questions = $_POST['questions'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answers = $_POST['correct_answer'];
    $m_id = mysqli_real_escape_string($conn, $_POST['mid']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);

    for ($i = 0; $i < count($questions); $i++) {
        $question = mysqli_real_escape_string($conn, $questions[$i]);
        $a = mysqli_real_escape_string($conn, $option_a[$i]);
        $b = mysqli_real_escape_string($conn, $option_b[$i]);
        $c = mysqli_real_escape_string($conn, $option_c[$i]);
        $d = mysqli_real_escape_string($conn, $option_d[$i]);
        $correct = mysqli_real_escape_string($conn, $correct_answers[$i]);

        $sql = "INSERT INTO question(quiz_id, question, option_a, option_b, option_c, option_d, correct_answer) VALUES ('$eid', '$question', '$a', '$b', '$c', '$d', '$correct')";

        mysqli_query($conn, $sql);
    }

    header("Location: module_list.php?course_id=$course_id");
    exit();
}

?>
