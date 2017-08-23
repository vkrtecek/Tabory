<?php
$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		echo '<select id="this_select" onchange="showFormToUpdate( \'this_select\', \'here_drow\' )">';
		echo '<option value="0" >---</option>';
		$sql = $spojeni->query( "SELECT * FROM vlc_users" );
		while ( $user = mysqli_fetch_array($sql) ){
			echo '<option value="'.$user['ID'].'">'.$user['nickname'].'</option>';
		}
		echo "</select>";
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";