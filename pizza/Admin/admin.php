<?php
include_once "../includes/gallery_upload.php";
include_once "../includes/db.php";
include_once "../includes/gallery_delete.php";

echo '<head>
    <link rel="stylesheet" href="../style/style.css">
</head>';
#-----------------LOGIN

session_start();
if(!isset($_SESSION['username'])) {
    echo '<div id = "form">
    <h1>Login</h1>
    <form name = "form" method ="POST" action="login.php">
        <label>Username: </label>
        <input type="text" id="user" name="user"><br><br>
        <label>Password:</label>
        <input type="password" id="pass" name="pass"><br><br>
        <input type="submit" id="btn" value="login" name="submit">
    </form>

</div>';

    #-------------------Upload

} else {
    echo '<div class="gallery_upload">
        <h2>Image Upload</h2>
        <form action="../includes/gallery_upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="filename" placeholder="enter file name"> <br><br>
            <input type="text" name="filetitle" placeholder="image title"><br><br>
            <input type="text" name="filedesc" placeholder="image description"><br><br>
            <input type="file" name="file">
            <br><br>
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>';

    #-----------------------Delete
    echo '<br><div class="gallery_upload">
        <h2>Image Delete</h2>';
    $sql = "SELECT * FROM gallery;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="gallery-card">
                <div class="gallery-card-content" style="border: 1px solid black; padding: 10px; margin-bottom: 5px">
                    <img src=../gallery/'.$row['image_name'].' width="200">
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
}
?>