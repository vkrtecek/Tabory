<?php
$id = $_REQUEST['id'];
$table = $_REQUEST['table'];
$name = $_REQUEST['name'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM ".$table." WHERE id=".$id );
		$task = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		$log = $name.' just deleted task with id '.$id.' ('.$task['ukol'].')';
		writeLog( $log, '../..', $table.'.txt' );
		
		$spojeni->query( "DELETE FROM ".$table." WHERE id=".$id );
		echo 'success';
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>