<?php
include_once "../includes/gallery_update.php";
$id = $_GET['id'];
echo '<div class="gallery_update">
        <h2>Image Update</h2>
        <form action="../includes/gallery_update.php" method="post" enctype="multipart/form-data">
            <input type="text" name="filename" placeholder="enter file name"> <br><br>
            <input type="text" name="filetitle" placeholder="image title"><br><br>
            <input type="text" name="filedesc" placeholder="image description"><br><br>
            <input type="file" name="file">
            <br><br>
            <button type="submit" name="submit"><a href="admin.php">Update</a></button>
        </form>
    </div>';
?>