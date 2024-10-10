<?php
include '../../php/conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $qid = $_POST['id'];
    $name = ucwords(strtolower($_POST['name']));
    $total = $_POST['total'];
    $tag = $_POST['tag'];
    $id = $_POST['module_id'];
    $course_id = $_POST['course_id'];

    // Update the data in the quiz_name table
    $sql = "UPDATE `quiz_name` 
            SET title = '$name', total = '$total', tag = '$tag', date = NOW()
            WHERE module_id = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the add_question page with parameters
        header("Location: add_question.php?module_id=$id&q_id=$qid&total=$total&course_id=$course_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
