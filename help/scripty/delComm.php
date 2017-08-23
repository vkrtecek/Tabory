<?php
$table = $_REQUEST['table'];
$ID = $_REQUEST['id'];

$promenne = '../../promenne.php';
if ( file_exists($promenne) )
{
	require('../../promenne.php');
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$spojeni->query( 'UPDATE '.$table.' SET platnost = 0 WHERE ID = '.$ID );
	}
	else echo '<h2>Connection with database had failed.</h2>';
}
else echo "<p>File $promenne doesn't exists.</p>";
?>