<section id="gallery" class="templatemo-section templatemo-light-gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-uppercase">Gallery</h2>
                <hr>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src="images/gallery-img1.jpg" class="img-responsive gallery-img" alt="Pizza 1">
                    <div class="gallery-des">
                        <h3>Curabitur </h3>
                        <h5>Cras in ante mattis, elementum nunc sed.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src="images/gallery-img2.jpg" class="img-responsive gallery-img" alt="Pizza 2">
                    <div class="gallery-des">
                        <h3>Lorem ipsum</h3>
                        <h5>In ullamcorper gravida enim id pulvinar</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src="images/gallery-img3.jpg" class="img-responsive gallery-img" alt="Pizza 3">
                    <div class="gallery-des">
                        <h3>Pellentesque</h3>
                        <h5>Maecenas efficitur nisi id sapien</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src="images/gallery-img4.jpg" class="img-responsive gallery-img" alt="Pizza 4">
                    <div class="gallery-des">
                        <h3>Suspendisse</h3>
                        <h5>Mauris sit amet augue sit amet risus</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src="images/gallery-img5.jpg" class="img-responsive gallery-img" alt="Pizza 5">
                    <div class="gallery-des">
                        <h3>Elementum</h3>
                        <h5>Maecenas efficitur nisi id sapien</h5>
                    </div>
                </div>
            </div>
            <?php
            include_once 'db.php';
                $sql = "SELECT * FROM gallery ORDER BY orderGal ASC";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)){
                    "failed";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)){
                        echo '<div class="col-md-4 col-sm-4">
                <div class="gallery-wrapper">
                    <img src=gallery/'.$row["image_name"].' class="img-responsive gallery-img">
                    <div class="gallery-des">
                        <h3>'.$row["title"].'</h3>
                        <h5>'.$row["description"].'</h5>
                    </div>
                </div>
            </div>';
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
                ?>
        </div>
    </div>
</section>