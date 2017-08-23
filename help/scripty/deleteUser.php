<?php
$id = $_REQUEST['id'];
$statement = "DELETE FROM vlc_users WHERE ID = ".$id;

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$log = 'Deleted user '.nicknameFromID($id, $spojeni).' (id='.$id.')';
		writeLog( $log, '../..', 'users.txt' );
		$spojeni->query( $statement );
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";