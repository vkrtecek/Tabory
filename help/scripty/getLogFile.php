<?php
$logFile = $_REQUEST['logFile'];

$content = file_get_contents( '..'.DIRECTORY_SEPARATOR.$logFile );
$lines = explode( '
', $content );
foreach( $lines as $line )
	echo $line.'<br />';