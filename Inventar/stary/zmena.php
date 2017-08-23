<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$jmeno = $_REQUEST['jmeno'];
	$heslo = $_REQUEST['heslo'];
	$prezdivka = $_REQUEST['prezdivka'];
	
	$stare_udaje = false;
	$warning1 = false;
	$warning2 = false;
	$warning3 = false;
	$zmeneno = false;
?>
<title>Změna osobních údajů</title>
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
<h1>Změna hesla - <?php echo $prezdivka;?></h1>
<?php
if (!file_exists('promene.php'))
{
	echo '<div class="oznameni"><h3><strong>Omlouvám se, ale databáze není k dispozici. Kontaktujte prosím správce (krtek@zlin6.cz).</strong></h3></div>';
}
else
{
	require('promene.php');
	if (isset($_REQUEST['zmena_potvrdit']))
	{
		$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
		$spojeni->query("SET CHARACTER SET UTF8");
		$sql = $spojeni->query("SELECT * FROM users");
		while ($uzivatel = mysqli_fetch_array($sql))
		{
			if ($_REQUEST['stav_jmeno'] == $uzivatel['email'] && $_REQUEST['stav_heslo'] == $uzivatel['heslo'])
			{
				$stare_udaje = true;
			}
		}
		if (!$stare_udaje) $warning1 = true;
		else
		{
			if ($_REQUEST['nove_heslo1'] != $_REQUEST['nove_heslo2']) $warning2 = true;
			else if ($_REQUEST['nove_heslo1'] == '' || $_REQUEST['nove_heslo2'] == '') $warning3 = true;
			else
			{	
				$zmeneno = true;
				$sql = $spojeni->query("UPDATE users SET heslo = '".$_REQUEST['nove_heslo1']."' WHERE prezdivka = '".$prezdivka."'");
				echo '<p class="red" id="items"><strong>Heslo bylo změněno.</strong><p>';
				$heslo = $_REQUEST['nove_heslo1'];
			}
		}
	}
	
	
	
	
	?>
	<div class="right">
    	<form method="post" action="index.php">
            <input name="jmeno" value="<?php echo $jmeno?>" type="hidden" />
            <input name="heslo" value="<?php echo $heslo?>" type="hidden" />
            <button type="submit" name="odeslat" class="menu">Zpět na inventář</button>
        </form>
    </div>
    
    <?php if (!$zmeneno)
	{?>
    <div id="items">
    <h2>Uživatel <?php echo $prezdivka;?></h2>
    <table rules="none">
    	<form  method="post">
        	<tr><td><label>Stávající přihlašovací jméno: </td><td><input name="stav_jmeno" value="<?php if (isset($_REQUEST['stav_jmeno'])) echo $_REQUEST['stav_jmeno']?>" /></label></td></tr>
            <tr><td><label>Stávající heslo: </td><td><input name="stav_heslo" type="password"/></label></td></tr>
            
            <tr><td><label>Nové heslo: </td><td><input name="nove_heslo1" type="password" /></label></td></tr>
            <tr><td><label>Ověření hesla: </td><td><input name="nove_heslo2" type="password" /></label></td></tr>
            
        	<input name="jmeno" value="<?php echo $jmeno?>" type="hidden" />
            <input name="heslo" value="<?php echo $heslo?>" type="hidden" />
            <input name="prezdivka" value="<?php echo $prezdivka?>" type="hidden" />
            <tr><td><button type="submit" name="zmena_potvrdit">Změnit</button></td></tr>
        </form>
    </table>
    <?php
	}
    	if ($warning1) echo '<p class="red"><strong>Špatné stávající přihlašovací údaje</strong></p>';
		if ($warning2) echo '<p class="red"><strong>Hesla se neshodují.</strong></p>';
		if ($warning3) echo '<p class="red"><strong>Heslo nemůže být prázdné.</strong></p>';
	?>
	</div>
<?php }?>
</body>
</html>