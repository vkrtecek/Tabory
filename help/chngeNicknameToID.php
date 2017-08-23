<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>

<form method="get">
	<button name="change">change</button>
</form>
<?php
if ( isset($_GET['change']) )
{
	$promenne = '../promenne.php';
	if ( file_exists($promenne) && require($promenne) )
	{
		if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
		{
			$parts = array( 'vedouci', 'dira1', 'dira2' );
			foreach ( $parts as $part )
			{
				$sql = $spojeni->query( "SELECT * FROM d2016_harmonogram H LEFT JOIN vlc_users U ON H.".$part." = U.nick" );
				while ( $res = mysqli_fetch_array( $sql ) )
				{
					echo  "UPDATE d2016_harmonogram SET ".$part."='".$res['ID']."' WHERE den = ".$res['den'].'<br />';
					if ( $res['ID'] != '' ) $spojeni->query( "UPDATE d2016_harmonogram SET ".$part."='".$res['ID']."' WHERE den = ".$res['den'] );
					
				}
				echo '<br /><br />';
			}
			
			
			$parts = array( 'gMor1', 'gMor2', 'gAf1', 'gAf2', 'gNig' );
			foreach ( $parts as $part )
			{
				$sql = $spojeni->query( 'SELECT * FROM d2016_harmonogram' );
				while ( $res = mysqli_fetch_array( $sql ) )
				{
					$sql1 = $spojeni->query( "SELECT ".$part." RES FROM d2016_harmonogram WHERE den = ".$res['den'] );
					$den_part = mysqli_fetch_array( $sql1 );
					$vykon = explode( ' - ', $den_part['RES'] );
					for ( $i = 0; $i < count($vykon); $i++ )
					{
						$sql2 = $spojeni->query( "SELECT id FROM vlc_users WHERE nick = '".$vykon[$i]."'" );
						$vyk = mysqli_fetch_array( $sql2 );
						if ( $vyk['id'] != '' ) $vykon[$i] = $vyk['id'];
					}
					/**/
					foreach( $vykon as $vykk ) echo $vykk.' --- ';echo '<br />';
					/**/
					$result = '';
					for ( $i = 0; $i < count($vykon); $i++ )
					{
						$result .= $vykon[$i];
						if ( $i != count($vykon)-1 ) $result .= ' - ';
					}
					$statement = 'UPDATE d2016_harmonogram SET '.$part.'="'.$result.'" WHERE den = '.$res['den'];
					echo $statement.'<br />';
					$spojeni->query( $statement );
				}
			}
		}
		else echo 'Second condition';
	}
	else echo 'First condition';
}
?>
</body>
</html>