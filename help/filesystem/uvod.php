<h1>Vítej na táboře YearToSubStr. Využij menu vpravo</h1>


<?php 
if ( file_exists( "../promenne.php" ) )
{
	require( "../promenne.php" );
	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name);
	if($spojeni)
	{
		$subject = $message = 'Povinné pole';
		$w_sub = $w_mess = false;
		if ( isset($_REQUEST['sent']) )
		{
			if ( $_REQUEST['subject'] == '' || $_REQUEST['subject'] == $subject ) $w_sub = true;
			if ( $_REQUEST['message'] == '' || $_REQUEST['message'] == $message ) $w_mess = true;
		}
		
		?>
        <div id="e-mail">
        <?php
		if ( !isset($_REQUEST['sent']) || $w_sub || $w_mess ) {
		?>
        <h3>Formulář na stížnosti</h3>
        <form method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            <label for="for">Pro: </label>
            <select name="for" id="for">
            <?php
                $spojeni->query("SET CHARACTER SET utf8");
				$sql = $spojeni->query("SELECT * FROM vlc_users ORDER BY mail");
				while ($mail = mysqli_fetch_array($sql))
				{
					if ( $mail['platnost'] && $mail['mail'] != '' )
					{
						echo '<option';
						if ( strtolower($mail['nick']) == $name ) echo ' selected="selected"';
						echo '>'.$mail['mail'].'</option>';
					}
				}
			?>
            </select><br />
            <label for="sub">Předmět: </label><input id="sub" type="text" name="subject" value="<?php echo isset($_REQUEST['subject']) ? $_REQUEST['subject'] : $subject; ?>"/><br />
            <label for="mess">Text: </label>
            <textarea id="mess" name="message" rows="5" cols="50"><?php echo isset($_REQUEST['message']) ? $_REQUEST['message'] : $message; ?></textarea><br />
            <button name="sent">Odeslat</button>
            <?php
			if ( $w_sub ) echo '<p class="red">Vyplň předmět</p>';
			if ( $w_mess ) echo '<p class="red">Vyplň text zprávy</p>';
			?>
        </form>
        
        <script>
		var subj = '<?php echo $subject; ?>';
		var get_sub = $("#sub").val();
		if ( get_sub == subj )
		{
			$("#sub").css( "font-family", "monospace" );
			$("#sub").css( "color", "grey" );
		}
		$("#sub").focus(function(){
			var content = $(this).val();
			if ( content == subj )
			{
				$(this).val( "" );
				$(this).css( "font-family", "sans-serif" );
				$(this).css( "color", "black" );
			}
		});
		$("#sub").focusout(function(){
			var content = $(this).val();
			if ( content == "" )
			{
				$(this).val( subj );
				$(this).css( "font-family", "monospace" );
				$(this).css( "color", "grey" );
			}
		});
		
		
		
		var mess = '<?php echo $message; ?>';
		var get_mess = document.getElementById("mess").value;
		if ( get_mess == mess )
		{
			$("#mess").css( "font-family", "monospace" );
			$("#mess").css( "color", "grey" );
		}
		$("#mess").focus(function(){
			var content = document.getElementById("mess").value;
			if ( content == mess )
			{
				document.getElementById("mess").innerHTML = "";
				$(this).css( "color", "black" );
			}
		});
		$("#mess").focusout(function(){
			var content = document.getElementById("mess").value;
			if ( content == "" )
			{
				document.getElementById("mess").innerHTML = mess;
				$(this).css( "color", "grey" );
			}
		});
		</script>
        <?php 
		} else  { ?>
        <h3>Stížnost byla odeslána na <?php echo $_REQUEST['for']; ?></h3>
        <?php 
		
		//send email
		$spojeni->query("SET CHARACTER SET utf8");
		$sql = $spojeni->query("SELECT * FROM vlc_users ORDER BY mail");
		while ($mail = mysqli_fetch_array($sql))
		{
			if ( strtolower($mail['nick']) == $name ) $send_from = $mail['mail'];
		}
		
		
		require('../getMyTime().php');
		$to = $_REQUEST['for'];
		$subject = 'Vlcata YearToSubStr - stížnost - '.$_REQUEST['subject'];
		$sender = 'From: '.$name.'<'.$send_from.'>\n';
		$after = '
			

(Time: '.getMyTime().')';
		$message = wordwrap($_REQUEST['message'], 70, "\r\n", false);
		$message = $_REQUEST['message'].$after;
		
				function autoUTF($s)
				{
					// detect UTF-8
					if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
						return $s;
					// detect WINDOWS-1250
					if (preg_match('#[\x7F-\x9F\xBC]#', $s))
						return iconv('WINDOWS-1250', 'UTF-8', $s);
					// assume ISO-8859-2
					return iconv('ISO-8859-2', 'UTF-8', $s);
				}
				 
				function cs_mail ($to, $subject, $message, $headers = "")
				{
					$subject = "=?utf-8?B?".base64_encode( autoUTF($subject))."?=";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
					$headers .= "Content-Transfer-Encoding: base64\n";
					$message = base64_encode ( autoUTF($message));
					return mail($to, $subject, $message, $headers);
				}
				cs_mail($to, $subject, $message, $sender);
		
		
		} ?>
        </div>
<?php 
	} else echo "<p>Connection failed.</p>";
} else echo "<p>File ../promenne.php doesn't exists.</p>"; ?>




<?php if ( date( 'Y' ) < YearToSubStr || (date( 'Y' ) == YearToSubStr && date( 'n' ) <= 8) ) {?>
    <div id="bottom">
    	<div id="datumChange">
            <label for="dateToCountDown">Datum tábora: </label>
            <input type="datetime-local" id="dateToCountDown" value="YYYY-MM-DD hh:mm" />
            <button onclick="changeCampDate()">Změnit</button>
		</div>
                
        <hr />
        
        <div id="photoChange">    
            <form method="post" onsubmit="return IMGUpload()" enctype="multipart/form-data">
                <input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
                <input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
                <label for="backGroundPic">Tématické pozadí: </label>
                <input type="file" name="photo" id="backGroundPic" />
                <button name="upload">Změnit</button>
            </form>
        </div>
    </div>
<?php }?>
</body>
<?php
if( isset($_FILES['photo']) )
{
	$fileName = 'background.jpg';
	$tmpName = $_FILES['photo']['tmp_name'];
	move_uploaded_file( $_FILES['photo']['tmp_name'], "styles/background.jpg");
	?>
    <script type="text/javascript">
	document.getElementById( "photoChange" ).innerHTML = '<p>Úsměšně změněno. Aktualizujte stránku.</p>';
    </script>
    <?php
}
?>
<script type="text/javascript">
var YEAR_MAX = 2030;

function isInt( n )
{
	return n % 1 == 0 ? true : false;
}
function checkDate( n, MIN, MAX )
{
	if ( n < MIN || n > MAX )
	{
		alert( n + ' mimo meze' );
		return false;
	}
	return true;
}

function IMGUpload()
{
	var photo = document.getElementById( 'backGroundPic' ).value;
	if ( photo != '' )
	{
		photo = photo.split( '.' );
		if ( photo[photo.length-1].toUpperCase() == 'JPG' ) return true;
		else
		{
			alert( 'Podporovaný formát je JPG, Vy se pokoušíte vložit ' + photo[photo.length-1].toUpperCase() );
			return false;
		}
	}
	return false;
}
function changeCampDate()
{
	var time = document.getElementById( 'dateToCountDown' ).value; //2016-08-19T12:12
	if ( time == null || time == '' || time == 'YYYY-MM-DD hh:mm' )
	{
		alert( 'Vyplň celý datum s časem' );
		return;
	}
	var datum = (time.split( 'T' ));
	//if ( datum.length != 2 ) datum = time.split( ' ' );
	if ( datum.length != 2 )
	{
		alert( 'Špatný formát data YYYY-MM-DD hh:mm' );
		return;
	}
	var cas = datum[1].split( ':' );
	datum = datum[0].split( '-' );
	
	
	if ( datum.length != 3 || cas.length != 2 )
	{
		alert( 'Špatný formát data YYYY-MM-DD hh:mm' );
		return;
	}
	else
	{
		for ( var i = 0; i < datum.length; i++ )
			if ( isNaN(datum[i]) || !isInt(datum[i]) )
			{
				alert( datum[i] + ' není celé číslo' );
				return;
			}
		for (  var i = 0; i < cas.length; i++ )
			if ( isNaN(cas[i]) || !isInt(cas[i]) )
			{
				alert( cas[i] + ' není celé číslo' );
				return;
			}
	}
	var tm = new Date();
	if ( !checkDate(datum[0], tm.getFullYear(), YEAR_MAX) || !checkDate(datum[1], 1, 12) || !checkDate(datum[2], 1, 31) || !checkDate(cas[0], 0, 23) || !checkDate(cas[1], 0, 59) ) return;
	
	
	
	if ( tm.getFullYear() == datum[0] && ( tm.getMonth() + 1 > datum[1] || ( tm.getMonth() + 1 == datum[1] && ( tm.getDate() > datum[2] || ( tm.getDate() == datum[2] && ( tm.getHours() > cas[0] || ( tm.getHours() == cas[0] && ( tm.getMinutes() >= cas[1] ))))))) )
	{
		alert( 'Událost už proběhla' );
		return;
	}
	//OK
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( 'datumChange' ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/datumChange.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "year=" + datum[0] + "&month=" + datum[1] + "&day=" + datum[2] + "&hour=" + cas[0] + "&minute=" + cas[1] );
}
</script>