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
    <meta property="og:url" content="https://www.sweetsound.co.za/musiq/">
  	<meta property="og:image:secure" content="https://www.sweetsound.co.za/musiq/img/bg-img/">
  	<meta name="description" content="Access all songs, albums, poems, podcasts, etc. in one place for free. Sweet Sound Musiq website offers a streaming option, external DSP links. DOWNLOAD, STREAM, LIKE AND SHARE.">
  	<meta property="og:title" content="Sweet Sound Musiq - Home">
    <meta property="og:type" content="website">
    <title>Sweet Sound Musiq - Home</title>
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
        <section class="new-release-banner">
            <div class="heading-txt">
                <h3>New Release</h3>
            </div>
            <?php
                $sel_musiq = "SELECT * FROM ((artist INNER JOIN  musiq ON artist.artist_id = musiq.artist_id) INNER JOIN album ON musiq.musiq_id = album.musiq_id) WHERE musiq.musiq_type = 'Album' || musiq.musiq_type = 'Single' LIMIT 1";
                $query_musiq = mysqli_query($conn, $sel_musiq);

                while($row = mysqli_fetch_array($query_musiq)){
            ?>
            <a href="https://www.sweetsound.co.za/musiq/<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>">
                <div class="cover-art-lg slide-in">
                    <img id="slider" src="https://files.sweetsound.co.za/musiq/images/musiq_images/<?php echo $row['musiq_coverart'] ?>" alt="">
                </div>
                <div class="musiq-info slide-in">
                    <h3><?php echo $row['artist_name']?></h3>
                    <h5><?php echo $row['musiq_title'] ?></h5>
                </div>
            </a>
            <?php
            }
            ?>
        </section>
        <section class="subscribe-section">
            <div class="heading-txt">
                <h3>SUBSCRIBE</h3>
            </div>
            <form action="email.php" method="post" class="subscribe-form">
                <button type="submit" name="submit_subscribe"> <i class="fas fa-arrow-right"></i></button>
                <input type="email" name="subscriber_email" placeholder="Your email" pattern="[A-z0-9.]+@[A-z]+\.[A-z.]+" required>
            </form>
        </section>
        <section class="albums-section border-bottom">
            <div class="music-content-top">
                <div class="header-text">
                    <h3>Albums</h3>
                </div>
                <div class="view-more">
                    <a href="#" >more albums</a>
                </div>
            </div>
            <div class="music-content">
                <div class="cs-hidden" id="albums-slider">
                <?php
                    $query_musiq = "SELECT * FROM ((artist INNER JOIN  musiq ON artist.artist_id = musiq.artist_id) INNER JOIN album ON musiq.musiq_id = album.musiq_id) WHERE musiq.musiq_type = 'Album' LIMIT 5";
                    $result_set = mysqli_query($conn, $query_musiq);

                    while($row = mysqli_fetch_assoc($result_set)){

                        $data = preg_split("/[()+]/", $row['musiq_title'], -1, PREG_SPLIT_NO_EMPTY);
                        
                ?>
                    <a href="https://www.sweetsound.co.za/musiq/<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>">
                        <div class="albums-item">
                            <img class="cover-art" src="https://files.sweetsound.co.za/musiq/images/musiq_images/<?php echo $row['musiq_coverart'] ?>" alt="">
                            <div class="albums-item-info">
                                <p><?php echo $row['artist_name'] ?></p>
                                <p><?php echo $data[0] ?></p>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </section>
        <div class="musiq-section">
            <div class="music-content-top">
                <div class="header-text">
                    <h3>Singles</h3>
                </div>
                <div class="view-more">
                    <a href="#" >more singles</a>
                </div>
            </div>
            <?php
                $sel_musiq = "SELECT * FROM musiq, artist WHERE musiq.artist_id = artist.artist_id AND musiq.musiq_type = 'Single' ORDER BY musiq_id LIMIT 6";
                $query_musiq = mysqli_query($conn, $sel_musiq);

                while($row = mysqli_fetch_array($query_musiq)){

                    $data = preg_split("/[()+]/", $row['musiq_title'], -1, PREG_SPLIT_NO_EMPTY);
            ?>
            <div class="musiq-item border-bottom">
                <div class="musiq-details">
                    <a href="https://www.sweetsound.co.za/musiq/<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>">
                        <img src="https://files.sweetsound.co.za/musiq/images/musiq_images/<?php echo $row['musiq_coverart'] ?>" alt="">
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
                    <a href="https://www.sweetsound.co.za/musiq/<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>"><i class="fa fa-download"></i></a>
                </div>
            </div>
            <?php } ?>
            <div class="load-more">
                <a href="#" >LOAD MORE</a>
            </div>
        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.js" ></script>
    <script>
        // Product Slider
        $(document).ready(function() {
            $('#albums-slider').lightSlider({
                autoWidth:true,
                speed: 5000, //ms'
                auto: true,
                loop: true,
                slideEndAnimation: true,
                pause: 3000,
                controls: true,
                onSliderLoad: function() {
                    $('#albums-slider').removeClass('cs-hidden');
                } 
            });  
        });
        let slider = document.getElementById('slider');
        let isOpen = slider.classList.contains('slide-in');

        slider.setAttribute('class', isOpen ? 'slide-out' : 'slide-in');
    </script>
</body>
</html>
<?php
    include 'inc/bottom-cache.php';
?>