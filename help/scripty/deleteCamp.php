<?php
$statement = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME LIKE 'd".$_REQUEST['year']."%'";
$dir = $_REQUEST['path'].'Tabor '.$_REQUEST['year'];

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( $statement );
		while ( $tables = mysqli_fetch_array( $sql, MYSQLI_ASSOC ) ) {
			foreach ( $tables as $table ) {
				if ( $spojeni->query( "DROP TABLE ".$table ) ) echo 'Dropped table '.$table.'<br />';
				else echo 'Can\'t drop table '.$table.'<br />';
			}
		}
		
		function rrmdir($dir) { 
		if (is_dir($dir)) { 
			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") { 
					if (is_dir($dir."/".$object))
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object); 
					} 
				}
				return rmdir($dir); 
			} 
		}
		if ( rrmdir( $dir ) ) echo 'Removed '.$dir.'<br />';
		else echo 'Can\'t remove '.$dir.'<br />';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";