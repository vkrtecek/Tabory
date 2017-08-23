<form method="post" id="addDay" >
<input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>"/>
<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
<button type="submit" name="Add" <?php echo strtolower($name) == "novacek" ? 'disabled="disabled"' : ''; ?>>Přidat den<br />do tabulky</button>
</form>

<div id="modifyDay">
<form method="post">
<input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>"/>
<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
Upravit 
<select name="day_to_modify"><?php
    $spojeni->query("SET CHARACTER SET utf8");
    $sql = $spojeni->query("SELECT * FROM ".$sql_table."");
    while ($den = mysqli_fetch_array($sql))
    {
        echo '<option value="'.$den['den'].'"';
        echo isset( $_REQUEST['day_to_modify'] ) && $_REQUEST['day_to_modify'] == $den['den'] ? ' selected="selected"' : '';
        echo '>'.$den['den'].'.</option>';
        $cntt = true;
    }?>
</select> den
<button type="submit" name="modifyDay" <?php echo strtolower($name) == "novacek" || !isset($cntt) ? 'disabled="disabled"' : ''; ?>>Upravit</button>
</form>
<?php
if ( isAdmin($name, $spojeni) ) {
	echo '<button onclick="showStatistic()">Show statistic</button>';
}
?>
</div>



<?php
/* - etapové skupině přidat pole vložení excelu - */
$spojeni->query("SET CHARACTER SET utf8");
$sql = $spojeni->query("SELECT * FROM vlc_users WHERE nick = '".$name."'");
$clovek = mysqli_fetch_array($sql);

if ( $clovek['etapa'] )
{
    if ( file_exists("upload_excel.php") )
    {
        require("upload_excel.php");
        upload( "harmonogram", $name, $passwd );
    }
    else echo '<div id="div_upload"><p>Form to upload excel files not found.</p></div>';
}
/* - etapa - */
?>




<table rules="all" id="rozpis" >
<tr><th colspan="8"><h2>Harmonogram tábora dYearToSubStr</h2></th></tr>
<tr><th>Den</th><th>Datum</th><th>Vedoucí dne</th><th class="blok">Dopoledne I</th><th class="blok">Dopoledne II</th><th class="blok">Odpoledne I</th><th class="blok">Odpoledne II</th><th class="blok">Večer</th></tr>
<?php
$cnt = 0;
$spojeni->query("SET CHARACTER SET utf8");
$sql = $spojeni->query("SELECT * FROM ".$sql_table." ORDER BY den ASC");
while ($den = mysqli_fetch_array($sql))
{
    $parita = $cnt % 2 != 0 ? 'liche' : 'sude';
    
    $item = '<tr class="'.$parita.'">';
    $item .= '<td rowspan="3">'.$den['den'].'.</td>';
    $item .= '<td rowspan="3">'.$den['datum'].'</td>';
    $item .= '<td class="'.$den['den'].'_vedouci';
		if ( $den['vedouci'] == 0 ) $item .= ' nobodyTD';
		else  if ($den['vedouci'] == IDFromNick( $name, $spojeni )) $item .= ' redBl';
    $item .= '"><strong>'.nicknameFromID( $den['vedouci'], $spojeni ).'</strong></td>';
    if ( $den['colspan1'] )
    {
        $gMor1 = explode( ' - ', $den['gMor1'] );
        $item .= '<td id="'.$den['den'].'_gMor1" class="';
        foreach ( $gMor1 as $person )
					if ( $person == IDFromNick( $name, $spojeni ) ) $item .= ' redBl';
				if ( $den['gMor1'] == 0 ) $item .= ' nobodyTD';
        $item .= '" colspan="'.$den['colspan1'].'" onDblClick="makeChange( \''.$den['den'].'_gMor1\', \''.$sql_table.'\', '.$max_of_doers.' )">';
        //$item .= nicknameFromID( $gMor1[0], $spojeni );
        foreach ( $gMor1 as $person )
        {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
    }
    if ( $den['colspan2'] )
    {
        $gMor2 = explode( ' - ', $den['gMor2'] );
        $item .= '<td id="'.$den['den'].'_gMor2" class="';
        foreach ( $gMor2 as $person )
            if ( $person == IDFromNick( $name, $spojeni) ) $item .= ' redBl';
				if ( $den['gMor2'] == 0 ) $item .= ' nobodyTD';
        $item .= '" colspan="'.$den['colspan2'].'" onDblClick="makeChange( \''.$den['den'].'_gMor2\', \''.$sql_table.'\', '.$max_of_doers.' )">';
        foreach ( $gMor2 as $person )
        {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
        //$item .=  strtolower(strtr($den['gMor2'], $prevodni_tabulka)) == strtolower($name) ? '<td class="redBl" colspan="'.$den['colspan2'].'">'.nicknameFromID( $den['gMor2'], $spojeni ).'</td>' : '<td colspan="'.$den['colspan2'].'">'.nicknameFromID( $den['gMor2'], $spojeni ).'</td>';
    }
    if ( $den['colspan3'] )
    {
        $gAf1 = explode( ' - ', $den['gAf1'] );
        $item .= '<td id="'.$den['den'].'_gAf1" class="';
        foreach ( $gAf1 as $person )
            if ( $person == IDFromNick( $name, $spojeni ) ) $item .= ' redBl';
				if ( $den['gAf1'] == 0 ) $item .= ' nobodyTD';
        $item .= '" colspan="'.$den['colspan3'].'" onDblClick="makeChange( \''.$den['den'].'_gAf1\', \''.$sql_table.'\', '.$max_of_doers.' )">';
        foreach ( $gAf1 as $person )
        {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
        //$item .=  strtolower(strtr($den['gAf1'], $prevodni_tabulka)) == strtolower($name) ? '<td class="redBl" colspan="'.$den['colspan3'].'">'.nicknameFromID( $den['gAf1'], $spojeni ).'</td>' : '<td colspan="'.$den['colspan3'].'">'.nicknameFromID( $den['gAf1'], $spojeni ).'</td>';
    }
    if ( $den['colspan4'] )
    {
        $gAf2 = explode( ' - ', $den['gAf2'] );
        $item .= '<td id="'.$den['den'].'_gAf2" class="';
        foreach ( $gAf2 as $person )
            if ( $person == IDFromNick( $name, $spojeni ) ) $item .= ' redBl';
				if ( $den['gAf2'] == 0 ) $item .= ' nobodyTD';
        $item .= '" colspan="'.$den['colspan4'].'" onDblClick="makeChange( \''.$den['den'].'_gAf2\', \''.$sql_table.'\', '.$max_of_doers.' )">';
        foreach ( $gAf2 as $person )
        {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
        //$item .=  strtolower(strtr($den['gAf2'], $prevodni_tabulka)) == strtolower($name) ? '<td class="redBl" colspan="'.$den['colspan4'].'">'.nicknameFromID( $den['gAf2'], $spojeni ).'</td>' : '<td colspan="'.$den['colspan4'].'">'.nicknameFromID( $den['gAf2'], $spojeni ).'</td>';
    }
    if ( $den['colspan5'] )
    {
        $gNig = explode( ' - ', $den['gNig'] );
        $item .= '<td id="'.$den['den'].'_gNig" class="';
        foreach ( $gNig as $person )
            if ( $person == IDFromNick( $name, $spojeni ) ) $item .= ' redBl';
				if ( $den['gNig'] == 0 ) $item .= ' nobodyTD';
        $item .= '" colspan="'.$den['colspan5'].'" onDblClick="makeChange( \''.$den['den'].'_gNig\', \''.$sql_table.'\', '.$max_of_doers.' )">';
        foreach ( $gNig as $person )
        {
            $item .= nicknameFromID( $person, $spojeni ).' ';
        }
        $item .= '</td>';
        //$item .=  strtolower(strtr($den['gNig'], $prevodni_tabulka)) == strtolower($name) ? '<td class="redBl">'.nicknameFromID( $den['gNig'], $spojeni ).'</td>' : '<td>'.nicknameFromID( $den['gNig'], $spojeni ).'</td>';
    }
    $item .= '</tr>';
    
    $item .= '<tr class="'.$parita.'">';
		$item .= '<td';
		if ($den['dira1'] == 0 ) $item .= ' class="nobodyTD"';
    else if ($den['dira1'] == IDFromNick( $name, $spojeni )) $item .= ' class="redBl"';
		$item .= '><em>'.nicknameFromID( $den['dira1'], $spojeni ).'</em></td>';
    if ( $den['colspan1'] ) { $item .= '<td rowspan="2" '; if ($den['etapa1'] == 1) $item .= 'class="etapa"'; $item .= 'colspan="'.$den['colspan1'].'">'.$den['Mor1'].'</td>'; }
    if ( $den['colspan2'] ) { $item .= '<td rowspan="2" '; if ($den['etapa2'] == 1) $item .= 'class="etapa"'; $item .= 'colspan="'.$den['colspan2'].'">'.$den['Mor2'].'</td>'; }
    if ( $den['colspan3'] ) { $item .= '<td rowspan="2" '; if ($den['etapa3'] == 1) $item .= 'class="etapa"'; $item .= 'colspan="'.$den['colspan3'].'">'.$den['Af1'].'</td>'; }
    if ( $den['colspan4'] ) { $item .= '<td rowspan="2" '; if ($den['etapa4'] == 1) $item .= 'class="etapa"'; $item .= 'colspan="'.$den['colspan4'].'">'.$den['Af2'].'</td>'; }
    if ( $den['colspan5'] ) { $item .= '<td rowspan="2" '; if ($den['etapa5'] == 1) $item .= 'class="etapa"'; $item .= '>'.$den['Nig'].'</td>'; }
    $item .= '</tr>';
    
    $item .= '<tr class="'.$parita.'">';
		$item .= '<td';
		if ( $den['dira2'] == 0 ) $item .= ' class="nobodyTD"';
    else if ( $den['dira2'] == IDFromNick( $name, $spojeni )) $item .= ' class="redBl"';
		$item .= '><em>'.nicknameFromID( $den['dira2'], $spojeni ).'</em></td>';
		$item .= '</tr>';
    
    echo $item;
    
    $cnt++;
}
?>
</table>




<hr class="konec" />
<p class="konec">Stáhnout v: 
<select name="vybrat" size="1" id="DW">
    <?php if ( file_exists("files/harmonogram.xlsx") ) {?><option value="xlsx" selected="selected">.XLSX</option><?php } ?>
    <?php if ( file_exists("files/harmonogram.xls") ) {?><option value="xls">.XLS</option><?php } ?>
</select>
<button id="JS" onclick="download('harmonogram')" <?php if ( !file_exists("files/harmonogram.xlsx") && !file_exists("files/harmonogram.xls") ) echo 'disabled="disabled"'; ?>>Stáhnout</button></p>

<div id="statistic"></div>
<script type="text/javascript">
function download(soub)
{
    var option = $('#DW option:selected').attr('value');
    //alert( 'files/' + soub + '.' + option );
    window.open('files/' + soub + '.' + option);
};
    
width = $("#rozpis").width();
$("hr").css( "width", width );


printStatistic( "statistic" );
$("div#statistic").hide();
function showStatistic() {
	$("div#statistic").toggle();
}
</script>