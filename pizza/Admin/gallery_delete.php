<?php
include_once "../includes/db.php";
if (isset($_POST['idGallery'])) {
    $image_id = $_POST['idGallery'];

    $sql = "SELECT * FROM gallery WHERE idGallery=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
        include_once "../includes/error_btns.php";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $image_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $image_name = $row['image_name'];
            $file_path = "../gallery/" . $image_name;
            unlink($file_path);

            $sql = "DELETE FROM gallery WHERE idGallery=?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed";
                include_once "../includes/error_btns.php";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $image_id);
                mysqli_stmt_execute($stmt);
                header("Location: ../index.php?delete=success");
            }
        } else {
            header("Location: ../index.php?delete=error");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

}
?>
