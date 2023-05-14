<?php
include_once "../includes/db.php";

if (isset($_POST['submit'])) {
    $newFileName = $_POST['filename'];
    if (empty($_POST['filename'])) {
        $newFileName = "picture";
    } else {
        $newFileName = strtolower(str_replace(" ", "_", $newFileName));
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $file = $_FILES["file"];
    $fileName = $file["name"];
    $fileTempName = $file["tmp_name"];

    #--------error variables

    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName); /*[nazov,koncovka]*/
    $fileExtOnly = strtolower(end($fileExt)); /* 'koncovka' */

    $allowed = array("jpeg", "jpg", "png");

    if (in_array($fileExtOnly, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 200000) {
                $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileExtOnly;
                $fileDestination = "../gallery/" . $imageFullName;
                #---------------------------koniec vytvorenia obrazku

                if (!empty($imageTitle) && !empty($imageDesc)) {
                    $sql = "SELECT * FROM gallery;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                        include_once "../includes/error_btns.php";
                        exit();
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($result);
                        $setImageOrder = $rowCount + 1;

                        $sql = "INSERT INTO gallery (title,description,image_name,orderGal) VALUES (?, ?, ?, ?);";
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL statement failed";
                            include_once "../includes/error_btns.php";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssi", $imageTitle, $imageDesc, $imageFullName, $setImageOrder); # do placeholderov vlozim upravene hodnoty
                            mysqli_stmt_execute($stmt);

                            move_uploaded_file($fileTempName, $fileDestination);

                            header("Location: ../index.php?upload=success");
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