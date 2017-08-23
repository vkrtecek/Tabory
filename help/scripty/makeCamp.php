<?php
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$hour = 8;
$minute = 0;
$name = $_REQUEST['whoCreated'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$statement = "SELECT count(*) CNT FROM information_schema.tables WHERE table_schema = '".$db_name."' AND table_name = 'd".$year."_harmonogram'";
		$sql = $spojeni->query( $statement );
		$table = mysqli_fetch_array( $sql );
		if ( !$table['CNT'] )
		{
			require( "CTharmonogram.php" );
		}
		else echo 'Table d'.$year.'_harmonogram already exists.<br>';
		
		
		$statement = "SELECT count(*) CNT FROM information_schema.tables WHERE table_schema = '".$db_name."' AND table_name = 'd".$year."_jidlo'";
		$sql = $spojeni->query( $statement );
		$table = mysqli_fetch_array( $sql );
		if ( !$table['CNT'] )
		{
			require( "CTjidlo.php" );
		}
		else echo 'Table d'.$year.'_jidlo already exists.<br>';
		
		
		$statement = "SELECT count(*) CNT FROM information_schema.tables WHERE table_schema = '".$db_name."' AND table_name = 'd".$year."_members'";
		$sql = $spojeni->query( $statement );
		$table = mysqli_fetch_array( $sql );
		if ( !$table['CNT'] )
		{
			require( "CTmembers.php" );
		}
		else echo 'Table d'.$year.'_members already exists.<br>';
		
		
		$statement = "SELECT count(*) CNT FROM information_schema.tables WHERE table_schema = '".$db_name."' AND table_name = 'd".$year."_ukoly_radcu'";
		$sql = $spojeni->query( $statement );
		$table = mysqli_fetch_array( $sql );
		if ( !$table['CNT'] )
		{
			require( "CTukoly_radcu.php" );
		}
		else echo 'Table d'.$year.'_ukoly_radcu already exists.<br>';
		
		
		
		
		
		
		
		
		
		
		
		
		
		function recurse_copy( $src, $dst, $year )
		{ 
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						recurse_copy( $src.'/'.$file, $dst.'/'.$file, $year ); 
					} 
					else { 
						copy( $src.'/'.$file, $dst.'/'.$file ); 
						
						$str = file_get_contents( $dst.'/'.$file ); //replacing
						$str = str_replace( "YearToSubStr", $year, $str ); //replacing
						file_put_contents( $dst.'/'.$file, $str ); //replacing
					} 
				} 
			} 
			closedir($dir); 
		}
		if ( !file_exists( "../../Tabor ".$year ) )
		{
			recurse_copy( '../filesystem', '../../Tabor '.$year, $year );
			echo 'Filesystem have been created<br>';
		}
		else echo 'Filesystem with this name already exists.<br>';
		
		//here rewrite date of camp
		$file = '../../campDate.js';
		$content = 'var year = '.$year.';
var mon = '.$month.';
var day = '.$day.';
var hod = '.$hour.';
var mnt = '.$minute.';
var sec = 0;';
		file_put_contents( $file, $content );
		/*
		$file = "../../index.php";
		file_put_contents( $file, str_replace( 'var year= ', 'var year= '.$year.';//' ,file_get_contents($file) ));
		file_put_contents( $file, str_replace( 'var mon = ', 'var mon = '.$month.';//' ,file_get_contents($file) ));
		file_put_contents( $file, str_replace( 'var day = ', 'var day = '.$day.';//' ,file_get_contents($file) ));
		*/
		echo 'To see, please, refresh your browser.';
		
		$log = $name.' just created new camp to '.$year.'-'.$month.'-'.$day;
		writeLog( $log, '../..' );
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>