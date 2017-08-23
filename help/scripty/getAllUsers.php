<?php
$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		echo '<table rules="all">';
		$sql = $spojeni->query( "SELECT * FROM vlc_users" );
		echo '<tr>';
		$head = mysqli_fetch_fields($sql);
		for ( $i = 1; $i < count($head); $i++ ) {
			if ( $head[$i]->name == "ID" ) continue;
			echo '<th>'.$head[$i]->name.'</th>';
		}
			echo '<th>Smazat</th>';
		echo '</tr>';
		
		while ( $user = mysqli_fetch_array($sql, MYSQLI_NUM) ) {
			echo '<tr>';
			for ( $i = 1; $i < count($user); $i++ )
				echo '<td id="'.$user[0].'_'.$head[$i]->name.'" onDblClick="makeChange( \''.$user[0].'_'.$head[$i]->name.'\', \'vlc_users\' )" title="'.$head[$i]->name.'">'.$user[$i].'</td>';
			echo '<td><button onclick="deleteUser( \''.$user[0].'\', \''.$user[1].' '.$user[2].'\' )">Delete</button></td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";