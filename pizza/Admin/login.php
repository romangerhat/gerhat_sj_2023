<?php
session_start();
include_once "../includes/db_users.php";

if(isset($_POST['submit'])){
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE username=? AND password=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['username'] = $row['username'];
            header("Location: admin.php");
            exit();
        } else {
            echo 'Invalid username or password
            <br><br>
            <a href="../index.php" style="display: inline-block; padding: 5px 10px; border: 1px solid black;
            background-color: #767676; color: #e0e0e0; text-decoration: none;">Home</a>
            <a href="admin.php" style="display: inline-block; padding: 5px 10px; border: 1px solid black;
            background-color: #767676; color: #e3e3e3; text-decoration: none;">Retry</a>';
        }
    }
}
?>