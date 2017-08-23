// JavaScript Document

/**
* $IP string IP address from which user tryes to login
* $URL string which part of system the user want to see
* $pathToRoot string path to root of project - where file promenne.php is
*/
function relogin( IP, path ) {	
	if ( path == null ) path = '..';
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//alert( xmlhttp.responseText );
		}
	};
	xmlhttp.open( "POST", path+"/relogin.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "IP=" + IP + "&URL=" + window.location.href );
}