<?php
$table = $_REQUEST['table'];
$col = $_REQUEST['col'];
$id = $_REQUEST['id'];
$max_of_doers = $_REQUEST['max_of_doers'];
$promenne = '../../promenne.php';

if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{		
		$sql = $spojeni->query( "SELECT ".$col." TD FROM ".$table." WHERE den=".$id );
		$people = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
		$people = explode( ' - ', $people['TD'] );
		
		
		$i = 0;
		foreach ( $people as $person ) {
			$sql = $spojeni->query( "SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC" );
			echo '<select name="'.$col.'[]" id="'.$col.$i.'">';
			echo '<option value="0">-- vybrat --</option>';
			while ( $users = mysqli_fetch_array( $sql, MYSQLI_ASSOC ) ) {
				$item = '<option value="'.$users['ID'].'"';
				if ( $users['ID'] == $person ) $item .= ' selected=""';
				$item .= '>'.$users['nickname'].'</option>';
				echo $item;
			}
			echo '</select>';
			echo '<img src="imgs/delete.png" alt="minus" id="Del-'.$col.'-'.$i.'" onclick="minus( \'Del-'.$col.'-'.$i.'\' )" class="manipulate minus" title="odstranit vykonavatele" />';
			$i++;
		}
		//rest selects to $max_of_doers
		for (; $i < $max_of_doers; $i++ ) {
			echo '<select name="'.$col.'[]" id="'.$col.$i.'" disabled="">';
				echo '<option value="">-- vybrat --</option>';
				$sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
				while ($radce = mysqli_fetch_array($sql, MYSQLI_ASSOC))
				{
						echo '<option value="'.$radce['ID'].'"';
						echo '>'.$radce['nickname'].'</option>';
				}
			echo '</select>';
			echo '<img src="imgs/delete.png" alt="minus" id="Del-'.$col.'-'.$i.'" onclick="minus( \'Del-'.$col.'-'.$i.'\' )" class="manipulate minus toHide" title="odstranit vykonavatele" />';
		}
		//and image for add one of the hidden select(s)
		echo '<img src="imgs/plus.png" alt="plus" id="Add-'.$col.'" onclick="plus( \'Add-'.$col.'\', '.$max_of_doers.' )" class="manipulate plus" title="přidat vykonavatele" />';
		
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";