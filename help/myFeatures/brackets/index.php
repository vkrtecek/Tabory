<html>
    <head>
		<link rel="stylesheet" href="styly/styly.css" />
    </head>
    <body>
        <?php
		$sqlClass = 'scripty/class.php';
		if ( file_exists( $sqlClass ) && require( $sqlClass ) ) {
			//$DB = new sqlConn( 'localhost', 'root', '', 'vlc_login_users' );
			$db_host = 'wm70.wedos.net';
$db_username = 'w79175_vlcata';
$db_password = '7hP874ML';
$db_name = 'd79175_vlcata';


//plný přístup:
$db_username = 'a79175_vlcata';
$db_password = 'RkAmcKJb';
			echo $db_host;
			$DB = new sqlConn( $db_host, $db_username, $db_password, $db_name );
			
			$tables = array( 'vlc_users', 'vlc_last_log', 'items_items', 'utrata_check_state_vojta' );

			foreach ( $tables as $table ) {
				$DB->printTable( $table );  
			}
		}
		else echo "<h1>File $sqlClass doesn't exists.</h1>";
		
        
        ?>
    </body>
</html>