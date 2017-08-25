<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
<script src="scripty/dbConn.js" type="text/javascript"></script>
<script src="../help/scripty/harmonogram.js" type="text/javascript"></script>
<script src="../help/scripty/cleni.js" type="text/javascript"></script>
<script src="../relogin.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="styles/uvod.css" />
<link rel="stylesheet" type="text/css" href="styles/harmonogram.css" />
<link rel="stylesheet" type="text/css" href="styles/myslenkova_mapa.css" />
<link rel="stylesheet" type="text/css" href="styles/ukoly.css" />
<link rel="stylesheet" type="text/css" href="styles/jidelnicek.css" />
<link rel="stylesheet" type="text/css" href="styles/cleni.css" />
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<title>Tábor Vlčat 2017</title>
<?php
if ( !isset($_REQUEST['name']) || !isset($_REQUEST['passwd']) ) {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>' );</script>
  <?php
	//if ( file_exists('../relogin.php') && require('../relogin.php') ) relogin( $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], '..' );
	echo '<h1><a href="../">Zřejmě jste se zapomněli přihlásit</a></h1>';
}
else {
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
	
	$moznosti = array( 'Úvodní stránka', 'Harmonogram', 'Úkoly pro rádce'/*, 'long string as road3', 'long string as road2'*/ );
	$dalsi = array('Jídelníček', 'Členi na táboře' );
	$odkazy = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
	$prvni_rada_soubory = array('short string', 'short string', 'short string', 'short string' );
	$druha_rada_soubory = array('short string');
	
	
	?>
	</head>
	<body>
	<form method="post" action="../" id="form_back">
	<input type="hidden" name="name" value="<?php echo $name;?>"/>
	<input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
	<button type="submit" name="back" id="back"></button>
	</form>
	
	
	<div class="div_menu" style="width:1000px; margin-left:68vw;">
	<div id="menu_blue" onClick="$('#menu_red').slideToggle('slow');">
		<br />
		M<br />
		E<br />
		N<br />
		U<br />&nbsp;
	</div>
		  
	<div id="menu_red">
		<table rules="none" id="table_menu">
			<?php $cnt = 1;
			foreach ( $moznosti as $each)
			{?>
            	<tr><td>
                    <form method="post" action="?o=<?php echo $cnt; ?>">
                    <input type="hidden" name="name" value="<?php echo $name; ?>" />
                    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                    <button class="menu"><?php echo $each; ?></button>
                    </form>
                </td></tr><tr></td>
				<?php
				if ( $each == 'long string as road2' )
				{
					$vnt = 1;
					foreach ( $prvni_rada_soubory as $rada_1)
				  {?>
					  <tr><td>
                      	<form method="post" action="?o=<?php echo $cnt; ?>&pod=<?php echo $vnt; ?>">
                    	<input type="hidden" name="name" value="<?php echo $name; ?>" />
                    	<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                    	<button class="menu_modre"><?php echo $rada_1; ?></button>
                    	</form></td><td class="odsadit">•</td></tr>
					<?php
					$vnt++;
				  }
				}
				else if ( $each == 'long string as road3' )
				{
					$vnt = 1;
					foreach ( $druha_rada_soubory as $rada_2 )
					{?>
						<tr><td>
                        	<form method="post" action="?o=<?php echo $cnt; ?>&pod=<?php echo $vnt; ?>">
                    		<input type="hidden" name="name" value="<?php echo $name; ?>" />
                    		<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                    		<button class="menu_modre"><?php echo $rada_2; ?></button>
                    		</form>
                    	</td><td class="odsadit">•</td></tr>
						<?php
						$vnt++;
					}
				}
				$cnt++;
			}
			foreach ( $dalsi as $each)
			{?>
				<tr><td>
                	<form method="post" action="?o=<?php echo $cnt; ?>">
                    <input type="hidden" name="name" value="<?php echo $name; ?>" />
                    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                    <button class="menu_dalsi"><?php echo $each; ?></button>
                    </form></td></tr>
				<?php 
				$cnt++;
			}?>
		</table>
	</div>
	</div><!--div_menu-->
	
	<script type="text/javascript">
	var i = 0;
	$("#menu_red").hide();
	
	
	$("#menu_blue").click(function()
	{
		if (i % 2 == 0)
		{
			$("#menu").css("width", '99%');
		}
		else
		{
			$("#menu").css("width", '1%');
		}
		i++;
	});
	$("#moxo-cz").hide();
	</script>
	
	
	
	
	
	
	<?php if ( !isset($_REQUEST['o']) || $_REQUEST['o'] == 1 ) { 
		if ( file_exists('uvod.php') ) require('uvod.php');
		else echo '<h1 style="text-align:center; font-size:36px;">Vítej na táboře 2017. Využij menu vravo</h1>';
	 } else {
		switch ( $_REQUEST['o'] )
		{
			case 2:
				$pripoj_soub = "harmonogram.php";
				break;
			case 3:
				$pripoj_soub = 'ukoly.php';
				break;
			case 4:
				$pripoj_soub = "jidelnicek.php";
				break;
			case 5:
				$pripoj_soub = "cleni.php";
				break;
			default:
				$pripoj_soub = "uvod.php";
				break;
		}
		
		if ( isset($pripoj_soub) ) {
			if ( file_exists( $pripoj_soub ) ) require( $pripoj_soub );
			else echo "<p>Soubor <strong>".$pripoj_soub."</strong> nebyl nalezen.</p>";
		}
	}
}?>
</body>
</html>