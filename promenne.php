<?php 

function toHacky( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT nickname RES FROM vlc_users WHERE nick = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}
function nicknameFromID( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT nickname RES FROM vlc_users WHERE id = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}
function IDFromNick( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT id RES FROM vlc_users WHERE nick = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}

function toDefaultTime( $in )
{
	$date = explode( ' ', $in );
	if ( count($date) == 1 ) return $in;
	$time = explode( ':', $date[1] );
	
	return $date[0].'T'.$time[0].':'.$time[1];
}

function dateToReadableFormat( $date, $months = NULL )
{
	if ( $date == '0' || $date == NULL) return '';
	
	if ( count(explode(' ', $date)) == 2) list( $date, $time ) = explode( ' ', $date );
	else if ( count(explode(' ', $date)) == 1 ) $time = NULL;
	else return $date;
	list( $year, $month, $day ) = explode( '-', $date );
	if ( !$months ) $months = array( 'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec' );
	$month = $month == '01' ? $months[0] : ( $month == '02' ? $months[1] : ( $month == '03' ? $months[2] : ( $month == '04' ? $months[3] : ( $month == '05' ? $months[4] : ( $month == '06' ? $months[5] : ( $month == '07' ? $months[6] : ( $month == '08' ? $months[7] : ( $month == '09' ? $months[8] : ( $month == '10' ? $months[9] : ( $month == '11' ? $months[10] : ( $months[11] )))))))))));
	return $day.'. '.$month.' '.$year.($time != NULL ? ' | '.$time : '');
}

function isAdmin( $name, & $spojeni )
{
	$sql = $spojeni->query( "SELECT * FROM vlc_users WHERE nick = '".$name."'" );
	$person = mysqli_fetch_array( $sql );
	return $person['admin'] == 1 ? true : false;
}

function translateByCode( &$spojeni, $column, $value, $code ) {
	$st = "SELECT * FROM utr_translations WHERE LanguageCode in (SELECT LanguageCode FROM utrata_members WHERE ".$column."='".$value."')";
	$sqlTranslations = $spojeni->query( $st );
	while( $translate = mysqli_fetch_array($sqlTranslations, MYSQLI_ASSOC) )
		if ( $translate['TranslateCode'] == $code ) return $translate['Value'];
	return NULL;
}

/**
* $l string log to be written
* $path string path to root
* $file string 
*/
function writeLog( $l, $path = '.', $file = 'logFile.txt' ) {
	$files = get_included_files();
	if ( in_array(__DIR__.DIRECTORY_SEPARATOR.'getMyTime().php', $files) ) $log = dateToReadableFormat( getMyTime() ).'			';
	else if ( file_exists($path.DIRECTORY_SEPARATOR.'getMyTime().php') && require($path.DIRECTORY_SEPARATOR.'getMyTime().php') ) $log = dateToReadableFormat( getMyTime() ).'			';
	else $log = 'Can\'t find '.$path.DIRECTORY_SEPARATOR.'getMyTime().php
';
	$log .= $l.'
';
	file_put_contents( $path.DIRECTORY_SEPARATOR.'help'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.$file, $log, FILE_APPEND );
}


//add the right variables to connect the database
switch ($_SERVER['SERVER_NAME']) {
	case 'localhost':
		require_once 'variables.php';
		break;
	case 'vlcata.pohrebnisluzbazlin.cz':
		require_once 'variables_server.php';
		break;
	default:
		require_once 'variables.php';
		break;
}
/*

Databázový server: wm70.wedos.net
Název databáze: d79175_vlcata

Uživatel pro správu databáze (má plná přístupová práva):
Jméno: a79175_vlcata
Heslo: RkAmcKJb

Uživatel s omezenými právy pro použití ve vašich skriptech:
Jméno: w79175_vlcata
Heslo: 7hP874ML


FTP:
Server: 79175.w75.wedos.net
Login: w79175_krtek
Heslo: sefFU6eh
*/
