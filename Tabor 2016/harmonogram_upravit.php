<form method="post" id="addDay" action="./?o=<?php echo $_REQUEST['o'];?>" >
<input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>"/>
<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
<button type="submit" name="unAdd" >Zpět na harmonogram</button>
</form>

<h1>Upravit <?php echo $_REQUEST['day_to_modify']; ?>. den</h1>

<div id="div_add">
<?php if ( isset($_REQUEST['form_modify']) && $changed ) //show RESULT day in table
{
    echo '<p>Den byl upraven a nahrán do databáze.</p>'; 
    $item = '<table rules="all" class="table_nahled nahled">';
    $item .= '<tr><th>Den</th><th>Datum</th><th>Vedoucí dne</th><th>Dopoledne I</th><th>Dopoledne II</th><th>Odpoledne I</th><th>Odpoledne II</th><th>Večer</th></tr>';
    $item .= '<tr class="sude">';
    $item .= '<td rowspan="3">'.$_REQUEST['day_to_modify'].'.</td>';
    $item .= '<td rowspan="3">'.$_REQUEST['datum'].'<br />'.$_REQUEST['dayInWeek'].'</td>';
    $item .= '<td><strong>'.nicknameFromID( $_REQUEST['vedouci'], $spojeni ).'</strong></td>';
    if ( $_REQUEST['colspan1'] )
    {
        $item .= '<td colspan="'.$_REQUEST['colspan1'].'" class="td_nahled">';
        //$people = explode( ' - ', $_REQUEST['gMor1'] ); //get array from REQUEST
        foreach ( $_REQUEST['gMor1'] as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $_REQUEST['colspan2'] )
    {
        $item .= '<td colspan="'.$_REQUEST['colspan2'].'" class="td_nahled">';
        //$people = explode( ' - ', $_REQUEST['gMor2'] );
        foreach ( $_REQUEST['gMor2'] as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $_REQUEST['colspan3'] )
    {
        $item .= '<td colspan="'.$_REQUEST['colspan3'].'" class="td_nahled">';
        //$people = explode( ' - ', $_REQUEST['gAf1'] );
        foreach ( $_REQUEST['gAf1'] as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $_REQUEST['colspan4'] )
    {
        $item .= '<td colspan="'.$_REQUEST['colspan4'].'" class="td_nahled">';
        //$people = explode( ' - ', $_REQUEST['gAf2'] );
        foreach ( $_REQUEST['gAf2'] as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $_REQUEST['colspan5'] )
    {
        $item .= '<td colspan="'.$_REQUEST['colspan5'].'" class="td_nahled">';
        //$people = explode( ' - ', $_REQUEST['gNig'] );
        foreach ( $_REQUEST['gNig'] as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    $item .= '</tr>';
    
    $item .= '<tr class="sude">';
    $item .= '<td><em>'.nicknameFromID( $_REQUEST['dira1'], $spojeni ).'</em></td>';
    if ( $_REQUEST['colspan1'] )
    {
        $item .= '<td rowspan="2" ';
        if ($_REQUEST['etapa1'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$_REQUEST['colspan1'].'">'.$_REQUEST['Mor1'].'</td>';
    }
    if ( $_REQUEST['colspan2'] )
    {
        $item .= '<td rowspan="2" ';
        if ($_REQUEST['etapa2'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$_REQUEST['colspan2'].'">'.$_REQUEST['Mor2'].'</td>';
    }
    if ( $_REQUEST['colspan3'] )
    {
        $item .= '<td rowspan="2" ';
        if ($_REQUEST['etapa3'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$_REQUEST['colspan3'].'">'.$_REQUEST['Af1'].'</td>';
    }
    if ( $_REQUEST['colspan4'] )
    {
        $item .= '<td rowspan="2" ';
        if ($_REQUEST['etapa4'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$_REQUEST['colspan4'].'">'.$_REQUEST['Af2'].'</td>';
    }
    if ( $_REQUEST['colspan5'] )
    {
        $item .= '<td rowspan="2" ';
        if ($_REQUEST['etapa5'] == 1) $item .= 'class="etapa"';
        $item .= '>'.$_REQUEST['Nig'].'</td>';
    }
    $item .= '</tr>';
    
    $item .= '<tr class="sude">';
    $item .= '<td><em>'.nicknameFromID( $_REQUEST['dira2'], $spojeni ).'</em></td>';
    $item .= '</tr></table>';
    
    echo $item;
}
else if ( !isset($_REQUEST['day_to_modify']) )
{?>
    <p>Nastala neočekávaná chyba.</p><?php
}
else //modifying day
{
    $spojeni->query("SET CHARACTER SET utf8");
    $sql = $spojeni->query("SELECT * FROM ".$sql_table." WHERE den = '".$_REQUEST['day_to_modify']."'");
    $upravit_den = mysqli_fetch_array($sql);
    ?>
    
    
    
    <form method="post" id="modifyConcreteDay" >
    
    <table rules="all" class="addDayTable" border="4">
    	<tr class="sude">
        	<th>
            	Den
            </th>
            <th>
            	Datum
            </th>
            <th>
            	Vedoucí dne
            </th>
            <th class="TD-Mor1">
            	Dopoledne I
            </th>
            <th class="TD-Mor2">
            	Dopoledne II
            </th>
            <th class="TD-Af1">
            	Odpoledne I
            </th>
            <th class="TD-Af2">
            	Odpoledne II
            </th>
            <th class="TD-Nig">
            	Večer
            </th>
        </tr>
        <tr class="sude">
        	<td rowspan="3" style="text-align:center;">
    			<input type="hidden" name="day_to_modify"  value="<?php echo $_REQUEST['day_to_modify']; ?>"/>
                <?php echo $_REQUEST['day_to_modify']; ?>.
            </td>
            <td rowspan="3">
            	<input type="text" class="harmonogram" name="datum" value="<?php echo isset($_REQUEST['datum']) ? $_REQUEST['datum'] : substr( $upravit_den['datum'], 0, strpos($upravit_den['datum'], '<br />')); ?>"/>
                <br />
                <select name="dayInWeek">
                    <option value="">-- den --</option>
                    <?php $daysInWeek = array( 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle' ); 
                    foreach ( $daysInWeek as $i )
                    {
                        echo '<option value="'.$i.'"';
                        echo isset( $_REQUEST['dayInWeek'] ) && $_REQUEST['dayInWeek'] == $i ? ' selected=""' : ( strstr($upravit_den['datum'], $i) ? 'selected=""' : '' );
                        echo '>'.$i.'</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <select name="vedouci">
                    <option value="">-- vybrat --</option><?php
                    $spojeni->query("SET CHARACTER SET utf8");
                    $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                    while ($radce = mysqli_fetch_array($sql))
                    {
                        echo '<option value="'.$radce['ID'].'"';
                        echo isset($_REQUEST['vedouci']) && $_REQUEST['vedouci'] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == $upravit_den['vedouci'] ? ' selected="selected"' : '');
                        echo '>'.$radce['nickname'].'</option>';
                    }?>
                </select>
            </td>
            <td class="TD-Mor1">
                <?php
					$i = 0;
					$people = isset($_REQUEST['gMor1']) ? $_REQUEST['gMor1'] : explode( ' - ', $upravit_den['gMor1'] );
					foreach ( $people as $person ) {
					?>
						<select name="gMor1[]" id="Mor1<?php echo $i;?>">
							<option value="">-- vybrat --</option><?php
							$sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
							while ($radce = mysqli_fetch_array($sql))
							{
								echo '<option value="'.$radce['ID'].'"';
								echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'][$i] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
								echo '>'.$radce['nickname'].'</option>';
							}?>
						</select><img src="imgs/delete.png" alt="minus" id="Del-Mor1-<?php echo $i++;?>" class="manipulate minus" title="odstranit vykonavatele" />
					<?php
					}
					for ( ; $i < $max_of_doers; $i++ ){
					?>
						<select name="gMor1[]" id="Mor1<?php echo $i;?>" disabled="disabled">
							<option value="">-- vybrat --</option><?php
							$sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
							while ($radce = mysqli_fetch_array($sql))
							{
								echo '<option value="'.$radce['ID'].'"';
								//echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'] == $radce['nick'] ? ' selected=""' : ( $radce['nick'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
								echo '>'.$radce['nickname'].'</option>';
							}?>
						</select><img src="imgs/delete.png" alt="minus" id="Del-Mor1-<?php echo $i;?>" class="manipulate minus toHide" title="odstranit vykonavatele" />
					<?php
					}
				?>    
				<img src="imgs/plus.png" alt="plus" id="Add-Mor1" class="manipulate plus" title="přidat vykonavatele" />
            </td>
            <td class="TD-Mor2">
            	<?php
                    $i = 0;
                    $people = isset($_REQUEST['gMor2']) ? $_REQUEST['gMor2'] : explode( ' - ', $upravit_den['gMor2'] );
                    foreach ( $people as $person ) {
                    ?>
                        <select name="gMor2[]"  id="Mor2<?php echo $i;?>">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                echo isset($_REQUEST['gMor2']) && $_REQUEST['gMor2'][$i] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == /*$upravit_den['gMor2']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Mor2-<?php echo $i++;?>" class="manipulate minus" title="odstranit vykonavatele" />
                    <?php
                    }
                    for ( ; $i < $max_of_doers; $i++ ){
                    ?>
                        <select name="gMor2[]" id="Mor2<?php echo $i;?>" disabled="disabled">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                //echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'] == $radce['nick'] ? ' selected=""' : ( $radce['nick'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Mor2-<?php echo $i;?>" class="manipulate minus toHide" title="odstranit vykonavatele" />
                    <?php
                    }
                ?>
                <img src="imgs/plus.png" alt="plus" id="Add-Mor2" class="manipulate plus" title="přidat vykonavatele" />
            </td>
            <td class="TD-Af1">
            	<?php
                    $i = 0;
                    $people = isset($_REQUEST['gAf1']) ? $_REQUEST['gAf1'] : explode( ' - ', $upravit_den['gAf1'] );
                    foreach ( $people as $person ) {
                    ?>
                        <select name="gAf1[]" id="Af1<?php echo $i;?>">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                echo isset($_REQUEST['gAf1']) && $_REQUEST['gAf1'][$i] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == /*$upravit_den['gMor2']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Af1-<?php echo $i++;?>" class="manipulate minus" title="odstranit vykonavatele" />
                    <?php
                    }
                    for ( ; $i < $max_of_doers; $i++ ){
                    ?>
                        <select name="gAf1[]" id="Af1<?php echo $i;?>" disabled="disabled">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                //echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'] == $radce['nick'] ? ' selected=""' : ( $radce['nick'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Af1-<?php echo $i;?>" class="manipulate minus toHide" title="odstranit vykonavatele" />
                    <?php
                    }
                ?>
                <img src="imgs/plus.png" alt="plus" id="Add-Af1" class="manipulate plus" title="přidat vykonavatele" />
            </td>
            <td class="TD-Af2">
            	<?php
                    $i = 0;
                    $people = isset($_REQUEST['gAf2']) ? $_REQUEST['gAf2'] : explode( ' - ', $upravit_den['gAf2'] );
                    foreach ( $people as $person ) {
                    ?>
                        <select name="gAf2[]"  id="Af2<?php echo $i;?>">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                echo isset($_REQUEST['gAf2']) && $_REQUEST['gAf2'][$i] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == /*$upravit_den['gMor2']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Af2-<?php echo $i++;?>" class="manipulate minus" title="odstranit vykonavatele" />
                    <?php
                    }
                    for ( ; $i < $max_of_doers; $i++ ){
                    ?>
                        <select name="gAf2[]" id="Af2<?php echo $i;?>" disabled="disabled">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                //echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'] == $radce['nick'] ? ' selected=""' : ( $radce['nick'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Af2-<?php echo $i;?>" class="manipulate minus toHide" title="odstranit vykonavatele" />
                    <?php
                    }
                ?>
                <img src="imgs/plus.png" alt="plus" id="Add-Af2" class="manipulate plus" title="přidat vykonavatele" />
            </td>
            <td class="TD-Nig">
            	<?php
                    $i = 0;
                    $people = isset($_REQUEST['gNig']) ? $_REQUEST['gNig'] : explode( ' - ', $upravit_den['gNig'] );
                    foreach ( $people as $person ) {
                    ?>
                        <select name="gNig[]" id="Nig<?php echo $i;?>">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                echo isset($_REQUEST['gNig']) && $_REQUEST['gNig'][$i] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == /*$upravit_den['gMor2']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Nig-<?php echo $i++;?>" class="manipulate minus" title="odstranit vykonavatele" />
                    <?php
                    }
                    for ( ; $i < $max_of_doers; $i++ ){
                    ?>
                        <select name="gNig[]" id="Nig<?php echo $i;?>" disabled="disabled">
                            <option value="">-- vybrat --</option><?php
                            $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                            while ($radce = mysqli_fetch_array($sql))
                            {
                                echo '<option value="'.$radce['ID'].'"';
                                //echo isset($_REQUEST['gMor1']) && $_REQUEST['gMor1'] == $radce['nick'] ? ' selected=""' : ( $radce['nick'] == /*$upravit_den['gMor1']*/$person ? ' selected="selected"' : '');
                                echo '>'.$radce['nickname'].'</option>';
                            }?>
                        </select><img src="imgs/delete.png" alt="minus" id="Del-Nig-<?php echo $i;?>" class="manipulate minus toHide" title="odstranit vykonavatele" />
                    <?php
                    }
                ?>
                <img src="imgs/plus.png" alt="plus" id="Add-Nig" class="manipulate plus" title="přidat vykonavatele" />
            </td>
        </tr>
        <tr class="sude">
        	<td>
            	<select name="dira1">
                    <option value="">-- vybrat --</option><?php
                    $spojeni->query("SET CHARACTER SET utf8");
                    $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                    while ($radce = mysqli_fetch_array($sql))
                    {
                        echo '<option value="'.$radce['ID'].'"';
                        echo isset($_REQUEST['dira1']) && $_REQUEST['dira1'] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == $upravit_den['dira1'] ? ' selected="selected"' : '');
                        echo '>'.$radce['nickname'].'</option>';
                    }?>
                </select>
            </td>
            <td rowspan="2" class="TD-Mor1">
            	<textarea name="Mor1"><?php echo isset($_REQUEST['Mor1']) ? $_REQUEST['Mor1'] : $upravit_den['Mor1']; ?></textarea>
            </td>
            <td rowspan="2" class="TD-Mor2">
            	<textarea name="Mor2"><?php echo isset($_REQUEST['Mor2']) ? $_REQUEST['Mor2'] : $upravit_den['Mor2']; ?></textarea>
            </td>
            <td rowspan="2" class="TD-Af1">
            	<textarea name="Af1"><?php echo isset($_REQUEST['Af1']) ? $_REQUEST['Af1'] : $upravit_den['Af1']; ?></textarea>
            </td>
            <td rowspan="2" class="TD-Af2">
            	<textarea name="Af2"><?php echo isset($_REQUEST['Af2']) ? $_REQUEST['Af2'] : $upravit_den['Af2']; ?></textarea>
            </td>
            <td rowspan="2" class="TD-Nig">
            	<textarea name="Nig"><?php echo isset($_REQUEST['Nig']) ? $_REQUEST['Nig'] : $upravit_den['Nig']; ?></textarea>
            </td>
        </tr>
        <tr class="sude">
        	<td>
            	<select name="dira2">
                    <option value="">-- vybrat --</option><?php
                    $spojeni->query("SET CHARACTER SET utf8");
                    $sql = $spojeni->query("SELECT * FROM vlc_users WHERE aktivni = 1 ORDER BY nick ASC");
                    while ($radce = mysqli_fetch_array($sql))
                    {
                        echo '<option value="'.$radce['ID'].'"';
                        echo isset($_REQUEST['dira2']) && $_REQUEST['dira2'] == $radce['ID'] ? ' selected=""' : ( $radce['ID'] == $upravit_den['dira2'] ? ' selected="selected"' : '');
                        echo '>'.$radce['nickname'].'</option>';
                    }?>
                </select>
            </td>
        </tr>
        <tr class="sude">
        	<td colspan="3" style="text-align:center;">
            	Etapa:
            </td>
            <td class="TD-Mor1">
            	<label><input type="radio" name="etapa1" value="0" onclick="fce( 'n', 'TD-Mor1' )" <?php echo isset($_REQUEST['etapa1']) ? ( $_REQUEST['etapa1'] == 0 ? 'checked=""' : '' ) : ( $upravit_den['etapa1'] == 0 ? 'checked=""' : '' );?>/>NE</label>
                <br />
                <label><input type="radio" name="etapa1" value="1" onclick="fce( 'y', 'TD-Mor1' )" <?php echo isset($_REQUEST['etapa1']) ? ( $_REQUEST['etapa1'] == 1 ? 'checked=""' : '' ) : ( $upravit_den['etapa1'] == 1 ? 'checked=""' : '' );?>/>ANO</label>
            </td>
            <td class="TD-Mor2">
            	<label><input type="radio" name="etapa2" value="0" onclick="fce( 'n', 'TD-Mor2' )" <?php echo isset($_REQUEST['etapa2']) ? ( $_REQUEST['etapa2'] == 0 ? 'checked=""' : '' ) : ( $upravit_den['etapa2'] == 0 ? 'checked=""' : '' );?>/>NE</label>
                <br />
                <label><input type="radio" name="etapa2" value="1" onclick="fce( 'y', 'TD-Mor2' )" <?php echo isset($_REQUEST['etapa2']) ? ( $_REQUEST['etapa2'] == 1 ? 'checked=""' : '' ) : ( $upravit_den['etapa2'] == 1 ? 'checked=""' : '' );?>/>ANO</label>
            </td>
            <td class="TD-Af1">
            	<label><input type="radio" name="etapa3" value="0" onclick="fce( 'n', 'TD-Af1' )" <?php echo isset($_REQUEST['etapa3']) ? ( $_REQUEST['etapa3'] == 0 ? 'checked=""' : '' ) : ( $upravit_den['etapa3'] == 0 ? 'checked=""' : '' );?>/>NE</label>
                <br />
                <label><input type="radio" name="etapa3" value="1" onclick="fce( 'y', 'TD-Af1' )" <?php echo isset($_REQUEST['etapa3']) ? ( $_REQUEST['etapa3'] == 1 ? 'checked=""' : '' ) : ( $upravit_den['etapa3'] == 1 ? 'checked=""' : '' );?>/>ANO</label>
            </td>
            <td class="TD-Af2">
            	<label><input type="radio" name="etapa4" value="0" onclick="fce( 'n', 'TD-Af2' )" <?php echo isset($_REQUEST['etapa4']) ? ( $_REQUEST['etapa4'] == 0 ? 'checked=""' : '' ) : ( $upravit_den['etapa4'] == 0 ? 'checked=""' : '' );?>/>NE</label>
                <br />
                <label><input type="radio" name="etapa4" value="1" onclick="fce( 'y', 'TD-Af2' )" <?php echo isset($_REQUEST['etapa4']) ? ( $_REQUEST['etapa4'] == 1 ? 'checked=""' : '' ) : ( $upravit_den['etapa4'] == 1 ? 'checked=""' : '' );?>/>ANO</label>
            </td>
            <td class="TD-Nig">
            	<label><input type="radio" name="etapa5" value="0" onclick="fce( 'n', 'TD-Nig' )" <?php echo isset($_REQUEST['etapa5']) ? ( $_REQUEST['etapa5'] == 0 ? 'checked=""' : '' ) : ( $upravit_den['etapa5'] == 0 ? 'checked=""' : '' );?>/>NE</label>
                <br />
                <label><input type="radio" name="etapa5" value="1" onclick="fce( 'y', 'TD-Nig' )" <?php echo isset($_REQUEST['etapa5']) ? ( $_REQUEST['etapa5'] == 1 ? 'checked=""' : '' ) : ( $upravit_den['etapa5'] == 1 ? 'checked=""' : '' );?>/>ANO</label>
            </td>
        </tr>
        <tr class="sude" style="text-align:center;">
        	<td colspan="3" style="text-align:center;">
            	Počet bloků:
            </td>
            <td class="TD-Mor1">
            	<input class="cislo" type="text" name="colspan1" id="DB1" value="<?php echo isset($_REQUEST['colspan1']) ? $_REQUEST['colspan1'] : $upravit_den['colspan1']; ?>"/>
            </td>
            <td class="TD-Mor2">
            	<input class="cislo" type="text" name="colspan2" id="DB2" value="<?php echo isset($_REQUEST['colspan2']) ? $_REQUEST['colspan2'] : $upravit_den['colspan2']; ?>"/>
            </td>
            <td class="TD-Af1">
            	<input class="cislo" type="text" name="colspan3" id="DB3" value="<?php echo isset($_REQUEST['colspan3']) ? $_REQUEST['colspan3'] : $upravit_den['colspan3']; ?>"/>
            </td>
            <td class="TD-Af2">
            	<input class="cislo" type="text" name="colspan4" id="DB4" value="<?php echo isset($_REQUEST['colspan4']) ? $_REQUEST['colspan4'] : $upravit_den['colspan4']; ?>"/>
            </td>
            <td class="TD-Nig">
            	<input class="cislo" type="text" name="colspan5" id="DB5" value="<?php echo isset($_REQUEST['colspan5']) ? $_REQUEST['colspan5'] : $upravit_den['colspan5']; ?>"/>
            </td>
        </tr>
    </table>
    
    
    
    <input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
    <input type="hidden" name="name" value="<?php echo $name; ?>"/>
    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
    <button type="submit" name="form_modify" >Uložit</button>
    </form>
    <?php
        echo $warning_colspan ? '<p class="red"><strong>Součet počtu bloků musí být 5, a nemůže obsahovat záporná čísla.</strong></p>' : '';
        echo $warning_colspan2 ? '<p class="red"><strong>Přesah bloků přes den.</strong></p>' : '';
        echo $warning_colspan_int ? '<p class="red"><strong>Počty bloků nejsou celá čísla</strong></p>' : '';
        echo $warning_dira_velden ? '<p class="red"><strong>Velden nemůže být zároveň díra nebo díra druhou dírou.</strong></p>' : '';
        echo $warning_everyone ? '<p class="red"><strong>Vyplň všechny vykonavatele.</strong></p>' : '';
        echo $warning_other ? '<p class="red"><strong>Nejsou vyplněny všechny potřebné políčka.</strong></p>' : '';
?>
</div>

<?php	
    /*
	$item = '<div class="nahled" style="top:50%;">';
	$item .= '<table rules="all" class="table_nahled">';
    $item .= '<tr><th>Den</th><th>Datum</th><th>Vedoucí dne</th><th>Dopoledne I</th><th>Dopoledne II</th><th>Odpoledne I</th><th>Odpoledne II</th><th>Večer</th></tr>';
    $item .= '<tr class="sude">';
    $item .= '<td rowspan="3">'.$upravit_den['den'].'.</td>';
    $item .= '<td rowspan="3">'.$upravit_den['datum'].'</td>';
    $item .= '<td><strong>'.nicknameFromID( $upravit_den['vedouci'], $spojeni ).'</strong></td>';
    if ( $upravit_den['colspan1'] )
    {
        $item .= '<td colspan="'.$upravit_den['colspan1'].'" class="td_nahled">';
        $people = explode( ' - ', $upravit_den['gMor1'] );
        foreach ( $people as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $upravit_den['colspan2'] )
    {
        $item .= '<td colspan="'.$upravit_den['colspan2'].'" class="td_nahled">';
        $people = explode( ' - ', $upravit_den['gMor2'] );
        foreach ( $people as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $upravit_den['colspan3'] )
    {
        $item .= '<td colspan="'.$upravit_den['colspan3'].'" class="td_nahled">';
        $people = explode( ' - ', $upravit_den['gAf1'] );
        foreach ( $people as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $upravit_den['colspan4'] )
    {
        $item .= '<td colspan="'.$upravit_den['colspan4'].'" class="td_nahled">';
        $people = explode( ' - ', $upravit_den['gAf2'] );
        foreach ( $people as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $upravit_den['colspan5'] )
    {
        $item .= '<td colspan="'.$upravit_den['colspan5'].'" class="td_nahled">';
        $people = explode( ' - ', $upravit_den['gNig'] );
        foreach ( $people as $person ) {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    $item .= '</tr>';
    
    $item .= '<tr class="sude">';
    $item .= '<td><em>'.nicknameFromID( $upravit_den['dira1'], $spojeni ).'</em></td>';
    if ( $upravit_den['colspan1'] )
    {
        $item .= '<td rowspan="2" ';
        if ($upravit_den['etapa1'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$upravit_den['colspan1'].'">'.$upravit_den['Mor1'].'</td>';
    }
    if ( $upravit_den['colspan2'] )
    {
        $item .= '<td rowspan="2" ';
        if ($upravit_den['etapa2'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$upravit_den['colspan2'].'">'.$upravit_den['Mor2'].'</td>';
    }
    if ( $upravit_den['colspan3'] )
    {
        $item .= '<td rowspan="2" ';
        if ($upravit_den['etapa3'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$upravit_den['colspan3'].'">'.$upravit_den['Af1'].'</td>';
    }
    if ( $upravit_den['colspan4'] )
    {
        $item .= '<td rowspan="2" ';
        if ($upravit_den['etapa4'] == 1) $item .= 'class="etapa"';
        $item .= 'colspan="'.$upravit_den['colspan4'].'">'.$upravit_den['Af2'].'</td>';
    }
    if ( $upravit_den['colspan5'] )
    {
        $item .= '<td rowspan="2" ';
        if ($upravit_den['etapa5'] == 1) $item .= 'class="etapa"';
        $item .= '>'.$upravit_den['Nig'].'</td>';
    }
    $item .= '</tr>';
    
    $item .= '<tr class="sude">';
    $item .= '<td><em>'.nicknameFromID( $upravit_den['dira2'], $spojeni ).'</em></td>';
    $item .= '</tr></table>';
    $item .= '</div>';
	
    echo $item;*/
}?>


<script type="text/javascript">
$( "select:disabled, .toHide" ).hide();

$( ".minus" ).click(function(){
    var str = this.id;
    var frag = str.split( '-' );
    //alert( frag[0] + " - " + frag[1] + " - " + frag[2] ); //Del - Mor1 - 0
    document.getElementById( frag[1] + frag[2] ).disabled = true;
    $( "#" + frag[1] + frag[2] ).hide();
    $(this).hide();
});



$( ".plus" ).click(function(){
    var str = this.id;
    var frag = str.split( "-" );
    var max_of_doers = <?php echo $max_of_doers; ?>
    //alert( frag[0] + frag[1] ); //Add - Mor1
    for ( var i = 0; i < max_of_doers; i++ )
    {
        if ( document.getElementById( frag[1] + i ).disabled )
        {
            $( "#" + frag[1] + i ).show();
            document.getElementById( frag[1] + i ).disabled = false;
            $( "#Del-" + frag[1] + "-" + i ).show();
            break;
        }
    }
    if ( i == max_of_doers ) alert( "Maximum je " + max_of_doers );
});




$( "#DB1" ).focusout(function() {
	var colspan = this.value;
	if ( colspan > 5 )
	{
		alert( "Příliš dlouhý blok" );
		this.value = 1;
		colspan = 1;
	}
	if ( colspan >= 2 )
	{
		$( ".TD-Mor2" ).hide();
		document.getElementById( "DB2" ).value = 0;
	}
	else
	{
		$( ".TD-Mor2" ).show();
		document.getElementById( "DB2" ).value = 1;
	}
	if ( colspan >= 3 )
	{
		$( ".TD-Af1" ).hide();
		document.getElementById( "DB3" ).value = 0;
	}
	else
	{
		$( ".TD-Af1" ).show();
		document.getElementById( "DB3" ).value = 1;
	}
	if ( colspan >= 4 )
	{
		$( ".TD-Af2" ).hide();
		document.getElementById( "DB4" ).value = 0;
	}
	else
	{
		$( ".TD-Af2" ).show();
		document.getElementById( "DB4" ).value = 1;
	}
	if ( colspan >= 5 )
	{
		$( ".TD-Nig" ).hide();
		document.getElementById( "DB5" ).value = 0;
	}
	else
	{
		$( ".TD-Nig" ).show();
		document.getElementById( "DB5" ).value = 1;
	}
});
$( "#DB2" ).focusout(function() {
	var colspan = this.value;
	if ( colspan > 4 )
	{
		alert( "Příliš dlouhý blok" );
		this.value = 1;
		colspan = 1;
	}
	if ( colspan >= 2 )
	{
		$( ".TD-Af1" ).hide();
		document.getElementById( "DB3" ).value = 0;
	}
	else
	{
		$( ".TD-Af1" ).show();
		document.getElementById( "DB3" ).value = 1;
	}
	if ( colspan >= 3 )
	{
		$( ".TD-Af2" ).hide();
		document.getElementById( "DB4" ).value = 0;
	}
	else
	{
		$( ".TD-Af2" ).show();
		document.getElementById( "DB4" ).value = 1;
	}
	if ( colspan >= 4 )
	{
		$( ".TD-Nig" ).hide();
		document.getElementById( "DB5" ).value = 0;
	}
	else
	{
		$( ".TD-Nig" ).show();
		document.getElementById( "DB5" ).value = 1;
	}
});
$( "#DB3" ).focusout(function() {
	var colspan = this.value;
	if ( colspan > 3 )
	{
		alert( "Příliš dlouhý blok" );
		this.value = 1;
		colspan = 1;
	}
	if ( colspan >= 2 )
	{
		$( ".TD-Af2" ).hide();
		document.getElementById( "DB4" ).value = 0;
	}
	else
	{
		$( ".TD-Af2" ).show();
		document.getElementById( "DB4" ).value = 1;
	}
	if ( colspan >= 3 )
	{
		$( ".TD-Nig" ).hide();
		document.getElementById( "DB5" ).value = 0;
	}
	else
	{
		$( ".TD-Nig" ).show();
		document.getElementById( "DB5" ).value = 1;
	}
});
$( "#DB4" ).focusout(function() {
	var colspan = this.value;
	if ( colspan > 2 )
	{
		alert( "Příliš dlouhý blok" );
		this.value = 1;
		colspan = 1;
	}
	if ( colspan >= 2 )
	{
		$( ".TD-Nig" ).hide();
		document.getElementById( "DB5" ).value = 0;
	}
	else
	{
		$( ".TD-Nig" ).show();
		document.getElementById( "DB5" ).value = 1;
	}
});
$( "#DB5" ).focusout(function() {
	var colspan = this.value;
	if ( colspan > 1 )
	{
		alert( "Příliš dlouhý blok" );
		this.value = 1;
		colspan = 1;
	}
});

if ( $( "#DB1" ).val() == 0 )
{
	$( ".TD-Mor1" ).hide();
}
if ( $( "#DB2" ).val() == 0 )
{
	$( ".TD-Mor2" ).hide();
}
if ( $( "#DB3" ).val() == 0 )
{
	$( ".TD-Af1" ).hide();
}
if ( $( "#DB4" ).val() == 0 )
{
	$( ".TD-Af2" ).hide();
}
if ( $( "#DB5" ).val() == 0 )
{
	$( ".TD-Nig" ).hide();
}

function fce( type, name )
{
	if ( type == 'y' )
		color = '#FE9CAB';
	else
		color = '#93e6f7';
	$( "td." + name ).css( 'background-color', color );
}




var x = document.getElementsByName( "etapa1" );
if ( x[1].checked )
{
	$( "td.TD-Mor1" ).css( 'background-color', '#FE9CAB' );
}
var x = document.getElementsByName( "etapa2" );
if ( x[1].checked )
{
	$( "td.TD-Mor2" ).css( 'background-color', '#FE9CAB' );
}
var x = document.getElementsByName( "etapa3" );
if ( x[1].checked )
{
	$( "td.TD-Af1" ).css( 'background-color', '#FE9CAB' );
}
var x = document.getElementsByName( "etapa4" );
if ( x[1].checked )
{
	$( "td.TD-Af2" ).css( 'background-color', '#FE9CAB' );
}
var x = document.getElementsByName( "etapa5" );
if ( x[1].checked )
{
	$( "td.TD-Nig" ).css( 'background-color', '#FE9CAB' );
}
</script>