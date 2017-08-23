<?php
$statement = 'CREATE TABLE d'.$year.'_jidlo(
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
  `changed` int(3) DEFAULT NULL
);';
$spojeni->query( $statement );

$days = 15;
for ( $i = 0; $i < $days; $i++ )
{
	$statement = 'INSERT INTO d'.$year.'_jidlo ( den, datum ) VALUES ( '.($i+1).', "'.$year.'-'.$month.'-'.$day.'" + INTERVAL '.$i.' day );';
	$spojeni->query( $statement );
}
echo '<p>d'.$year.'_jidlo have been created.</p>';
?>