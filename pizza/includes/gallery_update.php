<?php
include_once 'db.php';
if (isset($_POST['submit'])) {
    $fileName = $_POST['filename'];
    $fileTitle = $_POST['filetitle'];
    $fileDesc = $_POST['filedesc'];
    $id = $_GET['id'];
    $sql = "UPDATE gallery SET title = ?, description = ?, image_name = ? WHERE idGallery = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL statement failed");
    } else {
        mysqli_stmt_bind_param($stmt, "sssi", $fileTitle, $fileDesc, $fileName, $id);
        mysqli_stmt_execute($stmt);
        echo "Data updated successfully";
    }
}
?>