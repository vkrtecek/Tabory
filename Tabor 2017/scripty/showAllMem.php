<?php
$table = $_REQUEST['table'];
$order = $_REQUEST['order'];
$orderBy = $_REQUEST['orderBy'];
$pattern = $_REQUEST['pattern'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$statement = "SELECT * FROM ".$table;
		if ( $pattern != '' ) $statement .= " WHERE name LIKE N'%".$pattern."%' OR sname LIKE N'%".$pattern."%' OR nick LIKE N'%".$pattern."%'";
		$statement .= " ORDER BY ".$order." ".$orderBy;
		$sql = $spojeni->query( $statement );
		while ( $person = mysqli_fetch_array( $sql ) )
		{
			echo '<li onMouseOver="showFormUpdate( \''.$person['id'].'\', \'placeToFormUpdate\' )" style="cursor:pointer;">';
			echo $person['name'].' '.$person['sname'];
			if ( $person['nick'] ) echo ' ('.$person['nick'].')';
			echo '</li>';
		}
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>