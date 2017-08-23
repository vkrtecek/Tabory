<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account activator</title>
<style>
*{ margin:0; padding:0; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; font-size:18px; }
#ac{
	position:absolute;
	top:50%;
	left:50%;
	margin-left:-10em;
}
</style>
</head>
<body>
<?php 
if ( isset($_REQUEST['j']) && isset($_REQUEST['d']) && file_exists("promenne.php") ) //name && mail
{
	require("promenne.php");
	
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if( $spojeni && $spojeni->query("SET CHARACTER SET UTF8") )
	{
		if ( $spojeni->query("SELECT * FROM vlc_users WHERE nick = '".$_REQUEST['j']."' && platnost = 0") )
		{
			if ( file_exists('getMyTime().php') ) require('getMyTime().php');
			$spojeni->query("UPDATE vlc_users SET platnost = 1, mail = '".$_REQUEST['d']."' WHERE nick = '".$_REQUEST['j']."'");
			$spojeni->query("INSERT INTO vlc_last_log  ( nick, mail, date, IP_address ) VALUES ( '".$_REQUEST['j']."', '".$_REQUEST['d']."', '".getMyTime()."', '".$_SERVER['REMOTE_ADDR']."' )");
			echo '<p id="ac">Váš účet byl aktivován. Nyní se můžete <a href="index.php">přihlásit</a></p>';
			
			$log = $_REQUEST['j'].' ('.$_REQUEST['d'].') just activated his/her account';
			writeLog( $log );
		}
		else {
			echo '<p id="ac">Váš účet již není v databázi nebo již je aktivován.</p>';
			$log = $_REQUEST['j'].' ('.$_REQUEST['d'].') IP='.$_SERVER['REMOTE_ADDR'].' activation failed';
			writeLog( $log );
		}
	}
	else echo '<p id="ac">Spojení s databází nenavázáno. Aktivace neproběhla úspěšně.</p>';
}
else echo '<p id="ac">Něco se pokazilo. Aktivace neproběhla úspěšně.</p>';
?>
</body>
</html>