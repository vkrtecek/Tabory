
var HP = 25;
var lastID = 0;
var char = 'x';
var color = '#A4EDFF';
var end = false;

function printTable()
{
	var startStr = '<table rules="all">';
	for ( var i = 0; i < HP; i++ )
	{
		startStr += '<tr>';
		for ( var l = 0; l < HP; l++ )
		{
			startStr += '<td id="'+i+'_'+l+'" onClick="insert( \''+i+'_'+l+'\')"></td>';
		}
		startStr += '</tr>';
	}
	startStr += '</table>';
	document.getElementById( 'GamingTable' ).innerHTML = startStr;
}
function emptyCell( id )
{
	return document.getElementById( id ).innerHTML == '' ? true : false;
}
function horizontalWin( axe, char )
{
	var minusStart = Math.min( axe[1], win-1 );
	var plusEnd = Math.min( HP-axe[1]-1, win-1 );
	//alert( minusStart + " - " + plusEnd );
	
	var cnt = 0, maxCNT = 0, x, y;
	for ( var i = -minusStart; i <= plusEnd; i++ )
	{
		x = parseInt(axe[0]);
		y = parseInt(axe[1])+i;
		
		if ( document.getElementById( x + "_" + y ).innerHTML == char )
		{
			cnt++;
			if ( cnt >= win ) return true;
		}
		else
		{
			maxCNT = cnt > maxCNT ? cnt : maxCNT;
			cnt = 0;
		}
	}
	return false;
}
function verticalWin( axe, char )
{
	var minusStart = Math.min( axe[0], win-1 );
	var plusEnd = Math.min( HP-axe[0]-1, win-1 );
	//alert( minusStart + " - " + plusEnd );
	
	var cnt = 0, maxCNT = 0, x, y;
	for ( var i = -minusStart; i <= plusEnd; i++ )
	{
		x = parseInt(axe[0])+i;
		y = parseInt(axe[1]);
		
		if ( document.getElementById( x + "_" + y ).innerHTML == char )
		{
			cnt++;
			if ( cnt >= win ) return true;
		}
		else
		{
			maxCNT = cnt > maxCNT ? cnt : maxCNT;
			cnt = 0;
		}
	}
	return false;
}
function diagonalWinX( axe, char )
{
	var minXY = Math.min( axe[0], axe[1] );
	var maxXY = Math.max( axe[0], axe[1] );
	var minusStart = minXY < win-1 ? minXY : win-1;
	var plusEnd = maxXY < HP-(win-1) ? win-1 : HP-maxXY-1;
	
	var cnt = 0, maxCNT = 0, x, y;
	for ( var i = -minusStart; i <= plusEnd; i++ )
	{
		x = parseInt(axe[0])+i;
		y = parseInt(axe[1])+i;
		
		if ( document.getElementById( x + "_" + y ).innerHTML == char )
		{
			cnt++;
			if ( cnt >= win ) return true;
		}
		else
		{
			maxCNT = cnt > maxCNT ? cnt : maxCNT;
			cnt = 0;
		}
	}
	return false;
}

function diagonalWinY( axe, char )
{
	var minusStart = Math.min( axe[0], HP-axe[1]-1 );
	minusStart = minusStart >= win ? win-1 : minusStart;
	var plusEnd = Math.min( axe[1], HP-axe[0]-1 );
	plusEnd = plusEnd >= win ? win-1 : plusEnd;
	//alert( minusStart + " - " + plusEnd );

	var cnt = 0, maxCNT = 0, x, y;
	for ( var i = -minusStart; i <= plusEnd; i++ )
	{
		x = parseInt(axe[0])+i;
		y = parseInt(axe[1])-i;
		//alert( x + "_" + y + " = " + document.getElementById( x + "_" + y ).innerHTML );
		
		if ( document.getElementById( x + "_" + y ).innerHTML == char )
		{
			cnt++;
			if ( cnt >= win ) return true;
		}
		else
		{
			maxCNT = cnt > maxCNT ? cnt : maxCNT;
			cnt = 0;
		}
	}
	return false;
}

function checkEndOfGame( id, char )
{
	var axe = id.split( '_' );
	
	if ( horizontalWin( axe, char ) ) return true;
	else if ( verticalWin( axe, char ) ) return true;
	else if ( diagonalWinX( axe, char ) || diagonalWinY( axe, char ) ) return true;
	
	for ( var i = 0; i < HP; i++ )
		 for ( var l = 0; l < HP; l++ )
		 	if ( emptyCell( i+'_'+l ) ) return false;
	return null;
}
function getBetterScore( char )
{
	var score = document.getElementById( 'win_'+char ).innerHTML;
	var newScore = parseInt( score ) + 1;
	document.getElementById( 'win_'+char ).innerHTML = newScore;
}

function insert( id )
{
	if ( end );
	else if( emptyCell(id) )
	{
		if ( lastID ) document.getElementById( lastID ).style.color = 'black';
		lastID = id;
		document.getElementById( id ).style.color = 'red';
		
		document.getElementById( id ).className += " disabled";
		
		document.getElementById( id ).innerHTML = char;
		document.getElementById( id ).style.backgroundColor = color;
		if ( end = checkEndOfGame( id, char ) )
		{
			document.getElementById( 'GamingTable' ).innerHTML += char + ' win <span id="again" onClick="gameAgain()">again?</span>';
			getBetterScore( char );
		}
		else if ( end === null ) {
			document.getElementById( 'GamingTable' ).innerHTML += 'Gaming table is full, <span id="again" onClick="gameAgain()">again?</span>';
		}
		else //not end yet
		{
			color = char == 'x' ? '#FFB6A4' : '#A4EDFF';
			char = char == 'o' ? 'x' : 'o';
			document.getElementById( 'player' ).innerHTML = char;
			document.getElementById( 'GamingTable' ).style.cursor = 'url(./img/'+char+'.jpg), pointer';
		}
	}
	//else alert( 'Toto políčko je zabráno' );
}
function gameAgain()
{
	printTable();
	end = false;
}