<?php
$table = $_REQUEST['table'];
$col = $_REQUEST['col'];
$id = $_REQUEST['id'];
$val = $_REQUEST['val'];
$promenne = '../../promenne.php';

if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$query = "UPDATE ".$table." set ".$col."='".$val."' WHERE den=".$id;
		if ( $spojeni->query($query) ) echo 'success';
		else echo 'fail -> '.$query;
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";