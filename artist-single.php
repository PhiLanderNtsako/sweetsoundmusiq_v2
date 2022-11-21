<?php
    // include 'inc/top-cache.php';
    include 'inc/config.php';

    if(!empty($_GET['artist'])){

        $artist_name_slug = $_GET['artist'];

        $query_artistID = "SELECT artist_id, artist_name_slug FROM artist WHERE artist_name_slug = '$artist_name_slug'";
        $result_set = mysqli_query($conn, $query_artistID);
        $row = mysqli_fetch_assoc($result_set);

        if(!empty($row)){

            $artist_id = $row['artist_id'];

            $update_artist = "UPDATE artist SET artist_page_views = artist_page_views + 1 WHERE artist_id = '$artist_id'";
            mysqli_query($conn, $update_artist);
            echo mysqli_error($conn);
        }

    }else{
        echo '<meta http-equiv="refresh" content="0; url= artist">';
    }
    $query_artist2 = "SELECT * FROM artist WHERE artist_id = '$artist_id'";
    $result_set = mysqli_query($conn, $query_artist2);
    $row2 = mysqli_fetch_assoc($result_set);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162897830-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}s
      gtag('js', new Date());
      gtag('config', 'UA-162897830-1');
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:url" content="https://www.sweetsound.co.za/musiq/<?php echo $row2['artist_name_slug']?>">
  	<meta property="og:image:secure" content="https://www.sweetsound.co.za/musiq/images/artists_images/<?php echo $row2['artist_image'] ?>">
  	<meta name="description" content="Learn more about <?php echo $row2['artist_name'] ?>, who is a <?php echo $row2['artist_bio'] ?>. READ Full bio in website.">
  	<meta property="og:title" content="Sweet Sound Musiq Artist - <?php echo $row2['artist_name']?>">
  	<meta property="og:type" content="website">
  	<title>Sweet Sound Musiq Artist - <?php echo $row2['artist_name']?></title>
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="http://localhost/musiq-local/css/artist-link.css">
    <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: linear-gradient(rgba(22, 22, 22, 0.5), rgba(22, 22, 22, 0.5)), url('http://localhost/musiq-local/images/artists_images/<?php echo 'artist.jpg' //$row2['artist_image'] ?>')">
    <?php
        if(!empty($artist_id)){

            $query_artist = "SELECT * FROM artist INNER JOIN social_media_link ON artist.artist_id = social_media_link.artist_id WHERE artist.artist_id = '$artist_id'";
            $result_set = mysqli_query($conn, $query_artist);
            $rows=mysqli_fetch_assoc($result_set);
    ?>
            <div class="container">
                <div class="preview-img">
                    <img src="http://localhost/musiq-local/images/artists_images/<?php echo 'artist.jpg' //$rows['artist_image'] ?>">
                </div>
                <div>
                    <div class="details">
                        <h1><?php echo $rows['artist_name'] ?></h1>
                        <h2><?php echo $rows['artist_bio']?></h2>
                    </div>
                </div>
                <div class="link-options">
                    <div class="link-options-header">
                        <div class="link-options-triangle-back"></div>
                        <div class="link-options-triangle"></div>
                    </div>
                    <?php
                        $query_musiq = "SELECT * FROM artist INNER JOIN musiq ON artist.artist_id = musiq.artist_id WHERE artist.artist_id = '$artist_id'";
                        $result_set = mysqli_query($conn, $query_musiq);

                        while($row=mysqli_fetch_assoc($result_set)){
                    ?>
                        <a href="http://localhost/musiq-local/<?php echo $row['artist_name_slug'].'/'.$row['musiq_title_slug'] ?>" class="link-option">
                            <div class="link-option-row">
                                <div class="link-option-title">
                                    <span>
                                        <img id="artist-img" src="http://localhost/musiq-local/images/musiq_images/<?php echo $row['musiq_coverart'] ?>">
                                    </span>
                                </div>
                                <div id="link-option-action">
                                    <?php echo $row['musiq_title'] ?>
                                  <small></small>
                                </div>
                            </div>
                        </a>
                    <?php
                        }
                     ?>
                </div>
            </div>
    <?php
        }
        include 'footer.php';
    ?>
</body>
</html>
<?php
    // include 'inc/bottom-cache.php';
?>
