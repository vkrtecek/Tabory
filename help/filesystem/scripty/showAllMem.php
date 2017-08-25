<?php
$table = $_REQUEST['table'];
$order = $_REQUEST['order'];
$orderBy = $_REQUEST['orderBy'];
$pattern = $_REQUEST['pattern'];
$active = $_REQUEST['active'] == 'true' ? true : false;

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$statement = "SELECT * FROM ".$table;
		if ( $pattern != '' || $active == false ) {
			$statement .= " WHERE";
			if ( $pattern != '' ) $statement .= " (name LIKE N'%".$pattern."%' OR sname LIKE N'%".$pattern."%' OR nick LIKE N'%".$pattern."%')";
			if ( $pattern != '' && $active == false ) $statement .= " and";
			if ( $active == false ) $statement .= " member=1";
		}
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