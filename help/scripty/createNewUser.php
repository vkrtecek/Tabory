<?php
$telefon = $_REQUEST['telefon'] == "NULL" || $_REQUEST['telefon'] == "" ? NULL : $_REQUEST['telefon'];
$statement1 = "INSERT INTO vlc_users ( name, sname, nick, nickname, passwd, mail, birthdate, platnost, etapa, aktivni, kuchar, admin, telefon ) VALUES ( N'".$_REQUEST['name']."',  N'".$_REQUEST['sname']."',  N'".$_REQUEST['nick']."',  N'".$_REQUEST['nickname']."', N'".$_REQUEST['passwd']."', N'".$_REQUEST['mail']."', '".$_REQUEST['birthdate']."', ".$_REQUEST['platnost'].", ".$_REQUEST['etapa'].", ".$_REQUEST['aktivni'].", ".$_REQUEST['kuchar'].", ".$_REQUEST['admin'].", '".$telefon."' );";
//$statement2 = "INSERT INTO vlc_last_log ( nick, mail ) VALUES ( '".$_REQUEST['nick']."', '".$_REQUEST['mail']."' );";


$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( $spojeni->query( $statement1 ) )
		{
			$subject = 'Nový účet na 51. smečce Vlčat';
			$message = 'Byl Vám vytvořen nový účet na http://vlcata.pohrebnisluzbazlin.cz.

Přihlašovací jméno: '.$_REQUEST['nick'].'
Heslo: '.$_REQUEST['passwd'].'

S případnými dotazy se obraťte na správce webu ('.$spravce.')';
			$headers = 'From: Vlčata <'.$spravce.'>';
			mail( $_REQUEST['mail'], $subject, $message, $headers );
			echo '<p>Everything gone OK <br />'.$statement1.'<br />Mail sent to '.$_REQUEST['mail'].'</p>';
			
			$log = 'Created new user '.$_REQUEST['nick'];
			writeLog( $log, '../..', 'users.txt' );
		}
		else {
			echo '<p>Statement contain mistake<br /><br />'.$statement1.'</p>';
			$log = 'Creating new user '.$_REQUEST['nick'].' had failed';
			writeLog( $log, '../..', 'users.txt' );
		}
		//if ( $spojeni->query( $statement2 ) ) echo $statement2;
		//else echo '<p>Statement contain mistake<br /><br />'.$statement2.'</p>';
		
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>