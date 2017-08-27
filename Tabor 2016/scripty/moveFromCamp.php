<?php
$id = $_REQUEST['id'];
$tableNow = $_REQUEST['tableNow'];
$who = $_REQUEST['who'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$spojeni->query( "DELETE FROM ".$tableNow." WHERE id = ".$id );
		
		$log = $who.' just deleted boy ('.$id.') from '.$tableNow;
		$path = '../..';
		writeLog( $log, $path, $tableNow.'.txt' );
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>