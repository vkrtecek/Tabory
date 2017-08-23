<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripts/dbConn.js" type="text/javascript"></script>
<script type="text/javascript">
	MAX_LENGTH = 40;
</script>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<title>Upravit položku</title>
</head>
<body id="body">
<h1>Upravit položku z inventáře</h1>
<?php
if ( file_exists('../promenne.php') && require( "../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		if (isset($_REQUEST['name'])) $name = $_REQUEST['name'];
		if (isset($_REQUEST['passwd'])) $passwd = $_REQUEST['passwd'];
		$ID = $_REQUEST['upravit_prispevek'];	
		
		?>
            <div class="right">
            <form method="post" action="index.php">
                <button type="submit" name="odeslat">Zpět na inventář</button>
                <input type="hidden" name="name" value="<?php echo $name; ?>" />
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            </form>
        	</div>
        
        	<div id="items">
        	<?php 
			$sql = $spojeni->query("SELECT * FROM items_items WHERE ID = ".$ID);
			$item = mysqli_fetch_array( $sql );
			$cat = $item['kategorie'];
			$verejne = $item['verejne'];
			$nazev = $item['nazev'];
			$popis = $item['popis'];
			
			
			echo '<h2>'.$item['nazev'].'&nbsp;&nbsp;&nbsp;&nbsp;#'.$ID.'</h2>';
			?>
            	<div id="formToUpdate">
				<p>Kategorie:        	
				<select name="cat" size="1">
				<?php
					$spojeni->query("SET CHARACTER SET utf8");
					$sql = $spojeni->query("SELECT * FROM items_kategory");
					while ($item = mysqli_fetch_array($sql))
					{
						$option = '<option value="'.$item['jmeno'].'"';
						if ($cat == $item['jmeno']) $option .= ' selected="selected"';
						$option .= '>'.$item['kategorie_nazev'].'</option>';
						echo $option;
					}
				?>
				</select></p><br />
				<p>Veřejné:
				<select name="verejne" size="1">
					<option value=1 <?php if ($verejne == 1) echo 'selected="selected"';?>>ANO</option>
					<option value=0 <?php if ($verejne == 0) echo 'selected="selected"'?>>NE</option>
				</select>&nbsp;(toto uvidí rodiče)</p><br />
				<p><label> Název:<strong class="red">*</strong> <input id="name" name="nazev" value="<?php echo isset($_REQUEST['nazev']) ? $_REQUEST['nazev'] : $nazev;?>" /></label></p><br />
				<p><label>Popis: <textarea rows="4" cols="35" id="popis" name="popis"><?php echo isset($_REQUEST['popis']) ? $_REQUEST['popis'] : $popis;?></textarea></label></p><br />
				
				<input name="upravit_prispevek" value="<?php echo $ID?>" type="hidden" />
				<button name="upravit" onClick="updateItem( <?php echo "'".$ID."'";?>, 'formToUpdate', 'items_items' )">Upravit</button> <em class="red">*Povinné pole</em></p><br />
			</div>
			<script type="text/javascript">
				$("#name").keyup(function(){
					var text = $(this).val();
					if ( text.length >= MAX_LENGTH )
					{
						//alert( 'Maximální počet znaů je '+MAX_LENGTH );
						text = text.substring( 0, MAX_LENGTH );
						$(this).val( text );
					}
				});
			</script>
        </div>
        <?php
		
	}
	else echo '<p>Connection to database failed.</p>';
}
else echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce ('.$spravce.').</strong></h3></div>';
?>
</body>
</html>