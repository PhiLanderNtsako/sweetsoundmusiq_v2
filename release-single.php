 <?php
    include 'inc/top-cache.php';
    include 'inc/config.php';

   $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(isset($_POST['like'])){

        $musiq_id = $_POST['musiq_id'];

        if(!isset($_COOKIE[$musiq_id.'likes'])) {

            $cookie_name = $musiq_id.'likes';
            $cookie_id = 'likes-'.$musiq_id.$link;
        
            setcookie($cookie_name, $cookie_id, time() + 86400, "/");

            if('likes'.$_SERVER['REMOTE_ADDR'] != $cookie_id){
                $updateLikes = "UPDATE musiq SET musiq_likes = musiq_likes + 1 WHERE musiq_id = '$musiq_id'";
            mysqli_query($conn, $updateLikes);
            echo mysqli_error($conn);
            }
        }
    }
    if(isset($_POST['download'])){

        if(!isset($_COOKIE['downloads'])) {

            $musiq_id = $_POST['musiq_id'];

            $cookie_name = 'downloads';
            $cookie_id ='downloads-'.$musiq_id.$link;
            setcookie($cookie_name, $cookie_id, time() + 86400, "/");

            $updateDownloads = "UPDATE musiq SET musiq_downloads = musiq_downloads + 1 WHERE musiq_id = '$musiq_id'";
            mysqli_query($conn, $updateDownloads);
            echo mysqli_error($conn);
        }
    }

    if(!isset($_COOKIE['user_ip'])){

        $cookie_name = 'user_ip';
        $cookie_id = $link;

        setcookie($cookie_name, $cookie_id, time() + (18), "/");
        $musiq_title_slug = $_GET['title'];
        
        $query_musiqID = "SELECT musiq_id, musiq_title_slug FROM musiq WHERE musiq_title_slug = '$musiq_title_slug'";
        $result_set = mysqli_query($conn, $query_musiqID);
        $row = mysqli_fetch_assoc($result_set);

        if(!empty($row)){

            $musiq_id = $row['musiq_id'];

            $update_musiq = "UPDATE musiq SET musiq_page_views = musiq_page_views + 1 WHERE musiq_id = '$musiq_id'";
            mysqli_query($conn, $update_musiq);
            echo mysqli_error($conn);
        }
    }

    $musiq_title_slug = $_GET['title'];
        
    $query_musiqID = "SELECT musiq_id, musiq_title_slug, musiq_type FROM musiq WHERE musiq_title_slug = '$musiq_title_slug'";
    $result_set = mysqli_query($conn, $query_musiqID);
    $row3 = mysqli_fetch_assoc($result_set);
    $musiq_id = $row3['musiq_id'];
    
    $query_musiq2 = "SELECT * FROM musiq, artist WHERE musiq.artist_id = artist.artist_id AND musiq.musiq_id = '$musiq_id'";
    $result_set = mysqli_query($conn, $query_musiq2);
    $row2 = mysqli_fetch_assoc($result_set);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://www.sweetsound.co.za/musiq/<?php echo $row2['artist_name_slug'].'/'.$row2['musiq_title_slug'] ?>">
    <meta property="og:image:secure" content="https://files.sweetsound.co.za/images/musiq_images/<?php echo $row2['musiq_coverart'] ?>">
    <meta name="description" content="Stream, Download, Like and Share <?php echo $row2['artist_name'].' - '.$row2['musiq_title'].' ['.$row2['musiq_type']?>] from your preferred platform. Download MP3 file straight from Sweet Sound Musiq website.">
    <meta property="og:title" content="<?php echo $row2['artist_name'].' - '.$row2['musiq_title'] ?>">
    <meta property="og:type" content="website">
    <title><?php echo $row2['artist_name'].' - '.$row2['musiq_title'] ?></title>
    <link rel="stylesheet" href="https://www.sweetsound.co.za/musiq/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css">
</head>
<body>
<?php
    include 'header.php';
?>
    <div class="border-bottom"></div>
    <main>
        <?php
            if(!empty($musiq_id)){

                $query_musiq = "SELECT * FROM (artist INNER JOIN  musiq ON artist.artist_id = musiq.artist_id) WHERE musiq.musiq_id = '$musiq_id'";
                $result_set = mysqli_query($conn, $query_musiq);
                $row123=mysqli_fetch_assoc($result_set);

                if($row123['musiq_type'] == 'Album-Track'){

                    $query_musiq = "SELECT * FROM (album_single INNER JOIN musiq ON album_single.musiq_id = musiq.musiq_id) INNER JOIN artist ON musiq.artist_id = artist.artist_id WHERE musiq.musiq_id = '$musiq_id'";
                    $result_set = mysqli_query($conn, $query_musiq);
                    $row=mysqli_fetch_assoc($result_set);
                }else{
                    $query_musiq = "SELECT * FROM ((artist INNER JOIN  musiq ON artist.artist_id = musiq.artist_id) INNER JOIN musiq_link ON musiq.musiq_id = musiq_link.musiq_id) WHERE musiq.musiq_id = '$musiq_id'";
                    $result_set = mysqli_query($conn, $query_musiq);
                    $row=mysqli_fetch_assoc($result_set);
                }
                $data = preg_split("/[()+]/", $row['musiq_title'], -1, PREG_SPLIT_NO_EMPTY);
                
        ?>
        <div class="song-content">
            <div class="song-details">
                <div class="album-singles off">
                    <ul class="scroll">
                    <?php
                        $musiq_id = $row['musiq_id'];
                        $query_album = "SELECT * FROM album WHERE musiq_id = '$musiq_id'";
                        $result_set = mysqli_query($conn, $query_album);
                        $row_album = mysqli_fetch_assoc($result_set);

                        $album_id = $row_album['album_id'];
                        $query_musiq = "SELECT * FROM (album_single INNER JOIN musiq ON album_single.musiq_id = musiq.musiq_id) INNER JOIN artist ON musiq.artist_id = artist.artist_id WHERE album_single.album_id = '$album_id'";
                        $result_set = mysqli_query($conn, $query_musiq);
                        $i = 0;
                        
                        while ($row_tracks = mysqli_fetch_assoc($result_set)){
                    ?>
                                <div class="album-track border-bottom">
                                    <?php 
                                        $s = $i+1;
                                        echo '<a href="">'.$row_tracks['musiq_title'].'</a>'; ?>
                                </div>
                            <?php
                                $i++;
                                echo '<script type="text/javascript"> var audio = "'.$row_tracks['musiq_file'].'";</script>';
                                }
                            ?>
                    </ul>
                </div>
                <img id="swap" src="https://files.sweetsound.co.za/images/musiq_images/<?php echo $row['musiq_coverart'] ?>" alt="">
                <h2><?php echo $data[0] ?></h2>
                <h3><?php echo $row['artist_name'] ?></h3>
                <?php
                    if(!empty($data[1])){
                        echo '<h4>('.$data[1].')</h4>';
                    }
                ?>
            </div>
            <div class="progress-bar">
                <div class="current-time">00:00</div>
                <input id="seekSlider" type="range" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
                <div class="total-duration">00:00</div>
            </div>
            <div class="controls">
                <div id="like" class="player-btn">
                <?php
                    if(isset($_COOKIE[$row['musiq_id'].'likes'])) {
                        echo '
                            <i id="likeIcon" class="fa-solid fa-heart"></i>
                        ';
                    }else{
                        echo '
                        <i id="likeIcon" class="fa-regular fa-heart"></i>
                        '; 
                    }      
                ?>
                </div>
                <div onclick="" id="prev"  onclick="prevTrack()" class="player-btn"><i class="fa fa-step-backward"></i></div>
                <div id="play-pause" onclick="playpauseTrack()" class="player-btn"><i class="fa fa-play-circle fa-2x"></i></div>
                <audio id="audio" src="songs/singles/<?php echo $row['musiq_file'] ?>" autoplay="false" ></audio>
                <div id="next" onclick="nextTrack()" class="player-btn"><i class="fa fa-step-forward"></i></div>
                <div id="download" class="player-btn"><i class="fa fa-download"></i></div>

                <form id="like_form" action="" method="post">
                    <input type="hidden" name="musiq_id" value="<?php echo $row['musiq_id'] ?>" >
                    <input type="hidden" name="like" value="like" >
                    <input type="submit" name="submit-like" id="submit-like" value="submit-like" hidden />
                </form>
                <form id="download_form" action="" method="post">
                    <input type="hidden" name="musiq_id" value="<?php echo $row['musiq_id'] ?>" >
                    <input type="hidden" name="download" value="download" >
                    <input type="submit" name="submit" id="submit-form" value="submit" hidden />
                </form>
                <form id="play_form" action="" method="post">
                    <input type="hidden" name="musiq_id" value="<?php echo $row['musiq_id'] ?>" >
                    <input type="hidden" name="play" value="play" >
                    <input type="submit" name="submit-play" id="submit-play" value="submit-play" hidden />
                </form>
            </div>
            <div class="progress-bar border-bottom">
                <?php 
                    if($row['musiq_type'] == 'Album'){
                ?>
                <div id="tracklist-btn" class="player-btn"><i class="fa fa-list"></i></div>
                <div class="volume-bar">
                    <i class="fa fa-volume-down"></i>
                    <input type="range" min="1" max="100" value="100" class="volume_slider" onchange="setVolume()" style="width:150px;">
                    <i class="fa fa-volume-up"></i>
                </div>
                <?php 
                    }else{
                ?>
                <div class="volume-bar">
                    <i class="fa fa-volume-down"></i>
                    <input type="range" min="1" max="100" value="100" class="volume_slider" onchange="setVolume()" style="width:200px;">
                    <i class="fa fa-volume-up"></i>
                </div>
                <?php } ?>
            </div>
            <div class="musiq-links">
                <?php if(!empty($row['link_genius_lyrics'])){ ?>
                <a href="<?php echo $row['link_genius_lyrics'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/genius.png" alt="">
                        <h2> Lyrics</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_spotify'])){ ?>
                <a href="<?php echo $row['link_spotify'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/spotify.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_youtube'])){ ?>
                <a href="<?php echo $row['link_youtube'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/youtube.png" alt="">
                        <h2> Watch</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_applemusic'])){ ?>
                <a href="<?php echo $row['link_applemusic'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/apple-music.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_youtubemusic'])){ ?>
                <a href="<?php echo $row['link_youtubemusic'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/youtube-music.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_amazonmusic'])){ ?>
                <a href="<?php echo $row['link_amazonmusic'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/amazon-music.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_deezer'])){ ?>
                <a href="<?php echo $row['link_deezer'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/deezer.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_audiomack'])){ ?>
                <a href="<?php echo $row['link_audiomack'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/audiomack.png" alt="">
                        <h2> Play</h2>
                    </div>
                <a/>
                <?php }?>
                <?php if(!empty($row['link_itunes'])){ ?>
                <a href="<?php echo $row['link_itunes'] ?>">
                    <div class="musiq-link-item">
                        <img src="https://www.sweetsound.co.za/musiq/img/icons/itunes.png" alt="">
                        <h2> Buy</h2>
                    </div>
                <a/>
                <?php }?>
            </div>
        </div>
        <?php
        if($row['musiq_type'] == 'Single' || $row['musiq_type'] == 'Album-Track'){
            echo '<script type="text/javascript"> var songFile = "'.$row['musiq_file'].'";</script>';
        }else{
            $musiq_id = $row['musiq_id'];
            $query_album = "SELECT * FROM album WHERE musiq_id = '$musiq_id'";
            $result_set = mysqli_query($conn, $query_album);
            $row_album = mysqli_fetch_assoc($result_set);

            $album_id = $row_album['album_id'];
            $query_musiq = "SELECT * FROM (album_single INNER JOIN musiq ON album_single.musiq_id = musiq.musiq_id) INNER JOIN artist ON musiq.artist_id = artist.artist_id WHERE album_single.album_id = '$album_id'";
            $result_set = mysqli_query($conn, $query_musiq);
            $i = 0;
            $songs = array();
            // print_r(mysqli_fetch_assoc($result_set));
            while($row_tracks = mysqli_fetch_assoc($result_set)){
                $i++;
                $songs[] = $row_tracks['musiq_file'];
            }
            echo '<script type="text/javascript"> var songFile = '.json_encode($songs).';</script>';
        }
    }
        ?>

    </div>
    </main>  
    <script>
                
        let playpause_btn = document.querySelector("#play-pause");
        let next_btn = document.querySelector("#next");
        let prev_btn = document.querySelector("#prev");

        let seek_slider = document.querySelector(".seek_slider");
        let volume_slider = document.querySelector(".volume_slider");
        let curr_time = document.querySelector(".current-time");
        let total_duration = document.querySelector(".total-duration");

        let track_index = 0;
        let isPlaying = false;
        let updateTimer;

        // Create new audio element
        let curr_track = document.createElement('audio');
        // function submitCopy() {
        //     /* Get the text field */
        //     var copyText = document.getElementById("submit-copy");

        //     /* Select the text field */
        //     copyText.select();
        //     copyText.setSelectionRange(0, 99999); /* For mobile devices */

        //      /* Copy the text inside the text field */
        //     navigator.clipboard.writeText(copyText.value);

        //     /* Alert the copied text */
        //     alert("Link Coppied In Clipboard: " + copyText.value);
        // }

        // Define the tracks that have to be played}

        var test = "<?php echo $row2['musiq_type'] ?>";
            
        if(test === 'Album'){
            var track_list = [];
            for (var song of songFile){
                track_list.push({ path: 'https://files.sweetsound.co.za/musiq/singles/'+song });        
            }
        }
        if(test === 'Single' || test === 'Album-Track'){
            var track_list = [{
                path: 'https://files.sweetsound.co.za/musiq/singles/'+songFile
            },];
        }

        function loadTrack(track_index) {
            clearInterval(updateTimer);
            resetValues();
            curr_track.src = track_list[track_index].path;
            curr_track.autoplay="";
            curr_track.muted="";
            curr_track.playsinline="";
            
            curr_track.load();

            updateTimer = setInterval(seekUpdate, 1000);
            curr_track.addEventListener("ended", nextTrack);
        }

        function resetValues() {
            curr_time.textContent = "00:00";
            total_duration.textContent = "00:00";
            seek_slider.value = 0;
        }

        // Load the first track in the tracklist
        loadTrack(track_index);

        function playpauseTrack() {
        if (!isPlaying){
            playTrack();
            // document.createElement('div').classList.add('waveform');
            // document.getElementById('seekSlider').classList.add('off');
        }else pauseTrack();
        }

        function playTrack() {
            curr_track.play();
            isPlaying = true;
            playpause_btn.innerHTML = '<i class="fa fa-pause-circle fa-2x"></i>';
        }

        function pauseTrack() {
            curr_track.pause();
            isPlaying = false;
            playpause_btn.innerHTML = '<i class="fa fa-play-circle fa-2x"></i>';;
        }

        function nextTrack() {
            if (track_index < track_list.length - 1)
                track_index += 1;
            else track_index = 0;
            loadTrack(track_index);
            playTrack();
        }

        function prevTrack() {
            if (track_index > 0)
                track_index -= 1;
            else track_index = track_list.length;
            loadTrack(track_index);
            playTrack();
        }

        function seekTo() {
            let seekto = curr_track.duration * (seek_slider.value / 100);
            curr_track.currentTime = seekto;
        }

        function setVolume() {
            curr_track.volume = volume_slider.value / 100;
        }

        function seekUpdate() {
            let seekPosition = 0;

            if (!isNaN(curr_track.duration)) {
                seekPosition = curr_track.currentTime * (100 / curr_track.duration);

                seek_slider.value = seekPosition;

                let currentMinutes = Math.floor(curr_track.currentTime / 60);
                let currentSeconds = Math.floor(curr_track.currentTime - currentMinutes * 60);
                let durationMinutes = Math.floor(curr_track.duration / 60);
                let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);

                if (currentSeconds < 10) { currentSeconds = "0" + currentSeconds; }
                if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
                if (currentMinutes < 10) { currentMinutes = "0" + currentMinutes; }
                if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }

                curr_time.textContent = currentMinutes + ":" + currentSeconds;
                total_duration.textContent = durationMinutes + ":" + durationSeconds;
            }
        }

        const download = document.querySelector("#download");
        const like = document.querySelector("#likeIcon");
        const submitForm = document.querySelector("#submit-form");
        const submitLike = document.querySelector("#submit-like");
        const tracklist = document.querySelector("#tracklist-btn");
        const albumSingles = document.querySelector(".album-singles");
        const image = document.querySelector("#swap");

        var musiq_file = "<?php echo $row['musiq_file'] ?>";
        var album_file = "<?php echo $row2['musiq_file'] ?>";
        var test = "<?php echo $row2['musiq_type'] ?>";

        if(test === 'Album'){
            download.addEventListener("click", () => {

            let element = document.createElement("a");
            element.href = "https://files.sweetsound.co.za/musiq/albums/"+album_file;
            element.download = album_file;

            document.documentElement.appendChild(element);
            element.click();
            document.documentElement.removeChild(element);

            submitForm.click();
            
            tracklist.addEventListener("click", () => {
            if(albumSingles.classList.contains('off')){
                albumSingles.classList.remove('off');
                image.classList.add('off');
            }else{
                albumSingles.classList.add('off');
                image.classList.remove('off');  
            }
        });
            
        });
        }else{
            download.addEventListener("click", () => {

            let element = document.createElement("a");
            element.href = "https://files.sweetsound.co.za/musiq/singles/"+musiq_file;
            element.download = musiq_file;

            document.documentElement.appendChild(element);
            element.click();
            document.documentElement.removeChild(element);

            submitForm.click();
        });
        }
        
        like.addEventListener("click", () => {
            submitLike.click();
        });


    </script>
</body>
</html>
<?php
    include 'inc/bottom-cache.php';
?>