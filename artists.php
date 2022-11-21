<?php
    include 'inc/top-cache.php';
    include 'inc/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://www.sweetsound.co.za/musiq/artists/">
  	<meta property="og:image:secure" content="https://www.sweetsound.co.za/musiq/img/bg-img/">
  	<meta name="description" content="View all Sweet Sound Musiq artists and learn more about them and check out them projects they did and released.">
  	<meta property="og:title" content="Sweet Sound Musiq - Artists">
    <meta property="og:type" content="website">
    <title>Sweet Sound Musiq - Artists</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lightslider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css">
</head>
<body>
    <?php
    include 'header.php';
    ?>
    <div class="music-section border-bottom">
        <div class="music-content-top">
            <div class="header-text">
                <h3>Artists</h3>
            </div>
            <div class="view-more">
                <a href="#" >filter</a>
            </div>
        </div>
        <div class="music-content">
            <div class="artist-list">
            <?php
                $sel_musiq = "SELECT * FROM artist ORDER BY artist_id DESC";
                $query_musiq = mysqli_query($conn, $sel_musiq);

                while($row = mysqli_fetch_array($query_musiq)){
            ?>
            <a href="https://www.sweetsound.co.za/musiq/artist-single.php?artist=<?php echo $row['artist_name_slug']?>">
                <div class="music-item">
                    <img class="cover-art" src="https://files.sweetsound.co.za/musiq/images/artists_images/<?php echo 'artist.jpg'//$row['artist_image'] ?>" alt="">
                    <div class="artist-info">
                        <p><?php echo $row['artist_name']?></p>
                    </div>
                </div>
            </a>
            <?php } ?>
            <div class="load-more">
                <a href="#" >LOAD MORE</a>
            </div>
            </div>
        </div>
    </div>
    <?php
    include 'footer.php';
    ?>
    <script src="app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js" ></script>
    <script>
        // Product Slider
        $(document).ready(function() {
            $('#cover-slides').lightSlider({
                autoWidth:true,
                speed: 5000, //ms'
                auto: true,
                loop: true,
                slideEndAnimation: true,
                pause: 3000,
                controls: true,
                onSliderLoad: function() {
                    $('#cover-slides').removeClass('cs-hidden');
                } 
            });  
        });
    </script>

</body>
</html>
<?php
    include 'inc/bottom-cache.php';
?>