<?php
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$hour = $_REQUEST['hour'];
$minute = $_REQUEST['minute'];

//echo $year.'-'.$month.'-'.$day.'T'.$hour.':'.$minute;

/*
$str = file_get_contents( '../../index.php' );
$str = str_replace( "var year= ", 'var year= '.$year.';//', $str );
$str = str_replace( "var mon = ", 'var mon = '.$month.';//', $str );
$str = str_replace( "var day = ", 'var day = '.$day.';//', $str );
$str = str_replace( "var hod = ", 'var hod = '.$hour.';//', $str );
$str = str_replace( "var mnt = ", 'var mnt = '.$minute.';//', $str );
file_put_contents('../../index.php', $str );
*/

$file = '../../campDate.js';
$content = 'var year = '.$year.';
var mon = '.$month.';
var day = '.$day.';
var hod = '.$hour.';
var mnt = '.$minute.';
var sec = 0;';
file_put_contents( $file, $content );
echo '<p>Změněno</p>';
?>