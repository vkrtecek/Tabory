<?php 
function email()
{
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
	
	if (!isset($_SESSION['spravnost_udaju'])) $_SESSION['spravnost_udaju'] = false;
	if (isset($_REQUEST['remail'])) $_SESSION['spravnost_udaju'] = false;
	$upozorneni = array('Vyplňte prosím text e-mailu.', 'Zadejte prosím svůj email.', 'Špatný formát e-mailu.', 'Vyber příjemce');
	$warning = array(false, false, false, false);
	$zprava = array('Zde napište svůj e-mail', 'name@example.com');
	
	
	
	if (isset($_REQUEST['odeslat_email']))
	{
		
		
		if ($_REQUEST['text_emailu'] == 'Zde napište svůj e-mail')
		{
			$_REQUEST['text_emailu'] = '';	
		}
		
		if ($_REQUEST["text_emailu"] == '' or $_REQUEST['nick'] == 'name@example.com' or !filter_var($_REQUEST['nick'], FILTER_VALIDATE_EMAIL) or $_REQUEST['prijemce'] == '')
		{
			if ($_REQUEST["text_emailu"] == '')
			{
				$warning[0] = true;
			}
			
			if ($_REQUEST['nick'] == 'name@example.com')
			{
				$warning[1] = true;
			}
			
			else if (!filter_var($_REQUEST['nick'], FILTER_VALIDATE_EMAIL))
			{
				$warning[2] = true;
			}
			if ($_REQUEST['prijemce'] == '')
			{
				$warning[3] = true;
			}
		}
		else
		{
			require('getMyTime().php');
			$to = $_REQUEST['prijemce'];
			$subject = 'Vlcata 2015 - '.$_REQUEST['subject'];
			$sender = 'From: '.$name.'<'.$_REQUEST['nick'].'>\n';
			$after = '
			

(Time: '.getMyTime().')';
			$message = wordwrap($_REQUEST['text_emailu'], 70, "\r\n", false);
			$message = $$_REQUEST['text_emailu'].$after;
			$_SESSION['spravnost_udaju'] = true;
			
			
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
						 
						function cs_mail ($to, $subject, $message, $headers)
						{
							$subject = "=?utf-8?B?".base64_encode( autoUTF($subject))."?=";
							$headers .= "MIME-Version: 1.0\n";
							$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
							$headers .= "Content-Transfer-Encoding: base64\n";
							$message = base64_encode ( autoUTF($message));
							return mail($to, $subject, $message, $headers);
						}
						cs_mail($to, $subject, $message, $sender);	
		}
	}
            
  	if ( file_exists("../promenne.php") )
  	{
	  	require("../promenne.php");          
      	$spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name); 
  	  	if ( $spojeni )
  	  	{          
			?>
            
            <style>
			#email{
				background-color:#FCF38D;
				padding:13px;
				width:400px;
				border:solid green 1px;
			}
			.w1{
				color:red;
			}			
			p{
				font-family:Calibri, sans-serif;
				font-size:16px;
				text-align:justify;
				margin-left:15px;
			}
			#textarea{
				max-width:370px;
			}
			</style>
            
              
			<div id="email">
			<?php
			if ($_SESSION['spravnost_udaju'] == false)
			{?>
			<h4>Chceš poslat e-mail někomu z nás?</h4>
			
			
			
					<form method="get" action="">
					<p>
					Pro:
					<select name="prijemce" size="1">
						<option value="">---vyber---</option>
						<?php
						$spojeni->query("SET CHARACTER SET UTF8");
						$sql = $spojeni->query("SELECT * FROM vlc_users WHERE platnost = 1 ORDER BY nick ASC");
						while ( $clovek = mysqli_fetch_array($sql) )
						{
							echo '<option value="'.$clovek['mail'].'"';
							if ( isset($_REQUEST['prijemce']) && $clovek['mail'] == $_REQUEST['prijemce'] ) echo ' selected=""';
							echo '>'.$clovek['nickname'].'</option>';
						}
						?>
					</select><br /><br />
					<label>Předmět: <input type="text" name="subject" value="<?php if (isset($_REQUEST['odeslat_email'])) echo $_REQUEST['subject'];?>"/></label><br /><br />
					<textarea style="max-width:350px;" rows="5" cols="50" name="text_emailu" id="textarea"><?php echo (isset($_REQUEST['odeslat_email'])) ? $_REQUEST['text_emailu'] : "Zde napište svůj e-mail";?></textarea><br /><br />
					<label>Tvůj e-mail: <input type="text" name="nick" id="input1" value="<?php if (isset($_REQUEST['odeslat_email'])) echo $_REQUEST['nick'];?>"/></label><br /><br />
					<input type="hidden" name="name" value="<?php echo $name;?>" />
					<input type="hidden" name="passwd" value="<?php echo $passwd;?>" />
					<button type="submit" name="odeslat_email" value="1">Odeslat e-mail</button>
					</p>
					</form>
					<?php
					if ($warning[3] == true) echo '<p class="w1">'.$upozorneni[3].'</p>';
					if ($warning[0] == true) echo '<p class="w1">'.$upozorneni[0].'</p>';
					if ($warning[1] == true) echo '<p class="w1">'.$upozorneni[1].'</p>';
					if ($warning[2] == true) echo '<p class="w1">'.$upozorneni[2].'</p>';
					?>
			
			<?php
			}
			else 
			{
				?>
				<span id="email_ok"><p>E-mail byl úspěšně odeslán na <strong><?php echo $to;?></strong></p>
				<form method="post" action="">
					<input type="hidden" name="name" value="<?php echo $name;?>" />
					<input type="hidden" name="passwd" value="<?php echo $passwd;?>" />
					<button type="submit" name="remail">Poslat další e-mail</button>
				</form></span>
			<?php
			}
			?>
			</div>
	<?php } // !$spojeni
	}//require promenne.php?>
			
    
    
    <script type="text/javascript">
    var zprava = ['Zde napište svůj e-mail', 'name@example.com'];
    
    
    <?php if (!isset($_REQUEST['odeslat_email'])){?>
        document.getElementById("textarea").innerHTML = zprava[0];
        $('#input1').attr('value', zprava[1]);
    <?php }?>
    
    
    
    <?php if (!isset($_REQUEST['odeslat_email']) or isset($_REQUEST['odeslat_email']) && $_REQUEST['text_emailu'] == ''){?>
        $("#textarea").focus(function()
        {
            document.getElementById("textarea").innerHTML = "";
        });
        $("#textarea").focusout(function()
        {
            document.getElementById("textarea").innerHTML = zprava[0];
        });
    <?php }?>
    
    
    <?php if (!isset($_REQUEST['odeslat_email']) or isset($_REQUEST['odeslat_email']) && $_REQUEST['nick'] == 'name@example.com'){?>
        $('#input1, #input2').focus(function()
        {
            $(this).attr('value', '');
        });
        $('#input1').focusout(function()
        {
            $('#input1').attr('value', zprava[1]);
        });
    <?php }?>
	
    </script><?php
	if (isset($_REQUEST['odeslat_email']))
	{
		$kontr = true;
		for ($i = 0; $i < count($warning); $i++)
		{
			if ($warning[$i] == true)
			{?>
				<style type="text/css">
					#email{
						border:solid red 1px;!important
					}
				</style>
			<?php
			}
		}
	}
	
} 
?>