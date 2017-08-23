<?php
$typy_ukolu = array( 'etapa', 'zaridit', 'jine', 'funkce' );
$table_tasks = "dYearToSubStr_ukoly_radcu";
$tmp_table = "dYearToSubStr_harmonogram";


if ( file_exists("../promenne.php") && require("../promenne.php") )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		
		$task_example = 'Nasekat dříví';
		$war = false;
		require('../getMyTime().php');
		
		$file = '../funkce.php';
		$funkce_php = ( !file_exists($file) || !include($file) ) ? false : true;
		
		$over = false;
		if ( file_exists('uzaverka.php') && require('uzaverka.php') ) {
			$over = isOver( $referenceDate, getMyTime() );
		}
		
		
		if ( isset($_REQUEST['insert_task']) )
		{
			if ( trim($_REQUEST['zneni']) == "" || $_REQUEST['zneni'] == $task_example ) $war = true;
			else
			{
				$spojeni->query( "INSERT INTO ".$table_tasks." ( radce, typ, ukol, inserted, created) VALUES ( '".IDFromNick( $_REQUEST['add_radce'], $spojeni )."', '".$_REQUEST['typ']."', '".$_REQUEST['zneni']."', ".IDFromNick($name, $spojeni).", '".getMyTime()."' )" );
				
				$sql = $spojeni->query( "SELECT max(id) max FROM ".$table_tasks );
				$res = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
				$log = $name.' just created task with id '.$res['max'];
				writeLog( $log, '../', $table_tasks.'.txt' );
			}
		}
		else if ( isset($_REQUEST['getTask']) || isset($_REQUEST['putTask']) || isset($_REQUEST['delTask']) ) {
			$ssql = $spojeni->query( "SELECT * FROM ".$table_tasks." WHERE id=".$_REQUEST['idTask'] );
			$task = mysqli_fetch_array( $ssql, MYSQLI_ASSOC );
			
			
			if ( isset($_REQUEST['getTask']) ) {
				$spojeni->query( "UPDATE ".$table_tasks." SET radce=".IDFromNick($name, $spojeni).", modified='".getMyTime()."' WHERE id = ".$_REQUEST['idTask'] );
				$log = $name.' just changed task with id '.$_REQUEST['idTask'].' - get task ('.$task['ukol'].')';
				writeLog( $log, '../', $table_tasks.'.txt' );
			}
			else if ( isset($_REQUEST['putTask']) ) {
				$spojeni->query( "UPDATE ".$table_tasks." SET radce=0, modified='".getMyTime()."' WHERE id = ".$_REQUEST['idTask'] );
				$log = $name.' just changed task with id '.$_REQUEST['idTask'].' - put task ('.$task['ukol'].')';
				writeLog( $log, '../', $table_tasks.'.txt' );
			}
			else if ( isset($_REQUEST['delTask']) ) {
				$spojeni->query( "DELETE FROM ".$table_tasks." WHERE id = ".$_REQUEST['idTask'] );
				$log = $name.' just deleted task with id '.$_REQUEST['idTask'].' ('.$task['ukol'].')';
				writeLog( $log, '../', $table_tasks.'.txt' );
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
				$radce = isset($_REQUEST['add_radce']) && $_REQUEST['add_radce'] != 0 ? $_REQUEST['add_radce'] : ( !isset($_REQUEST['radce']) ? IDFromNick( $name, $spojeni ) : $_REQUEST['radce'] );
				echo '<h2>'.NicknameFromID( $radce, $spojeni ).'</h2>';
				
				echo '<table rules="all" class="table_tasks">';
				echo '<tr>';
				echo '<th>Typ úkolu</th><th>Znění úkolu</th>';
				if ( $radce == IDFromNick($name, $spojeni) ) echo '<th></th>';
				echo '</tr>';
				$sql = $spojeni->query( "SELECT * FROM ".$table_tasks." WHERE radce = '".$radce."' ORDER BY typ" );
				while ( $row = mysqli_fetch_array( $sql ) )
				{
					echo '<tr class="'.strtolower($row['typ']).'">';
					echo '<td>'.strtoupper($row['typ']).'</td><td>'.$row['ukol'].'</td>';
					if ( $radce == IDFromNick($name, $spojeni) ) {
						echo '<td>';
							if ( !$over ) {
								echo '<form method="post" action="?o='.$_REQUEST['o'].'" >';
									echo '<input type="hidden" name="name" value="'.$name.'" />';
									echo '<input type="hidden" name="passwd" value="'.$passwd.'" />';
									echo '<input type="hidden" name="idTask" value="'.$row['id'].'" />';
									echo '<button name="putTask">Nechci úkol</button>';
								echo '</form>';
							}
						echo '</td>';
					}
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
		if ( !$over ) {
			$sql = $spojeni->query("SELECT * FROM vlc_users WHERE platnost = 1 ORDER BY nick ASC");
			?>
					<div id="addTask">
					<h3>Přidat úkol</h3>
					<form method="post" action="?o=<?php echo $_REQUEST['o']; ?>" id="add_task">
							<input type="hidden" name="name" value="<?php echo $name; ?>" />
							<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
							<label for="person">Pro: </label>
						<select id="person" name="add_radce">
							<option value="0">--nikdo--</option>
					<?php
									while ( $user = mysqli_fetch_array( $sql ) )
									{
											echo '<option value="'.$user['ID'].'"';
											if ( $user['ID'] == IDFromNick($name, $spojeni) && !isset($_REQUEST['add_radce']) ) echo ' selected=""';
											else if ( isset($_REQUEST['add_radce']) && $_REQUEST['add_radce'] == $user['ID'] ) echo ' selected=""';
											echo '>'.$user['nickname'].'</option>';
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
        <?php } ?>
        
        <div id="unownedTasks">
        	<h3>Ještě nerozebrané úkoly</h3>
        	<?php					
						echo '<table rules="all" id="tasksWithNobody">';
						echo '<tr><th>Typ úkolu</th><th>Znění</th><th></th></tr>';
						$sql = $spojeni->query( "SELECT * FROM ".$table_tasks." WHERE radce = 0" );
						while ( $item = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
							echo '<tr>';
								echo '<td>'.$item['typ'].'</td>';
								echo '<td>'.$item['ukol'].'</td>';
								echo '<td>';
									echo '<form method="post" action="?o='.$_REQUEST['o'].'">';
									echo '<input type="hidden" name="idTask" value="'.$item['id'].'" />';
									echo '<input type="hidden" name="name" value="'.$name.'" />';
									echo '<input type="hidden" name="passwd" value="'.$passwd.'" />';
									echo '<button name="getTask">Vzít si na starosti</button>';
									echo '  <button name="delTask" style="color:red;">Smazat</button>';
									echo '</form>';
								echo '</td>';
							echo '</tr>';
						}
						echo '</table>';
					?>
        </div>
        
        
        <?php if ( isAdmin($name, $spojeni) ) { ?>
        	<div id="statistic">
        		<h3>Admin sekce</h3>
        		<table rules="all" id="tasks_admin_section">
            <tr><th>ID</th><th>Typ</th><th>Znění</th><th>Rádce</th><th>Vložil</th><th>Vloženo</th><th>Upraveno</th><th>Přidělit pro</th><th></th></tr>
            	<?php
							$sql = $spojeni->query( "SELECT * FROM ".$table_tasks );
							while ( $row = mysqli_fetch_array($sql, MYSQLI_ASSOC) ) {
								echo '<tr id="tr_'.$row['id'].'">';
									echo '<td>'.$row['id'].'</td>';
									echo '<td>'.$row['typ'].'</td>';
									echo '<td>'.$row['ukol'].'</td>';
									echo '<td';
									if ( $row['radce'] == 0 ) echo ' class="red"';
									echo '>'.NicknameFromID($row['radce'], $spojeni).'</td>';
									echo '<td>'.NicknameFromID($row['inserted'], $spojeni).'</td>';
									echo '<td>'.dateToReadableFormat($row['created']).'</td>';
									echo '<td>'.dateToReadableFormat($row['modified']).'</td>';
									echo '<td>';
										if ( !$funkce_php ) echo 'chybí patřičný soubor '.$file;
										else {
											printSelectOfUsers( $spojeni, '', 'giveTo_'.$row['id'], 'class="selectToGiveTask"' );
										}
									echo '</td>';
									echo '<td>';
										echo '  <button onclick="delTask( '.$row['id'].' )" style="color:red;">Smazat</button>';
									echo '</td>';
								echo '</tr>';
							}
							?>
        		</table>
            
            
            <br /><br />
            <label for="uzaverka">Uzávěrka modifikace: </label>
            <input type="datetime-local" id="uzaverka" />
            <button onclick="setUzaverka()">OK</button>
            <span onclick="defaultDate()" style="cursor:pointer;">(default)</span>
        	</div>
        <?php } ?>
        
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
		
		$( ".selectToGiveTask" ).change(function(){
			var id = this.id;
			id = id.split( '_' );
			id = id[1];
			var val = this.options[this.selectedIndex].text;
			var user = this.value;
			var ok = confirm( 'Really give the task to ' + val );
			if ( ok ) {
				if (window.XMLHttpRequest) {
					var xmlhttp = new XMLHttpRequest();
				} else {
					var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						if ( xmlhttp.responseText == 'success' ) {
							location.reload();
						} else {
							alert( 'some error occures' + xmlhttp.responseText );
						}
					}
				};
				xmlhttp.open( "POST", "scripty/giveTaskTo.php", true );
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send( "table=<?= $table_tasks; ?>&id=" + id + "&nick=" + user + "&admin=<?= $name; ?>" );
			} else {
				this.selectedIndex = 0;
			}
		});
		
		function delTask( id ) {
			var ok = confirm( "Really delete?" );
			if ( ok ) {
				if (window.XMLHttpRequest) {
						var xmlhttp = new XMLHttpRequest();
					} else {
						var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							if ( xmlhttp.responseText == 'success' ) {
								location.reload();
							} else {
								alert( 'some error occures: ' + xmlhttp.responseText );
							}
						}
					};
					xmlhttp.open( "POST", "scripty/delTask.php", true );
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send( "table=<?= $table_tasks; ?>&id=" + id + "&name=<?= $name; ?>" );
			}
		}
		
		function defaultDate() { document.getElementById('uzaverka').value = '2017-01-01T00:00'; }
		function setUzaverka() {
			var date = document.getElementById('uzaverka').value;
			if ( date == null || date == '' ) alert( 'insert whole date' );
			else {
				var d = date.split( 'T' );
				date = d[0] + ' ' + d[1];
				
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						if ( xmlhttp.responseText != 'success' ) {
							alert( 'some error occures: ' + xmlhttp.responseText );
						}
						location.reload();
					}
				};
				xmlhttp.open( "POST", "scripty/changeUzaverka.php", true );
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send( "date=" + date );
			}
		}
</script>
    <?php
	}
	else echo 'didn\'t connect to database';
}
else echo '../promenne.php doesn\'t exists';






?>