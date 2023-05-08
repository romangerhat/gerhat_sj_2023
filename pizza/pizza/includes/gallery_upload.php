<?php
if (isset($_POST['submit'])) {
    $newFileName = $_POST['filename'];
    if (empty($_POST['filename'])) {
        $newFileName = "gallery";
    } else {
        $newFileName = strtolower(str_replace(" ", "_", $newFileName));
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $file = $_FILES["file"];
    #errorhandling
    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileTempName = $file["tmp_name"];
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName); #spravi zoznam [nazov,koncovka(jpeg...)]
    $fileExtOnly = strtolower(end($fileExt)); # vybere uba koncovku

    $allowed = array("jpeg", "jpg", "png");

    if (in_array($fileExtOnly, $allowed)) { # kontorluje ci sme zadali spravny typ
        if ($fileError === 0) {
            if ($fileSize < 200000) {
                $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileExtOnly; #ulozi nazov suboru + nahodne id proti duplikatu + koncovka
                $fileDestination = "../gallery/" . $imageFullName;

                include_once "db.php"; #prepoji ma na databazu
                #----------------------------------------------
                if (!empty($imageTitle) && !empty($imageDesc)) {
                    $sql = "SELECT * FROM gallery;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $rowCount = mysqli_num_rows($result);
                        $setImageOrder = $rowCount + 1;

                        $sql = "INSERT INTO gallery (title,description,image_name,orderGal) VALUES (?, ?, ?, ?);"; #? = placeholder pre kazdy stlpec
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL statement failed";
                        } else {
                            mysqli_stmt_bind_param($stmt, "ssss", $imageTitle, $imageDesc, $imageFullName, $setImageOrder); # do placeholderov vlozim upravene hodnoty
                            mysqli_stmt_execute($stmt);

                            move_uploaded_file($fileTempName, $fileDestination);

                            header("Location: ../index.php?upload=success");
                        }

                    }
                }
                #-----------------------------------------------
            } else {
                echo "file too big";
                exit();
            }
        } else {
            echo "you had an error";
            exit();
        }
    } else {
        echo "wrong file type";
        exit();
    }
}