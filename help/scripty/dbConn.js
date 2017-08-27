// JavaScript Document


/**
* Prints comments
* @param where	id of div, where comments will be printed
* @param table	SQL table where are comments
* @param n		name of user
*/
function printComm( where, table, n )
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
	xmlhttp.open( "POST", "help/scripty/printComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + table + "&n=" + n );
}


/**
* Delete comment
* @param id		id of comment
* @param where	id of div, where rest comments will be printed
* @param table	SQL table where are comments
* @param n		name of user
*/
function delComm( id, where, table, n )
{
	var enter = confirm( "Opravdu chceš smazat komentář?" );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "help/scripty/delComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id + "&table=" + table );
	
	printComm( where, table, n );
}

/**
* Create comment
* @param where		id of div, where rest comments will be printed
* @param table		SQL table where are comments
* @param n			name of user
* @param ip			IP address of user
* @param DEFF_MESS	default message inserted by system like 'here write comment'
*/
function insertComm( where, table, n, ip, DEFF_MESS )
{
	var subj = document.getElementById( 'subject' ).value;
	var comm = document.getElementById( 'textarea' ).value;
	if ( comm == '' || comm == DEFF_MESS )
	{
		alert( 'Nevyplněné povinné pole' );
		return;
	}
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "help/scripty/insertComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + table + "&name=" + n + "&ip=" + ip + "&subject=" + subj + "&comm=" + comm );
	
	printComm( where, table, n );
	
	var subj = document.getElementById( 'subject' ).value = '';
	var comm = document.getElementById( 'textarea' ).value = '';
}

function showFormToUpdate( whereToGetID, whereToDrow ) {
	var e = document.getElementById( whereToGetID );
	var id = e.options[e.selectedIndex].value;
	if ( id == 0 ) {
		document.getElementById( whereToDrow ).innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( whereToDrow ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/formToUpdatePerson.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id );
}

function printUsersToUpdate(){
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( DEF_DIV ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/selectPersonFromList.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}


function getAllUsers( DIV ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( DIV ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/getAllUsers.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}








/**
* @param id				id of user
* @param val			new value of column
* @param table		in witch table in database
* @param col			witch column to change
*/
function makeChangeInTable( id, val, table, col ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( STATUS ).innerHTML = xmlhttp.responseText;
			getAllUsers( "update" );
		}
	};
	xmlhttp.open( "POST", "scripty/updateUser.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'id=' + id + '&val=' + val + '&table=' + table + '&col=' + col );
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function testUserExistence( name, table, col, id ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var res = xmlhttp.responseText;
			if ( res == 'true' ) {
				alert( col + " with value " + name + " already exists" );
				return;
			} else if ( res == 'false' ) makeChangeInTable( id, name, table, col );
		}
	};
	xmlhttp.open( "POST", "scripty/testUserExistence.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'val=' + name + '&table=' + table + '&col=' + col + "&id=" + id );
}
/**
* @param str id of user and column; for example 13_mail
* 
*/
function makeChange( str, table ) {
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
	
	var form = '<input id="updatingInput" type="text" value="' + val + '" col="' + col + '" idRow="' + id + '" table="' + table + '" />';
	document.getElementById( str ).innerHTML = form;
}

function letsMakeChanges() {
	var id = $("#updatingInput").attr( 'idRow' );
	var table = $("#updatingInput").attr( 'table' );
	var val = $("#updatingInput").val();
	var col = $("#updatingInput").attr( 'col' );
	
	switch ( col ) {
		case 'telefon':
			if ( val != '' && (val != parseInt(val) ||  val < 100000000 || val > 999999999) ) {
				alert( 'Bad ' + col );
				return;
			} else if ( val == "" ) val = null;
			break;
		case 'platnost':
			if ( val != 1 && val != 0 ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'etapa':
			if ( val != 1 && val != 0 ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'aktivni':
			if ( val != 1 && val != 0 ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'kuchar':
			if ( val != 1 && val != 0 ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'admin':
			if ( val != 1 && val != 0 ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'passwd':
			if ( val == '' ) {
				alert( 'Empty ' + col );
				return;
			} else if ( val.length < 3 ) {
				alert( 'Short ' + col );
				return;
			}
			break;
		case 'nickname':
			if ( val == '' ) {
				alert( 'Empty ' + col );
				return;
			} else if ( val.length < 3 ) {
				alert( 'Short ' + col );
				return;
			}
			break;
		case 'name':
			if ( val == '' ) {
				alert( 'Empty ' + col );
				return;
			} else if ( val.length < 3 ) {
				alert( 'Short ' + col );
				return;
			}
			break;
		case 'sname':
			if ( val == '' ) {
				alert( 'Empty ' + col );
				return;
			} else if ( val.length < 3 ) {
				alert( 'Short ' + col );
				return;
			}
			break;
		case 'mail':
			if ( !validateEmail(val) ) {
				alert( 'Bad ' + col );
				return;
			}
			break;
		case 'nick':
			if ( val == "" ) {
				alert( 'Empty ' + col );
				return;
			} else if ( val.length < 3 ) {
				alert( "Short " + col );
				return;
			} else testUserExistence(val, table, col, id);
			break;
	}
	if ( col != 'nick' ) makeChangeInTable( id, val, table, col );
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






function printConcreteLog( logFile, WHERE ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/getLogFile.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'logFile=' + logFile );
}


function deleteUser( id, jmeno ) {
	var enter = confirm( "Opravdu chcete smazat " + jmeno + "?" );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//document.getElementById( WHERE ).innerHTML = xmlhttp.responseText;
			getAllUsers( "update" );
		}
	};
	xmlhttp.open( "POST", "scripty/deleteUser.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'id=' + id );
}


function printBirthday( WHERE ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "help/scripty/printBirthday.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}