<?php
$sql_table = "dYearToSubStr_harmonogram";
$max_of_doers = 5;
$DAY_MAX = 15;
$mustBeFilledVeldenAndHoles = false;

	if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
	{
		if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
		{ 
			$warning_colspan = false;
			$warning_colspan2 = false;
			$warning_colspan_int = false;
			$warning_day = false;
			$warning_day_exists = false;
			$warning_day_number = false;
			$warning_other = false;
			$warning_dira_velden = false;
			$warning_everyone = false;
			$saved = false;
			$changed = false;
			
			if ( isset($_REQUEST['form_add']) ) //kontrola vložení dne
			{
				if ( !is_numeric($_REQUEST['den']) ) $warning_day_number = true;
				else if ( $_REQUEST['den'] <= 0 || $_REQUEST['den'] > $DAY_MAX || $_REQUEST['den'] != (int)$_REQUEST['den'] ) $warning_day = true;
				else
				{
					$sql = $spojeni->query("SELECT * FROM ".$sql_table."");
					while ($den = mysqli_fetch_array($sql))
					{
						if ( $_REQUEST['den'] == $den['den'] ) $warning_day_exists = true;
					}
				}
				
				if ( !is_numeric($_REQUEST['colspan1']) || !is_numeric($_REQUEST['colspan2']) || !is_numeric($_REQUEST['colspan3']) || !is_numeric($_REQUEST['colspan4']) || !is_numeric($_REQUEST['colspan5']) ) $warning_colspan = true;
				else if ( $_REQUEST['colspan1'] != (int)$_REQUEST['colspan1'] || $_REQUEST['colspan2'] != (int)$_REQUEST['colspan2'] || $_REQUEST['colspan3'] != (int)$_REQUEST['colspan3'] || $_REQUEST['colspan4'] != (int)$_REQUEST['colspan4'] || $_REQUEST['colspan5'] != (int)$_REQUEST['colspan5'] ) $warning_colspan_int = true;
				else if ( $_REQUEST['colspan1'] < 0 || $_REQUEST['colspan2'] < 0 || $_REQUEST['colspan3'] < 0 || $_REQUEST['colspan4'] < 0 || $_REQUEST['colspan5'] < 0 ) $warning_colspan = true;
				else if ( $_REQUEST['colspan1'] > 5 || $_REQUEST['colspan2'] > 4 || $_REQUEST['colspan3'] > 3 || $_REQUEST['colspan4'] > 2 || $_REQUEST['colspan5'] > 1 ) $warning_colspan2 = true;
				else if ( $_REQUEST['colspan1'] + $_REQUEST['colspan2'] + $_REQUEST['colspan3'] + $_REQUEST['colspan4'] + $_REQUEST['colspan5'] != 5 ) $warning_colspan = true;
				else if ( $mustBeFilledVeldenAndHoles && ($_REQUEST['vedouci'] == "" || $_REQUEST['dira1'] == "" || $_REQUEST['dira2'] == "" || ($_REQUEST['colspan1'] && $_REQUEST['gMor1'] == "") || ($_REQUEST['colspan2'] && $_REQUEST['gMor2'] == "") || ($_REQUEST['colspan3'] && $_REQUEST['gAf1'] == "") || ($_REQUEST['colspan4'] && $_REQUEST['gAf2'] == "") || ($_REQUEST['colspan5'] && $_REQUEST['gNig'] == "")) ) $warning_everyone = true;
				else if ( ($_REQUEST['vedouci'] == $_REQUEST['dira1'] && $_REQUEST['dira1'] != "") || ($_REQUEST['vedouci'] == $_REQUEST['dira2'] && $_REQUEST['dira2'] != "") || ($_REQUEST['dira1'] == $_REQUEST['dira2'] && $_REQUEST['dira1'] != "") ) $warning_dira_velden = true;
				
				if ( $_REQUEST['colspan1'] && $_REQUEST['Mor1'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan2'] && $_REQUEST['Mor2'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan3'] && $_REQUEST['Af1'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan4'] && $_REQUEST['Af2'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan5'] && $_REQUEST['Nig'] == "" ) $warning_other = true;
			}
			
			
			if ( isset($_REQUEST['form_modify']) ) //kontrola upravy dne
			{
				if ( !is_numeric($_REQUEST['colspan1']) || !is_numeric($_REQUEST['colspan2']) || !is_numeric($_REQUEST['colspan3']) || !is_numeric($_REQUEST['colspan4']) || !is_numeric($_REQUEST['colspan5']) ) $warning_colspan = true;
				else if ( $_REQUEST['colspan1'] != (int)$_REQUEST['colspan1'] || $_REQUEST['colspan2'] != (int)$_REQUEST['colspan2'] || $_REQUEST['colspan3'] != (int)$_REQUEST['colspan3'] || $_REQUEST['colspan4'] != (int)$_REQUEST['colspan4'] || $_REQUEST['colspan5'] != (int)$_REQUEST['colspan5'] ) $warning_colspan_int = true;
				else if ( $_REQUEST['colspan1'] < 0 || $_REQUEST['colspan2'] < 0 || $_REQUEST['colspan3'] < 0 || $_REQUEST['colspan4'] < 0 || $_REQUEST['colspan5'] < 0 ) $warning_colspan = true;
				else if ( $_REQUEST['colspan1'] > 5 || $_REQUEST['colspan2'] > 4 || $_REQUEST['colspan3'] > 3 || $_REQUEST['colspan4'] > 2 || $_REQUEST['colspan5'] > 1 ) $warning_colspan2 = true;
				else if ( $_REQUEST['colspan1'] + $_REQUEST['colspan2'] + $_REQUEST['colspan3'] + $_REQUEST['colspan4'] + $_REQUEST['colspan5'] != 5 ) $warning_colspan = true;
				else if ( $mustBeFilledVeldenAndHoles && (!isset($_REQUEST['gMor1']) || !isset($_REQUEST['gMor2']) || !isset($_REQUEST['gAf1']) || !isset($_REQUEST['gAf2']) || !isset($_REQUEST['gNig'])) ) $warning_everyone = true;
				else if ( $mustBeFilledVeldenAndHoles && ($_REQUEST['vedouci'] == "" || $_REQUEST['dira1'] == "" || $_REQUEST['dira2'] == "" || ($_REQUEST['colspan1'] && $_REQUEST['gMor1'] == "") || ($_REQUEST['colspan2'] && $_REQUEST['gMor2'] == "") || ($_REQUEST['colspan3'] && $_REQUEST['gAf1'] == "") || ($_REQUEST['colspan4'] && $_REQUEST['gAf2'] == "") || ($_REQUEST['colspan5'] && $_REQUEST['gNig'] == "")) ) $warning_everyone = true;
				else if ( ($_REQUEST['vedouci'] == $_REQUEST['dira1'] && $_REQUEST['vedouci'] != "") || ($_REQUEST['vedouci'] == $_REQUEST['dira2'] && $_REQUEST['vedouci'] != "") || ($_REQUEST['dira1'] == $_REQUEST['dira2'] && $_REQUEST['dira1'] != "") ) $warning_dira_velden = true;
				
				if ( $_REQUEST['colspan1'] && $_REQUEST['Mor1'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan2'] && $_REQUEST['Mor2'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan3'] && $_REQUEST['Af1'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan4'] && $_REQUEST['Af2'] == "" ) $warning_other = true;
				else if ( $_REQUEST['colspan5'] && $_REQUEST['Nig'] == "" ) $warning_other = true;
			}
			
			//if everything is ok
			if ( !$warning_colspan && !$warning_colspan2 && !$warning_colspan_int && !$warning_day && !$warning_day_number && !$warning_day_exists && !$warning_other && !$warning_dira_velden && !$warning_everyone )
			{
				if ( isset($_REQUEST['form_add']) )//insert new day
				{
					$cnt = $vnt = 0;
					$vals = array( 'den', 'vedouci', 'dira1', 'dira2', 'Mor1', 'gMor1', 'colspan1', 'etapa1', 'Mor2', 'gMor2', 'colspan2', 'etapa2', 'Af1', 'gAf1', 'colspan3', 'etapa3', 'Af2', 'gAf2', 'colspan4', 'etapa4', 'Nig', 'gNig', 'colspan5', 'etapa5' );
					
					$query = "INSERT INTO ".$sql_table." (inserted, datum, den";
					$query .= ", vedouci, dira1, dira2, Mor1, gMor1, colspan1, etapa1, Mor2, gMor2, colspan2, etapa2, Af1, gAf1, colspan3, etapa3, Af2, gAf2, colspan4, etapa4, Nig, gNig, colspan5, etapa5, created )";
					$query .= " VALUES (";
					$query .= " '".IDFromNick( $name, $spojeni )."', '".$_REQUEST['datum']."<br />".$_REQUEST['dayInWeek']."'";
					$query .= ", ".$_REQUEST['den'];
					$query .= ", '".$_REQUEST['vedouci']."'";
					$query .= ", '".$_REQUEST['dira1']."'";
					$query .= ", '".$_REQUEST['dira2']."'";
					$query .= ", '".$_REQUEST['Mor1']."'";
					$query .= ", '";
					for ( $i = 0; $i < count($_REQUEST['gMor1']); $i++ )
					{
						$query .= $_REQUEST['gMor1'][$i];
						$query .= $i != count($_REQUEST['gMor1'])-1 ? ' - ' : '';
					}
					$query .= "'";
					$query .= ", ".$_REQUEST['colspan1']."";
					$query .= ", ".$_REQUEST['etapa1']."";
					$query .= ", '".$_REQUEST['Mor2']."'";
					$query .= ", '";
					for ( $i = 0; $i < count($_REQUEST['gMor2']); $i++ )
					{
						$query .= $_REQUEST['gMor2'][$i];
						$query .= $i != count($_REQUEST['gMor2'])-1 ? ' - ' : '';
					}
					$query .= "'";
					$query .= ", ".$_REQUEST['colspan2']."";
					$query .= ", ".$_REQUEST['etapa2']."";
					$query .= ", '".$_REQUEST['Af1']."'";
					$query .= ", '";
					for ( $i = 0; $i < count($_REQUEST['gAf1']); $i++ )
					{
						$query .= $_REQUEST['gAf1'][$i];
						$query .= $i != count($_REQUEST['gAf1'])-1 ? ' - ' : '';
					}
					$query .= "'";
					$query .= ", ".$_REQUEST['colspan3']."";
					$query .= ", ".$_REQUEST['etapa3']."";
					$query .= ", '".$_REQUEST['Af2']."'";
					$query .= ", '";
					for ( $i = 0; $i < count($_REQUEST['gAf2']); $i++ )
					{
						$query .= $_REQUEST['gAf2'][$i];
						$query .= $i != count($_REQUEST['gAf2'])-1 ? ' - ' : '';
					}
					$query .= "'";
					$query .= ", ".$_REQUEST['colspan4']."";
					$query .= ", ".$_REQUEST['etapa4']."";
					$query .= ", '".$_REQUEST['Nig']."'";
					$query .= ", '";
					for ( $i = 0; $i < count($_REQUEST['gNig']); $i++ )
					{
						$query .= $_REQUEST['gNig'][$i];
						$query .= $i != count($_REQUEST['gNig'])-1 ? ' - ' : '';
					}
					$query .= "'";
					$query .= ", ".$_REQUEST['colspan5']."";
					$query .= ", ".$_REQUEST['etapa5']."";
					if ( file_exists('../getMyTime().php') ) {
						require('../getMyTime().php');
						$query .= ", '".getMyTime()."'";
					}
					else $query .= ", NULL";
					$query .= " )";
					$spojeni->query($query);
					
					$saved = true;
					include_once( 'files/harmonogramCreator.php' );
				}
				else if ( isset($_REQUEST['form_modify']) ) //update day
				{
					$cnt = 0;
					
					
					
					$query = "UPDATE ".$sql_table." SET `changed` = '".IDFromNick( $name, $spojeni )."', datum = '".$_REQUEST['datum']."<br />".$_REQUEST['dayInWeek']."'";
					$query .= ", den = ".$_REQUEST['day_to_modify'];
					$query .= ", vedouci = '".$_REQUEST['vedouci']."'";
					$query .= ", dira1 = '".$_REQUEST['dira1']."'";
					$query .= ", dira2 = '".$_REQUEST['dira2']."'";
					$query .= ", Mor1 = '".$_REQUEST['Mor1']."'";
					$query .= ", gMor1 = '";
					for ( $i = 0; $i < count($_REQUEST['gMor1']); $i++ )
					{
						$query .= $_REQUEST['gMor1'][$i];
						$query .= $i != count($_REQUEST['gMor1'])-1 ? ' - ' : '';
					}
					$query .= "', colspan1 = ".$_REQUEST['colspan1'];
					$query .= ", etapa1 = ".$_REQUEST['etapa1'];
					$query .= ", Mor2 = '".$_REQUEST['Mor2']."'";
					$query .= ", gMor2 = '";
					for ( $i = 0; $i < count($_REQUEST['gMor2']); $i++ )
					{
						$query .= $_REQUEST['gMor2'][$i];
						$query .= $i != count($_REQUEST['gMor2'])-1 ? ' - ' : '';
					}
					$query .= "', colspan2 = ".$_REQUEST['colspan2'];
					$query .= ", etapa2 = ".$_REQUEST['etapa2'];
					$query .= ", Af1 = '".$_REQUEST['Af1']."'";
					$query .= ", gAf1 = '";
					for ( $i = 0; $i < count($_REQUEST['gAf1']); $i++ )
					{
						$query .= $_REQUEST['gAf1'][$i];
						$query .= $i != count($_REQUEST['gAf1'])-1 ? ' - ' : '';
					}
					$query .= "', colspan3 = ".$_REQUEST['colspan3'];
					$query .= ", etapa3 = ".$_REQUEST['etapa3'];
					$query .= ", Af2 = '".$_REQUEST['Af2']."'";
					$query .= ", gAf2 = '";
					for ( $i = 0; $i < count($_REQUEST['gAf2']); $i++ )
					{
						$query .= $_REQUEST['gAf2'][$i];
						$query .= $i != count($_REQUEST['gAf2'])-1 ? ' - ' : '';
					}
					$query .= "', colspan4 = ".$_REQUEST['colspan4'];
					$query .= ", etapa4 = ".$_REQUEST['etapa4'];
					$query .= ", Nig = '".$_REQUEST['Nig']."'";
					$query .= ", gNig = '";
					for ( $i = 0; $i < count($_REQUEST['gNig']); $i++ )
					{
						$query .= $_REQUEST['gNig'][$i];
						$query .= $i != count($_REQUEST['gNig'])-1 ? ' - ' : '';
					}
					$query .= "', colspan5 = ".$_REQUEST['colspan5'];
					$query .= ", etapa5 = ".$_REQUEST['etapa5'];
					if ( file_exists('../getMyTime().php') ) {
						require('../getMyTime().php');
						$query .= ", modified='".getMyTime()."'";
					}
					$query .= " WHERE den = ".$_REQUEST['day_to_modify'];
					
					
					$spojeni->query( $query );
					$changed = true;
					
					$log = $name.' just changed '.$_REQUEST['day_to_modify'].'th day';
					writeLog( $log, '../', $sql_table.'.txt' );
					
					include_once( 'files/harmonogramCreator.php' );
				}
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		if ( isset($_REQUEST['Add']) || isset($_REQUEST['form_add']) ) //nahrát den
		{
			if ( file_exists('harmonogram_add_day.php') ) require( 'harmonogram_add_day.php' );
		}
		else if ( isset($_REQUEST['modifyDay']) || isset($_REQUEST['form_modify']) ) //upravit den
		{
			if ( file_exists('harmonogram_upravit.php') ) require( 'harmonogram_upravit.php' );
		}
		else { //zobrazit harmonogram
			if ( file_exists('harmonogram_show_all.php') ) require( 'harmonogram_show_all.php' );
		}
		?>
        <script>
		/*$("#DB1").blur(function(){
			blok = $(this).val();
			alert(blok);
			if ( blok > 1 )
			{
				$("#DB2").val(0);
				$("#DB2").attr("disabled", "");
			}
			if ( blok > 2 )
			{
				$("#DB3").val(0);
				$("#DB3").attr("disabled", "");
			}
			if ( blok > 3 )
			{
				$("#DB4").val(0);
				$("#DB4").attr("disabled", "");
			}
			if ( blok > 4 )
			{
				$("#DB5").val(0);
				$("#DB5").attr("disabled", "");
			}
		});*/
		</script>
		<?php
		}
		else echo "<p>Databáze nenalezena.</p>";
	}
	else echo "<p>Soubor <strong>../promenne.php</strong> nenalezen.</p>";
?>