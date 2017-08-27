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


function checkLogin( input, SPAN ) {
	var minChars = 2;
	document.getElementById( SPAN ).style.fontFamily = 'monospace';
	
	if ( input.value == '' ) {
		document.getElementById( SPAN ).innerHTML = '';
	} else if ( input.value.length < minChars ) {
		document.getElementById( SPAN ).innerHTML = 'příliš krátké (<'+minChars+')';
		document.getElementById( SPAN ).style.color = 'violet';
	} else {
		if (window.XMLHttpRequest) {
			var xmlhttp = new XMLHttpRequest();
		} else {
			var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				if ( xmlhttp.responseText == 'success' ) {
					document.getElementById( SPAN ).innerHTML = 'OK';
					document.getElementById( SPAN ).style.color = 'green';
				} else if ( xmlhttp.responseText == 'duplicity' ) {
					document.getElementById( SPAN ).innerHTML = 'login already exists';
					document.getElementById( SPAN ).style.color = 'red';
				} else {
					document.getElementById( SPAN ).innerHTML = 'some error';
					document.getElementById( SPAN ).style.color = 'red';
				}
			} else {
				document.getElementById( SPAN ).innerHTML = 'some error';
				document.getElementById( SPAN ).style.color = 'red';
			}
		};
		xmlhttp.open( "POST", "../help/scripty/checkLogin.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "login=" + input.value );
	}
}