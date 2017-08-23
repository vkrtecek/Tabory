<?php
$table = $_REQUEST['table'];
$name = $_REQUEST['n'];

if ( file_exists('../../promenne.php') && file_exists('../../getMyTime().php') )
{
	require('../../promenne.php');
	require('../../getMyTime().php');
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
				$sql = $spojeni->query("SELECT jmeno, subject, text, datum, IP_address, ID FROM ".$table." WHERE platnost = 1 ORDER BY ID DESC");
				if ($sql)
				{
					while ($vysledek = mysqli_fetch_array($sql))
					{?>
						<div class="prispevek">
							<?php if ( strtolower(nicknameFromID($vysledek['jmeno'], $spojeni)) == strtolower($name) ) 
							{?>
									<button onClick="delComm( <?php echo $vysledek['ID']; ?>, 'commHere', '<?php echo $table; ?>', '<?php echo $name; ?>' )" class="smazat_prispevek"><b>SMAZAT</b></button>
							<?php } ?>
							<p class="subject"><strong>Věc: </strong><?php echo $vysledek['subject'] != NULL ? $vysledek['subject'] : '-'; ?></p>
							<p class="textPrispevku"><?php echo $vysledek['text'];?></p>
							<p class="jmeno">Příspěvek přidal: <strong><?php echo nicknameFromID( $vysledek['jmeno'], $spojeni );?></strong><br />
							<?php echo dateToReadableFormat($vysledek['datum']);?></p>
						</div>
					<?php
					}
				}
				
				
	}
	else echo '<h2>Connection with database had failed.</h2>';
}
else echo "<p>File $promenne doesn't exists.</p>";

?>