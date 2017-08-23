<?php
$col = $_REQUEST['col'];
$val = $_REQUEST['val'];
$table = $_REQUEST['table'];
$id = $_REQUEST['id'];

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$true = false;
		$sql = $spojeni->query( 'SELECT * FROM '.$table );
		while ( $user = mysqli_fetch_array($sql) ) {
			if ( $user[$col] == $val && $user['ID'] != $id ) {
				echo 'true';
				$true = true;
				break;
			}
		}
		if ( $true == false ) echo 'false';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";