<?php
$statement = 'CREATE TABLE d'.$year.'_members(
  `id` int(12) NOT NULL PRIMARY KEY
);';
$spojeni->query( $statement );
echo '<p>d'.$year.'_members have been created.</p>';
?>