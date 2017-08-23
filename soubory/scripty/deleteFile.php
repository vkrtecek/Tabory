<?php
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];
$name = $_REQUEST['name'];

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$spojeni->query( "UPDATE ".$table." SET platnost = 0, down = '".IDFromNick($name, $spojeni)."' WHERE id = ".$id );
		$sql = $spojeni->query( "SELECT nazev FROM ".$table." WHERE id = ".$id );
		$l = mysqli_fetch_array( $sql );
		if ( file_exists("../files/".$l['nazev']) ) rename( "../files/".$l['nazev'], "../old/".$l['nazev'] );
	}
}
?>