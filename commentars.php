<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="help/scripty/dbConn.js" type="text/javascript"></script>
<script src="relogin.js" type="text/javascript"></script>
<script type="text/javascript">
	DEF_MESS = "Povinné pole";
</script>
<link rel="stylesheet" type="text/css" href="help/styles/styly.css" />
<title>Komentáře</title>
</head>
<body>
<?php 
if ( isset($_REQUEST['passwd']) && isset($_REQUEST['name']) )
{
	
	$name = $_REQUEST['name'];
	$passwd = $_REQUEST['passwd'];
	?>
    <form method="post" action="./">
    <input type="hidden" name="name" value="<?php echo $name;?>"/>
    <input  type="hidden" name="passwd" value="<?php echo $passwd;?>"/>
    <button type="submit" name="back" id="back"></button>
    </form>
	<div id="allComments">
        <h2 style="font-family:Geneva, sans-serif">Komentáře:</h2>
        
        <div id="commHere"><img src="help/img/loading.gif" alt="loading" /></div>
        <script type="text/javascript">
            printComm( 'commHere', 'vlc_comments', '<?php echo $name ?>' );
        </script>
    </div>
    
			
    <h3 id="addComment">
        <label>Věc: <input type="text" name="subject" id="subject" /></label><br />
        Tělo komentáře:<br />
        <textarea id="textarea" name="comment" cols="60" rows="6">Povinné pole</textarea><br /><br />
        <button onClick="insertComm( 'commHere', 'vlc_comments', '<?php echo $name; ?>', '<?php echo $_SERVER['REMOTE_ADDR']; ?>', DEF_MESS )">Odeslat koment</button>
    </h3>

	<script type="text/javascript">
    $("textarea").focus(function()
    {
        val = document.getElementById("textarea").value;
        if ( val == "Povinné pole" ) document.getElementById("textarea").innerHTML = "";
    });
    $("textarea").focusout(function()
    {
        val = document.getElementById("textarea").value;
        if ( val == "" ) document.getElementById("textarea").innerHTML = DEF_MESS;
    });
    $("#jmeno").click(function()
    {
        $(this).attr("value", "");
    });
    </script>
    <?php		
}
else {
	?>
  <script>relogin( '<?= $_SERVER['REMOTE_ADDR']; ?>', '.' );</script>
  <?php
  echo '<h1><a href="./index.php">Nejspíš jste se zapomněli přihlásit.</a></h1>';
}
?>
</body>
</html>