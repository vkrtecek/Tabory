<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="relogin.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="help/styles/aboutMe.css" />
<title>O mně</title>
</head>
<body>
<h1>Nastavení osobních údajů</h1>
<?php
if ( isset($_REQUEST['name']) && isset($_REQUEST['passwd']) )
{
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
	
	if ( file_exists("promenne.php") && require("promenne.php") )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
		{
			$sql = $spojeni->query( "SELECT * FROM vlc_users WHERE nick = '".$name."'" );
			$person = mysqli_fetch_array( $sql );
			?>
			<div id="hereProperities"> 
			<form id="back" method="post" action="./">
				<input type="hidden" name="name" value="<?php echo $name; ?>" />
				<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
				<button>Zpět</button>
			</form>
            <div id="Properities"> 
			<table>
				<tr>
					<td>
						<label for="name">Jméno:</label>
					</td>
					<td>
						<input type="text" name="name" value="<?php echo $person['name']; ?>" id="name" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#name').val( DEF_NAME )">×</span>
						<span id="w_name"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="sname">Příjmení:</label>
					</td>
					<td>
						<input type="text" name="sname" value="<?php echo $person['sname']; ?>" id="sname" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#sname').val( DEF_SNAM )">×</span>
						<span id="w_sname"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nick">Přihlašovací jméno:</label>
					</td>
					<td>
						<input type="text" name="nick" value="<?php echo $person['nick']; ?>" id="nick" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#nick').val( DEF_NICK )">×</span>
						<span id="w_nick"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nickname">Přezdívka:</label>
					</td>
					<td>
						<input type="text" name="nickname" value="<?php echo $person['nickname']; ?>" id="nickname" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#nickname').val( DEF_NCKN )">×</span>
						<span id="w_nickname"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="passwd">Heslo:</label>
					</td>
					<td>
						<input type="password" name="passwd" id="passwd" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#passwd').val( '' )">×</span>
						<span id="w_pass1"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="passwd2">Heslo znova:</label>
					</td>
					<td>
						<input type="password" name="passwd2" id="passwd2" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#passwd2').val( '' )">×</span>
						<span id="w_pass2"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="mail">E-mail:</label>
					</td>
					<td>
						<input type="text" name="mail" value="<?php echo $person['mail']; ?>" id="mail" class="changeB" />
					</td>
					<td>
						<span class="clear" title="výchozí" onclick="$('#mail').val( DEF_MAIL )">×</span>
						<span id="w_mail"></span>
					</td>
				</tr>
				<tr>
					<td>
						<button onClick="checkUpdate( 'Properities' )">Změnit</button>
					</td>
					<td>
					</td>
					<td>
						<span class="clear" title="výchozí vše" onclick="clearAll()">×</span>
						<span id="w_"></span>
					</td>
				</tr>
			</table>
            </div>
			</div>
		<?php
		}
		else echo "<p>File promenne.php doesn't exists.</p>";
	}
	else echo '<p>Connection with database had failed.</p>';
	?>
	<script type="text/javascript">
	WARNING = false;
	DEF_NAME = document.getElementById( 'name' ).value;
	DEF_SNAM = document.getElementById( 'sname' ).value;
	DEF_NICK = document.getElementById( 'nick' ).value;
	DEF_NCKN = document.getElementById( 'nickname' ).value;
	DEF_PASS = document.getElementById( 'passwd' ).value;
	DEF_PAS2 = document.getElementById( 'passwd2' ).value;
	DEF_MAIL = document.getElementById( 'mail' ).value;
	ERR_PASSWD = '';
	
	WARNING_name = false;
	WARNING_sname = false;
	WARNING_nick = false;
	WARNING_nickname = false;
	WARNING_pass = false;
	WARNING_mail = false;
	
	function definitlyChange( where, DEF_NICK, name, sname, nick, nickname, passwd, mail )
	{
		if (window.XMLHttpRequest) {
			var xmlhttp = new XMLHttpRequest();
		} else {
			var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById( where ).innerHTML = xmlhttp.responseText;
			}
		};
		xmlhttp.open( "POST", "help/scripty/changePerson.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "reference=" + DEF_NICK + "&name=" + name + "&sname=" + sname + "&nick=" + nick + "&nickname=" + nickname + "&passwd=" + passwd + "&mail=" + mail );
	}
	
	function checkUpdate( where )
	{		
		var name = document.getElementById( 'name' ).value;
		var sname = document.getElementById( 'sname' ).value;
		var nick = document.getElementById( 'nick' ).value;
		var nickname = document.getElementById( 'nickname' ).value;
		var passwd = document.getElementById( 'passwd' ).value;
		var passwd2 = document.getElementById( 'passwd2' ).value;
		var mail = document.getElementById( 'mail' ).value;
		
		if ( WARNING ) return;
		
		name = name == DEF_NAME ? '' : name;
		sname = sname == DEF_SNAM ? '' : sname;
		nick = nick == DEF_NICK ? '' : nick;
		nickname = nickname == DEF_NCKN ? '' : nickname;
		passwd = passwd == '' || passwd != passwd2 ? '' : passwd;
		mail = mail == DEF_MAIL ? '' : mail;
		
		if (window.XMLHttpRequest) {
			var xmlhttp = new XMLHttpRequest();
		} else {
			var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				if ( xmlhttp.responseText == 'true' ) //if another person have same nick?
				{
					definitlyChange( where, DEF_NICK, name, sname, nick, nickname, passwd, mail );
				}
				else
				{
					document.getElementById( 'w_nick' ).innerHTML = 'Takové přihlašovací jméno už někdo má. Změň ho.';
					document.getElementById( 'w_nick' ).style.color = 'red';
				}
				document.getElementById( 'hereProperities' ).style.background = '';
				document.getElementById( 'hereProperities' ).style.backgroundColor = '#FFFFB9';
			}
			else document.getElementById( 'hereProperities' ).style.background = "url( 'help/img/loading.gif' )";
		};
		xmlhttp.open( "POST", "help/scripty/checkPersonExistence.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "reference=" + DEF_NICK + "&name=" + name + "&sname=" + sname + "&nick=" + nick + "&nickname=" + nickname + "&passwd=" + passwd + "&mail=" + mail );
	}
	
	function checkMail( inn )
	{
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test( inn );
	}
	function passwdOK( inn )
	{
		if ( inn.length < 3 )
		{
			ERR_PASSWD = ' - délka < ' + 3;
			WARNING_pass = true;
			document.getElementById( 'w_pass1' ).style.color = 'red';
			return false;
		}
		else if ( !inn.match( /[0-9]/ ) )
		{
			ERR_PASSWD = ' - neobsahuje číslice';
			WARNING_pass = false;
			document.getElementById( 'w_pass1' ).style.color = '#FFA54A';
			return false;
		}
		else if ( !inn.match( /[a-z]/ ) )
		{
			ERR_PASSWD = ' - neobsahuje malé písmeno';
			WARNING_pass = false;
			document.getElementById( 'w_pass1' ).style.color = '#FFA54A';
			return false;
		}
		else if ( !inn.match( /[A-Z]/ ) )
		{
			ERR_PASSWD = ' - neobsahuje velké písmeno';
			WARNING_pass = false;
			document.getElementById( 'w_pass1' ).style.color = '#FFA54A';
			return false;
		}
		WARNING_pass = false;
		ERR_PASSWD = '';
		return true;
	}
	
	
	
	$("#name").keyup(function(){
		if ( $(this).val() == '' )
		{
			document.getElementById( 'w_name' ).innerHTML = 'Toto pole musí být vyplněno';
			document.getElementById( 'w_name' ).style.color = 'red';
			WARNING_name = true;
		}
		else
		{
			document.getElementById( 'w_name' ).innerHTML = '';
			WARNING_name = false;
		}
	});
	$("#sname").keyup(function(){
		if ( $(this).val() == '' )
		{
			document.getElementById( 'w_sname' ).innerHTML = 'Toto pole musí být vyplněno';
			document.getElementById( 'w_sname' ).style.color = 'red';
			WARNING_sname = true;
		}
		else
		{
			document.getElementById( 'w_sname' ).innerHTML = '';
			WARNING_sname = false;
		}
	});
	$("#nick").keyup(function(){
		if ( $(this).val() == '' )
		{
			document.getElementById( 'w_nick' ).innerHTML = 'Toto pole musí být vyplněno';
			document.getElementById( 'w_nick' ).style.color = 'red';
			WARNING_nick = true;
		}
		else
		{
			document.getElementById( 'w_nick' ).innerHTML = '';
			WARNING_nick = false;
		}
	});
	$("#nickname").keyup(function(){
		if ( $(this).val() == '' )
		{
			document.getElementById( 'w_nickname' ).innerHTML = 'Toto pole musí být vyplněno';
			document.getElementById( 'w_nickname' ).style.color = 'red';
			WARNING_nickname = true;
		}
		else
		{
			document.getElementById( 'w_nickname' ).innerHTML = '';
			WARNING_nickname = false;
		}
	});
	$("#passwd").keyup(function(){
		if ( $(this).val() != '' && !passwdOK($(this).val()) )
		{
			document.getElementById( 'w_pass1' ).innerHTML = 'Heslo je slabé ' + ERR_PASSWD;
		}
		else
		{
			document.getElementById( 'w_pass1' ).innerHTML = '';
			WARNING_pass = false;
		}
	});
	$("#passwd2").keyup(function(){
		if ( $(this).val() != $("#passwd").val() )
		{
			document.getElementById( 'w_pass2' ).innerHTML = 'Hesla se neshodují';
			document.getElementById( 'w_pass2' ).style.color = 'red';
			WARNING = true;
		}
		else
		{
			if ( $(this).val() != '' && !WARNING ) document.getElementById( 'w_pass2' ).innerHTML = 'OK';
			else document.getElementById( 'w_pass2' ).innerHTML = '';
			document.getElementById( 'w_pass2' ).style.color = 'green';
			WARNING = false;
		}
	});
	$("#mail").keyup(function(){
		if ( $(this).val() == '' )
		{
			document.getElementById( 'w_mail' ).innerHTML = 'Toto pole musí být vyplněno';
			document.getElementById( 'w_mail' ).style.color = 'red';
			WARNING = true;
		}
		else if ( !checkMail( $(this).val() ) )
		{
			document.getElementById( 'w_mail' ).innerHTML = 'Špatný formát e-mailu';
			document.getElementById( 'w_mail' ).style.color = 'red';
			WARNING = true;
		}
		else
		{
			document.getElementById( 'w_mail' ).innerHTML = '';
			WARNING = false;
		}
	});
	
	function clearAll()
	{
		$("#name").val( DEF_NAME );
		$("#sname").val( DEF_SNAM );
		$("#nick").val( DEF_NICK );
		$("#nickname").val( DEF_NCKN );
		$("#passwd").val( '' );
		$("#passwd2").val( '' );
		$("#mail").val( DEF_MAIL );
		WARNING = false;
		document.getElementById("w_name").innerHTML = '';
		document.getElementById("w_sname").innerHTML = '';
		document.getElementById("w_nick").innerHTML = '';
		document.getElementById("w_nickname").innerHTML = '';
		document.getElementById("w_pass1").innerHTML = '';
		document.getElementById("w_pass2").innerHTML = '';
		document.getElementById("w_mail").innerHTML = '';
		document.getElementById("w_").innerHTML = '';
	}
	$("#name, #sname, #nick, #nickname, #passwd, #passwd2, #mail").keyup(function(){
		//alert( WARNING_name + " " +  WARNING_sname + " " + WARNING_nick + " " + WARNING_nickname + " " + WARNING_pass + " " + WARNING_mail );
		if ( WARNING_name || WARNING_sname || WARNING_nick || WARNING_nickname || WARNING_pass || WARNING_mail )
		{
			WARNING = true;
		}
		else
		{
			WARNING = false;
		}
		if ( WARNING )
		{
			document.getElementById( 'w_' ).innerHTML = 'Máte nějakou chybu ve formuláři';
			document.getElementById( 'w_' ).style.color = 'red';
		}
		else document.getElementById( 'w_' ).innerHTML = '';
	});
	</script>
<?php
}
else {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>', '.' );</script>
  <?php
	echo '<h1><a href="./">Zřejmě jste se zapomněli přihlásit</a></h1>';
}
?>
</body>
</html>