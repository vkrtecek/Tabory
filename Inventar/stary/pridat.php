<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nahrát položku</title>
<?php
	$warning1 = false;
	$warning2 = false;
	$item_nahran = false;
	if (isset($_REQUEST['nahrat']) && $_REQUEST['nahr_nazev'] == '') $warning2 = true;
?>
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
}
h1{
	margin-left:30vw;
	display:inline;
}
.oznameni{ /* tady*/
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
.red_border{
	border:solid 1px red;
}
p{
	margin:0;
}
.red{
	color:red;
}
button.menu{
	cursor:pointer;
}
button.menu:hover{
	text-decoration:underline;
}
</style>
</head>
<body id="body">
<?php
if (!$warning2)
{
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
	
			$fileName = basename($nazev);
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
			}
	
		}
	
		echo "<p>Bylo nahráno {$counter} z ".sizeof($_FILES['obrazky']['name'])." obrázků.</p>";
		if (isset($_REQUEST['nahrat']) && $counter == 0) $warning1 = true;
		if (isset($_REQUEST['nahrat']) && !$warning1 && !$warning2) $item_nahran = true;
	}
}




?>
<h1>Přidat položku do inventáře</h1>
<?php
if (!file_exists('promene.php'))
{
	echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce (krtek@zlin6.cz).</strong></h3></div>';
}
else
{
	require('promene.php');
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	?>
    <div class="right">
        <form method="post" action="index.php">
            <input name="jmeno" value="<?php echo $_REQUEST['jmeno']?>" type="hidden" />
            <input name="heslo" value="<?php echo $_REQUEST['heslo']?>" type="hidden" />
            <button type="submit" name="odeslat" class="menu">Zpět na inventář</button>
        </form>
        <?php if ($item_nahran) {?>
            <form method="post" action="pridat.php">
                <input name="jmeno" value="<?php echo $_REQUEST['jmeno']?>" type="hidden" />
                <input name="heslo" value="<?php echo $_REQUEST['heslo']?>" type="hidden" />
                <button type="submit" name="dalsi" class="menu">Přidal talší položku</button>
            </form>
        <?php }?>
    </div>
    
    <div id="items">
    <?php if (!$item_nahran)
	{ ?>
        <form method="post" enctype="multipart/form-data"> 
        <p>Obrázek:<strong class="red">*</strong> <input type="file" name="obrazky[]"/></p><br />
        <p>Kategorie:        	
            <select name="nahr_cat" size="1">
                <?php 
                if ($spojeni)
                {
                    $spojeni->query("SET CHARACTER SET utf8");
                    $sql = $spojeni->query("SELECT * FROM kategory");
                    while ($cat = mysqli_fetch_array($sql))
                    {
                        echo '<option value="'.$cat['jmeno'].'">'.$cat['kategorie_nazev'].'</option>';
                    }
                }
                ?>
            </select></p><br />
            <p>Veřejné:
            <select name="nahr_verejne" size="1">
                <option value=1 selected="selected">ANO</option>
                <option value=0>NE</option>
            </select>&nbsp;(toto uvidí rodiče)</p><br />
            <p><label> Název:<strong class="red">*</strong> <input name="nahr_nazev" value="<?php if (isset($_REQUEST['nahr_nazev'])) echo $_REQUEST['nahr_nazev'];?>" /></label></p><br />
            <p><label>Popis: <textarea name="nahr_popis"><?php if (isset($_REQUEST['nahr_popis'])) echo $_REQUEST['nahr_popis'];?></textarea></label></p><br />
            <input name="jmeno" value="<?php echo $_REQUEST['jmeno']?>" type="hidden" />
                <input name="heslo" value="<?php echo $_REQUEST['heslo']?>" type="hidden" />
            <button typename="nahrat" name="nahrat">Nahrát</button> <em class="red">*Povinné pole</em></p><br />
        </form>
    <?php
		if ($warning1) echo ' <strong class="red">Vyber obrázek</strong><br />';
		if ($warning2) echo ' <strong class="red">Vyplň název souboru</strong><br />';
	}
	else //item nahrán
	{
		$spojeni->query("SET CHARACTER SET utf8");
		$spojeni->query("INSERT INTO items (nazev, popis, kategorie, verejne, obrazek) VALUES ('".$_REQUEST['nahr_nazev']."', '".$_REQUEST['nahr_popis']."', '".$_REQUEST['nahr_cat']."', '".$_REQUEST['nahr_verejne']."', '".$fileName."')");
        echo '<p>Položka byla nahrána do databáze.</p>';
	}
	?>
    </div>
<?php } ?>

</body>
</html>