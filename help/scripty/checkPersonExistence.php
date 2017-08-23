<?php
$nick = $_REQUEST['nick'];

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT count(*) CNT FROM vlc_users WHERE nick = '".$nick."'" );
		$per = mysqli_fetch_array( $sql );
		echo $per['CNT'] == '0' ? 'true' : 'false';
	}
	else echo "false";
}
else echo "false";
?>