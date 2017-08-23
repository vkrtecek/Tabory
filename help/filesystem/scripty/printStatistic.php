<?php
function contains( $all, $user ) {
	$users = explode( ' - ', $all );
	foreach ( $users as $u )
		if ( $u == $user ) return true;
	return false;
}

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT den, inserted, changed, created, modified FROM dYearToSubStr_harmonogram" );
		$table = '<table rules="all" id="statistic">';
		$table .= '<tr><th>Day</th><th>inserted</th><th>date</th><th>changed</th><th>date</th></tr>';
		while ( $row = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
			$table .= '<tr>';
				$table .= '<td>'.$row['den'].'</td>';
				$table .= '<td>'.NicknameFromID( $row['inserted'], $spojeni ).'</td>';
				$table .= '<td>'.dateToReadableFormat( $row['created'] ).'</td>';
				$table .= '<td>'.NicknameFromID( $row['changed'], $spojeni ).'</td>';
				$table .= '<td>'.dateToReadableFormat( $row['modified'] ).'</td>';
			$table .= '</tr>';
		}
		$table .= '</table>';
		echo $table;
		
		$table = '<table id="statisticPercentage" rules="all">';
		$table .= '<tr><th>Name</th><th>His programs</th><th>Blocks</th><th>%</th><th>His blocks</th><th>%</th></tr>';
		$sql = $spojeni->query( "SELECT id FROM vlc_users WHERE aktivni=1" );
		while ( $user = mysqli_fetch_array($sql, MYSQL_ASSOC) ) {
			$table .= '<tr>';
				$table .= '<td>'.NicknameFromID( $user['id'], $spojeni ).'</td>';
				$allBlocks = 0;
				$blocks = 0;
				$programs = 0;
				$sqlBs = $spojeni->query( "SELECT * FROM dYearToSubStr_harmonogram" );
				while ( $row = mysqli_fetch_array($sqlBs, MYSQLI_ASSOC) ) {
					if ( $row['colspan1'] ) $allBlocks++;
					if ( $row['colspan2'] ) $allBlocks++;
					if ( $row['colspan3'] ) $allBlocks++;
					if ( $row['colspan4'] ) $allBlocks++;
					if ( $row['colspan5'] ) $allBlocks++; 
					
					if ( contains($row['gMor1'], $user['id']) && $row['colspan1'] ) {
						$programs++;
						$blocks += $row['colspan1'];
					}
					if ( contains($row['gMor2'], $user['id']) && $row['colspan2'] ) {
						$programs++;
						$blocks += $row['colspan2'];
					}
					if ( contains($row['gAf1'], $user['id']) && $row['colspan3'] ) {
						$programs++;
						$blocks += $row['colspan3'];
					}
					if ( contains($row['gAf2'], $user['id']) && $row['colspan4'] ) {
						$programs++;
						$blocks += $row['colspan4'];
					}
					if ( contains($row['gNig'], $user['id']) && $row['colspan5'] ) {
						$programs++;
						$blocks += $row['colspan5'];
					}
				}
				$table .= '<td>'.$programs.'</td>';
				$table .= '<td>'.$allBlocks.'</td>';
				$table .= '<td>'.($programs == 0 ? 0 : ($programs/$allBlocks)*100).' %</td>';
				$table .= '<td>'.$blocks.'</td>';
				$table .= '<td>'.($blocks*100/(15*5)).' %</td>'; // <days> * <blocksEachDay>
			$table .= '</tr>';
		}
		echo $table;
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";