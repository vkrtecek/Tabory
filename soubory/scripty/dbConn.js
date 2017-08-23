// JavaScript Document

function printFiles(){
	var orderBy = document.getElementById( 'orderBy' ).value;
	var asc = document.getElementById( 'asc' ).value;
	var month = document.getElementById( 'month' ).value;
	var year = document.getElementById( 'year' ).value;
	year = year == DEF_YEAR ? '' : year;
	var inserted = document.getElementById( 'inserted' ).value;
	var pattern = document.getElementById( 'pattern' ).value;
	pattern = pattern == DEF_PATT ? '' : pattern;
	
	
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
	xmlhttp.open( "POST", "scripty/printFiles.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + DEF_TABLE + "&orderBy=" + orderBy + "&asc=" + asc + "&month=" + month + "&year=" + year + "&inserted=" + inserted + "&pattern=" + pattern + "&name=" + MY_NAME + "&table_downloaded=" + DEF_TABLE_DOWNLOAD + "&table_seen=" + DEF_TABLE_SEEN );
}

function deleteFile( id )
{
	var enter = confirm( 'Opravdu chceš soubor smazat?' );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "scripty/deleteFile.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + DEF_TABLE + "&id=" + id + "&name=" + MY_NAME );
	
	printFiles();
}

function stahni( soub ){
	window.open('files/' + soub );
};

function downloadFile( file_name, file_id )
{
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	/*xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( DEF_DIV ).innerHTML = xmlhttp.responseText;
		}
	};*/
	xmlhttp.open( "POST", "scripty/downloadFile.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + DEF_TABLE + "&file_id=" + file_id + "&table_download=" + DEF_TABLE_DOWNLOAD + "&userName=" + MY_NAME );
	
	stahni( file_name );
	printFiles();
}

function dec( num, len )
{
	var new_num = '';
	num =  num.toString();
	for ( var i = 0; i < len; i++ )
	{
		if ( !num[i] || num[i] == '' || num[i] == 'undefined' ) break;
		new_num += num[i];
		if ( num[i] == '.' ) ++len;
	}
	return new_num;
}

function bytesToRead( inn )
{
	var ext = ' B';
	if ( inn >= 1024 )
	{
		inn /= 1024;
		ext = ' kB';
	}
	if ( inn >= 1024 )
	{
		inn /= 1024;
		ext = ' MB';
	}
	if ( inn >= 1024 )
	{
		inn /= 1024;
		ext = ' GB';
	}
	if ( inn >= 1024 )
	{
		inn /= 1024;
		ext = ' TB';
	}
	
	return dec( inn, 5 ) + ext;
}

function checkUpload()
{
	var file = document.getElementById( 'file' ).value;
	var popis = document.getElementById( 'popis' ).value;
	var pozn = document.getElementById( 'pozn' ).value;
	if ( file == '' ) {
		alert( 'No file selected' );
		return false;
	}
	else if ( file.length > MAX_LEN_OF_FILE_NAME )
	{
		alert( 'The name is too long (>'+MAX_LEN_OF_FILE_NAME+' ch)' );
		return false;
	}
	else if ( pozn.length > MAX_LEN_OF_NOTE )
	{
		alert( 'Note is too long (> '+MAX_LEN_OF_NOTE+' ch)' );
		return false;
	}
	else if ( MAX_UPLOAD_SIZE < ACT_SIZE )
	{
		var minus = parseInt(ACT_SIZE)-parseInt(MAX_UPLOAD_SIZE);
		alert( 'Velikost překročila meze o ' + bytesToRead(minus) );
		return false;
	}

	
	return true;
}

function clearSearch()
{
	document.getElementById( 'orderBy' ).selectedIndex = 0;
	document.getElementById( 'asc' ).selectedIndex = 0;
	document.getElementById( 'month' ).selectedIndex = 0;
	$('#year').val( DEF_YEAR );
	$("#year").css( 'font-family', 'monospace' );
	$("#year").css( 'color', 'grey' );
	document.getElementById( 'inserted' ).selectedIndex = 0;
	$("#pattern").val( DEF_PATT );
	$("#pattern").css( 'font-family', 'monospace' );
	$("#pattern").css( 'color', 'grey' );
	
	printFiles();
}


function openNewWindow( link, file_id ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	/*xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( DEF_DIV ).innerHTML = xmlhttp.responseText;
		}
	};/**/
	xmlhttp.open( "POST", "scripty/seeFile.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + DEF_TABLE + "&file_id=" + file_id + "&table_seen=" + DEF_TABLE_SEEN + "&userName=" + MY_NAME );
	
	window.open( "http://docs.google.com/gview?url=http://vlcata.pohrebnisluzbazlin.cz/soubory/files/" + link + "&embedded=true" );
	printFiles();
}

function printStatistic( divID, tableDownloaded, tableSeen ) {
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( divID ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/seeStatistic.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table_downloaded=" + tableDownloaded + "&table_seen=" + tableSeen );

}