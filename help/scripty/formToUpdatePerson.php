<?php
$id = $_REQUEST['id'];



$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM vlc_users WHERE id=".$id );
		$user = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		$name = $user['name'];
		$sname = $user['sname'];
		$nick = $user['nick'];
		$nickname = $user['nickname'];
		$passwd = $user['passwd'];
		$mail = $user['mail'];
		$telefon = $user['telefon'];
		$platnost = $user['platnost'];
		$etapa = $user['etapa'];
		$aktivni = $user['aktivni'];
		$kuchar = $user['kuchar'];
		$admin = $user['admin'];
		?>
			<table rules="none">
        <tr><td></td><td><input type="hidden" id="id" value="<?= $id; ?>" /></td></tr>
        <tr><td><label for="name">Jméno </label></td><td><input type="text" id="name" value="<?= $name; ?>" /></td></tr>
        <tr><td><label for="sname">Příjmení </label></td><td><input type="text" id="sname" value="<?= $sname; ?>"/></td></tr>
        <tr><td><label for="nick">Přihlašovací jméno</label></td><td><input type="text" id="nick" value="<?= $nick; ?>" /></td></tr>
        <tr><td><label for="nickname">Přezdívka</label></td><td><input type="text" id="nickname" value="<?= $nickname; ?>" /></td></tr>
        <tr><td><label for="passwd">Heslo</label></td><td><input type="text" id="passwd" value="<?= $passwd; ?>" /></td></tr>
        <tr><td><label for="mail">E-mail</label></td><td><input type="text" id="mail" value="<?= $mail; ?>" /></td></tr>
        <tr><td><label for="telefon">Telefon</label></td><td><input type="text" id="telefon" value="<?= $telefon; ?>" /> Nepovinné</td></tr>
        <tr>
            <td>
                <label for="platnost">Platnost účtu</label>
            </td>
            <td>
                <select type="text" id="platnost"/>
                    <option value="1" <?= ($platnost == "1" ? 'selected=""' : ''); ?> >ANO</option>
                    <option value="0" <?= ($platnost == "0" ? 'selected=""' : ''); ?>>NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="etapa">Etapová skupina</label>
            </td>
            <td>
                <select type="text" id="etapa"/>
                    <option value="1" <?= ($etapa == "1" ? 'selected=""' : ''); ?>>ANO</option>
                    <option value="0" <?= ($etapa == "0" ? 'selected=""' : ''); ?>>NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="aktivni">Aktivní člen</label>
            </td>
            <td>
                <select type="text" id="aktivni"/>
                    <option value="1" <?= ($aktivni == "1" ? 'selected=""' : ''); ?>>ANO</option>
                    <option value="0" <?= ($aktivni == "0" ? 'selected=""' : ''); ?>>NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="kuchar">Kuchař</label>
            </td>
            <td>
                <select type="text" id="kuchar"/>
                    <option value="1" <?= ($kuchar == "1" ? 'selected=""' : ''); ?>>ANO</option>
                    <option value="0" <?= ($kuchar == "0" ? 'selected=""' : ''); ?>>NE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="admin">Admin</label>
            </td>
            <td>
                <select type="text" id="admin"/>
                    <option value="1" <?= ($admin == "1" ? 'selected=""' : ''); ?>>ANO</option>
                    <option value="0" <?= ($admin == "0" ? 'selected=""' : ''); ?>>NE</option>
                </select>
            </td>
        </tr>
        <tr><td><button name="update" onclick="check()">Změnit člověka</button></td></tr>
    </table>
    
		<script type="text/javascript">
    function mailOK( email )
    {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    function updatePerson( id, name, sname, nick, nickname, passwd, mail, platnost, aktivni, etapa, kuchar, admin, telefon )
    {
      //document.getElementById( 'div' ).innerHTML = "UPDATE vlc_users SET name='" + name + "', sname='" + sname + "', nick='" + nick + "', nickname='" + nickname + "', passwd='" + passwd + "', mail='" + mail + "', platnost=" + platnost + ", etapa=" + etapa + ", aktivni=" + aktivni + ", kuchar=" + kuchar + ", admin=" + admin + ", telefon='" + telefon + "' WHERE id='" + id + "' );";
      
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
        {
          document.getElementById( 'div' ).innerHTML = xmlhttp.responseText;
        }
      };
      xmlhttp.open( "POST", "scripty/updateNewUser.php", true );
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send( "id="+id+"&name="+name+"&sname="+sname+"&nick="+nick+"&nickname="+nickname+"&passwd="+passwd+"&mail="+mail+"&platnost="+platnost+"&etapa="+etapa+"&aktivni="+aktivni+"&kuchar="+kuchar+"&admin="+admin+"&telefon="+telefon );
    }
    function check()
    {
      var id = document.getElementById( 'id' ).value;
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
            updatePerson( id, name, sname, nick, nickname, passwd, mail, platnost, aktivni, etapa, kuchar, admin, telefon );
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
    <?php
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>