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
		$sql = $spojeni->query( "SELECT * FROM dYearToSubStr_jidlo" );
		echo '<h3>Změny v tabulce</h3>';
		$table = '<table rules="all" id="statistic">';
		$table .= '<tr><th>Day</th><th>created</th><th>modified</th><th>Changed</th></tr>';
		while ( $row = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
			$table .= '<tr>';
				$table .= '<td>'.$row['den'].'</td>';
				$table .= '<td>'.dateToReadableFormat( $row['created'] ).'</td>';
				$table .= '<td>'.dateToReadableFormat( $row['modified'] ).'</td>';
				$table .= '<td>'.NicknameFromID( $row['changed'], $spojeni ).'</td>';
			$table .= '</tr>';
		}
		$table .= '</table>';
		echo $table;
		
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";