<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create new user</title>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<script src="scripty/cleni.js" type="text/javascript"></script>
</head>
<body>
<h1>Create new user</h1>
	<form method="post" action="../" id="form_back">
        <input type="hidden" name="name" value="<?= $_REQUEST['name']; ?>"/>
        <input  type="hidden" name="passwd" value="<?= $_REQUEST['passwd']; ?>"/>
        <button type="submit" name="back" id="back"></button>
	</form>
<?php
if ( !isset($_REQUEST['insert']) )
{
	?>
    <div id="div_create_new_user">
    <table rules="none">
        <tr><td><label for="name">Jméno </label></td><td><input type="text" id="name" /></td></tr>
        <tr><td><label for="sname">Příjmení </label></td><td><input type="text" id="sname"/></td></tr>
        <tr><td><label for="nick">Přihlašovací jméno</label></td><td><input type="text" id="nick" onkeyup="checkLogin( this, 'validLoginSpan' )" /> <strong id="validLoginSpan"></strong></td></tr>
        <tr><td><label for="nickname">Přezdívka</label></td><td><input type="text" id="nickname"/></td></tr>
        <tr><td><label for="passwd">Heslo</label></td><td><input type="text" id="passwd"/></td></tr>
        <tr><td><label for="mail">E-mail</label></td><td><input type="text" id="mail"/></td></tr>
        <tr><td><label for="telefon">Telefon</label></td><td><input type="text" id="telefon"/> Nepovinné</td></tr>
        <tr><td><label for="birthdate">Datum narození</label></td><td><input type="date" id="birthdate"/> Nepovinné</td></tr>
        <tr>
            <td>
                <label for="platnost">Platnost účtu</label>
            </td>
            <td>
                <select type="text" id="platnost"/>
                    <option value="1" selected="selected">ANO</option>
                    <option value="0">NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="etapa">Etapová skupina</label>
            </td>
            <td>
                <select type="text" id="etapa"/>
                    <option value="1">ANO</option>
                    <option value="0" selected="selected">NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="aktivni">Aktivní člen</label>
            </td>
            <td>
                <select type="text" id="aktivni"/>
                    <option value="1" selected="selected">ANO</option>
                    <option value="0">NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="kuchar">Kuchař</label>
            </td>
            <td>
                <select type="text" id="kuchar"/>
                    <option value="1">ANO</option>
                    <option value="0" selected="selected">NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="admin">Admin</label>
            </td>
            <td>
                <select type="text" id="admin"/>
                    <option value="1">ANO</option>
                    <option value="0" selected="selected">NE</option>
                </select>
            </td>
        </tr>
        <tr><td><button name="insert" onclick="check()">Vložit člověka</button></td></tr>
    </table>
    </div>
	<?php
}
else
{
    echo "INSERT INTO vlc_users( name, sname, nick, nickname, passwd, mail, platnost, etapa, aktivni, kuchar, admin, telefon ) VALUES ( '".$_REQUEST['name']."',  '".$_REQUEST['sname']."',  '".$_REQUEST['nick']."',  '".$_REQUEST['nickname']."', '".$_REQUEST['passwd']."', '".$_REQUEST['mail']."', ".$_REQUEST['platnost'].", ".$_REQUEST['etapa'].", ".$_REQUEST['aktivni'].", ".$_REQUEST['kuchar'].", ".$_REQUEST['admin'].", ".$_REQUEST['telefon']." );";
}
?>
<script type="text/javascript">
function mailOK( email )
{
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function insertPerson( name, sname, nick, nickname, passwd, mail, platnost, aktivni, etapa, kuchar, admin, telefon, birthdate )
{
	document.getElementById( 'div_create_new_user' ).innerHTML = "INSERT INTO vlc_users ( name, sname, nick, nickname, passwd, mail, platnost, etapa, aktivni, kuchar, admin, telefon ) VALUES ( '"+name+"', '"+sname+"', '"+nick+"', '"+nickname+"', '"+passwd+"', '"+mail+"', '"+platnost+"', '"+etapa+"', '"+aktivni+"', '"+kuchar+"', '"+admin+"', '"+telefon+"', '"+birthdate+"' );";
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
		{
			document.getElementById( 'div_create_new_user' ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/createNewUser.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name="+name+"&sname="+sname+"&nick="+nick+"&nickname="+nickname+"&passwd="+passwd+"&mail="+mail+"&birthdate="+birthdate+"&platnost="+platnost+"&etapa="+etapa+"&aktivni="+aktivni+"&kuchar="+kuchar+"&admin="+admin+"&telefon="+telefon );
}
function check()
{
	var name = document.getElementById( 'name' ).value;
	var sname = document.getElementById( 'sname' ).value;
	var nick = document.getElementById( 'nick' ).value;
	var nickname = document.getElementById( 'nickname' ).value;
	var passwd = document.getElementById( 'passwd' ).value;
	var mail = document.getElementById( 'mail' ).value;
	var platnost = document.getElementById( 'platnost' ).value;
	var aktivni = document.getElementById( 'aktivni' ).value;
	var etapa = document.getElementById( 'etapa' ).value;
	var kuchar = document.getElementById( 'kuchar' ).value;
	var admin = document.getElementById( 'admin' ).value;
	var telefon = document.getElementById( 'telefon' ).value;
	var birthdate = document.getElementById( 'birthdate' ).value;
	var validate = document.getElementById( 'validLoginSpan' ).innerHTML;
	
	if ( validate != 'OK' ) {
		alert( 'Login state must be "OK"' );
		return false;
	}
	if ( name == '' || sname == '' || nick == '' || nickname == '' || passwd == '' || mail == '' )
	{
		alert( 'Něco není vyplněno' );
		return;
	}
	if ( telefon != "" && (telefon != parseInt(telefon) || telefon < 100000000 || telefon > 999999999) ) {
		alert( "Bad telefon" );
		return;
	}
	if ( !mailOK(mail) )
	{
		alert( 'Špatný formát e-mailu' );
		return;
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
		{
			if ( xmlhttp.responseText == 'true' )
			{
				insertPerson( name, sname, nick, nickname, passwd, mail, platnost, aktivni, etapa, kuchar, admin, telefon, birthdate );
			}
			else alert( 'Takové přihlašovací jméno již existuje' );
		}
	};
	xmlhttp.open( "POST", "scripty/checkPersonExistence.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "nick="+nick );
}
document.getElementById( 'passwd' ).value = 'klubovna';
</script>
</body>
</html>