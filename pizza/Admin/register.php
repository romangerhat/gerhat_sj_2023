<?php
include_once "../includes/db_login.php";

if(isset($_POST['submit'])){
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];
    if ($password != $cPassword){
        echo "Passwords must match.";
        include_once "../includes/error_btns.php";
        exit();
    }
    else{
    $sql = "INSERT INTO users (username,email,password) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
        include_once "../includes/error_btns.php";
        exit();
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sss", $username,$email, $hash);
        mysqli_stmt_execute($stmt);
        header("Location: admin.php?register=success");
    }}
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
