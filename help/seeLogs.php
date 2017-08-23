<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="scripty/dbConn.js" type="text/javascript"></script>
<title>See logs</title>
</head>
<body>
  <h1>See logs</h1>
  <form method="post" action="../" id="form_back">
        <input type="hidden" name="name" value="<?= $_REQUEST['name']; ?>"/>
        <input  type="hidden" name="passwd" value="<?= $_REQUEST['passwd']; ?>"/>
        <button type="submit" name="back" id="back"></button>
	</form>
  
  <select id="logSelect" onchange="printLog()">
  	<option value="">---</option>
    <?php
			$all = scandir( "logs" );
			foreach( $all as $file ) {
				if ( is_dir( "logs".DIRECTORY_SEPARATOR.$file ) ) continue;
				echo '<option value="logs'.DIRECTORY_SEPARATOR.$file.'">'.$file.'</option>';
			}
		?>
  </select>
  <div id="logHere"></div>
  
  <script type="text/javascript">
		function printLog() {
			var logFile = $("#logSelect").val();
			if ( logFile == "" )
				document.getElementById( 'logHere' ).innerHTML = "";
			else {
				printConcreteLog( logFile, 'logHere' );
			}
		}
	</script>
</body>
</html>