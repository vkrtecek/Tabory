<?php
function ourDayInWeek( $in )
{
	return $in == 1 ? 'pondělí' : ( $in == 2 ? 'úterý' : ( $in == 3 ? 'středa' : ( $in == 4 ? 'čtvrtek' : ( $in == 5 ? 'pátek' : ( $in == 6 ? 'sobota' : ( $in == 7 ? 'neděle' : '' ))))));
}

require('../../getMyTime().php');
$statement = "CREATE TABLE d".$year."_jidlo(
  `den` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `datum` date,
  `denv`	varchar(255) COLLATE utf8_czech_ci,
  `snidane` varchar(255) COLLATE utf8_czech_ci,
  `sv1` varchar(255) COLLATE utf8_czech_ci,
  `ob1` varchar(255) COLLATE utf8_czech_ci,
  `ob2` varchar(255) COLLATE utf8_czech_ci,
  `sv2` varchar(255) COLLATE utf8_czech_ci,
  `vecere` varchar(255) COLLATE utf8_czech_ci,
  `pozn` longtext COLLATE utf8_czech_ci,
  `changed` int(3) DEFAULT NULL,
	`created` datetime default '".getMyTime()."',
	`modified` datetime NULL
);";
$spojeni->query( $statement );

$days = 15;
$timeStampToInsert = strtotime( $year.'-'.$month.'-'.$day );
for ( $i = 0; $i < $days; $i++ )
{
	$timeStampToInsert += 86400;
	$statement = 'INSERT INTO d'.$year.'_jidlo ( den, datum, denv ) VALUES ( '.($i+1).', "'.$year.'-'.$month.'-'.$day.'" + INTERVAL '.$i.' day, "'.ourDayInWeek( date( 'N', $timeStampToInsert ) ).'" );';
	$spojeni->query( $statement );
}
echo '<p>d'.$year.'_jidlo have been created.</p>';
?>