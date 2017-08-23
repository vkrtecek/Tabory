// JavaScript Document
function printMenu( where, n, p )
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
	xmlhttp.open( "POST", "scripts/printMenu.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "n="+n+"&p="+p );
}

function printItems( where, n, p )
{
	var category = document.getElementsByClassName( 'changeSort' )[0].value;
	var sortBy = document.getElementsByClassName( 'changeSort' )[1].value;
	var asc = document.getElementsByClassName( 'changeSort' )[2].value;
	var pattern = document.getElementsByClassName( 'changeSortBtn' )[0].value;
	
	var prikaz = 'SELECT * FROM items_items I LEFT JOIN items_kategory K ON I.kategorie = K.jmeno LEFT JOIN vlc_users U ON K.garant = U.id WHERE I.platnost = 1';
	//var prikaz = 'SELECT a.*, b.*, v.nickname GARANT FROM items_items AS a LEFT JOIN items_kategory AS b ON a.kategorie = b.jmeno LEFT JOIN vlc_users AS v ON b.garant = v.nick WHERE a.platnost = 1';
	if ( category != '1' ) prikaz += ' AND kategorie = "'+category+'"';
	if ( pattern != '' ) prikaz += ' AND (popis LIKE "%25'+pattern+'%25" OR nazev LIKE "%25'+pattern+'%25")';
	prikaz += ' ORDER BY I.'+sortBy+' '+asc;
	
	
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
	xmlhttp.open( "POST", "scripts/printItems.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "prikaz="+prikaz+"&n="+n+"&p="+p );
}

function delItem( id, where, table )
{
	var enter = confirm( "Opravdu chceš smazat položku?" );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "scripts/delItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&table="+table );
	
	printItems( where );
}

function updateItem( id, where, table )
{
	var cat = document.getElementsByTagName( 'select' )[0].value;
	var verejne = document.getElementsByTagName( 'select' )[1].value;
	var nazev = document.getElementById( 'name' ).value;
	var popis = document.getElementsByTagName( 'textarea' )[0].innerHTML;
	
	if ( nazev == '' )
	{
		alert( 'Nevyplněný název' );
		return;
	}
	
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
	xmlhttp.open( "POST", "scripts/updateItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&table="+table+"&cat="+cat+"&verejne="+verejne+"&nazev="+nazev+"&popis="+popis );
}

function checkInsert( table, DEF_NAME, where )
{
	var cat = document.getElementById( 'nahr_cat' ).value;
	var nazev = document.getElementById( 'nahr_nazev' ).value;
	var popis = document.getElementById( 'nahr_popis' ).value;
	var pic = document.getElementById( 'nahr_file' ).value;
	
	if ( pic == '' || nazev == '' || nazev == DEF_NAME )
	{
		alert( 'Nevyplněn název nebo obrázek' );
		return false;
	}
	pic = pic.split( '\\' );
	pic = pic[pic.length-1];
	pic = cat+"_"+pic;
	
	
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
	xmlhttp.open( "POST", "scripts/insertItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "nahr_nazev="+nazev+"&nahr_popis="+popis+"&nahr_cat="+cat+"&fileName="+pic+"&table="+table );
	
	return true;
}

function addAnotherItem()
{
	alert( 'another item' );
}

function clearSearch( where, n, p )
{
	document.getElementsByClassName( 'changeSort' )[0].selectedIndex = 0;
	document.getElementsByClassName( 'changeSort' )[1].selectedIndex = 0;
	document.getElementsByClassName( 'changeSortBtn' )[0].value = '';
	
	printItems( where, n, p );
}