// JavaScript Document

function mvBoyToUses( id, whoMoving ) {
	var enter = confirm( 'Opravdu přesunout do vedoucích?' );
	if ( enter == false ) return;
	
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if ( xmlhttp.responseText != '' ) alert( xmlhttp.responseText );
			else window.location.reload(false);
		}
	};
	xmlhttp.open( "POST", "../help/scripty/mvBoyToUses.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id + "&who=" + whoMoving );
	
}