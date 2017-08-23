<?php

function printSelectOfUsers( & $spojeni, $actualUser, $selectID, $attributes ) {
	$sql = $spojeni->query( "SELECT * from vlc_users WHERE platnost = 1" );
	
	echo '<select id="'.$selectID.'" '.$attributes.'>';
	echo '<option>-- vybrat --</option>';
	while ( $user = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
		echo '<option value="'.$user['nick'].'"';
		if ( $user['nick'] == $actualUser ) echo ' selected=""';
		echo '>'.$user['nickname'].'</option>';
	}
	echo '</select>';
}

function isOver( $reference, $now ) {
	$R_YYYY = $R_MM = $R_DD = $R_hh = $R_mm = $R_ss = 0;
	$N_YYYY = $N_MM = $N_DD = $N_hh = $N_mm = $N_ss = 0;
	sscanf( $reference, "%d-%d-%d %d:%d:%d", $R_YYYY, $R_MM, $R_DD, $R_hh, $R_mm, $R_ss );
	sscanf( $now, "%d-%d-%d %d:%d:%d", $N_YYYY, $N_MM, $N_DD, $N_hh, $N_mm, $N_ss );
	
	if ( $R_YYYY < $N_YYYY ) return true;
	if ( $R_YYYY == $N_YYYY ) {
		if ( $R_MM < $N_MM ) return true;
		if ( $R_MM == $N_MM ) {
			if ( $R_DD < $N_DD ) return true;
			if ( $R_DD == $N_DD ) {
				if ( $R_hh < $N_hh ) return true;
				if ( $R_hh == $N_hh ) {
					if ( $R_mm < $N_mm ) return true;
					if ( $R_mm == $N_mm ) {
						if ( $R_ss < $N_ss ) return true;
						return false;
					}
				}
			}
		}
	}
	return false;
}