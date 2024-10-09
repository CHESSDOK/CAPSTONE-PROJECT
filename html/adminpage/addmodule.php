<?php 
include 'conn_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $course_id = $_POST['course_id'];
    $module_name = $_POST['module'];

    $sql = "INSERT  INTO modules  (course_id, module_name) VALUES ('$course_id', '$module_name')";
    if(mysqli_query($conn, $sql)) {
        // Redirect to the add_question page with parameters
        header("Location: module_list.php?course_id=$course_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}
?>