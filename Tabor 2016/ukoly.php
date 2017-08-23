<?php
$typy_ukolu = array( 'etapa', 'zaridit', 'jine', 'funkce' );
$table_tasks = "d2016_ukoly_radcu";
$tmp_table = "d2016_harmonogram";



if ( file_exists("../promenne.php") && require("../promenne.php") )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		
		$task_example = 'Nasekat dříví';
		$war = false;
		if ( isset($_REQUEST['insert_task']) )
		{
			if ( trim($_REQUEST['zneni']) == "" || $_REQUEST['zneni'] == $task_example ) $war = true;
			else
			{
				$spojeni->query( "INSERT INTO ".$table_tasks." ( radce, typ, ukol) VALUES ( '".IDFromNick( $_REQUEST['add_radce'], $spojeni )."', '".$_REQUEST['typ']."', '".$_REQUEST['zneni']."' )" );
			}
		}
		
		
		
		
		
		$sql = $spojeni->query("SELECT * FROM vlc_users WHERE platnost = 1 ORDER BY nickname ASC");
		?>

        <div id="form">
        <form method="post" action="?o=<?php echo $_REQUEST['o']; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            <label for="for">Úkoly pro: </label>
            <select id="for" name="radce">
				<?php
                while ( $item = mysqli_fetch_array( $sql ) )
                {
                    echo '<option value="'.$item['ID'].'"';
                    if ( $item['ID'] == IDFromNick( $name, $spojeni ) && !isset($_REQUEST['radce']) ) echo ' selected=""';
                    else if ( isset($_REQUEST['radce']) && $_REQUEST['radce'] == $item['ID'] ) echo ' selected=""';
                    echo '>'.$item['nickname'].'</option>';
                }
                ?>
            </select>
            <button name="show" class="taskbutton">Ukaž</button>
        </form>
        </div>
        
        
        <div id="tasks">
        	<?php
				$radce = isset($_REQUEST['add_radce']) ? $_REQUEST['add_radce'] : ( !isset($_REQUEST['radce']) ? IDFromNick( $name, $spojeni ) : $_REQUEST['radce'] );
				echo '<h2>'.NicknameFromID( $radce, $spojeni ).'</h2>';
				
				echo '<table rules="all" class="table_tasks">';
				echo '<tr><th>Typ úkolu</th><th>Znění úkolu</th></tr>';
				$sql = $spojeni->query( "SELECT * FROM ".$table_tasks." WHERE radce = '".$radce."' ORDER BY typ" );
				while ( $row = mysqli_fetch_array( $sql ) )
				{
					echo '<tr class="'.strtolower($row['typ']).'">';
					echo '<td>'.strtoupper($row['typ']).'</td><td>'.$row['ukol'].'</td>';
					echo '</tr>';
				}
				echo '</table>';
				
				echo '<h4>Program</h4>';
				
				echo '<table rules="all" class="table_tasks">';
				echo '<tr><th>Role</th><th>Den</th><th>Datum</th><th>Blok</th><th>Program</th></tr>';
				$sql = $spojeni->query( "SELECT * FROM ".$tmp_table." WHERE vedouci = '".$radce."'" );
				while ( $den = mysqli_fetch_array( $sql ) )
				{
					echo '<tr>';
					echo '<td>Velden</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>celý den</td><td>-</td>';
					echo '</tr>';
				}
				$sql = $spojeni->query( "SELECT * FROM ".$tmp_table." WHERE dira1 = '".$radce."' OR dira2 = '".$radce."'" );
				while ( $den = mysqli_fetch_array( $sql ) )
				{
					echo '<tr>';
					echo '<td>Díra</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>celý den</td><td>-</td>';
					echo '</tr>';
				}
				$garats_sql = "SELECT * FROM ".$tmp_table." WHERE";
				$garats_sql .= " gMor1 = '".$radce."'";
				$garats_sql .= " OR gMor1 LIKE '% - ".$radce."'";
				$garats_sql .= " OR gMor1 LIKE '".$radce." - %'";
				$garats_sql .= " OR gMor1 LIKE '% - ".$radce." - %'";
				
				$garats_sql .= " OR gMor2 = '".$radce."'";
				$garats_sql .= " OR gMor2 LIKE '% - ".$radce."'";
				$garats_sql .= " OR gMor2 LIKE '".$radce." - %'";
				$garats_sql .= " OR gMor2 LIKE '% - ".$radce." - %'";
				
				$garats_sql .= " OR gAf1 = '".$radce."'";
				$garats_sql .= " OR gAf1 LIKE '% - ".$radce."'";
				$garats_sql .= " OR gAf1 LIKE '".$radce." - %'";
				$garats_sql .= " OR gAf1 LIKE '% - ".$radce." - %'";
				
				$garats_sql .= " OR gAf2 = '".$radce."'";
				$garats_sql .= " OR gAf2 LIKE '% - ".$radce."'";
				$garats_sql .= " OR gAf2 LIKE '".$radce." - %'";
				$garats_sql .= " OR gAf2 LIKE '% - ".$radce." - %'";
				
				$garats_sql .= " OR gNig = '".$radce."'";
				$garats_sql .= " OR gNig LIKE '% - ".$radce."'";
				$garats_sql .= " OR gNig LIKE '".$radce." - %'";
				$garats_sql .= " OR gNig LIKE '% - ".$radce." - %'";
				
				$sql = $spojeni->query( $garats_sql );
				while ( $den = mysqli_fetch_array( $sql ) )
				{
					if ( $den['gMor1'] == $radce || strstr($den['gMor1'], ' - '.$radce ) || strstr($den['gMor1'], $radce.' - ' ) || strstr($den['gMor1'], ' - '.$radce.' - ' ) )
					{
						echo '<tr>';
						echo '<td>Program</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>Dopoledne 1</td><td>'.$den['Mor1'].'</td>';
						echo '</tr>';
					}
					if ( $den['gMor2'] == $radce || strstr($den['gMor2'], ' - '.$radce ) || strstr($den['gMor2'], $radce.' - ' ) || strstr($den['gMor2'], ' - '.$radce.' - ' ) )
					{
						echo '<tr>';
						echo '<td>Program</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>Dopoledne 2</td><td>'.$den['Mor2'].'</td>';
						echo '</tr>';
					}
					if ( $den['gAf1'] == $radce || strstr($den['gAf1'], ' - '.$radce ) || strstr($den['gAf1'], $radce.' - ' ) || strstr($den['gAf1'], ' - '.$radce.' - ' ) )
					{
						echo '<tr>';
						echo '<td>Program</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>Odpoledne 1</td><td>'.$den['Af1'].'</td>';
						echo '</tr>';
					}
					if ( $den['gAf2'] == $radce || strstr($den['gAf2'], ' - '.$radce ) || strstr($den['gAf2'], $radce.' - ' ) || strstr($den['gAf2'], ' - '.$radce.' - ' ) )
					{
						echo '<tr>';
						echo '<td>Program</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>Odpoledne 2</td><td>'.$den['Af2'].'</td>';
						echo '</tr>';
					}
					if ( $den['gNig'] == $radce || strstr($den['gNig'], ' - '.$radce ) || strstr($den['gNig'], $radce.' - ' ) || strstr($den['gNig'], ' - '.$radce.' - ' ) )
					{
						echo '<tr>';
						echo '<td>Program</td><td>'.$den['den'].'.</td><td>'.$den['datum'].'</td><td>Večer</td><td>'.$den['Nig'].'</td>';
						echo '</tr>';
					}
				}
				echo '</table>';
			?>
        </div>
        
        
        
        <?php 
		$sql = $spojeni->query("SELECT * FROM vlc_users WHERE platnost = 1 ORDER BY nick ASC");
		
		?>
        <div id="addTask">
        <h3>Přidat úkol</h3>
        <form method="post" action="?o=<?php echo $_REQUEST['o']; ?>" id="add_task">
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            <label for="person">Pro: </label>
        	<select id="person" name="add_radce">
				<?php
                while ( $item = mysqli_fetch_array( $sql ) )
                {
                    echo '<option value="'.IDFromNick( $item['nick'], $spojeni ).'"';
                    if ( strtolower($item['nick']) == $name && !isset($_REQUEST['add_radce']) ) echo ' selected=""';
                    else if ( isset($_REQUEST['add_radce']) && $_REQUEST['add_radce'] == $item['nick'] ) echo ' selected=""';
                    echo '>'.$item['nickname'].'</option>';
                }
                ?>
            </select>
            <br />
            <label for="typ">Typ úkolu: </label>
            <select id="typ" name="typ">
            	<?php
				foreach ( $typy_ukolu as $ukol )
					echo '<option>'.$ukol.'</option>';
				?>
            </select>
            <br />
            <textarea rows="5" cols="15" name="zneni" id="area"><?php echo $task_example;?></textarea>
            <br />
            <button name="insert_task" class="taskbutton">Uložit úkol</button>
        </form>
        <?php if ( $war ) echo '<p class="red">Nevyplnil jsi zadání úkolu</p>';?>
        </div>
        
        
        <script type="text/javascript">
		var mess = '<?php echo $task_example; ?>';
		var get_mess = document.getElementById("area").value;
		if ( get_mess == mess )
		{
			$("#area").css( "font-family", "monospace" );
			$("#area").css( "color", "grey" );
		}
		$("#area").focus(function(){
			var content = document.getElementById("area").value;
			if ( content == mess )
			{
				document.getElementById("area").innerHTML = "";
				$(this).css( "color", "black" );
			}
		});
		$("#area").focusout(function(){
			var content = document.getElementById("area").value;
			if ( content == "" )
			{
				document.getElementById("area").innerHTML = mess;
				$(this).css( "color", "grey" );
			}
		});
        </script>
    <?php
	}
	else echo 'didn\'t connect to database';
}
else echo '../promenne.php doesn\'t exists';






?>