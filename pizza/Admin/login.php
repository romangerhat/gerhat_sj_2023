<?php
include_once "../includes/db_login.php";
session_start();

if (isset($_POST['submit'])) {

    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = $conn->query("SELECT password FROM users WHERE email='$email'");

        $data = $sql->fetch_array();
        if ($data != null){
        if (password_verify($password, $data['password'])) {
            $_SESSION['email'] = $email;
            header("Location: admin.php");
            exit();
        } else
            echo 'Invalid username or password';
                include_once "../includes/error_btns.php";
                exit();
        } else
            echo 'User does not exist';
                include_once "../includes/error_btns.php";
                exit();

}
?>