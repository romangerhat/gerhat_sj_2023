<?php
include_once 'db.php';

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

    $file = $_FILES['file'];
    #errhandling
    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileTempName = $file["tmp_name"];
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName); #spravi zoznam [nazov,koncovka(jpeg...)]
    $fileExtOnly = strtolower(end($fileExt)); # vybere uba koncovku

    $allowed = array("jpeg", "jpg", "png");

    if (in_array($fileExtOnly, $allowed)){
        if ($fileError === 0){
            if ($fileSize < 200000){
                $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileExtOnly; #ulozi nazov suboru + nahodne id proti duplikatu + koncovka
                $fileDestination = "../gallery/" . $imageFullName;
                if (!empty($imageTitle) && !empty($imageDesc)){
                    $sql = "SELECT * FROM gallery;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                    } else {
                        $sql = "UPDATE gallery SET title = ?, description = ?, image_name = ? WHERE idGallery = ?";
                        if (!mysqli_stmt_prepare($stmt, $sql)){
                            echo "SQL statement failed";
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssi", $imageTitle, $imageDesc, $imageFullName, $id);
                            mysqli_stmt_execute($stmt);
                            echo "Data updated successfully";
                            move_uploaded_file($fileTempName, $fileDestination);
                            header("Location: ../index.php?update=success");
                        }
                    }


                }
            } else {
                echo 'file too big';
                include_once "error_btns.php";
                exit();
            }
        } else {
            echo "you had an error";
            include_once "error_btns.php";
            exit();
        }
    } else {
        echo "wrong file type";
        include_once "error_btns.php";
        exit();
    }
}
?>