<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
if (!file_exists('promene.php'))
{
	echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce (krtek@zlin6.cz).</strong></h3></div>';
}
else
{
	require('promene.php');
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	$prihlaseni = false;
	$kontr_pass = true;
	$kontr_mail = true;
	
	
	if (!isset($title)) $title = "Úvodní stránka";
	?>
	<title><?php echo $title; ?></title>
	<style>
	body::after {
	  content: "";
	  background: url('pozadi.jpg') center no-repeat;
	  background-attachment: fixed;
	  opacity: 0.2;
	  top: 0;
	  left: 0;
	  bottom: 0;
	  right: 0;
	  position:fixed;
	  z-index: -1;  
	  padding:20px;
	  background-color: rgba(255, 255, 255, 0.5);
	}
	#body{
		margin:auto;
		max-width:1900px;
	}
	.right{
		float:right;
		margin-right:2vw;
		display:inline;
	}
	h1{
		margin-left:30vw;
		display:inline;
	}
	.item h2{
		display:inline;
		margin-left:3vw;
	}
	.oznameni{
		margin:auto;
		border:2px red solid;
		width:23vw;
		padding:10px;
	}
	#items{
		width:70vw;
		margin:auto;
		margin-top:15vh;
	}
	.item{
		margin:1.7%;
		border-radius:7%;
		border:solid 2px #0033FF;
		padding:5px;
		background-color:#FFC;
	}
	.red_border{
		border:solid 1px red;
	}
	div.nazev{
		display:inline;
	}
	div.popis{
		display:inline;
		margin-left:6vw;
	}
	div.kategorie{
		clear:both;
		margin:auto;
		text-align:center;
	}
	p{
		margin:0;
	}
	.red{
		color:red;
	}
	.smazat_prispevek, .upravit_prispevek{
		float:right;
		font-family:Verdana, Geneva, sans-serif;
		font-size:9px;
		margin: 13px 10px 0 0;
		padding:1px;
	}
	.smazat_prispevek:hover, .upravit_prispevek:hover{
		text-decoration:underline;
		cursor:pointer;
	}
	.smazat_prispevek{
		color:#F09;
	}
	.upravit_prispevek{
		color:blue;
	}
	img{
		cursor:cell;
	}
	button.menu{
		cursor:pointer;
	}
	button.menu:hover{
		text-decoration:underline;
	}
	div{order:solid black 1px;}
	</style>
	</head>
	<body id="body">
    <?php
	if($spojeni)
	{
		$spojeni->query("SET CHARACTER SET utf8");
		if (/*!isset($uziv_jmeno) ||  && */isset($_REQUEST['jmeno']) && isset($_REQUEST['heslo'])) //overeni uzivatele
		{
			if (isset($_REQUEST['odeslat'])) $kontr_mail = false;
			
			$sql = $spojeni->query("SELECT email, heslo, prezdivka FROM users");
			while ($item = mysqli_fetch_array($sql))
			{
				if ($item['email'] == $_REQUEST['jmeno'])
				{
					$kontr_mail = true;
					if ($item['heslo'] == $_REQUEST['heslo'])
					{
						$prihlaseni = true;
						$uziv_jmeno = $item['prezdivka'];
					}
					else $kontr_pass = false;
				}
			}
		}
	}
	?>
	<h1>Inventář 51. Smečky Vlčat<?php if(isset($uziv_jmeno)) echo ' - '.$uziv_jmeno;?></h1>
	
    <?php if(!isset($uziv_jmeno)) {?>
        <div class="right" >
        <form method="post" action="" method="get"><p><table rules="none">
            <tr><label><td>Přihlašovací jméno: </td><td><input name="jmeno" value="<?php if (isset($_REQUEST['odeslat'])) echo $_REQUEST['jmeno']?>" id="jmeno" <?php if(!$kontr_mail) echo 'class="red_border"';?>/></label></td></tr>
            <tr><label><td>Heslo: </td><td><input name="heslo" type="password" id="heslo" <?php if(!$kontr_pass) echo 'class="red_border"';?>/></label></td></tr>
            <tr><td></td><td><button name="odeslat" class="menu">Přihlásit</button></td></tr>
        </table></p></form>
        </div>
	<?php
	}
	else
	{?>
		<div class="right">
        <form method="post" action="pridat.php" method="get">
        	<input name="jmeno" value="<?php echo $_REQUEST['jmeno']?>" type="hidden" />
            <input name="heslo" value="<?php echo $_REQUEST['heslo']?>" type="hidden" />
            <button type="submit" name="pridat" class="menu">Přidat předmět</button>
        </form>
        <form method="post" action="zmena.php" method="get">
        	<input name="jmeno" value="<?php echo $_REQUEST['jmeno']?>" type="hidden" />
            <input name="heslo" value="<?php echo $_REQUEST['heslo']?>" type="hidden" />
            <input name="prezdivka" value="<?php echo $uziv_jmeno?>" type="hidden" />
            <button type="submit" name="zmenit" class="menu">Změna údajů</button>
        </form>
        <a href="index.php"><button class="menu">Odhlásit</button></a>
        </div>
	<?php }
	
	
	if($spojeni)
	{
		if (isset($_REQUEST['smazat_prispevek'])) $spojeni->query("UPDATE items SET platnost = 0 WHERE ID = '".$_REQUEST['smazat_prispevek']."'");
		?>
		<div id="items">
            <div class="right">
            <form method="post" >
                <input type="text" name="hledane_slovo"/>
                <input name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" type="hidden" />
				<input name="heslo" value="<?php echo $_REQUEST['heslo'];?>" type="hidden" />
                <button type="submit" name="hledat">Vyhledat</button>
            </form>
            </div>
        
		<form method="post" method="post"><p>Kategorie: 
		
			<select name="kategorie" size="1">
				<option value="1"<?php if (!isset($_REQUEST['kategorie']) || $_REQUEST['kategorie'] == '1') echo ' selected="selected"';?>>Vše</option><br />
                <?php
				$sql = $spojeni->query("SELECT jmeno, kategorie_nazev FROM kategory"); //doplnit
				while ($cat = mysqli_fetch_array($sql)) //vypsání itemů
				{
					$option = '<option value="'.$cat['jmeno'].'"';
					if (isset($_REQUEST['kategorie']) && $_REQUEST['kategorie'] == $cat['jmeno']) $option .= ' selected="selected"';
					$option .= '>'.$cat['kategorie_nazev'].'</option><br />';
					echo $option;
				}
				?>
			</select> řadit podle: 
			<select name="razeni" size="1">
				<option value="nazev" <?php if (isset($_REQUEST['razeni']) && $_REQUEST['razeni'] == 'nazev') echo 'selected="selected"';?>>Název</option>
				<option value="kategorie" <?php if (isset($_REQUEST['razeni']) && $_REQUEST['razeni'] == 'kategorie') echo 'selected="selected"';?>>Kategorie</option>
			</select>
			<select name="razeni_styl" size="1">
				<option value="ASC" <?php if (isset($_REQUEST['razeni_styl']) && $_REQUEST['razeni_styl'] == 'ASC') echo 'selected="selected"';?>>Vzestupně</option>
				<option value="DESC" <?php if (isset($_REQUEST['razeni_styl']) && $_REQUEST['razeni_styl'] == 'DESC') echo 'selected="selected"';?>>Sestupně</option>
			</select>
			<input name="jmeno" value="<?php echo $_REQUEST['jmeno'];?>" type="hidden" />
			<input name="heslo" value="<?php echo $_REQUEST['heslo'];?>" type="hidden" />
			<button>Vybrat</button></p>
		</form>
        <?php
		$prikaz = 'SELECT * FROM items AS a';
		$prikaz .= ' LEFT JOIN kategory AS b ON a.kategorie = b.jmeno';
		if (isset($uziv_jmeno)) $prikaz .= ' WHERE platnost = 1';
		else $prikaz .= ' WHERE platnost = 1 && verejne = 1';
		if (isset($_REQUEST['hledat']) && $_REQUEST['hledane_slovo'] != '') $prikaz .= ' && (popis LIKE "%'.$_REQUEST['hledane_slovo'].'%" || nazev LIKE "%'.$_REQUEST['hledane_slovo'].'%")';
		if (isset($_REQUEST['kategorie']) && $_REQUEST['kategorie'] != 1) $prikaz .= ' && kategorie = "'.$_REQUEST['kategorie'].'"';
		if (isset($_REQUEST['razeni']) && isset($_REQUEST['razeni_styl'])) $prikaz .= ' ORDER BY a.'.$_REQUEST['razeni'].' '.$_REQUEST['razeni_styl'];
		//echo $prikaz;
		$items_count = 0;
		
		$sql = $spojeni->query($prikaz); //doplnit
		while ($item = mysqli_fetch_array($sql)) //vypsání itemů
		{
			$each_item = '<div class="item">';
			if (isset($uziv_jmeno))
			{
				$each_item .= '<form method="post" action="index.php">
				<input name="jmeno" value="'.$_REQUEST['jmeno'].'" type="hidden" />
				<input name="heslo" value="'.$_REQUEST['heslo'].'" type="hidden" />
				<button type="submit"  name="smazat_prispevek" class="smazat_prispevek" value="'.$item['ID'].'"><b>ODEBRAT</b></button></form>';
				
				$each_item .= '<form method="post" action="upravit.php">
				<input name="nazev" value="'.$item['nazev'].'" type="hidden" />
				<input name="popis" value="'.$item['popis'].'" type="hidden" />
				<input name="cat" value="'.$item['kategorie_nazev'].'" type="hidden" />
				<input name="verejne" value="'.$item['verejne'].'" type="hidden" />
				
				<input name="jmeno" value="'.$_REQUEST['jmeno'].'" type="hidden" />
				<input name="heslo" value="'.$_REQUEST['heslo'].'" type="hidden" />
				<button type="submit"  name="upravit_prispevek" class="upravit_prispevek" value="'.$item['ID'].'"><b>UPRAVIT</b></button>
				</form>';
			}
			$each_item .=	'<a href="obrazky/'.$item['obrazek'].'"><img src="obrazky/'.$item['obrazek'].'" alt="polozka" height="100" width="100"/></a><div class="nazev"><h2>'.$item['nazev'].'</h2></div><div class="popis">'.$item['popis'].'</div><div class="kategorie"><strong>'.$item['kategorie_nazev'].' - '.$item['garant'].' ('.$item['garant_cislo'].')</strong></div></div>';
			echo $each_item;
			$items_count++;
		}
		if ($items_count == 0) echo '<p><br /><br />V této kategorii momentálně nic není.</p>';
		else echo '<p>Celkem položek: '.$items_count.'</p></div>';
	}
	else
	{
		echo '<div class="oznameni"><h3><strong>Spojení s databází selhalo</strong></h3></div>';
	}		
}
?>

</body>
</html>