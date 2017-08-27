<?php
$in = array( 'á', 'é', 'í', 'ý', 'ó', 'ú', 'ů', 'č', 'ď', 'ě', 'ň', 'ř', 'š', 'ť', 'ž', 'Á', 'É', 'Í', 'Ý', 'Ó', 'Ú', 'Ů', 'Č', 'Ď', 'Ě', 'Ň', 'Ř', 'Š', 'Ť', 'Ž' );
$out = array( 'a', 'e', 'i', 'y', 'o', 'u', 'u', 'c', 'd', 'e', 'n', 'r', 's', 't', 'z', 'A', 'E', 'I', 'Y', 'O', 'U', 'U', 'C', 'D', 'E', 'N', 'R', 'S', 'T', 'Z' );
$uploadDir = '../help/img/members';
if( isset($_FILES['photo']) )
{
	$ext = explode( '.', basename($_FILES['photo']['name']) );
	$fileName = str_replace( $in, $out, $_REQUEST['Dname']).'_'.str_replace( $in, $out, $_REQUEST['sname']).'.'.$ext[count($ext)-1];
	$tmpName = $_FILES['photo']['tmp_name'];

	// presun souboru
	if( move_uploaded_file( $tmpName, "{$uploadDir}".DIRECTORY_SEPARATOR."{$fileName}") )
	{
	  if ( file_exists('scripty/image_resizer.php') )
	  {
		  require('scripty/image_resizer.php');
		  
		  resizeImage( $uploadDir."/".$fileName, 120, 150, $uploadDir.'/small' );
	  } else echo "<p>Image resizer not found. The preview on inventar will not appear.</p>";
	}
	else echo '<p>Fotku se nepodařilo přesunout z dočasného adresáře</p>';
}
?>







<form id="navigate" method="post">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
	<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<button name="EDIT">Zpět</button>
</form>

<p id="info">Člen byl zdárně nahrán do databáze <br /> <span onClick="backToDefault()">Nahrát dalšího?</span></p>
<p id="blur"></p>
<div id="herePlace">
<form method="post" onsubmit="return check()" enctype="multipart/form-data">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
    <input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<table rules="none">
    	<tr>
        	<td>
				<label for="Dname">Jméno: </label>
            </td>
            <td>
    			<input id="Dname" type="text" name="Dname" class="im" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="sname">Příjmení: </label>
            </td>
            <td>
    			<input id="sname" type="text" name="sname" class="im" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="nick">Přezdívka: </label>
            </td>
            <td>
    			<input id="nick" type="text" name="nick" />
            </td>
        </tr>
    	<tr>
        	<td>
    			<label for="address">Adresa: </label>
            </td>
            <td>
    			<input id="address" type="text" name="address" class="im" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="birthdate">Datum narození: </label>
            </td>
            <td>
    			<input id="birthdate" type="date" name="birthdate" class="im" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="RC">Rodné číslo: </label>
            </td>
            <td>
    			<input id="RC" type="text" name="RC" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="zdravi">Zdravotní omezení: </label>
            </td>
            <td>
    			<textarea id="zdravi" type="text" name="zdravi"></textarea>
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="telO">Telefon na otce</label>
            </td>
            <td>
    			<input id="telO" type="tel" name="telO" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="mailO">E-mail na otce</label>
            </td>
            <td>
    			<input id="mailO" type="mail" name="mailO" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="telM">Telefon na matku</label>
            </td>
            <td>
    			<input id="telM" type="tel" name="telM" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="mailM">E-mail na matku</label>
            </td>
            <td>
    			<input id="mailM" type="mail" name="mailM" />
            </td>
        </tr>
        <tr>
        	<td>
    			<label for="photo">Fotka</label>
            </td>
            <td>
    			<input id="photo" type="file" name="photo" />
            </td>
        </tr>
        <tr>
        	<td colspan="2">
            	<button name="ADD">Přidat</button>
            </td>
        </tr>
    </table>
</form>
</div>

<script type="text/javascript">
$( "p#info" ).hide();
var mess = 'Povinné';
$( ".im" ).val( mess );
$( ".im" ).css( 'color', 'red' );
$( ".im" ).css( 'font-style', 'italic' );

$( ".im" ).focus(function(){
	var tmp = $(this).val();
	if ( tmp == mess )
	{
		$(this).val( '' );
		$(this).css( 'color', 'black' );
		$(this).css( 'font-style', 'normal' );
	}
});
$( ".im" ).focusout(function(){
	var tmp = $(this).val();
	if ( tmp == '' )
	{
		$(this).val( mess );
		$(this).css( 'color', 'red' );
		$(this).css( 'font-style', 'italic' );
	}
});


<?php if ( isset($_REQUEST['Dname']) ) {?>
	$( "#herePlace" ).hide();
	$( "p#info" ).show();
<?php }?>


function checkTel( inn )
{
	var tel = document.getElementById( inn ).value;
	if ( tel != '' && tel.length != 9 )
		return false;
	return true;
}
function checkMail( inn )
{
	var mail = document.getElementById( inn ).value;
	if ( mail != '' )
	{
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(mail);
	}
	return true;
}
function checkDate( inn )
{
	return moment( inn, "YYYY-MM-DD", true).isValid();;
}
function isRC( RC )
{
	if ( RC == '' ) return true;
	
	var i = 0, cnt = 0, sum = 0;
	for ( ; i < RC.length; i++ )
	{
		if ( i == 6 && RC[i] == '/' ) continue;
		sum += parseInt( RC[i] );
		cnt++;
	}
	if ( cnt != 10 ) return false;
	return true;
}

function check()
{
	var important = document.getElementsByClassName( 'im' );
	for ( var i = 0; i < important.length; i++ )
	{
		if ( important[i].value == mess || important[i].value.trim() == '' )
		{
			alert( 'Nejsou vyplněny všechny povinné pole.' );
			return false;
		}
	}
	if ( !checkDate( document.getElementById( 'birthdate' ).value ) )
	{
		alert( 'Špatný formát datumu' );
		return false;
	}
	if ( !isRC( document.getElementById('RC').value) )
	{
		alert( 'Špatný formát rodného čísla' );
		return false;
	}
	if ( !checkTel( 'telO' ) || !checkTel( 'telM' ) )
	{
		alert( 'Telefonní číslo se nesestává z devíti číslic' );
		return false;
	}
	if ( !checkMail( 'mailO' ) || !checkMail( 'mailM' ) )
	{
		alert( 'Špatný formát e-mailu' );
		return false;
	}
	if ( (k = document.getElementById( 'photo' ).value) != '' )
	{
		var photo = k.split( '\\' );
		var tmp = photo[photo.length-1].split( '.' );
		var ext = [ 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'png', 'PNG' ];
		var i = 0;
		for ( ; i < ext.length; i++ )
			if ( tmp[tmp.length-1] == ext[i] )
				break;
		if ( i == ext.length )
		{
			alert( 'Podporované formáty fotek jsou JPG, JPEG, PNG, GIF. Vy se pokoušíte vložit ' + tmp[tmp.length-1].toUpperCase() );
			return false;
		}
	}
	function myReplace( inn, out, str ){
		for ( var i = 0; i < inn.length; i++ )
		{
			str = str.replace( new RegExp( inn[i], 'g'), out[i] );
		}
		return str;
	}
	
	
	var name = document.getElementById( 'Dname' ).value;
	var sname = document.getElementById( 'sname' ).value;
	var nick = document.getElementById( 'nick' ).value;
	var address = document.getElementById( 'address' ).value;
	var birthdate = document.getElementById( 'birthdate' ).value;
	var RC = document.getElementById( 'RC' ).value;
	var zdravi = document.getElementById( 'zdravi' ).value;
	var telO = document.getElementById( 'telO' ).value;
	var mailO = document.getElementById( 'mailO' ).value;
	var telM = document.getElementById( 'telM' ).value;
	var mailM = document.getElementById( 'mailM' ).value;
	var photo = document.getElementById( 'photo' ).value.split( '\\' );
	photo = photo[photo.length-1];
	if ( photo == '' ) photo = 'blank.jpg';
	else
	{
		var inn = [ 'á', 'é', 'í', 'ý', 'ó', 'ú', 'ů', 'č', 'ď', 'ě', 'ň', 'ř', 'š', 'ť', 'ž', 'Á', 'É', 'Í', 'Ý', 'Ó', 'Ú', 'Ů', 'Č', 'Ď', 'Ě', 'Ň', 'Ř', 'Š', 'Ť', 'Ž' ];
		var out = [ 'a', 'e', 'i', 'y', 'o', 'u', 'u', 'c', 'd', 'e', 'n', 'r', 's', 't', 'z', 'A', 'E', 'I', 'Y', 'O', 'U', 'U', 'C', 'D', 'E', 'N', 'R', 'S', 'T', 'Z' ];
		var Mname = myReplace( inn, out, name );
		var Msname = myReplace( inn, out, sname );
		var Mphoto = myReplace( inn, out, photo );
		Mphoto = Mphoto.split( '.' );
		
		photo = Mname + "_" + Msname + "." + Mphoto[ Mphoto.length-1 ];
	}
	
	
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//document.getElementById( 'blur' ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/insertMember.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name="+name+"&sname="+sname+"&nick="+nick+"&address="+address+"&birthdate="+birthdate+"&zdravi="+zdravi+"&telO="+telO+"&mailO="+mailO+"&telM="+telM+"&mailM="+mailM+"&photo="+photo+"&RC="+RC+"&who=<?=$_REQUEST['name'];?>" );
	return true;
}

function backToDefault()
{
	$( "#herePlace" ).show();
	$( "p#info" ).hide();
	
	
	var All = $( "#hereplace input" );
	var All = document.getElementById( 'herePlace' ).getElementsByTagName( 'input' );
	for ( var i = 0; i < All.length; i++ )
	{
		All[i].value = '';
	}
	$( ".im" ).val( mess );
	$( ".im" ).css( 'color', 'red' );
	$( ".im" ).css( 'font-style', 'italic' );
}
</script>