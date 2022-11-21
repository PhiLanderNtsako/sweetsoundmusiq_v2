<?php
    include 'inc/config.php';

    if(isset($_POST['like'])){

        if(!isset($_COOKIE['likes'])) {

            $cookie_name = 'likes';
            $cookie_id = 'likes-'.$_SERVER['REMOTE_ADDR'];
        
            setcookie($cookie_name, $cookie_id, time() + 86400, "/");
            $musiq_id = $_POST['musiq_id'];

            if('likes'.$_SERVER['REMOTE_ADDR'] != $cookie_id){
                $updateLikes = "UPDATE musiq SET musiq_likes = musiq_likes + 1 WHERE musiq_id = '$musiq_id'";
            mysqli_query($conn, $updateLikes);
            echo mysqli_error($conn);
            }
        }
    }
    if(isset($_POST['download'])){

        if(!isset($_COOKIE['downloads'])) {

            $cookie_name = 'downloads';
            $cookie_id ='downloads-'.$_SERVER['REMOTE_ADDR'];
            setcookie($cookie_name, $cookie_id, time() + 86400, "/");

            $musiq_id = $_POST['musiq_id'];

            $updateDownloads = "UPDATE musiq SET musiq_downloads = musiq_downloads + 1 WHERE musiq_id = '$musiq_id'";
            mysqli_query($conn, $updateDownloads);
            echo mysqli_error($conn);
        }
    }

    $musiq_id = $_POST['musiq_id'];
    $query_musiq = "SELECT * FROM ((artist INNER JOIN  musiq ON artist.artist_id = musiq.artist_id) INNER JOIN musiq_link ON musiq.musiq_id = musiq_link.musiq_id) WHERE musiq.musiq_id = '$musiq_id'";
    $result_set = mysqli_query($conn, $query_musiq);
    $row=mysqli_fetch_assoc($result_set);

    echo '<meta http-equiv="refresh" content="0; url= '.$row['artist_name_slug'].'/'.$row['musiq_title_slug'].'">';
?>