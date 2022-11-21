<?php

	$dbhost = "localhost";

	$dbuser = "sweetsound_musiq_user";

	$dbpass = "SSFamily@17/22";

	$dbname = "sweetsound_musiq_db";

	$conn = mysqli_connect($dbhost,$dbuser,$dbpass) or die('cannot connect to the server'); 

	mysqli_select_db($conn,$dbname) or die('database selection problem');

?>