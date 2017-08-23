<?php
$sql_table = "dYearToSubStr_jidlo";
$vymena_kucharu = 8;
function dateToReadableFormat2( $date )
{
	$tmp = explode( '-', $date );
	if ( count($tmp) != 3 ) return $date;
	list( $year, $month, $day ) = explode( '-', $date );
	$month = $month == '01' ? 'leden' : ( $month == '02' ? 'únor' : ( $month == '03' ? 'březen' : ( $month == '04' ? 'duben' : ( $month == '05' ? 'květen' : ( $month == '06' ? 'červen' : ( $month == '07' ? 'červenec' : ( $month == '08' ? 'srpen' : ( $month == '09' ? 'září' : ( $month == '10' ? 'říjen' : ( $month == '11' ? 'listopad' : 'prosinec'))))))))));
	return $day.'. '.$month.' '.$year;
}


if ( file_exists("../promenne.php") && require("../promenne.php") )
{
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if ( $spojeni )
	{
		$spojeni->query("SET CHARACTER SET utf8");
		$clovek = mysqli_fetch_array( $spojeni->query("SELECT * FROM vlc_users WHERE nick = '".$name."'") );
		$kuchar = $clovek['kuchar'];
		if ( !isset($_REQUEST['modify']) && !isset($_REQUEST['save']) )
		{
			if ( $kuchar )
			{?>
				<div id="modifyDayCook">
				<form method="post">
				<input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
				<input type="hidden" name="name" value="<?php echo $name; ?>"/>
				<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
				Upravit 
				<select name="den"><?php
					
					$sql = $spojeni->query("SELECT * FROM ".$sql_table);
					while ($den = mysqli_fetch_array($sql))
					{
						echo '<option value="'.$den['den'].'"';
						echo isset( $_REQUEST['den'] ) && $_REQUEST['den'] == $den['den'] ? ' selected="selected"' : '';
						echo '>'.$den['den'].'.</option>';
						$cntt = true;
					}?>
				</select> den
				<button type="submit" name="modify" <?php echo strtolower($name) == "novacek" || !isset($cntt) ? 'disabled="disabled"' : ''; ?>>Upravit</button>
				</form>
				</div>
				<?php
				if ( file_exists("upload_excel.php") )
				{
					require("upload_excel.php");
					upload( "jidelnicek", $name, $passwd );
				}
				?> <span id="span_nap">>podporované formáty<</span>
                <div id="napoveda">
                	<table>
                    	<tr><td>.XLSX</td><td> - Excel 2007 a novější</td></tr>
                        <tr><td>.XLS</td><td> - Excel 2003 a starší</td></tr>
                    </table>
                </div><?php
			}//if kuchar
			
			
			
			
			
			
			
			$tab = '<div id="jidelnicek"><table rules="all">';
			$tab .= '<tr><th>Den</th><th class="date">Datum</th><th>Snídaně</th><th>Svačina 1</th><th>Oděd - 1. chod</th><th>Oběd - 2. chod</th><th>Svačina 2</th><th>Večeře</th><th class="pozn">Poznámka ke koupi</th></tr>';
			$sql = $spojeni->query("SELECT * FROM ".$sql_table);
			while ( $den = mysqli_fetch_array($sql) )
			{
				$tab .= '<tr class="';
				$tab .= $den['den'] < $vymena_kucharu ? 'prvniTyden' : 'druhyTyden';
				if ( $den['den'] == $vymena_kucharu ) $tab .= ' prelomovyDen';
				$tab .= '"><td class="centr">'.$den['den'].'.</td>';
				$tab .= '<td class="centr date">'.dateToReadableFormat2( $den['datum'] ).'<br>'.$den['denv'].'</td>';
				$tab .= '<td class="sni">'.$den['snidane'].'</td>';
				$tab .= '<td class="sv1">'.$den['sv1'].'</td>';
				$tab .= '<td class="ob1">'.$den['ob1'].'</td>';
				$tab .= '<td class="ob2">'.$den['ob2'].'</td>';
				$tab .= '<td class="sv2">'.$den['sv2'].'</td>';
				$tab .= '<td class="vec">'.$den['vecere'].'</td>';
				$tab .= '<td class="pozn"><div>'.str_replace( '
', '<br />', $den['pozn'] ).'</div></td>';
				$tab .= '</tr>';
			}
			$tab .= '</table>';
			$tab .= '<hr class="cook"/>';
			$tab .= '<p>Stáhnout v: ';
            $tab .= '<select name="vybrat" size="1" id="DW">';
            if ( file_exists("files/jidelnicek.xlsx") ) $tab .= '<option value="xlsx" selected="selected">.XLSX</option>';
            if ( file_exists("files/jidelnicek.xls") ) $tab .= '<option value="xls">.XLS</option>';
            $tab .= '</select>';
            $tab .= '<button id="JS" onclick="download(\'harmonogram\')"';
			if ( !file_exists("files/jidelnicek.xlsx") && !file_exists("files/jidelnicek.xls") ) $tab .= 'disabled="disabled"';
			$tab .= '>Stáhnout</button>';
			echo $tab;
			
			$tab = '<table rules="all" id="legenda">';
			$tab .= '<tr><th colspan="2">legenda</th></tr>';
			$tab .= '<tr><td class="prvniTyden">Jana & Magda & Žena</td><td class="druhyTyden">Leoš & Bětka</td></tr>';
			$tab .= '</table></p></div>';
			echo $tab;
			
			
			if ( isAdmin( $name, $spojeni ) ) echo '<div id="statistic"></div>';
		}
		else
		{
			?>
            <form method="post" id="addDayCook" action="./?o=<?php echo $_REQUEST['o'];?>" >
            	<input type="hidden" name="o" value="<?php echo $_REQUEST['o']; ?>" />
            	<input type="hidden" name="name" value="<?php echo $name; ?>"/>
            	<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            	<button type="submit" name="unAdd" >Zpět na jídelníček</button>
        	</form>
            <?php
			$sql = $spojeni->query("SELECT * FROM ".$sql_table." WHERE den = ".$_REQUEST['den']);
			$day = mysqli_fetch_array($sql);
            echo '<h1 class="cook">Upravit '.$day['den'].'. den</h1>';?>
            
            <div id="div_addCook">
            <?php
            	if ( isset($_POST['save']) )
				{
					echo "<p>Jídelníček na tento den byl změněn.</p>";
					
					$things = array();
					$uprav = "UPDATE ".$sql_table." SET ";
					$uprav .= "datum = '".$_REQUEST['datum']."', ";
					$uprav .= "denv = '".$_REQUEST['denv']."', ";
					$uprav .= "snidane = '".$_REQUEST['snidane']."', ";
					$uprav .= "sv1 = '".$_REQUEST['sv1']."', ";
					$uprav .= "ob1 = '".$_REQUEST['ob1']."', ";
					$uprav .= "ob2 = '".$_REQUEST['ob2']."', ";
					$uprav .= "sv2 = '".$_REQUEST['sv2']."', ";
					$uprav .= "vecere = '".$_REQUEST['vecere']."', ";
					$uprav .= "pozn = '".$_REQUEST['pozn']."', ";
					$uprav .= "changed = '".IDFromNick( $name, $spojeni )."'";
					if ( file_exists('../getMyTime().php') ) {
						require('../getMyTime().php');
						$uprav .= ", modified='".getMyTime()."'";
					}
					$uprav .= " WHERE den = ".$_REQUEST['den'];
					$spojeni->query($uprav);
					
					
					$log = $name.' just changed '.$_REQUEST['den'].'th day';
					writeLog( $log, '../', $sql_table.'.txt' );
					
					
					$tab = '<table rules="all" id="nahledCook">';
					$tab .= '<tr><th>Den</th><th class="date">Datum</th><th>Snídaně</th><th>Svačina 1</th><th>Oděd - 1. chod</th><th>Oběd - 2. chod</th><th>Svačina 2</th><th>Večeře</th><th class="pozn">Poznámka ke koupi</th></tr>';
					$tab .= '<tr class="';
					$tab .= $day['den'] < $vymena_kucharu ? 'prvniTyden' : 'druhyTyden';
					if ( $day['den'] == $vymena_kucharu ) $tab .= ' prelomovyDen';
					$tab .= '"><td class="centr">'.$day['den'].'.</td>';
					$tab .= '<td class="centr date">'.dateToReadableFormat2( $day['datum'] ).'<br>'.$day['denv'].'</td>';
					$tab .= '<td class="sni">'.$_REQUEST['snidane'].'</td>';
					$tab .= '<td class="sv1">'.$_REQUEST['sv1'].'</td>';
					$tab .= '<td class="ob1">'.$_REQUEST['ob1'].'</td>';
					$tab .= '<td class="ob2">'.$_REQUEST['ob2'].'</td>';
					$tab .= '<td class="sv2">'.$_REQUEST['sv2'].'</td>';
					$tab .= '<td class="vec">'.$_REQUEST['vecere'].'</td>';
					$tab .= '<td class="pozn">'.$_REQUEST['pozn'].'</td>';
					$tab .= '</tr>';
					$tab .= '</table>';
					echo $tab;
					
					include_once( 'files/jidelnicekCreator.php' );
				}
				else
				{
					$den_d = explode( '<br />', $day['datum'] );
					?>
                	<form method="post">
                    <input type="hidden" name="den" value="<?php echo $day['den']; ?>" />
                    <input type="hidden" name="name" value="<?php echo $name; ?>" />
                    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                	<table rules="none" class="addDayTableCook">
                    	<tr><td>Datum: </td><td><input type="date" name="datum" value="<?php echo $day['datum']; ?>" />
                        <select name="denv">
                        	<option value="pondělí" <?php if ( $day['denv'] == 'pondělí' ) echo 'selected=""';?>>pondělí</option>
                            <option value="úterý" <?php if ( $day['denv'] == 'úterý' ) echo 'selected=""';?>>úterý</option>
                            <option value="středa" <?php if ( $day['denv'] == 'středa' ) echo 'selected=""';?>>středa</option>
                            <option value="čtvrtek" <?php if ( $day['denv'] == 'čtvrtek' ) echo 'selected=""';?>>čtvrtek</option>
                            <option value="pátek" <?php if ( $day['denv'] == 'pátek' ) echo 'selected=""';?>>pátek</option>
                            <option value="sobota" <?php if ( $day['denv'] == 'sobota' ) echo 'selected=""';?>>sobota</option>
                            <option value="neděle" <?php if ( $day['denv'] == 'neděle' ) echo 'selected=""';?>>neděle</option>
                        </select></td></tr>
                    	<tr><td>Snídaně: </td><td><input type="text" name="snidane" value="<?php echo $day['snidane']; ?>" /></td></tr>
                        <tr><td>Svačina 1: </td><td><input type="text" name="sv1" value="<?php echo $day['sv1']; ?>" /></td></tr>
                        <tr><td>Oběd - 1. chod: </td><td><input type="text" name="ob1" value="<?php echo $day['ob1']; ?>" /></td></tr>
                        <tr><td>Oběd - 2. chod: </td><td><input type="text" name="ob2" value="<?php echo $day['ob2']; ?>" /></td></tr>
                        <tr><td>Svačina 2: </td><td><input type="text" name="sv2" value="<?php echo $day['sv2']; ?>" /></td></tr>
                        <tr><td>Večeře: </td><td><input type="text" name="vecere" value="<?php echo $day['vecere']; ?>" /></td></tr>
                        <tr><td>Něco koupit? </td><td><textarea name="pozn"><?php echo $day['pozn']; ?></textarea></td></tr>
                    </table>
                    <button type="submit" name="save">Uložit</button>
                    </form>
				<?php
					$tab = '<table rules="all" id="nahledCook">';
					$tab .= '<tr><th>Den</th><th class="date">Datum</th><th>Snídaně</th><th>Svačina 1</th><th>Oděd - 1. chod</th><th>Oběd - 2. chod</th><th>Svačina 2</th><th>Večeře</th><th class="pozn">Poznámka ke koupi</th></tr>';
					$tab .= '<tr class="';
					$tab .= $day['den'] < $vymena_kucharu ? 'prvniTyden' : 'druhyTyden';
					if ( $day['den'] == $vymena_kucharu ) $tab .= ' prelomovyDen';
					$tab .= '"><td class="centr">'.$day['den'].'.</td>';
					$tab .= '<td class="centr date">'.dateToReadableFormat2( $day['datum'] ).'<br>'.$day['denv'].'</td>';
					$tab .= '<td class="sni">'.$day['snidane'].'</td>';
					$tab .= '<td class="sv1">'.$day['sv1'].'</td>';
					$tab .= '<td class="ob1">'.$day['ob1'].'</td>';
					$tab .= '<td class="ob2">'.$day['ob2'].'</td>';
					$tab .= '<td class="sv2">'.$day['sv2'].'</td>';
					$tab .= '<td class="vec">'.$day['vecere'].'</td>';
					$tab .= '<td class="pozn">'.$day['pozn'].'</td>';
					$tab .= '</tr>';
					$tab .= '</table>';
					echo $tab;
				}
            ?>
            </div>
            <?php
            	
		}
	}
	else //upravujeme den
	{
		echo "<p>Nepodařilo se navázat spojení. ( 'if ( $spojeni )' )</p>";
	}
}
?>
<script>
$("#napoveda").hide();
$("#span_nap").mouseover(function(){
	$("#napoveda").show();
});
$("#span_nap").mouseout(function(){
	$("#napoveda").hide();
});

function download(soub)
{
    var option = $('#DW option:selected').attr('value');
    //alert( 'files/' + soub + '.' + option );
    window.open('files/' + soub + '.' + option);
};

$( ".prelomovyDen td.sni" ).css( "background-color", "#0FC" );
$( ".prelomovyDen td.sv1" ).css( "background-color", "#0FC" );
$( ".prelomovyDen td.ob1" ).css( "background-color", "#0FC" );
$( ".prelomovyDen td.ob2" ).css( "background-color", "#0FC" );
$( ".prelomovyDen td.centr" ).css( "background-color", "#0FC" );

printStatisticFood( "statistic" );
</script>