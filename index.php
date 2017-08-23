<?php
$headers = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="help/styles/index.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="getMyTime().js" type="text/javascript"></script>
<script src="campDate.js" type="text/javascript"></script>
<title>Tábory Vlčat</title>';

$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
$passwd = isset($_REQUEST['passwd']) ? $_REQUEST['passwd'] : "";
$prezdivka_min_strlen = 2;


function someKey()
{
	$key = '';
	for ( $i  = 0; $i < 18; $i++ )
		$key .= rand( 0, 1) ? chr( rand( 97, 122 ) ) : rand( 0, 9 );
	return $key;
}


$logged_failed = -1;
$valid_account = -1;
$bad_mail = false;
$send = false;
$color_border = "green";
$megaWin = false;
$megaNum = -4;
$tatrKey = NULL;

if ( !file_exists("promenne.php") )
{
	echo $headers."The file <strong>promenne.php</strong> does not exist.<br />";
} else {
	require( "promenne.php" );
	//ověření uživatele
	if ( isset( $_REQUEST['name'] ) && !isset($_REQUEST['smail']) )
	{
		$spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name );
		if($spojeni)
		{
			$logged_failed = 1;
			$spojeni->query("SET CHARACTER SET utf8");
			$sql = $spojeni->query("SELECT * FROM vlc_users WHERE nick = '".$_REQUEST['name']."' && passwd = '".$_REQUEST['passwd']."'");
			$uzivatel = mysqli_fetch_array($sql);
			if ( $uzivatel )
			{
				$logged_failed = false;
				
				if ( $uzivatel['platnost'] == 1 )
				{
					$valid_account = true;
					if ( isset($_REQUEST['login_into_web']) && file_exists("getMyTime().php" ) )
					{
						require( "getMyTime().php" );
						//$spojeni->query("UPDATE vlc_last_log SET date='".getMyTime()."', IP_address='".$_SERVER['REMOTE_ADDR']."' WHERE mail='".$uzivatel['mail']."'");
						$spojeni->query("INSERT INTO vlc_syslog ( user_id, date, IP_address, typ ) VALUES ( '".IDFromNick($name, $spojeni)."', '".getMyTime()."', '".$_SERVER['REMOTE_ADDR']."', '".(stripos($_SERVER["HTTP_USER_AGENT"], "mobile") !== false ? 'mobile' : 'PC')."' )");
						
						$sql = mysqli_fetch_array($spojeni->query( "SELECT count(*) CNT FROM vlc_syslog" ));
						if ( $sql['CNT'] % 100 == 0 )
						{
							$megaWin = true;
							$megaNum = $sql['CNT'];
							$tatrKey = someKey();
							$spojeni->query( "INSERT INTO vlc_tatranky ( tatrKey, kdo, kdy ) VALUES ( '".$tatrKey."', '".IDFromNick( $_REQUEST['name'], $spojeni )."', '".getMyTime()."' )" );
						}
						
					}
				}
				else $valid_account = false;
			}						  
		}
		else echo $headers.'<p>Databázi s registrovanými uživateli nelze najít<br />Kontaktujte správce: '.$spravce.'</p>';
	}

if ( isset($_REQUEST['ssend']) )
{
	if ( !filter_var($_REQUEST['smail'], FILTER_VALIDATE_EMAIL) ) $bad_mail = true;
	else {
		$to = $_REQUEST['smail'];
		$subject = "Account activation";
		$message = 'http://vlcata.pohrebnisluzbazlin.cz/activation.php?j='.$_REQUEST['name'].'&d='.$_REQUEST['smail'];
		$headers = 'From: 51. Smečka Vlčat <'.$spravce .'>';
		
		mail($to, $subject, $message, $headers);
		$send = true;
	}
}


$warning_change = false;
$warning_change1 = false;
$warning_change2 = false;
if ( isset($_REQUEST['changeNick']) )
{
	$warning_change1 = true;
	if ( strlen(trim($_REQUEST['changedNick'])) >= $prezdivka_min_strlen )
	{
		$warning_change1 = false;
		$warning_change2 = true;
		if ( $spojeni->query( "UPDATE vlc_users SET nickname= '".$_REQUEST['changedNick']."' WHERE nick = '".$name."'" ) ) $warning_change2 = false;
	}
}
if ( $warning_change1 || $warning_change2 ) $warning_change = true;


if ( $logged_failed && !isset($_REQUEST['ssend']) ) {
	echo $headers;?>
</head>
<body id="body">
<div id="login">
<form method="post" id="loginn">
<table rules="none">
    <tr><td><label>Nick: </td><td><input name="name" type="text" value="<?php echo $name;?>" id="focusHere"/></label></td></tr>
    <tr><td><label>Heslo: </td><td><input name="passwd" type="password" /></label></td></tr>
    <tr><td><button type="submit" name="login_into_web">Přihlásit</button></td><td><a href="forgot_passwd.php" title="nechat si poslat heslo na mail">Zapomenuté heslo</a><br /><a href="change_passwd.php" title="umožňuje změnit si heslo">Změnit heslo</a></td></tr>
</table>
</form>
</div>
<?php } else if ( (!$logged_failed && !$valid_account) || $bad_mail ) { 
	echo $headers;?>
  </head>
  <body id="body">
	<div id="login2">
    	<button id="back"><a href="index.php">zpět</a></button>
		<form id="sendmail" method="post">
        	<p id="activation2">Nemáte aktivovaný účet.</p><br />
            <input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
            <label>Váš mail: <input id="smail" type="text" name="smail" value="<?php if ( $bad_mail ) echo $_REQUEST['smail']; ?>" /></label><br />
            <button style="margin-top:10px;" type="submit" name="ssend">Poslat e-mail s aktivací</button>
        </form>
	</div>

<?php } else if ( isset($_REQUEST['ssend']) ) {
		echo $headers;?>
  </head>
  <body id="body">
	<div id="login">
    	<button id="back"><a href="index.php">zpět</a></button>
		<?php if ( $send ) { ?>
        <p id="activation">E-mail byl zaslán na adresu <?php echo $_REQUEST['smail']; ?></p><?php }
		else {?>
        <p id="activation">Něco se pokazilo. Email neposlán.</p>
		<?php }?>
	</div>

<?php } else if ( !$logged_failed && $valid_account ) { //HEURECA successfully logged in
	$included = false;
	foreach( get_included_files() as $file ) {
		if ( strpos($file, 'getMyTime().php') ) $included = true;
	}
	if ( file_exists('getMyTime().php') && !$included ) require('getMyTime().php');
	
	$spojeni->query( "SET CHARACTER SET UT8" );
	//if there is a line in vlc_relog, redirect to this URL
	/*$sql = $spojeni->query( "SELECT * FROM `vlc_relog` WHERE id=( SELECT MAX(id) FROM vlc_relog WHERE ip='".$_SERVER['REMOTE_ADDR']."' )" );
	$redirect = mysqli_fetch_array( $sql, MYSQLI_ASSOC );
	if ( $redirect['logged'] == 0 ) {
		$spojeni->query( "UPDATE vlc_relog SET modified='".getMyTime()."', logged=1 WHERE id=".$redirect['id'] );
		$URL = $redirect['URL'];
		$URL .= count(explode( '?', $URL)) == 2 ? ('&') : '?';
		$URL .= 'name='.$name.'&passwd='.$passwd;
		//header( "Location: ".$URL );
		//die();
	}*/

	$clovek = mysqli_fetch_array( $spojeni->query("SELECT name, sname, nick, nickname FROM vlc_users WHERE nick ='".$name."'") );
	echo $headers;
	echo '<h1>'.$clovek['nickname'].' - '.$clovek['name'].' '.$clovek['sname'].'</h1>';
?>
<p id="tabor"></p>
<script>
	document.getElementById("tabor").innerHTML = countdown( year, mon, day, hod, mnt, sec, true, "<strong>Do tábora zbývá</strong> " );
	setInterval(function(){
		document.getElementById("tabor").innerHTML = countdown( year, mon, day, hod, mnt, sec, true, "<strong>Do tábora zbývá</strong> " );
		/*
		year + " " + mon + " " + day + " " + hod + " " + mnt + " " + sec + " <strong>Do tábora zbývá</strong> ";
		*/
	}, 1000);
	
	
	function showChangeNick()
	{
		$("#ChangeNickForm").slideToggle();
	};
</script>
	
    
  <div id="menicko">
		<form method="post" action="aboutMe.php">
			<input type="hidden" name="name" value="<?php echo $name; ?>" />
			<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
			<button id="back_img"></button>
		</form>
		<?php
		if ( isAdmin( $name, $spojeni ) ) {?>
		<div id="syslog">
      <form method="post" action="syslog.php">
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
        <button>Syslog</button>
      </form>
      
      <form method="post" action="help/createNewUser.php">
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
        <button>Create new user</button>
      </form>
      
      <form method="post" action="help/updateUser.php">
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
				<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
        <button>Update user</button>
      </form>

			<form method="post" action="help/seeLogs.php">
        <input type="hidden" name="name" value="<?php echo $name; ?>" />
        <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
      	<button>See logs</button>
      </form>
      
      <a href="./help/scripty/deleteCamp.php?year=<year>&path=../../" title="/help/scripty/deleteCamp.php?year=<year>&path=../../">DeleteCamp</a>
    </div>
		<?php }?>
		
		<div id="comments">
		<form method="post" action="commentars.php">
			<input type="hidden" name="name" value="<?php echo $name; ?>" />
			<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
			<button title="přidat komentář pro vývoj webu?">Komentáře</button>
		</form>
		</div>
		
    <div id="change_nick">
			<button title="" onClick="showChangeNick()">Změnit přezdívku</button>
		</div>
		
    <form id="logout">
			<button type="submit">Odhlásit</button>
		</form> 
  </div>
    
    
    <div id="ChangeNickForm">                
		<?php if ( !isset($_REQUEST['changeNick']) || $warning_change ) {?>
            <form method="post" action=".">
                <input type="hidden" name="name" value="<?php echo $name; ?>" />
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                <label>Nová přezdívka: <input type="text" name="changedNick" /></label><br  />
                <button name="changeNick">Změnit přezdívku</button>
                <?php if ( $warning_change1 ) echo '<br /><span class="red">Špatný formát přezdívky. Alespoň '.$prezdivka_min_strlen.' znaků.</span>'; ?>
                <?php if ( $warning_change2 ) echo '<br /><span class="red">Přesdívka nemohla být změněna.</span>'; ?>
            </form>
		<?php } else { ?>
            	<p>Přezdívka byla změněna</p>
                <button onClick="showChangeNick()">OK</button>
        <?php } ?>
    </div>
    
    
    
        
	<div id="menu">
	<?php
		$dirs = array_filter( glob( "*", GLOB_ONLYDIR ) );
		for ( $i = 0; $i < sizeof($dirs); $i++ )
		{
			if ( $dirs[$i] == "Inventar" )
			{?>
            	<form method="post" action="Inventar/">
               	<input type="hidden" name="name" value="<?php echo $name; ?>" />
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                <button id="inventar">Inventář</button>
				</form><?php  
			}
        }
        for ( $i = 0; $i < sizeof($dirs); $i++ )
		{
			if ( $dirs[$i] == "Inventar" || $dirs[$i] == "utrata" || $dirs[$i] == "help" ) continue;
			else
			{?>
            	<form method="post" action="./<?php echo $dirs[$i]; ?>/">
               	<input type="hidden" name="name" value="<?php echo $name; ?>" />
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
                <button class="tabor_rok"><?php echo $dirs[$i]; ?></button>
				</form><?php
			}
		}?>
	</div>
    
    
    
    
    
    
    
    				<?php
                    	if ( $megaWin )
						{
							echo '<div id="megawin" onclick="$(this).hide()">';
							echo '<p><br>Blahopřeni.<br>Na stránku ses přihlásil v celkovém pořadí '.$megaNum.'.<br>Kód k tatrance: <code style="font-family:monospace" class="red">'.strtoupper($tatrKey).'</code><br>napiš si ho a Krtek Ti ji jistě rád dá</p>';
							echo '</div>';
						}
                    ?>
    
    <div id="makeCamp">
    	<label for="makeCampYear">Vytvořit tábor, který začíná v: </label>
      <input type="date" name="year" value="yyyy-mm-dd" tyle="max-width:72px;" id="makeCampYear" />
      <input type="submit" name="make" value="Vytvořit" onClick="makeCamp( 'makeCamp' )"/>
    </div>
    
<?php }
}//promenne.php exists ?>
<script>
<?php if ( !isset($_REQUEST['changeNick']) ) { ?>
	$("#ChangeNickForm").hide();
<?php } ?>
function makeCamp( where )
{
	var date = document.getElementById( 'makeCampYear' ).value;
	if ( date == '' ) return;
	var tmp = date.split( '-' );
	if ( tmp.length != 3 )
	{
		alert( "Špatný formát data" );
		return;
	}
	var year = tmp[0];
	var month = tmp[1];
	var dday = tmp[2];
	
	if ( parseInt(dday) != dday || dday < 1 || dday > 31 )
	{
		alert( 'Den neodpovídá předpokladům' );
		return;
	}
	
	if ( parseInt(month) != month || month < 1 || month > 12 )
	{
		alert( 'Měsíc neodpovídá předpokladům' );
		return;
	}
	
	if ( parseInt(year) != year || year < new Date().getFullYear() )
	{
		alert( "Rok neodpovídá předpokladům" );
		return;
	}
	
	
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "help/scripty/makeCamp.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "year=" + year + "&month=" + month + "&day=" + dday + "&whoCreated=<?= $name; ?>" );
}



$("#inventar").mousedown(function(){
	vrch = $(this).css("margin-top");
	spod = $(this).css("margin-bottom");
	$(this).css("margin-top", parseInt(vrch) + 10 + "px");
	$(this).css("margin-bottom", parseInt(spod) - 10 + "px");
});
$(".tabor_rok").mousedown(function(){
	vrch = $(this).css("margin-top");
	spod = $(this).css("margin-bottom");
	$(this).css("margin-top", parseInt(vrch) + 10 + "px");
	$(this).css("margin-bottom", parseInt(spod) - 10 + "px");
});
$("#inventar").mouseup(function(){
	vrch = $(this).css("margin-top");
	spod = $(this).css("margin-bottom");
	$(this).css("margin-top", parseInt(vrch) - 10 + "px");
	$(this).css("margin-bottom", parseInt(spod) + 10 + "px");
});
$(".tabor_rok").mouseup(function(){
	vrch = $(this).css("margin-top");
	spod = $(this).css("margin-bottom");
	$(this).css("margin-top", parseInt(vrch) - 10 + "px");
	$(this).css("margin-bottom", parseInt(spod) + 10 + "px");
});
</script>


<script type="text/javascript">
	$( "#login" ).css( 'top', '50%' );
	$( "#focusHere" ).focus();
	<?php
		if ( $logged_failed == 1 ) echo 'document.getElementById( "login" ).style.borderColor = "red";
	document.getElementById( "login2" ).style.borderColor = "red";';
		if ( $bad_mail ) echo 'document.getElementById( "login" ).style.border = "solid red 1px";';
	?>
</script>
<noscript>
	<h1>Pro tento web je nutné mít zapnutý javascript</h1>
</noscript>
</body>
</html>