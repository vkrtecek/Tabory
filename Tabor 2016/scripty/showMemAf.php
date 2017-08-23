<?php
$tableAll = $_REQUEST['tableAll'];
$tableNow = $_REQUEST['tableNow'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM ".$tableNow );
		echo '<ul>';
		while ( $mem = mysqli_fetch_array( $sql ) )
		{
			$sql2 = $spojeni->query( "SELECT * FROM ".$tableAll." WHERE id = ".$mem['id'] );
			$mem = mysqli_fetch_array( $sql2 );
			echo '<li><img src="imgs/minus.png" alt="minus" onclick="moveFromCamp( '.$mem['id'].' )" />';
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