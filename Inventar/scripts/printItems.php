<?php
$prikaz = $_REQUEST['prikaz'];
$name = $_REQUEST['n'];
$passwd = $_REQUEST['p'];
$items_count = 0;

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query($prikaz); //doplnit
		while ($item = mysqli_fetch_array($sql)) //vypsání itemů
		{
			$each_item = '<div class="item">';
			
			$each_item .= '<button class="smazat_prispevek" onClick="delItem( \''.$item['ID'].'\', \'itemsHere\', \'items_items\' )"><b>ODEBRAT</b></button>';
			
			$each_item .= '<form method="post" action="upravit.php">
			<input type="hidden" name="name" value="'.$name.'" />
			<input type="hidden" name="passwd" value="'.$passwd.'" />
			<button type="submit"  name="upravit_prispevek" class="upravit_prispevek" value="'.$item['ID'].'"><b>UPRAVIT</b></button>
			</form>';
			
			list( $i_name, $i_ext ) = explode( '.', $item['obrazek'] );
			$each_item .= '<a href="obrazky/'.$item['obrazek'].'"><img src="obrazky/male/'.$i_name.'_small.'.$i_ext.'" alt="polozka" height="100" width="100"/></a>';
			$each_item .= '<div class="nazev"><h2>'.$item['nazev'].'</h2></div>';
			$each_item .= '<div class="popis"><span>'.$item['popis'].'</span></div>';
			$each_item .= '<div class="kategorie"><strong>'.$item['kategorie_nazev'].' - '.$item['nickname'].' ('.$item['telefon'].')</strong></div>';
			$each_item .= '</div>';//class = item
			echo $each_item;
			$items_count++;
		}
		if ($items_count == 0) echo '<p><br /><br />V této kategorii momentálně nic není.</p>';
		else echo '<p>Celkem položek: '.$items_count.'</p></div>';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>