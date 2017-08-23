<?php
function findExt( $basename, $dir ) {
	foreach ( glob( $dir.'/*' ) as $file ) {
		$tmp = pathinfo($file);
		if ( $tmp['filename'] == $basename ) return $tmp['extension'];
	}
	return 'bin';
}


?>