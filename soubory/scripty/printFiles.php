<?php
$table = $_REQUEST['table'];
$orderBy = $_REQUEST['orderBy'];
$asc = $_REQUEST['asc'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$inserted = $_REQUEST['inserted'];
$pattern = $_REQUEST['pattern'];
$name = $_REQUEST['name'];
$tableD = $_REQUEST['table_downloaded'];
$tableS = $_REQUEST['table_seen'];


if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{		
		$items = 0;
		$statement = "SELECT * FROM ".$table." WHERE platnost = 1";
		if ( $month != '' ) $statement .= ' AND datum LIKE "%-'.$month.'-%"';
		if ( $year != '' ) $statement .= ' AND datum LIKE "%'.$year.'-%"';
		if ( $inserted != '' ) $statement .= ' AND inserted = "'.$inserted.'"';
		if ( $pattern != '' ) $statement .= ' AND ( nazev LIKE "%'.$pattern.'%" OR pozn LIKE "%'.$pattern.'%" )';
		$statement .= ' ORDER BY '.$orderBy.' '.$asc;
		
		
		if ( isset($_REQUEST['download']) )
		{
			$sql = $spojeni->query("SELECT * FROM vlc_files WHERE id = ".$_REQUEST['id']);
			$polozka = mysqli_fetch_array( $sql );
			$spojeni->query("UPDATE vlc_files SET downloaded = ".(++$polozka['downloaded'])." WHERE id = ".$_REQUEST['id']);
		}
		
		$cnt = 0;
		$sql = $spojeni->query( $statement );
		while ( $c = mysqli_fetch_array($sql) )
		{
			$usersD = $usersS = array();
			$sqlD = $spojeni->query( "SELECT DISTINCT(user) from ".$tableD." WHERE file=".$c['id'] );
			while ( $user = mysqli_fetch_array( $sqlD, MYSQLI_ASSOC ) ) {
				array_push( $usersD, $user['user'] );
			}
			$sqlS = $spojeni->query( "SELECT DISTINCT(user) from ".$tableS." WHERE file=".$c['id'] );
			while ( $user = mysqli_fetch_array( $sqlS, MYSQLI_ASSOC ) ) {
				array_push( $usersS, $user['user'] );
			}
			
			
		
			$titleD = "";
			$titleS = "";
			if ( isAdmin( $name, $spojeni) ) {
				if ( $usersD ) {
					foreach( $usersD as $user ) {
						$titleD .= nicknameFromID( $user, $spojeni ).'
';
					}
				} else $titleD .= 'none';
				if ( $usersS ) {
					foreach ( $usersS as $user ) {
						$titleS .= nicknameFromID( $user, $spojeni ).'
';
					}
				} else $titleS .= 'none';
			} // end isAdmin() ...
			
			
			
			$item = '<div class="item">';
			$item .= '<input type="submit" value="×" class="hash" onClick="deleteFile( '.$c['id'].' )" />';
			$item .= '<span class="nazev" id="n_'.(++$cnt).'" onclick="openNewWindow( \''.$c['nazev'].'\', \''.$c['id'].'\' )" style="cursor:pointer;" title="'.$titleS.'">'.wordwrap($c['nazev'], 18, "-\r\n", true).'</span><br />';
			$item .= '<span class="pozn" id="p_'.$cnt.'"><em>'.$c['pozn'].'</em></span><br />';
			$item .= '<span class="pridal"><strong>'.nicknameFromID( $c['inserted'], $spojeni ).'</strong> -> '.dateToReadableFormat($c['datum']).'</span><br />';
			
			$item .= '<button name="download" class="download" id="d_'.$cnt.'" onclick="downloadFile( \''.$c['nazev'].'\', \''.$c['id'].'\' )" title="'.$titleD.'"></button><br />';
			
			$size = $c['velikost'];
			if ( $size < 1023 ) $size .= " B";
			else if ( $size < 1048575 ) { $size /= 1024; $size = (int)$size." kB";}
			else if ( $size > 1048576 ) { $size /= 1048576; $size = number_format( (float)$size, 2, '.', ' ')." MB"; }
			$item .= '<span class="downloaded">Velikost: '.$size.'</span><em class="downloaded2" id="p_'.$cnt.'">Staženo: '.$c['downloaded'].'x</em>';
			$item .= '</div>';
			
			echo $item;
			$items++;
		}
		?>
        <script type="text/javascript">
			for ( i = 0; i < <?php echo $items; ?>; i++ )
			{
				vyska = document.getElementsByClassName('item')[i].scrollHeight;
				nazev = document.getElementsByClassName("nazev")[i].innerHTML;
				delka = nazev.length;
				
				//alert( (i+1) + " - " + nazev + "(" + delka + ")" );
				if ( (vyska > 145 && vyska <= 289) || delka > 66 ) document.getElementsByClassName('item')[i].style.height="304px";
				else if ( vyska > 289 ) document.getElementsByClassName("item")[i].style.height="475px";
			}
		</script>
        <?php
	}
	else echo '<p>Connection with database had failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";
?>