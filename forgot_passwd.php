<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zapomenuté heslo</title>
<?php
$warning = false;
$sent = false;
if ( isset($_REQUEST['send']) && $_REQUEST['mail'] != "" )
{
	require( "promenne.php" );
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if($spojeni)
	{
		$spojeni->query("SET CHARACTER SET utf8");
		$sql = $spojeni->query("SELECT * FROM vlc_users WHERE mail = '".$_REQUEST['mail']."'");
		while ($uzivatel = mysqli_fetch_array($sql))
		{
			$mail = $uzivatel['mail'];
			$sent = true;
			
			
			$to = $mail;
			$subject = 'Zapomenuté heslo vlcata.pohrebnisluzbazlin.cz';
			$message = '
			Jméno: '.$uzivatel['name'].'
			Příjmení: '.$uzivatel['sname'].'
			Přihlašovací jméno: '.$uzivatel['nick'].'
			Vaše heslo je: '.$uzivatel['passwd'].'
			
			S pozdravem, správce webu ('.$spravce.')';
			$headers = 'From: Tábor Vlčat <'.$spravce.'>';
			
			function autoUTF($s)
			{
				// detect UTF-8
				if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
					return $s;
				// detect WINDOWS-1250
				if (preg_match('#[\x7F-\x9F\xBC]#', $s))
					return iconv('WINDOWS-1250', 'UTF-8', $s);
				// assume ISO-8859-2
				return iconv('ISO-8859-2', 'UTF-8', $s);
			}
			 
			function cs_mail ($to, $subject, $message, $headers = "")
			{
				$subject = "=?utf-8?B?".base64_encode(autoUTF ($subject))."?=";
				//$headers .= "MIME-Version: 1.0\n";
				//$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
				//$headers .= "Content-Transfer-Encoding: base64\n";
				//$message = base64_encode (autoUTF ($message));
				return mail($to, $subject, $message, $headers);
			}
			cs_mail($to, $subject, $message, $headers);
			
			$log = 'Send forgotten password to '.$to;
			writeLog( $log );
		}
		if ( !$sent ) {
			$warning = true;
			
			$log = 'Someone with IP='.$_SERVER['REMOTE_ADDR'].' just wanted to send forgotten password (mail='.$_REQUEST['mail'].')';
			writeLog( $log );
		}
	}
	else echo '<p>Spojení selhalo.</p>';
}

?>
<style>
	*{ margin:0; padding:0; font-family:Verdana, Geneva, sans-serif; font-size:18px; }
	#forgot{ position:absolute; top:50%; left:50%; width:20em; height:10em; margin-left:-10em; margin-top:-5em; border:solid 4px <?php echo $warning ? "red" : "green";?>; background-color:#FFFFC6; }
	#forgot form{ position:absolute; top:50%; left:50%; width:18em; height:4em; margin-left:-9em; margin-top:-2.3em; border:solid black 0px; }
	#forgot form tr{ line-height:2; }
	#forgot form td span{ font-size:9px; }
	#forgot form td label{ font-size:12px; }
	#forgot form button{ font-size:12px; padding:1px; }
	#forgot form td a{ font-size:9px; padding-left:15px; }
	#forgot form td input{ font-family:"Courier New", Courier, monospace; max-width:11em; }
	
	#w1, #w1 strong{ color:red; font-size:12px; margin-top:6px; }
	.sent, .sent a{ text-align:center; margin-top:6em; font-size:12px; padding:2px; text-decoration:none; color:black; }
	#back{ float:right; margin: 3px 3px 0 0; }
	#back a{ font-size:12px; text-decoration:none; color:black; }
</style>
</head>
<body>

<div id="forgot">
<button id="back"><a href="index.php">zpět</a></button>
<?php 
if ( !$sent ) {
	?>
  <form method="post" id="forgotn">
  <table rules="none">
    <tr><td colspan="2"><span>Heslo vám bude posláno na vámi registrovou e-mailovou adresu</span></td></tr>
      <tr><td><label>Váš e-mail: </td><td><input name="mail" type="text" value="<?php if (isset($_REQUEST['mail'])) echo $_REQUEST['mail'];?>" /></label></td></tr>
      <tr><td><button type="submit" name="send">Poslat heslo</button></td></tr>
  </table>
  <?php if ( $warning ) echo '<p id="w1"><strong>Tento email není v databázi.</strong></p>';
} else {
  echo '<p class="sent">Email odeslán na '.$mail.'<br /><br />';
} ?>
</form>
</div>

</body>
</html>