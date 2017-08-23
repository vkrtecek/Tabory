<?php
$id = $_REQUEST['id'];
$table = $_REQUEST['table'];
$nick = $_REQUEST['nick'];
$admin = $_REQUEST['admin'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" )  )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM ".$table." WHERE id=".$id );
		$task = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		$log = $admin.' just changed task with id '.$id.' ('.$task['ukol'].') give it to '.$nick;
		writeLog( $log, '../..', $table.'.txt' );
		
		
		$radceID = IDFromNick( $nick, $spojeni );
		$spojeni->query( "UPDATE ".$table." set radce=".$radceID.", modified='".getMyTime()."' WHERE id=".$id );
		echo 'success';
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php or ../../getMyTime().php doesn't exists.</p>";
?>