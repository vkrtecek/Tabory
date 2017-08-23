<?php
$IP = $_REQUEST['IP'];
$URL = $_REQUEST['URL'];

$file = 'promenne.php';
$date = 'getMyTime().php';
if ( file_exists($file) && file_exists($date) ) {
	require($file);
	require($date);
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) ) {

		$sql = $spojeni->query( "INSERT INTO vlc_relog ( URL, IP, date ) values ( '".$URL."', '".$IP."', '".getMyTime()."' );" );
		echo 'ok';

	} else echo 'p>Connection failed.</p>';
} else echo "<p>File $file doesn't exists</p>";
