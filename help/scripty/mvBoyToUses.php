<?php
$id = $_REQUEST['id'];
$who = $_REQUEST['who'];
$passwd = 'klubovna';

function makeNick( $nick, & $spojeni ) {
	$nick = iconv('UTF-8', 'ASCII//TRANSLIT', $nick);
	$nick = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $nick));
	$sql = $spojeni->query( "SELECT count(*) CNT FROM vlc_users WHERE nick = '".$nick."'" );
	$data = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
	if ( $data['CNT'] > 0 ) makeNick( $nick.'_K', $spojeni );
	return $nick;
}

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM vlc_boys WHERE id=".$id );
		$boy = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		
		$st1 = 'UPDATE vlc_boys SET member=0 WHERE id='.$id;
		$spojeni->query( $st1 );
		$nick = makeNick( $boy['nick'], $spojeni );
		$mail = $boy['mailM'] != '' ? $boy['mailM'] :($boy['mailO'] != '' ? $boy['mailO'] : 'NULL');
		$telefon = $boy['telM'] != '' ? $boy['telM'] :($boy['telO'] != '' ? $boy['telO'] : 'NULL');
		$st2 = 'INSERT INTO vlc_users (name, sname, nick, nickname, passwd, mail, birthdate, platnost, etapa, aktivni, kuchar, admin, telefon) VALUES ( "'.$boy['name'].'", "'.$boy['sname'].'", "'.$nick.'", "'.$boy['nick'].'", "'.$passwd.'", "'.$mail.'", "'.$boy['birthdate'].'", 1, 0, 1, 0, 0, '.$telefon.' );';
		$spojeni->query( $st2 );
		
		$log = $who.' just moved boy '.$boy['name'].' '.$boy['sname'].' '.$boy['nick'].' into vlc_users as Vedoucí';
		writeLog( $log, '../..', 'users.txt' );
		
		//send him an email
		$subject = 'Nový účet na 51. smečce Vlčat';
		$message = 'Byl Vám vytvořen nový účet na http://vlcata.pohrebnisluzbazlin.cz.

Přihlašovací jméno: '.$nick.'
Heslo: '.$passwd.'

S případnými dotazy se obraťte na správce webu ('.$spravce.')';
		$headers = 'From: Vlčata <'.$spravce.'>';
		mail( $mail, $subject, $message, $headers );
		
		//send mail to admin
		$messAdmin = 'Everything gone OK 
'.$st1.'
'.$st2.'
Mail sent to '.$mail.'. Check if it is right mail.';
		mail( $spravce, 'Move boy '.$boy['name'].' '.$boy['sname'].' ('.$boy['nick'].') to users', $messAdmin, $headers );
		
		
		$log = 'Created new user '.$_REQUEST['nick'];
		writeLog( $log, '../..', 'users.txt' );
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";