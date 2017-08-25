<?php
//fotka 120x150
$tableNow = "d2017_members";
$tableAll = "vlc_boys";

function ourDate( $in )
{
	$time = strtotime( $in );
	return  date('d', $time).'. '.date('m', $time).'. '.date('Y', $time);
}
function myDateDiff( $lower, $larger )
{	
	$diff = abs( strtotime($larger) - strtotime($lower) ); 
	return floor($diff / (365*60*60*24));
}
function birthToday( $date )
{
	return ourDate( $date ) == date( 'd. m. Y' );
}

if ( file_exists( "../promenne.php") && require( "../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( isset($_REQUEST['BACK']) || (!isset($_REQUEST['EDIT']) && !isset($_REQUEST['ADD']) && !isset($_REQUEST['EDIT_M'])) )
		{
			$cnt = 0;
			$sql = $spojeni->query( "SELECT id FROM ".$tableNow );
			echo '<div id="members">';
			echo '<ul>';
			while ( $clen = mysqli_fetch_array( $sql ) )
			{
				$sql2 = $spojeni->query( "SELECT * FROM ".$tableAll." WHERE id = ".$clen['id'] );
				$clen = mysqli_fetch_array( $sql2 );
				echo '<li title="'.$clen['name'].' '.$clen['sname'].'"';
				echo ' id="member'.$clen['id'].'"';
				echo ' onMouseOver="showCard( \'card'.$clen['id'].'\' )"';
				echo ' onMouseOut="hideCard( \'card'.$clen['id'].'\' )">';
				echo $clen['name'].' '.$clen['sname'].'</li>';
				
				echo '<div class="card" id="card'.$clen['id'].'">';
				echo '<img src="../help/img/members/small/'.$clen['photo'].'" alt="Fotka člena"/>';
				echo '<table rules="none">';
					echo '<tr><td>Jméno a příjmení:</td><td>'.$clen['name'].' '.$clen['sname'].'</td></tr>';
					echo '<tr><td>Přezdívka:</td><td>'.$clen['nick'].'</td></tr>';
					echo '<tr><td>Adresa:</td><td>'.$clen['address'].'</td></tr>';
					echo '<tr><td>Datum narození:</td><td>'.ourDate($clen['birthdate']).'</td></tr>';
					echo '<tr><td>Rodné číslo:</td><td>'.$clen['RC'].'</td></tr>';
					echo '<tr><td>Telefon otec:</td><td>'.$clen['telO'].'</td></tr>';
					echo '<tr><td>E-mail otec:</td><td>'.$clen['mailO'].'</td></tr>';
					echo '<tr><td>Telefon matka:</td><td>'.$clen['telM'].'</td></tr>';
					echo '<tr><td>E-mail matka:</td><td>'.$clen['mailM'].'</td></tr>';
					echo '<tr><td>Zdravotní omezení:</td><td>'.str_replace( '
', '<br />', $clen['zdravi']).'</td></tr>';
					echo '<tr><td>Věk</td><td>'.myDateDiff( $clen['birthdate'], date( 'Y-m-d' ) ).'</td></tr>';
					if ( birthToday( $clen['birthdate'] ) ) echo '<tr><td colspan="2" style="text-align:center"><span class="red">Dnes má narozeniny</span></td></tr>';
				echo '</table>';
				echo '</div>';
				
				$cnt++;
			}
			echo '</ul>';
			echo '<span class="red">'.$cnt.' členů</span>';
			echo '</div>';
			
			echo '<form method="post">';
			echo '<input type="hidden" name="name" value="'.$_REQUEST['name'].'" />';
			echo '<input type="hidden" name="passwd" value="'.$_REQUEST['passwd'].'" />';
			echo '<div id="underMembers" type="submit">';
			echo '<button name="EDIT">upravit sestavu</button>';
			echo '</div>';
			echo '</form>';
		}
		else if ( isset($_REQUEST['EDIT']) && !isset($_REQUEST['ADD']) && !isset($_REQUEST['BACK']) && !isset($_REQUEST['EDIT_M']) )
		{
			require( "cleni_edit.php" );
		}
		else if ( !isset($_REQUEST['EDIT']) && isset($_REQUEST['ADD']) && !isset($_REQUEST['BACK']) && !isset($_REQUEST['EDIT_M']) )
		{
			require( "cleni_add.php" );
		}
		else if ( !isset($_REQUEST['EDIT']) && !isset($_REQUEST['ADD']) && !isset($_REQUEST['BACK']) && isset($_REQUEST['EDIT_M']) )
		{
			require( "cleni_edit_concr.php" );
		}
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../promenne.php doesn't exists.</p>";
?>
<script type="text/javascript">
$( ".card" ).hide();

function showCard( inn )
{
	$( "#" + inn ).show();
}
function hideCard( inn )
{
	$( "#" + inn ).hide();
}
</script>