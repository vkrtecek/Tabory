// JavaScript Document
function makeChange( str, table, max_selects ) {
	var t = document.getElementById( 'updatingInput' );
	if ( t != null ) {
		return;
	}
	
	var res = str.split( '_' );
	if ( res.length != 2 ) {
		alert( "Bad format of param: " + str );
		return;
	}
	var id = res[0];
	var col = res[1];
	var val = document.getElementById( str ).innerHTML;
	
	//var people = val.trim().split( ' ' );
	var form = '<span id="updatingInput" col="' + col + '" idRow="' + id + '" table="' + table + '" ></span>';
	document.getElementById( str ).innerHTML = form;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( 'updatingInput' ).innerHTML = xmlhttp.responseText;
			$( "select:disabled, .toHide" ).hide();
		}
	};
	xmlhttp.open( "POST", "../help/scripty/fillTdInHarmonogram.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'table=' + table + "&col=" + col + '&id=' + id + '&max_of_doers=' + max_selects );
	
}




function minus( id ) {
	var frag = id.split( '-' );
	//alert( frag[0] + " - " + frag[1] + " - " + frag[2] ); //Del - Mor1 - 0
	document.getElementById( frag[1] + frag[2] ).disabled = true;
	$( "#" + frag[1] + frag[2] ).hide();
	$("#"+id).hide();
}



function plus( id, max_of_doers ) {
	var frag = id.split( "-" );
	for ( var i = 0; i < max_of_doers; i++ )
	{
		if ( document.getElementById( frag[1] + i ).disabled )
		{
			$( "#" + frag[1] + i ).show();
			document.getElementById( frag[1] + i ).disabled = false;
			$( "#Del-" + frag[1] + "-" + i ).show();
			break;
		}
	}
	if ( i == max_of_doers ) alert( "Maximum je " + max_of_doers );
}



/**
* Show new value of cell which doers was modified 
* @param TdID id of cell, where will be new value drown
* @param table table in database
* @param id id in table
* @param col column in table with value
*/
function redrawCell( TdID, table, id, col ) {
	var user = $( "input[name=name]" ).val();
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var ret = xmlhttp.responseText;
			document.getElementById( TdID ).innerHTML = ret;
			document.getElementById( TdID ).id = '';
		}
	};
	xmlhttp.open( "POST", "../help/scripty/redrawCell.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'table=' + table + "&col=" + col + '&id=' + id + '&who=' + user );
}

function letsMakeChanges() {
	var id = $("#updatingInput").attr( 'idRow' );
	var table = $("#updatingInput").attr( 'table' );
	var col = $("#updatingInput").attr( 'col' );
	var selects = document.getElementsByName( col + '[]' );
	var val = '';
	var change = false;
	for ( var i = 0; i < selects.length; i++ ) {
		if ( selects[i].disabled == false ) {
			if ( change == true ) val += ' - ';
			val += selects[i].value;
			change = true;
		}
	}
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//document.getElementById( 'updatingInput' ).innerHTML = 
			if ( xmlhttp.responseText != 'success' ) alert( 'Some error occurs. Please refresh the page (Ctrl+R or F5) and try it again.' );
			redrawCell( 'updatingInput', table, id, col );
		}
	};
	xmlhttp.open( "POST", "../help/scripty/changeCellInHarmonogram.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'table=' + table + "&col=" + col + '&id=' + id + '&val=' + val );
}

window.addEventListener('click', function(e){   
  if ( !document.getElementById('updatingInput').contains(e.target) )
    letsMakeChanges();
});
window.addEventListener('keydown', function(e){
	var obj = document.getElementById( 'updatingInput' );
	var charCode = e.keyCode || e.which;
	if ( charCode == 13 && obj != null)
		letsMakeChanges();
});
