<?php
$login = $_REQUEST['login'];

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{		
		$sql = $spojeni->query( "SELECT count(*) CNT FROM vlc_users WHERE nick='".$login."'" );
		$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		echo $res['CNT'] == 0 ? 'success' : 'duplicity';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";