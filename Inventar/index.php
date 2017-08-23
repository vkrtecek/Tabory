<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripts/dbConn.js" type="text/javascript"></script>
<script src="../relogin.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />

<?php
if ( !isset($_REQUEST['name']) || !isset($_REQUEST['passwd']) ) {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>' );</script>
  <?php
  echo '<h1><a href="../">Zřejmě jste se zapomněli přihlásit</a></h1>';
}
else {
	if (!file_exists('../promenne.php'))
	{
		echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce ('.$spravce.').</strong></h3></div>';
	}
	else
	{
		$name = $_REQUEST['name'];
		$passwd = $_REQUEST['passwd'];
		
		
		require('../promenne.php');
		$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
		$prihlaseni = false;
		$kontr_pass = true;
		$kontr_mail = true;
		
		
		if (!isset($title)) $title = "Inventář 51. smečky Vlčat";
		?>
		<title><?php echo $title; ?></title>
		</head>
		<body id="body">
		<h1>Inventář 51. Smečky Vlčat</h1>
		
		<div class="right" id="menuHere"></div>
        <script type="text/javascript">
		printMenu( 'menuHere', <?php echo "'".$_REQUEST['name']."'";?>, <?php echo "'".$_REQUEST['passwd']."'";?> );
		</script>
		
		
		<?php	
		if($spojeni)
		{
			if (isset($_REQUEST['smazat_prispevek'])) $spojeni->query("UPDATE items_items SET platnost = 0 WHERE ID = '".$_REQUEST['smazat_prispevek']."'");
			?>
			<div id="items">
				<p>Kategorie: 
				<select name="kategorie" size="1" class="changeSort" >
					<option value="1">Vše</option>
					<?php
					$spojeni->query("SET CHARACTER SET UTF8");
					$sql = $spojeni->query("SELECT jmeno, kategorie_nazev FROM items_kategory"); //doplnit
					while ($cat = mysqli_fetch_array($sql)) //vypsání itemů
						echo '<option value="'.$cat['jmeno'].'">'.$cat['kategorie_nazev'].'</option><br />';
					?>
				</select> řadit podle: 
				<select name="razeni" size="1" class="changeSort" >
					<option value="nazev">Název</option>
					<option value="kategorie">Kategorie</option>
				</select>
				<select name="razeni_styl" size="1" class="changeSort" >
					<option value="ASC">Vzestupně</option>
					<option value="DESC">Sestupně</option>
				</select>
                <label> slovo: <input type="text" name="hledane_slovo" class="changeSortBtn" /></label>
                <span id="clear" title="výchozí filtrování" onclick="clearSearch( 'itemsHere', '<?php echo $name; ?>', '<?php echo $passwd; ?>' )">×</span></p><br /><hr />
                
                <div id="itemsHere"><img src="img/loading.gif" alt="loading" /></div>
                <script type="text/javascript">
					printItems( 'itemsHere', <?php echo "'".$_REQUEST['name']."'";?>, <?php echo "'".$_REQUEST['passwd']."'";?> );
					$(".changeSort").change(function(){
						printItems( 'itemsHere', <?php echo "'".$_REQUEST['name']."'";?>, <?php echo "'".$_REQUEST['passwd']."'";?> );
					});
					$(".changeSortBtn").keyup(function(){
						printItems( 'itemsHere', <?php echo "'".$_REQUEST['name']."'";?>, <?php echo "'".$_REQUEST['passwd']."'";?> );
					});
				</script>
			<?php
		}
		else
		{
			echo '<div class="oznameni"><h3><strong>Spojení s databází selhalo</strong></h3></div>';
		}		
	}
}/*nejsem přihlášený*/?>

</body>
</html>