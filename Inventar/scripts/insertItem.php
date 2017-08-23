<?php
$table = $_REQUEST['table'];
$fileName = $_REQUEST['fileName'];

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT count(*) CNT FROM ".$table." WHERE obrazek = '".$fileName."'" );
		$pic = mysqli_fetch_array( $sql );
		if ( $pic['CNT'] != 0 )//change pic name
		{
			$frag = explode( '.', $fileName );
			$frag[count($frag)-2] .= '(1)';
			
			for ( $fileName = '', $i = 0; $i < count($frag); $i++ )
				$fileName .= $frag[$i];
		}
		
		
		$spojeni->query("INSERT INTO ".$table." (nazev, popis, kategorie, obrazek) VALUES ('".$_REQUEST['nahr_nazev']."', '".$_REQUEST['nahr_popis']."', '".$_REQUEST['nahr_cat']."', '".$fileName."')");
		?>
        <p>Položka byla nahrána do databáze.</p>
            <button type="submit" name="dalsi" class="menu" onClick="addAnotherItem()" >Přidat další položku</button>
        <?php
		
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";