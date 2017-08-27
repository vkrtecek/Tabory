<?php
$st0 = 'SELECT count(*) CNT FROM (
SELECT name, sname, nickname nick, birthdate FROM vlc_users
    WHERE birthdate IS NOT NULL AND month(birthdate) >= month(now()) AND day(birthdate) >= day(now())
UNION 
	SELECT name, sname, nick, birthdate FROM vlc_boys
    WHERE birthdate IS NOT NULL AND month(birthdate) >= month(now()) AND day(birthdate) >= day(now())
ORDER BY month(birthdate) ASC, day(birthdate) ASC) AL';
$st1 = 'SELECT name, sname, nickname nick, birthdate FROM vlc_users
    WHERE birthdate IS NOT NULL AND month(birthdate) >= month(now()) AND day(birthdate) >= day(now())
UNION 
	SELECT name, sname, nick, birthdate FROM vlc_boys
    WHERE birthdate IS NOT NULL AND month(birthdate) >= month(now()) AND day(birthdate) >= day(now())
ORDER BY month(birthdate) ASC, day(birthdate) ASC';
$st2 = 'SELECT name, sname, nickname nick, birthdate FROM vlc_users
    WHERE birthdate IS NOT NULL
UNION 
	SELECT name, sname, nick, birthdate FROM vlc_boys
    WHERE birthdate IS NOT NULL
ORDER BY month(birthdate) ASC, day(birthdate) ASC
LIMIT 1, 1';

function is_prestupny( $date ) {
	$tmp = explode( '-', $date);
	$year = $tmp[0];
	return $year % 4 == 0 && $year % 100 != 0 && $yead % 400 == 0;
}

function countDays( $date, & $years ) {
	$tmp = getdate();
	$nowM = $tmp['mon'];
	$nowD = $tmp['mday'];
	$nowY = $tmp['year'];
	$tmp = explode( '-', $date);
	$willY = $tmp[0];
	$willM = $tmp[1];
	$willD = $tmp[2];
	$years += $nowY - $willY;
	if ( $willM == $nowM ) {
		if ( $willD == $nowD ) return 0;
		return $willD - $nowD;
	} else {
		$resrDays = in_array($nowM, array(1, 3, 5, 7, 8, 10, 12)) ? 31 - $nowD : ($nowM != 2 ? 30 - $nowM : (is_prestupny($date) ? 29 - $nowM : 28 - $nowM));
		for ( $i = $nowM+1; $i < $willM; $i++ ) $resrDays += in_array($i, array(1, 3, 5, 7, 8, 10, 12)) ? 31 : ($i != 2 ? 30 : (is_prestupny($date) ? 29 : 28));
		$resrDays += $willD;
		return $resrDays;
	}
	//$days = date_diff( $will, $was )->format( '%R%a' ) % 365;
	//return $days > 0 ? $days : $days+365;
}

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$years = 0;
		$sql = $spojeni->query( $st0 );
		$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		if ( $res['CNT'] > 0 ) { // SB in this year
			$sql = $spojeni->query( $st1 );
		} else { // SB in nex year
			$sql = $spojeni->query( $st2 );
			$years++;
		}
		$person = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		
		$print = 'Nejbližší narozeniny má '.$person['name'].' '.$person['sname'];
		if ( $person['nick'] != '' ) $print .= ' ('.$person['nick'].')';
		$print .= ' za '.countDays( $person['birthdate'], $years ).' dní -> '.dateToREadableFormat($person['birthdate']).' ('.$years.' roků)';
		echo $print;
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";