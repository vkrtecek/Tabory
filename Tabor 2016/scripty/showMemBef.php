<?php
$tableAll = $_REQUEST['tableAll'];
$tableNow = $_REQUEST['tableNow'];


if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM ".$tableAll." WHERE member = 1 AND id NOT IN (SELECT id FROM ".$tableNow.") ORDER BY sname ASC" );
		echo '<ul>';
		while ( $mem = mysqli_fetch_array( $sql ) )
		{
			echo '<li><img src="imgs/plus.png" alt="plus" onclick="moveToCamp( '.$mem['id'].' )" />';
			echo $mem['name'].' '.$mem['sname'];
			if ( $mem['nick'] ) echo ' ('.$mem['nick'].')';
			echo '</li>';
		}
		echo '</ul>';
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>