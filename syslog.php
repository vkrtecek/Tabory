<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<title>Syslog</title>
<style>
body::after{
	content: "";
	background: url('soubory/background.jpg') no-repeat;
	background-attachment: fixed;
	opacity: 0.25;
	top: 0;
	left: 0;
	position:fixed;
	z-index: -1;
	background-color: #CCC;
	width:100%;
	height:100%;
	background-size:100%;
}
*{ margin:0; padding:0; font-family:"Courier New", Courier, monospace; font-size:12px; }
#back{ position:absolute; top:2vh; right:0.5vw; max-width:70px; }
#back > a{ color:black; text-decoration:none; font-size:14px; }
#NR{ position:absolute; top:3vh; right:15vw; }

#syslog_table{ border:solid black 2px; margin-bottom:20px; }
#main_div{ margin-left:30px; margin-top:2vh; }
td{ column-rule:dashed; padding: 2px 5px 2px 5px;}
th{ padding: 2px 5px 2px 5px; font-family:Verdana, Geneva, sans-serif; }
tr th{ background-color:#CCC; }
tr.sude{ background-color:#FFF; }
tr.odd{ background-color:#DDD; }
tr:hover td{ background-color:yellow; }

#last_login_page{ position:absolute; border:solid black 2px; top:10%; right:30px; }

#hidden button{
	position:absolute;
	right:3px;
	bottom:2px;
	width:1vw;
	height:2vh;
	max-width:10px;
	max-height:10px;
}
</style>
</head>
<body>
<?php
if ( ( isset($_REQUEST['name']) && isset($_REQUEST['passwd']) ) || isset($_REQUEST['success']) ) {
$name= $_REQUEST['name'];
$passwd = $_REQUEST['passwd'];
?>
<form method="post" action="./" id="back">
<input type="hidden" name="name" value="<?php echo $name;?>"/>
<input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
<button type="submit" name="back">Zpět na rozcestník</button>
</form>
<?php
if ( file_exists( "promenne.php" ) )
{
	require( "promenne.php" );
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if($spojeni)
	{
		echo '<div id="main_div">';
		echo '<table rules="all" id="syslog_table">';
		echo '<tr><th colspan="7">Syslog</th></tr>';
		echo '<tr><th>ID</th><th>Name</th><th>Surname</th><th>E-mail address</th><th>date of login</th><th>IP address</th><th>Typ</th></tr>';
		$cnt = 0;
		$spojeni->query("SET CHARACTER SET utf8");
		$sql = $spojeni->query("SELECT * FROM vlc_syslog S LEFT JOIN vlc_users U ON U.id = S.user_id");
		while ($uzivatel = mysqli_fetch_array($sql))
		{
			$item = '<tr';
			$item .= ( $cnt % 2 != 0 ) ? ' class="odd" ' : ' class="sude"';
			$item .= '><td>'.(++$cnt).'</td><td>'.$uzivatel['name'].'</td><td>'.$uzivatel['sname'].'</td><td>'.$uzivatel['mail'].'</td><td>'.dateToReadableFormat($uzivatel['date']).'</td><td>'.$uzivatel['IP_address'].'</td><td>'.$uzivatel['typ'].'</td></tr>';
			echo $item;
		}
		echo '</table>';
		echo '</div>';
		echo '<div id="NR">NR: '.$cnt.'</div>';
		
		
		$cnt = 0;
		echo '<table rules="all" id="last_login_page">';
		echo '<tr><th colspan="4">Last login</th></tr>';
		echo '<tr><th>Nick</th><th>Date</th><th>E-mail address</th><th>Přihlášen</th></tr>';
		$spojeni->query("SET CHARACTER SET utf8");
		//$sql = $spojeni->query("SELECT * FROM vlc_last_log ORDER BY date DESC");
		$sql = $spojeni->query( "SELECT DISTINCT U.nick, U.nickname, (SELECT max(date) FROM vlc_syslog WHERE user_id = U.id) datum, U.mail, (SELECT count(*) FROM vlc_syslog WHERE user_id=U.ID) CNT FROM vlc_syslog S LEFT JOIN vlc_users U ON S.user_id = U.id WHERE U.platnost = 1
UNION
SELECT DISTINCT nick, nickname, '0' datum, mail, '0' FROM vlc_syslog RIGHT JOIN vlc_users ON user_id = vlc_users.id WHERE platnost= 1 AND user_id IS NULL ORDER BY datum DESC, nickname" );
		while ($uzivatel = mysqli_fetch_array($sql))
		{
			echo  '<tr class="';
			echo $cnt % 2 == 0 ? 'odd' : 'sude';
			//echo '"><td>'.toHacky( $uzivatel['nick'], $spojeni ).'</td><td>'.dateToReadableFormat($uzivatel['date']).'</td><td>'.$uzivatel['mail'].'</td><td>'.$uzivatel['IP_address'].'</td></tr>';
			echo '"><td>'.toHacky( $uzivatel['nick'], $spojeni ).'</td><td>'.dateToReadableFormat($uzivatel['datum']).'</td><td>'.$uzivatel['mail'].'</td><td>'.$uzivatel['CNT'].'&times;</td></tr>';
			$cnt++;
		}
		echo '</table>';
	}
	else echo '<p>Databázi s registrovanými uživateli nelze najít<br />Kontaktujte správce: '.$spravce.'</p>';
}
else echo "<p>Nenalezen soubor <strong>promenne.php</strong></p>";
?>
<script>
	var sirka0 = $(window).width();
	var sirka1 = $("#last_login_page").width();
	var sirka2 = $("#syslog_table").width();
	var sirka_tables = sirka1 + sirka2 + 68;
	if ( sirka_tables > sirka0 ){
		var odsazeni = parseInt($("#main_div").css("margin-top"));
		var odsazeni2 = parseInt($('#last_login_page').css("top"));
		var vyska = $("#last_login_page").height();
		var nove_odsazeni = odsazeni + odsazeni2 + vyska;
		$("#syslog_table").css("margin-top", nove_odsazeni);
		$("#last_login_page").css("left", 30);
		
		alert( "Nutno odsadit." );
	};
</script>
<?php } else { ?>
<form method="post" id="hidden">
<input type="hidden" name="name" value="<?php echo $name;?>"/>
<input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
<button name="success"></button>
</form>
<?php } ?>
</body>
</html>