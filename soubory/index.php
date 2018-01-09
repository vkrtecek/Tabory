<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripty/dbConn.js" type="text/javascript"></script>
<script src="../relogin.js" type="text/javascript"></script>
<title>Soubory 51. smečky Vlčat</title>
<link rel="stylesheet" href="styly.css" />
<?php
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
$prevodni_tabulka = array(
  'á'=>'a',
  'Á'=>'A',
  'č'=>'c',
  'Č'=>'C',
  'ď'=>'d',
  'Ď'=>'D',
  'ě'=>'e',
  'Ě'=>'E',
  'é'=>'e',
  'É'=>'E',
  'í'=>'i',
  'Í'=>'I',
  'ň'=>'n',
  'Ň'=>'N',
  'ó'=>'o',
  'Ó'=>'O',
  'ř'=>'r',
  'Ř'=>'R',
  'š'=>'s',
  'Š'=>'S',
  'ť'=>'t',
  'Ť'=>'T',
  'ú'=>'u',
  'Ú'=>'U',
  'ů'=>'u',
  'Ů'=>'U',
  'ý'=>'y',
  'Ý'=>'Y',
  'ž'=>'z',
  'Ž'=>'Z'
);
if ( !isset($_REQUEST['name']) || !isset($_REQUEST['passwd']) ) {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>' );</script>
  <?php
	echo '<h1><a href="../">Zřejmě jste se zapomněli přihlásit</a></h1>';
}
else
{
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
	if ( file_exists("../promenne.php") ) require( "../promenne.php" );
	if ( file_exists("../getMyTime().php") ) require("../getMyTime().php");
	
	
	$chyba_nacitani = false;
	$popis = "Nové jméno souboru";
	$pozn = "Poznámka";
	$w_file_exists = false;
	$warning_error = false;
	$uploaded = false;
	$into_database = false;
	
	if ( isset($_REQUEST['post']) )
	{
		if ( isset($_FILES['file']) )
		{
			if ( $_REQUEST['popis'] != "" && $_REQUEST['popis'] != $popis ) 
			{
				$pripona = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$newname = $_REQUEST['popis'].".".$pripona;
			}
			else $newname = $_FILES['file']['name'];
			
			$newname = strtr($newname, $prevodni_tabulka);
			
			
			if ( file_exists( "files/".$newname) )
			{
				$w_file_exists = true;
			}
			else
			{
				$uploaded = true;
			}
		}
		else
		{
			$warning_error = true;
		}
	}//isset $_REQUEST['post']
	
	
	if ( $uploaded )
	{		
		$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
		if ( $spojeni )
		{
			$poznamka = $_REQUEST['pozn'] != $pozn ? $_REQUEST['pozn'] : '';
			$spojeni->query("SET CHARACTER SET UTF8");
			$spojeni->query("INSERT INTO vlc_files (nazev, datum, velikost, inserted, platnost, pozn) VALUES ('".$newname."', '".getMyTime()."', '".filesize($_FILES['file']['tmp_name'])."', '".IDFromNick($name, $spojeni)."', 1, '".$poznamka."')");
			
			$into_database = true;
		}
	}
	
	if ( $warning_error || $w_file_exists ) $chyba_nacitani = true;
	
	if ( $uploaded && $into_database ) move_uploaded_file( $_FILES['file']['tmp_name'], "files/".$newname );
?>
</head>
<body>
<h1>Sdílené soubory</h1>
<div id="soubs">
	Seřadit podle: <select id="orderBy">
    	<option value="datum">datumu</option>
        <option value="nazev">jména</option>
        <option value="downloaded">stahovanosti</option>
    </select>
    <select id="asc">
    	<option value="DESC">sestupně</option>
        <option value="ASC">vzestupně</option>
    </select>
    jen v <select id="month">
    	<option value="">--měsíc--</option>
        <?php
		$mesice = array( 'leden', 'únor', 'březen', 'buden', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec' );
		for ( $i = 0; $i < count($mesice); $i++ )
			echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'">'.$mesice[$i].'</option>';
		?>
    </select>
    <input id="year" style="max-width:50px;" />
    pouze od <select name="jmeno" id="inserted">
    	<option value="">--jmeno--</option>
        <?php
		$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
		if ( $spojeni )
		{
        	$spojeni->query("SET CHARACTER SET UTF8");
			$sql = $spojeni->query("SELECT * FROM vlc_users");
			while ( $a = mysqli_fetch_array($sql) )
				echo '<option value="'.$a['ID'].'">'.toHacky( $a['nick'], $spojeni ).'</option>';
		}
		?>
    </select>
    a <input id="pattern" /><span id="clear" title="výchozí filtrování" onclick="clearSearch()">×</span>
<hr id="vyhledavani" />


<div id="hereFiles"><img src="../help/img/loading.gif" alt="loading_image" /></div>
<script type="text/javascript">
DEF_DIV = 'hereFiles';
DEF_TABLE = 'vlc_files';
DEF_TABLE_DOWNLOAD = 'vlc_files_downloaded';
DEF_TABLE_SEEN = 'vlc_files_seen';
DEF_PATT = 'hledaná fráze';
DEF_YEAR = 'rok';
MY_NAME = '<?php echo $name; ?>';


$("#year").val( DEF_YEAR );
$("#year").css( 'color', 'grey' );
$("#year").css( 'font-family', 'monospace' );
$("#year").focus(function(){
	var val = $(this).val();
	if ( val == DEF_YEAR ){
		$(this).css( 'color', 'black' );
		$(this).css( 'font-family', 'sans-serif' );
		$(this).val( '' );
	}
});
$("#year").focusout(function(){
	var val = $(this).val();
	if ( val == '' ){
		$(this).css( 'color', 'grey' );
		$(this).css( 'font-family', 'monospace' );
		$(this).val( DEF_YEAR );
	}
});
$("#pattern").val( DEF_PATT );
$("#pattern").css( 'color', 'grey' );
$("#pattern").css( 'font-family', 'monospace' );
$("#pattern").focus(function(){
	var val = $(this).val();
	if ( val == DEF_PATT ){
		$(this).css( 'color', 'black' );
		$(this).css( 'font-family', 'sans-serif' );
		$(this).val( '' );
	}
});
$("#pattern").focusout(function(){
	var val = $(this).val();
	if ( val == '' ){
		$(this).css( 'color', 'grey' );
		$(this).css( 'font-family', 'monospace' );
		$(this).val( DEF_PATT );
	}
});



printFiles();
$("#orderBy, #asc, #month, #inserted").change(function(){
	printFiles();
});
$("#year, #pattern").keyup(function(){
	printFiles();
});
</script>
</div>



<div id="menu_files">
    <form method="post" action="../" id="form_back">
        <input type="hidden" name="name" value="<?php echo $name;?>"/>
        <input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
        <button type="submit" name="login" id="back"></button>
    </form>
    <?php
    if ( isAdmin( $name, $spojeni) ) {
        ?>
        <button onClick="showStatistic()">Statistiky stahování</button>
        <?php
    }
    ?>
    <div id="formular">
        <button id="add">Přidat soubor</button>
        <button id="uAdd">Skrýt formulář</button>
        <form method="post" enctype="multipart/form-data" id="addForm" onsubmit="return checkUpload()"><br /><br /><br />
            <input type="hidden" name="name" value="<?php echo $name;?>"/>
            <input type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
            <input type="file" name="file" id="file" multiple /> <em>Max: <?php echo ini_get('upload_max_filesize'); ?></em><br />
            <input type="text" name="popis" id="popis" value="<?php echo $chyba_nacitani ? $_REQUEST['popis'] : $popis; ?>" id="popis"  /><br />
            <input type="text" name="pozn" id="pozn" value="<?php echo $chyba_nacitani ? $_REQUEST['pozn'] : $pozn; ?>" id="pozn"  />
            &nbsp;&nbsp;&nbsp;&nbsp;<button name="post" type="submit">Nahrát</button>
            <?php
            if ( $chyba_nacitani ) echo '<br />';
            echo $warning_error ? '<p class="upoz">Something gone wrong.</p>' : ( $w_file_exists ? '<p class="upoz">File with this name is already exists. Please change it.</p>' : '' );
            ?>
        </form>
        <?php
            echo $uploaded && !$into_database ? '<br /><p class="upoz">Error while connecting to database. Contact '.$spravce.'</p>' : '';
            echo $uploaded ? '<br /><p class="upoz">OK</p>' : '';
        ?>
    </div>
</div> <!-- id="menu_files" -->

<div id="statistic">
</div>


<script>
MAX_LEN_OF_FILE_NAME = 225;
MAX_LEN_OF_NOTE = 20;
DEF_NAME = "<?php echo $popis; ?>";
DEF_POZN = "<?php echo $pozn; ?>";
MAX_UPLOAD_SIZE = <?php echo return_bytes(ini_get( 'upload_max_filesize' )); ?>;

$("#uAdd").hide();
$("#addForm").hide();
<?php if ( $chyba_nacitani ) { ?>
$("#uAdd").show();
$("#addForm").show();
$("#add").hide();
<?php } ?>

$("#add").click(function(){
	$(this).hide();
	$("#uAdd").show();
	$("#addForm").toggle("slide");
});
$("#uAdd").click(function(){
	$(this).hide();
	$("#add").show();
	$("#addForm").toggle("slide");
});


$("#popis").focusout(function(){
	akt = $(this).val();
	if ( akt == "" ) $(this).val( DEF_NAME );
});
$("#popis").focus(function(){
	akt = $(this).val();
	if ( akt == DEF_NAME ) $(this).val("");
});
$("#pozn").focusout(function(){
	akt = $(this).val();
	if ( akt == "" ) $(this).val( DEF_POZN );
});
$("#pozn").focus(function(){
	akt = $(this).val();
	if ( akt == DEF_POZN ) $(this).val("");
});


	var ACT_SIZE = 0;
	document.getElementById( 'file' ).addEventListener( 'change', function(evt){ ACT_SIZE = evt.target.files[0].size; }, false );
	$("#file").change(function(){
		if ( MAX_UPLOAD_SIZE < ACT_SIZE )
		{
			var minus = parseInt(ACT_SIZE)-parseInt(MAX_UPLOAD_SIZE);
			alert( 'Velikost překročila maximum o ' + bytesToRead(minus) );
		}
	});

printStatistic( 'statistic', 'vlc_files_downloaded', 'vlc_files_seen' );
$("div#statistic").hide();
function showStatistic() {
	$("div#statistic").toggle( "slow" );
	
}
</script>
</body>
<?php } ?>
</html>