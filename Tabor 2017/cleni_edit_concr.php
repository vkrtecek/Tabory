<form id="navigate" method="post">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
	<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<button name="EDIT">Zpět</button>
</form>


<div id="search">
	<label for="order">Řadit dle: </label>
	<select id="order" name="order" >
    	<option value="name">Jména</option>
        <option value="sname">Příjmení</option>
        <option value="nick" selected="selected">Přezdívky</option>
    </select>
    <select name="orderBy" id="orderBy">
    	<option value="DESC"> sestupně</option>
        <option value="ASC"> vzestupně</option>
    </select>
    <label for="pattern"> obsahujíc </label>
    <input id="pattern" type="text" name="pattern" />
    <span>
    	<input type="checkbox" id="active" />
    	<label for="active">Neaktivní</label>
    </span>

</div>
<div id="showMemToUpdate"></div>

<div id="placeToFormUpdate"></div>


<script type="text/javascript">
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
		if ( important[i].value.trim() == '' )
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
	var address = document.getElementById( 'address' ).value;
	var birthdate = document.getElementById( 'birthdate' ).value;
	var telO = document.getElementById( 'telO' ).value;
	var mailO = document.getElementById( 'mailO' ).value;
	var telM = document.getElementById( 'telM' ).value;
	var mailM = document.getElementById( 'mailM' ).value;
	
	if ( name == '' )
	{
		alert( 'Jméno musí být vyplněno' );
		return false;
	}
	if ( sname == '' )
	{
		alert( 'Příjmení musí být vyplněno' );
		return false;
	}
	if ( address == '' )
	{
		alert( 'Adresa musí být vyplněna' );
		return false;
	}
	
	
	return true;
}


function showFormUpdate( id, where )
{
	if (window.XMLHttpRequest) {
		xmlhttpForm = new XMLHttpRequest();
	} else {
		xmlhttpForm = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpForm.onreadystatechange = function() {
		if (xmlhttpForm.readyState == 4 && xmlhttpForm.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttpForm.responseText;
		}
	};
	xmlhttpForm.open( "POST", "scripty/showConcFormUpdate.php", true );
	xmlhttpForm.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpForm.send( "id="+id+"&name=<?php echo $_REQUEST['name']; ?>&passwd=<?php echo $_REQUEST['passwd']; ?>" );
}

function showMems( order, orderBy, pattern, table, active )
{
	if (window.XMLHttpRequest) {
		xmlhttpShow = new XMLHttpRequest();
	} else {
		xmlhttpShow = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpShow.onreadystatechange = function() {
		if (xmlhttpShow.readyState == 4 && xmlhttpShow.status == 200) {
			document.getElementById( 'showMemToUpdate' ).innerHTML = xmlhttpShow.responseText;
		}
	};
	xmlhttpShow.open( "POST", "scripty/showAllMem.php", true );
	xmlhttpShow.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpShow.send( "order="+order+"&orderBy="+orderBy+"&pattern="+pattern+"&table="+table+"&active="+active );
}





$(document).ready(function(){
    showMems( 'nick', 'DESC', '', 'vlc_boys' );
});
$("#pattern").keyup(function(){
	var order = document.getElementById( 'order' ).value;
	var orderBy = document.getElementById( 'orderBy' ).value;
	var pattern = document.getElementById( 'pattern' ).value;
	var active = document.getElementById( 'active' ).checked;
	showMems( order, orderBy, pattern, 'vlc_boys', active );
});
$("#order").change(function(){
	var order = document.getElementById( 'order' ).value;
	var orderBy = document.getElementById( 'orderBy' ).value;
	var pattern = document.getElementById( 'pattern' ).value;
	var active = document.getElementById( 'active' ).checked;
	showMems( order, orderBy, pattern, 'vlc_boys', active );
});
$("#orderBy").change(function(){
	var order = document.getElementById( 'order' ).value;
	var orderBy = document.getElementById( 'orderBy' ).value;
	var pattern = document.getElementById( 'pattern' ).value;
	var active = document.getElementById( 'active' ).checked;
	showMems( order, orderBy, pattern, 'vlc_boys', active );
});
$("#active").change(function(){
	var order = document.getElementById( 'order' ).value;
	var orderBy = document.getElementById( 'orderBy' ).value;
	var pattern = document.getElementById( 'pattern' ).value;
	var active = document.getElementById( 'active' ).checked;
	showMems( order, orderBy, pattern, 'vlc_boys', active );
});
</script>
<?php
	if ( isset($_REQUEST['Dname']) )
	{
		$statement = "UPDATE vlc_boys SET name='".$_REQUEST['Dname']."', sname='".$_REQUEST['sname']."', nick='".$_REQUEST['nick']."'";
		$statement .= ", address='".$_REQUEST['address']."', birthdate='".$_REQUEST['birthdate']."', RC='".$_REQUEST['RC']."'";
		$statement .= ", zdravi='".$_REQUEST['zdravi']."', member=".$_REQUEST['member'];
		if ( $_FILES['photo']['name'] != '' )
		{
			$in = array( 'á', 'é', 'í', 'ý', 'ó', 'ú', 'ů', 'č', 'ď', 'ě', 'ň', 'ř', 'š', 'ť', 'ž', 'Á', 'É', 'Í', 'Ý', 'Ó', 'Ú', 'Ů', 'Č', 'Ď', 'Ě', 'Ň', 'Ř', 'Š', 'Ť', 'Ž' );
			$out = array( 'a', 'e', 'i', 'y', 'o', 'u', 'u', 'c', 'd', 'e', 'n', 'r', 's', 't', 'z', 'A', 'E', 'I', 'Y', 'O', 'U', 'U', 'C', 'D', 'E', 'N', 'R', 'S', 'T', 'Z' );
			$uploadDir = '../help/img/members';
			$ext = explode( '.', basename($_FILES['photo']['name']) );
			$fileName = str_replace( $in, $out, $_REQUEST['Dname']).'_'.str_replace( $in, $out, $_REQUEST['sname']).'.'.$ext[count($ext)-1];
			$tmpName = $_FILES['photo']['tmp_name'];
			
			if( move_uploaded_file( $tmpName, "{$uploadDir}".DIRECTORY_SEPARATOR."{$fileName}") )
			{
			  if ( file_exists('scripty/image_resizer.php') )
			  {
				require( "scripty/image_resizer.php" );
				resizeImage( $uploadDir."/".$fileName, 120, 150, $uploadDir."/small" );
				$statement .= ", photo='".$fileName."'";
			  }
			}
		}
		$statement .= ", telO='".$_REQUEST['telO']."', mailO='".$_REQUEST['mailO']."', telM='".$_REQUEST['telM']."', mailM='".$_REQUEST['mailM']."'";
		$statement .= " WHERE id = ".$_REQUEST['id'];
		$spojeni->query( $statement );
	}
	else if ( isset($_REQUEST['delMem']) )
	{
		$statement = "DELETE FROM vlc_boys WHERE id = ".$_REQUEST['id'];
		$spojeni->query( $statement );
	}
?>