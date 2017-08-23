// JavaScript Document
WHERE = 'herePhotoShow';


function getCurInx( len, id, clas ) {
	var trida;
	for ( var i = 0; i < len; i++ ) {
		trida = document.getElementsByClassName( clas )[i].getAttribute( 'id' );
		if ( trida == id ) return i;
	}
	return -1;
}

function showPhoto( id ) {
	var imgName = document.getElementById( id ).getAttribute( 'src' );
	var bigImgName = document.getElementById( id ).getAttribute( 'value' );
	var name = document.getElementById( id ).getAttribute( 'alt' );
	var sameClass = document.getElementById( id ).getAttribute( 'class' );
	var heading = document.getElementById( id ).getAttribute( 'heading' );
		
		var maxIndex = document.getElementsByClassName( sameClass ).length;
    	var curInx = getCurInx( maxIndex, id, sameClass );
		var leftOK = curInx < 1 ? 'false' : 'true';
		var rightOK = curInx+1 >= maxIndex ? 'false' : 'true';
	document.getElementById( 'photos' ).style.opacity = '0.5'; //background
	
	document.getElementById( WHERE ).innerHTML = '<div id="photoViewer"><div id="aroundPic"><div id="bySideImgLeft"></div><img src="img/loading.gif" alt="loading" /></div></div>'; //loading gif before photo reads
	
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttp.responseText;
			document.getElementById( 'photos' ).style.opacity = '0.5';
		}
	};
	xmlhttp.open( "POST", "scripty/showPic.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "img="+imgName+"&name="+name+"&preview="+bigImgName+"&class="+sameClass+"&index="+curInx+"&leftOK="+leftOK+"&rightOK="+rightOK+"&heading="+heading );
}

function showPhotoByClass( clas, inx ) {
	var id = document.getElementsByClassName( clas )[inx].getAttribute( 'id' );
	showPhoto( id );
}

function undo() {
	document.getElementById( WHERE ).innerHTML = '';
	document.getElementById( 'photos' ).style.opacity = '1';
}

function checkKey(e) {
	if ( e.keyCode == 37 ) {
		var attr = document.getElementById( "leftArowToAnotherPic" ).getAttribute( 'onClick' );
		if ( attr == '' ) return;
		eval( attr );
	}
	else if ( e.keyCode == 39 ) {
		var attr = document.getElementById( "rightArowToAnotherPic" ).getAttribute( 'onClick' );
		if ( attr == '' ) return;
		eval( attr );
	}
	else if ( e.keyCode == 27 )
		undo();
}