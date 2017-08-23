<?php
$table = $_REQUEST['table'];
$col = $_REQUEST['col'];
$id = $_REQUEST['id'];
$who = $_REQUEST['who'];
$promenne = '../../promenne.php';

if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$query = "SELECT ".$col." FROM ".$table." WHERE den=".$id;
		if ( $sql = $spojeni->query($query) ) {
			$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
			$val = $res[$col];
			$ids = explode( ' - ', $val );
			$ret = '';
			foreach ( $ids as $id ) {
				$ret .= nicknameFromID( $id, $spojeni ).' ';
			}
			$ret = $ret == '0 ' ? '' : $ret;
			echo $ret;
			
			$log = $who.' just changed '.$id.'th day - '.$col.' is now '.$ret;
			$path = '../..';
			writeLog( $log, $path, $table.'.txt' );
		}
		else echo 'fail -> '.$query;
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";