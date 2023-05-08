<?php
include_once "../includes/gallery_upload.php";
$_SESSION['username'] = 'Admin';
#--------------------------- Upload formular
if (isset($_SESSION['username'])){
    #------------------------- NECHYTAT!!!!!!!!!!!!!!!!!!!!!!!
    echo('<div class="gallery_upload" style="display: flex; flex-direction: column; align-items: center;">
        <h1>Image Upload</h1>
        <form action="../includes/gallery_upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="filename" placeholder="enter file name"> <br><br>
            <input type="text" name="filetitle" placeholder="image title"><br><br>
            <input type="text" name="filedesc" placeholder="image description"><br><br>
            <input type="file" name="file">
            <br><br>
            <button type="submit" name="submit">Upload</button>

        </form>
    </div>');}
#------------------------- Delete formular
include_once "../includes/db.php";
include_once "../includes/gallery_delete.php";
if (isset($_SESSION['username'])) {
    echo('<div class="gallery_upload" style="display: flex; flex-direction: column; align-items: center;">
        <h2>Delete Images</h2>');
    $sql = "SELECT * FROM gallery;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="gallery-card">
                <div class="gallery-card-content">
                    <h3>'.$row['title'].'</h3>
                    <p>'.$row['description'].'</p>
                    <form action="../includes/gallery_delete.php" method="post">
                        <input type="hidden" name="idGallery" value="'.$row['idGallery'].'">
                        <button type="submit" name="delete-submit">Delete</button>
                    </form>
                </div>
            </div>';
        }
    }
    echo '</div>';
}
#-------------------------------------NECHYTAT!!!!!!!
?>