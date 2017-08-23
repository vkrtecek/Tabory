<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripts/dbConn.js" type="text/javascript"></script>
<script type="text/javascript">
	MAX_LENGTH = 40;
	DEF_NAME = 'Max. '+MAX_LENGTH+' znaků';
</script>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<title>Nahrát položku</title>
</head>
<body id="body">
<?php
	if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
	if (isset($_REQUEST['passwd'])) $passwd = $_REQUEST['passwd'];
	
	
	
	// konfigurace
	$uploadDir = './obrazky'; // adresar, kam se maji nahrat obrazky (bez lomitka na konci)
	$allowedExt = array('jpg', 'jpeg', 'png', 'gif'); // pole s povolenymi priponami
	
	// zpracovani uploadu
	if(isset($_FILES['obrazky']) && is_array($_FILES['obrazky']['name']))
	{
		$counter = 0;
		$allowedExt = array_flip($allowedExt);
		foreach($_FILES['obrazky']['name'] as $klic => $nazev)
		{
			$fileName = $_REQUEST['nahr_cat']."_".basename($nazev);
			$tmpName = $_FILES['obrazky']['tmp_name'][$klic];
	
			// kontrola souboru
			if(!is_uploaded_file($tmpName) || !isset($allowedExt[strtolower(pathinfo($fileName, PATHINFO_EXTENSION))]))
			{
			  // neplatny soubor nebo pripona
			  continue;
			}
			
			// presun souboru
			if(move_uploaded_file($tmpName, "{$uploadDir}".DIRECTORY_SEPARATOR."{$fileName}"))
			{
			  ++$counter;
			  if ( file_exists('image_resizer.php') )
			  {
				  require('image_resizer.php');
				  
				  resizeImage( $uploadDir."/".$fileName, 100, 100, $uploadDir.'/male' );
			  } else echo "<p>Image resizer not found. The preview on inventar will not appear.</p>";
			}
	
		}
	
		echo "<p>Bylo nahráno {$counter} z ".sizeof($_FILES['obrazky']['name'])." obrázků.</p>";
	}
?>




<h1>Přidat položku do inventáře</h1>
<?php
if ( file_exists( '../promenne.php' ) && require( "../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{?>
		<div class="right">
        <form method="post" action="index.php">
            <button type="submit" name="odeslat" class="menu">Zpět na inventář</button>
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
        	<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
        </form>
		</div>
		
		<div id="items">
		<form method="post" onsubmit="return checkInsert( 'items_items', DEF_NAME, 'items' )" enctype="multipart/form-data"> 
			<p>Obrázek:<strong class="red">*</strong> <input id="nahr_file" type="file" name="obrazky[]"/></p><br />
			<p>Kategorie:        	
            <select size="1" id="nahr_cat" name="nahr_cat">
                <?php 
                if ($spojeni)
                {
                    $spojeni->query("SET CHARACTER SET utf8");
                    $sql = $spojeni->query("SELECT * FROM items_kategory");
                    while ($cat = mysqli_fetch_array($sql))
                    {
                        echo '<option value="'.$cat['jmeno'].'">'.$cat['kategorie_nazev'].'</option>';
                    }
                }
                ?>
            </select></p><br />
            <p><label> Název:<strong class="red">*</strong> <input id="nahr_nazev" /></label></p><br />
            <p><label>Popis: <textarea id="nahr_popis"></textarea></label></p><br />
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            
            
            <button typename="nahrat" name="nahrat">Nahrát</button> <em class="red">*Povinné pole</em></p><br />
        </form>
		</div>
        <script type="text/javascript">
			$("#nahr_nazev").val( DEF_NAME );
			$("#nahr_nazev").css( 'font-family', 'monospace' );
			$("#nahr_nazev").css( 'color', 'grey' );
			
			$("#nahr_nazev").focusout(function(){
				var val = $(this).val();
				if ( val == '' )
				{
					$(this).val( DEF_NAME );
					$(this).css( 'font-family', 'monospace' );
					$(this).css( 'color', 'grey' );
				}
			});
			$("#nahr_nazev").focus(function(){
				var val = $(this).val();
				if ( val == DEF_NAME )
				{
					$(this).val( '' );
					$(this).css( 'font-family', 'calibri' );
					$(this).css( 'color', 'black' );
				}
			});
			$("#nahr_nazev").keypress(function(){
				var val = $(this).val();
				if ( val.length >= MAX_LENGTH )
				{
					//alert( 'moc dlouhé' );
					val = val.substring( 0, MAX_LENGTH-1 );
					$(this).val( val );
				}
			});
		</script>
        <?php
	}
	else echo '<p>Connection to database failed.</p>';
}
else echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce ('.$spravce.').</strong></h3></div>';
?>

</body>
</html>