<?php
$statement = 'CREATE TABLE d'.$year.'_ukoly_radcu(
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `radce` int(3) NOT NULL,
  `typ` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ukol` longtext COLLATE utf8_czech_ci NOT NULL,
	`created` datetime NULL,
	`modified` datetime NULL
);';
$spojeni->query( $statement );
echo '<p>d'.$year.'_ukoly_radcu have been created.</p>';
?>