<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upravit položku</title>
<?php
	$jmeno = $_REQUEST['jmeno'];
	$heslo = $_REQUEST['heslo'];
	$ID = $_REQUEST['upravit_prispevek'];
	
	$nazev = $_REQUEST['nazev'];
	$popis = $_REQUEST['popis'];
	$category = $_REQUEST['cat'];
	$verejne = $_REQUEST['verejne'];
	
	$item_nahran = false;
	$warning = false;
	if (isset($_REQUEST['upravit']) && $_REQUEST['nazev'] == '') $warning = true;
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
</style>
</head>
<body id="body">
<h1>Upravit položku z inventáře</h1>
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
            <input name="jmeno" value="<?php echo $jmeno?>" type="hidden" />
            <input name="heslo" value="<?php echo $heslo?>" type="hidden" />
            <button type="submit" name="odeslat">Zpět na inventář</button>
        </form>
    </div>
    
    <div id="items">
    <?php if ($warning || !isset($_REQUEST['upravit']))
	{ ?>
        <form method="post">
        <h2>
		<?php 
		if ($spojeni)
		{
			$spojeni->query("SET CHARACTER SET utf8");
			$sql = $spojeni->query("SELECT * FROM items WHERE ID = ".$ID);
			while ($cat = mysqli_fetch_array($sql))
			{
				echo $cat['nazev'].'&nbsp;&nbsp;&nbsp;&nbsp;#'.$ID;
			}
			?>
            </h2>
            <p>Kategorie:        	
            <select name="cat" size="1">
			<?php
                $spojeni->query("SET CHARACTER SET utf8");
                $sql = $spojeni->query("SELECT * FROM kategory");
                while ($cat = mysqli_fetch_array($sql))
                {
					$option = '<option value="'.$cat['jmeno'].'"';
					if ($category == $cat['kategorie_nazev']) $option .= ' selected="selected"';
					$option .= '>'.$cat['kategorie_nazev'].'</option>';
                    echo $option;
                }
      	}
            ?>
            </select></p><br />
            <p>Veřejné:
            <select name="verejne" size="1">
                <option value=1 <?php if ($verejne = 1) echo 'selected="selected"'?>>ANO</option>
                <option value=0 <?php if ($verejne = 2) echo 'selected="selected"'?>>NE</option>
            </select>&nbsp;(toto uvidí rodiče)</p><br />
            <p><label> Název:<strong class="red">*</strong> <input name="nazev" value="<?php if (isset($_REQUEST['nazev'])) echo $_REQUEST['nazev'];?>" /></label></p><br />
            <p><label>Popis: <textarea name="popis"><?php if (isset($_REQUEST['popis'])) echo $_REQUEST['popis'];?></textarea></label></p><br />
            <input name="jmeno" value="<?php echo $jmeno?>" type="hidden" />
            <input name="heslo" value="<?php echo $heslo?>" type="hidden" />
            <input name="upravit_prispevek" value="<?php echo $ID?>" type="hidden" />
            <button name="upravit">Upravit</button> <em class="red">*Povinné pole</em></p><br />
        </form>
    <?php

		if ($warning) echo ' <strong class="red">Vyplň název souboru</strong><br />';
	}
	else
	{
		$spojeni->query("SET CHARACTER SET utf8");
		$spojeni->query("UPDATE items SET popis = '".$_REQUEST['popis']."', kategorie = '".$_REQUEST['cat']."', verejne = '".$_REQUEST['verejne']."', nazev = '".$_REQUEST['nazev']."'  WHERE ID = ".$ID);
        echo '<p>Položka byla upravena.</p>';
		echo '<p><br /><br />
			<strong>Název:</strong> '.$_REQUEST['nazev'].'<br />
			<strong>Popis:</strong> '.$_REQUEST['popis'].'<br />
			<strong>Kategorie:</strong> '.$_REQUEST['cat'].'<br />
			<strong>Veřejné:</strong> '.$_REQUEST['verejne'].'</p>';
	}
	?>
    </div>
<?php } ?>
</body>
</html>