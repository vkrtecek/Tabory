<?php
$photo = $_REQUEST['photo'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT count(*) CNT FROM vlc_boys WHERE photo = '".$photo."'" );
		$sql = mysqli_fetch_array( $sql );
		if ( $sql['CNT'] == 0 ) echo 'FALSE';
		else echo 'TRUE';
	}
	else echo 'DONT KNOW';
}
else echo 'DONT KNOW';

?>