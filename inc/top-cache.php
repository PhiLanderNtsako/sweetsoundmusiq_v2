<?php 
        $url = $_SERVER['REQUEST_URI'];
        $break = Explode('/', $url);
        $file = $break[count($break) - 1];
        $cachefile = 'cache/cached-'.substr_replace($file , "",10).'.html';
        $cachetime = 1;

        if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)){
                echo "<!-- Cache copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
                readfile($cachefile);
                exit;
        }
        ob_start()
?>