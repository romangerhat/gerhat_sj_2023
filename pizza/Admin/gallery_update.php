<?php
include_once '../includes/db.php';

if (isset($_POST['submit'])) {
    $newFileName = $_POST['filename'];
    if (empty($_POST['filename'])) {
        $newFileName = "picture";
    } else {
        $newFileName = strtolower(str_replace(" ", "_", $newFileName));
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $id = $_POST['id'];
    $original_name = $_POST['original'];
    $original_path = "../gallery/" . $original_name;

    $file = $_FILES['file'];
    $fileName = $file["name"];
    $fileTempName = $file["tmp_name"];

    #---error variables

    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName); /* [meno,koncovka] */
    $fileExtOnly = strtolower(end($fileExt)); /* 'koncovka' */

    $allowed = array("jpeg", "jpg", "png");

    if (in_array($fileExtOnly, $allowed)){
        if ($fileError === 0){
            if ($fileSize < 200000){
                $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileExtOnly; #nazov + id + koncovka
                $fileDestination = "../gallery/" . $imageFullName;
                if (!empty($imageTitle) && !empty($imageDesc)){
                    $sql = "SELECT * FROM gallery;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                        include_once "../includes/error_btns.php";
                        exit();
                    } else {
                        $sql = "UPDATE gallery SET title = ?, description = ?, image_name = ? WHERE idGallery = ?";
                        if (!mysqli_stmt_prepare($stmt, $sql)){
                            echo "SQL statement failed";
                            include_once "../includes/error_btns.php";
                            exit();
                        } else {

                            unlink($original_path);

                            mysqli_stmt_bind_param($stmt, "sssi", $imageTitle, $imageDesc, $imageFullName, $id);
                            mysqli_stmt_execute($stmt);


                            move_uploaded_file($fileTempName, $fileDestination);
                            header("Location: ../index.php?update=success");
                        }
                    }
                }
            } else {
                echo 'file too big';
                include_once "../includes/error_btns.php";
                exit();
            }
        } else {
            echo "you had an error";
            include_once "../includes/error_btns.php";
            exit();
        }
    } else {
        echo "wrong file type";
        include_once "../includes/error_btns.php";
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>