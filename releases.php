<?php
    include 'inc/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://www.sweetsound.co.za/musiq/releases/">
  	<meta property="og:image:secure" content="https://www.sweetsound.co.za/musiq/img/bg-img/">
  	<meta name="description" content="Check out all singles and albums released under Sweet Sound Musiq distribution. Stream, Download, Like and Share any project you find.">
  	<meta property="og:title" content="Sweet Sound Musiq - Releases">
    <meta property="og:type" content="website">
    <title>Sweet Sound Musiq - Releases</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lightslider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css">
</head>
<body>
    <?php
    include 'header.php';
    ?>
    <div class="border-bottom"></div>
    <main>
    <div class="musiq-section">            
        <div class="heading-txt">
            <h3><?php echo strtoupper($musiq_type.'S') ?></h3>
        </div>
        <?php
            $sel_musiq = "SELECT * FROM musiq, artist WHERE musiq.artist_id = artist.artist_id AND musiq.musiq_type = 'single' || musiq.musiq_type = 'album' ORDER BY musiq_id";
            $query_musiq = mysqli_query($conn, $sel_musiq);

            while($row = mysqli_fetch_array($query_musiq)){

                $data = preg_split("/[()+]/", $row['musiq_title'], -1, PREG_SPLIT_NO_EMPTY);
        ?>
        <div class="musiq-item border-bottom">
            <div class="musiq-details">
                <a href="<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>">
                    <img src="images/musiq_images/<?php echo $row['musiq_coverart'] ?>" alt="">
                </a>
                <div class="musiq-details-info">
                    <div class="musiq-title">
                        <a href="<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>"><p><?php echo $data[0] ?></p></a>
                        <a href="<?php echo $row['artist_name_slug'] ?>"><p><?php echo $row['artist_name'] ?></p></a>
                    </div>
                    <div class="musiq-stats">
                        <i class="fa fa-eye"> <?php echo $row['musiq_page_views']?></i>
                        <i class="fa fa-heart">  <?php echo $row['musiq_likes']?></i>
                        <i class="fa fa-download">  <?php echo $row['musiq_downloads']?></i>
                    </div>
                </div>
            </div>
            <div class="view-btn">
                <a href="<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>"><i class="fa fa-download"></i></a>
            </div>
        </div>
        <?php } ?>
        <div class="load-more">
            <a href="#" >LOAD MORE</a>
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