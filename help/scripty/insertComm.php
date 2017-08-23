<?php
$table = $_REQUEST['table'];
$name = $_REQUEST['name'];
$IP = $_REQUEST['ip'];

if ( file_exists('../../promenne.php') && file_exists('../../getMyTime().php') )
{
	require('../../promenne.php');
	require('../../getMyTime().php');
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$spojeni->query("INSERT INTO ".$table." (jmeno, subject, text, IP_address, datum) VALUES ('".IDFromNick($name, $spojeni)."', '".$_REQUEST['subject']."', '".$_REQUEST['comm']."', '".$IP."', '".getMyTime()."')");
	}
	else echo '<h2>Connection with database had failed.</h2>';
}
else echo "<p>File $promenne doesn't exists.</p>";
?>