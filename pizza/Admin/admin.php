<?php

include_once "../includes/db.php";

echo '<head>
    <link rel="stylesheet" href="../style/style.css">
</head>';

#-----------------LOGIN & REGISTER

session_start();
if(!isset($_SESSION['email'])) {
    echo
    '<div id="form">
    <h1>Login</h1>
    <form method="post" action="login.php">
        <input name="email" type="email" placeholder="E-mail">
        <input name="password" type="password" placeholder="Password">
        <input name="submit" type="submit" value="Login">
    </form>
    <h1>Register</h1>
    <form method="post" action="register.php">
		<input name="name" type="text" placeholder="Name..."><br>
		<input name="email" type="email" placeholder="Email..."><br>
		<input name="password" type="password" placeholder="Password..."><br>
		<input name="cPassword"" type="password" placeholder="Confirm Password..."><br>
	    <input name="submit" type="submit" value="Register"><br>
    </form>
    </div>';

#--------------------UPLOAD

} else {
    echo '<div class="gallery_upload">
        <h2>Image Upload</h2>
        <form action="gallery_upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="filename" placeholder="enter file name"> <br><br>
            <input type="text" name="filetitle" placeholder="image title"><br><br>
            <input type="text" name="filedesc" placeholder="image description"><br><br>
            <input type="file" name="file">
            <br><br>
            <button type="submit" name="submit">Upload</button>
        </form>
           </div>';

#------------------DELETE / UPDATE

    echo '<br><div class="gallery_upload">
          <h2>Image Delete</h2>';
    $sql = "SELECT * FROM gallery;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
        include_once "../includes/error_btns.php";
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['idGallery'];
            echo '<div class="gallery-card">
                <div class="gallery-card-content" style="border: 1px solid black; padding: 10px; margin-bottom: 5px">
                        <img src=../gallery/'.$row['image_name'].' width="200">
                        <h3>'.$row['idGallery'].'</h3>
                        <h3>'.$row['title'].'</h3>
                        <p>'.$row['description'].'</p>
                        
                    <form action="gallery_delete.php" method="post">
                        <input type="hidden" name="idGallery" value="'.$row['idGallery'].'">
                        <button type="submit" name="delete-submit">Delete</button>
                    </form>
                    
                    <!--------------- UPDATE ---------------!>
                   
                    <form action="update.php" method="post">
                            <input type="hidden" name="original" value="'.$row['image_name'].'">
                            <input type="hidden" name="id" value="'.$row['idGallery'].'">
                            <button type="submit" name="edit-submit">Edit</button>
                    </form>
                </div>
            </div>';
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>