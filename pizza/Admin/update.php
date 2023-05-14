<?php
echo '<head>
    <link rel="stylesheet" href="../style/style.css">
</head>';

$id = $_POST['id'];
$origial_name = $_POST['original'];

echo '<div class="gallery_upload ">
        <h2>Image Update</h2>
        <form action="gallery_update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="original" value='.$origial_name.'>
            <input type="hidden" name="id" value='.$id.'>
            <input type="text" name="filename" placeholder="enter file name"> <br><br>
            <input type="text" name="filetitle" placeholder="image title"><br><br>
            <input type="text" name="filedesc" placeholder="image description"><br><br>
            <input type="file" name="file">
            <br><br>
            <button type="submit" name="submit" value="submit">Update</button>
        </form>
    </div>';
?>