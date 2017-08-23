<?php
$ID = $_REQUEST["id"];
$table = $_REQUEST["table"];

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query("SELECT obrazek FROM ".$table." WHERE ID = ".$ID);
		$name_of_pic = mysqli_fetch_array($sql);
		if ( !strstr($name_of_pic[0], $_REQUEST['cat']) )
		{
			$old_name = explode( '_', $name_of_pic[0] );
			$new_pic_name = $_REQUEST['cat'];
			for ( $i = 1; $i < count($old_name); $i++ ) $new_pic_name .= '_'.$old_name[$i];
			
			rename( 'obrazky/'.$name_of_pic[0], 'obrazky/'.$new_pic_name );
			rename( 'obrazky/male/'.$name_of_pic[0], 'obrazky/male/'.$new_pic_name );
			
			$spojeni->query("UPDATE ".$table." SET popis = '".$_REQUEST['popis']."', kategorie = '".$_REQUEST['cat']."', verejne = '".$_REQUEST['verejne']."', nazev = '".$_REQUEST['nazev']."', obrazek = '".$new_pic_name."'  WHERE ID = ".$ID);
		}
		else//same name of photo
		{
			$spojeni->query("UPDATE items_items SET popis = '".$_REQUEST['popis']."', kategorie = '".$_REQUEST['cat']."', verejne = '".$_REQUEST['verejne']."', nazev = '".$_REQUEST['nazev']."'  WHERE ID = ".$ID);
		}
		echo '<p>Položka byla upravena.</p>';
		echo '<p><br /><br />
			<strong>Název:</strong> '.$_REQUEST['nazev'].'<br />
			<strong>Popis:</strong> '.$_REQUEST['popis'].'<br />
			<strong>Kategorie:</strong> '.$_REQUEST['cat'].'<br />
			<strong>Veřejné:</strong> '.$_REQUEST['verejne'].'</p>';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";