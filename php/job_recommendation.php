    <?php
    include 'conn_db.php';

    function checkSession() {
        session_start();
        if (!isset($_SESSION['id'])) {
            header("Location: ../html/login.html");
            exit();
        } else {
            return $_SESSION['id'];
        }
    }

    $userId = checkSession();

    $command = escapeshellcmd("python3 D:\laragon\www\wakey\job_recommendation.py {$userId}");
    exec($command . ' 2>&1', $output, $return_var);

    if ($return_var !== 0) {
        echo json_encode(["error" => "Python script error: " . implode("\n", $output)]);
    } else {
        echo implode("\n", $output);
    }
    ?>
