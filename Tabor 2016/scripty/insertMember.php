<?php
$name = $_REQUEST['name'];
$sname = $_REQUEST['sname'];
$nick = $_REQUEST['nick'];
$address = $_REQUEST['address'];
$birthdate = $_REQUEST['birthdate'];
$zdravi = $_REQUEST['zdravi'];
$telO = $_REQUEST['telO'];
$mailO = $_REQUEST['mailO'];
$telM = $_REQUEST['telM'];
$mailM = $_REQUEST['mailM'];
$photo = $_REQUEST['photo'];
$RC = $_REQUEST['RC'];
$who = $_REQUEST['who'];


if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$statement = "INSERT INTO vlc_boys ( name, sname, nick, address, birthdate, photo, zdravi, telO, mailO, telM, mailM, RC ) VALUES ( N'".$name."', N'".$sname."', N'".$nick."', N'".$address."', '".$birthdate."', N'".$photo."', N'".$zdravi."', '".$telO."', N'".$mailO."', '".$telM."', N'".$mailM."', '".$RC."' )";
		$spojeni->query( $statement );
		echo $statement;
		
		$log = $who.' just inserted boy '.$name.' '.$sname.' ('.$nick.')';
		$path = '../..';
		writeLog( $log, $path, 'vlc_boys.txt' );
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";

?>