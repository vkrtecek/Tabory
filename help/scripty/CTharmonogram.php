<?php
$statement = 'CREATE TABLE IF NOT EXISTS `d'.$year.'_harmonogram` (
  `den` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `datum` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `vedouci` int(3) NOT NULL,
  `dira1` int(3) NOT NULL,
  `dira2` int(3) NOT NULL,
  `Mor1` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gMor1` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `colspan1` int(11) NOT NULL DEFAULT \'1\',
  `Mor2` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gMor2` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `colspan2` int(11) NOT NULL DEFAULT \'1\',
  `Af1` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gAf1` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `colspan3` int(11) NOT NULL DEFAULT \'1\',
  `Af2` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gAf2` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `colspan4` int(11) NOT NULL DEFAULT \'1\',
  `Nig` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `gNig` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `colspan5` int(11) NOT NULL DEFAULT \'1\',
  `inserted` int(3) DEFAULT NULL,
  `changed` int(3) DEFAULT NULL,
  `etapa1` int(11) NOT NULL DEFAULT \'0\',
  `etapa2` int(11) NOT NULL DEFAULT \'0\',
  `etapa3` int(11) NOT NULL DEFAULT \'0\',
  `etapa4` int(11) NOT NULL DEFAULT \'0\',
  `etapa5` int(11) NOT NULL DEFAULT \'0\',
	`created` datetime NULL,
	`modified` datetime NULL
);';
$spojeni->query( $statement );
echo '<p>d'.$year.'_harmonogram have been created.</p>';
?>