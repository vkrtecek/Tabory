<?php
$name = $_REQUEST['name'];
$sname = $_REQUEST['sname'];
$nick = $_REQUEST['nick'];
$nickname = $_REQUEST['nickname'];
$passwd = $_REQUEST['passwd'];
$mail = $_REQUEST['mail'];
$REF = $_REQUEST['reference'];

function sendMail( $mail, $REF, $spravce )
{
	$to = $mail;
	$subject = "Account activation";
	$message = 'http://vlcata.pohrebnisluzbazlin.cz/activation.php?j='.$REF.'&d='.$mail;
	$headers = 'From: 51. Smečka Vlčat <'.$spravce .'>';
	
	mail($to, $subject, $message, $headers);
}


if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$oldStatement = 'SELECT * FROM vlc_users WHERE nick="'.$REF.'"';
		$sql = $spojeni->query( $oldStatement );
		$old = mysqli_fetch_array( $sql );
		
		
		
		
		$and = false;
		$prikaz = 'UPDATE vlc_users SET ';
		if ( $name != '' )
		{
			$prikaz .= ' name="'.$name.'"';
			$and = true;
		}
		if ( $sname != '' )
		{
			if ( $and ) $prikaz .= ',';
			$prikaz .= ' sname="'.$sname.'"';
			$and = true;
		}
		if ( $nick != '' )
		{
			if ( $and ) $prikaz .= ',';
			$prikaz .= ' nick="'.$nick.'"';
			$and = true;
		}
		if ( $nickname  != '' )
		{
			if ( $and ) $prikaz .= ',';
			$prikaz .= ' nickname="'.$nickname.'"';
			$and = true;
		}
		if ( $passwd != '' )
		{
			if ( $and ) $prikaz .= ',';
			$prikaz .= ' passwd="'.$passwd.'"';
			$and = true;
			
			$message = 'Dobrý den,
na stránkách http://vlcata.pohrebnisluzbazlin.cz Vám bylo změněno heslo.

Přihlašovací jméno: '.($nick == '' ? $old['nick'] : $nick ).'
Nové heslo: '.$passwd.'

Pokud o této změně nic nevíte, kontaktujte prosím správce webu ('.$spravce.')

Pěkný den.';
			if ( file_exists( '../../getMyTime().php' ) && require( '../../getMyTime().php' ) ) $message .= ' ('.dateToReadableFormat(getMyTime()).')';
			mail( $old['mail'], 'Informace o změně hesla', $message, 'From: 51. smečka Vlčat<'.$spravce.'>' );
		}
		if ( $mail != '' )
		{
			if ( $and ) $prikaz .= ',';
			$prikaz .= ' mail="'.$mail.'", platnost=0';
			
			sendMail( $mail, $REF, $spravce );
		}
		$prikaz .= ' WHERE nick = "'.$REF.'"';
		
		if ( $name != '' ) echo 'Jméno změněno na '.$name;
		if ( $sname != '' ) echo '<br>Příjmení změněno na '.$sname;
		if ( $nick != '' ) echo '<br>nick změněn na '.$nick;
		if ( $nickname  != '' ) echo '<br>Přezdívka změněna na '.$nickname;
		if ( $passwd != '' )
		{
			echo '<br>Heslo změněno na ';
			for ( $i = 0; $i < strlen($passwd); $i++) echo '*';
			echo ' znění hesla bylo zasláno na starý e-mail';
		}
		if ( $mail != '' ) echo '<br>E-mail změněn na '.$mail.'<br>Kvůli změně e-mailu Vám byl dočasně znemožněn přístup a účet si musíte aktivovat pomocí odkazu zaslaného na e-mail';
		if ( $name == '' && $sname == '' && $nick == '' && $nickname == '' && $passwd == '' && $mail == '' ) echo 'Nic nezměněno.';
		
		$spojeni->query( $prikaz );
		//echo $prikaz;
		
		
		/*$vlc_syslog_name = $vlc_syslog_sname = $vlc_last_log_mail = $vlc_syslog_user = $vlc_last_log_nick = $vlc_comments_jmeno = $vlc_files_inserted = $vlc_files_down = $vlc_tatranky_kdo = '';*/

		if ( $name != '' )
		{
			//$vlc_syslog_name = 'UPDATE vlc_syslog SET name="'.$name.'" WHERE name="'.$old['name'].'";';
			//$spojeni->query( $vlc_syslog_name );
		}
		if ( $sname != '' )
		{
			//$vlc_syslog_sname = 'UPDATE vlc_syslog SET sname="'.$sname.'" WHERE sname="'.$old['sname'].'";';
			//$spojeni->query( $vlc_syslog_sname );
		}
		if ( $mail != '' )
		{
			//$vlc_last_log_mail = 'UPDATE vlc_last_log SET mail="'.$mail.'" WHERE nick ="'.$REF.'"';
			//$vlc_syslog_user = 'UPDATE vlc_syslog SET user="'.$mail.'" WHERE user="'.$old['mail'].'"';
			//$spojeni->query( $vlc_last_log_mail );
			//$spojeni->query( $vlc_syslog_user );
			
		}
		if ( $nick != '' )
		{
			//$vlc_last_log_nick = 'UPDATE vlc_last_log SET nick="'.$nick.'" WHERE nick ="'.$REF.'"';
			//$vlc_comments_jmeno = 'UPDATE vlc_comments SET jmeno="'.$nick.'" WHERE jmeno="'.$REF.'";';
			//$vlc_files_inserted = 'UPDATE vlc_files SET inserted="'.$nick.'" WHERE inserted="'.$REF.'";';
			//$vlc_files_down = 'UPDATE vlc_files SET down="'.$nick.'" WHERE down="'.$REF.'";';
			//$vlc_tatranky_kdo = 'UPDATE vlc_tatranky SET kdo="'.$nick.'" WHERE kdo="'.$REF.'";';
			//$spojeni->query( $vlc_last_log_nick );
			//$spojeni->query( $vlc_comments_jmeno );
			//$spojeni->query( $vlc_files_inserted );
			//$spojeni->query( $vlc_files_down );
			//$spojeni->query( $vlc_tatranky_kdo );
		}
		
		/*
		echo '<br />Statements: <br />';
		echo 'OLD: '.$oldStatement.'<br />';
		echo $prikaz.'<br />';
		//echo $vlc_syslog_name.'<br />';
		//echo $vlc_syslog_sname.'<br />';
		//echo $vlc_last_log_mail.'<br />';
		//echo $vlc_syslog_user.'<br />';
		//echo $vlc_last_log_nick.'<br />';
		//echo $vlc_comments_jmeno.'<br />';
		//echo $vlc_files_inserted.'<br />';
		//echo $vlc_files_down.'<br />';
		//echo $vlc_tatranky_kdo.'<br />';
		echo '--end of statements.';
		/**/
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>