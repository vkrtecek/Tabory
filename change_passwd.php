<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Změnit heslo</title>
<?php
$color_border="green";
$warning1 = false;
$warning2 = false;
$changed = false;

if ( isset($_REQUEST['re_passwd']) )
{
	if ( $_REQUEST['passwd1'] != $_REQUEST['passwd2'] )
	{
		$warning2 = true;
		$color_border = "red";
	}
	else if ( !file_exists("promenne.php") )
	{
		echo "<p>Něco se pokazilo.</p>";
	} else {
		require( "promenne.php" );
		$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
		if($spojeni)
		{
			$spojeni->query("SET CHARACTER SET utf8");
			$sql = $spojeni->query("SELECT * FROM vlc_users WHERE name = '".$_REQUEST['name']."' && sname = '".$_REQUEST['sname']."' && mail = '".$_REQUEST['mail']."'");
			while ($uzivatel = mysqli_fetch_array($sql))
			{
				if ($_REQUEST['passwd']  == $uzivatel['passwd'])
				{
					$spojeni->query("UPDATE vlc_users SET passwd = '".$_REQUEST['passwd2']."' WHERE mail = '".$_REQUEST['mail']."'");
					
					$to = $uzivatel['mail'];
					$subject = 'Změna hesla vlcata.pohrebnisluzbazlin.cz';
					$message = '
					Na stránkách vlcata.pohrebnisluzbazlin.cz Vám bylo změněno heslo.
					
					Jménno: '.$uzivatel['name'].'
					Příjmení: '.$uzivatel['sname'].'
					Přihlašovací jméno: '.$uzivatel['nick'].'
					Nové heslo: '.$_REQUEST['passwd2'].'
					
					Pokud o této změně nic nevíte, kontaktujte mneprosím správce webu ('.$spravce.')';
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
						$headers .= "MIME-Version: 1.0\n";
						$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
						$headers .= "Content-Transfer-Encoding: base64\n";
						$message = base64_encode (autoUTF ($message));
						return mail($to, $subject, $message, $headers);
					}
					cs_mail($to, $subject, $message, $headers);
					$changed = true;
					break;
				}
			}
			if ( !$changed )
			{
				$color_border = "red";
				$warning1 = true;
				
				$log = "Someone IP=".$_SERVER['REMOTE_ADDR']." just tried to change his/her password without logged in as [ name = '".$_REQUEST['name']."', surname = '".$_REQUEST['sname']."', mail = '".$_REQUEST['mail']."' ]";
				writeLog( $log );
			}
			else {}							  
		}
		else echo '<p>Spojení selhalo.</p>';
	}
}

?>
<style>
	*{ margin:0; padding:0; font-family:Verdana, Geneva, sans-serif; }
	#send_passwd{ position:absolute; top:50%; left:50%; width:20em; height:15em; margin-left:-10em; margin-top:-7em; border:solid 4px <?php echo $color_border; ?>; background-color:#FFFFC6; }
	#send_passwd form{ position:absolute; top:50%; left:50%; width:14em; height:4em; margin-left:-7em; margin-top:-5.5em; border:solid black 0px; }
	#send_passwd form tr{ line-height:2; }
	#send_passwd form td label{ font-size:12px; }
	#send_passwd form td a{ font-size:9px; padding-left: 15px; }
	#send_passwd form td input{ font-family:"Courier New", Courier, monospace; max-width:8em; }
	
	#w1, #w2{ color:red; font-size:12px; margin-top:4px;}
	#changed{ font-size:12px; text-align:center; margin-top:9em; }
	#back{ float:right; margin: 3px 3px 0 0; }
	#back a{ font-size:12px; text-decoration:none; color:black; }
</style>
</head>
<body>

<div id="send_passwd">
<button id="back"><a href="index.php">zpět</a></button>
<?php if ( !$changed ) { ?>
<form method="post">
<table rules="none">
    <tr><td><label>Křestní jméno: </td><td><input name="name" type="text" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name'];?>" /></label></td></tr>
    <tr><td><label>Příjmení: </td><td><input name="sname" type="text" value="<?php if (isset($_REQUEST['sname'])) echo $_REQUEST['sname'];?>" /></label></td></tr>
    <tr><td><label>E-mail: </td><td><input name="mail" type="text" value="<?php if (isset($_REQUEST['mail'])) echo $_REQUEST['mail'];?>" /></label></td></tr>
    <tr><td><label>Nynější heslo: </td><td><input name="passwd" type="password" /></label></td></tr>
    <tr><td><label>Nové heslo: </td><td><input name="passwd1" type="password" /></label></td></tr>
    <tr><td><label>Heslo znova: </td><td><input name="passwd2" type="password" /></label></td></tr>
    <tr><td><button type="submit" name="re_passwd">Změnit heslo</button></td></tr>
    <tr><td colspan="2"><?php if ( $warning1 ) {?><p id="w1"><strong>Údaje nesedí</strong></p><?php }
	                          if ( $warning2 ) {?><p id="w2"><strong>Hesla se neshodují</strong></p><?php } ?></td></tr>
</table>
</form>
<?php } else {?>
<p id="changed">Heslo bylo změněno a posláno na Vaši e-mailovou adresu.<br />
<?php } ?>
</div>

</body>
</html>