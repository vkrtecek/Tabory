<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
	//header('Content-disposition: inline');
	//header('Content-type: application/msword'); // not sure if this is the correct MIME type
	//readfile('./src/MyWordDocument.docx');
	//exit;
?>
<a href="./src/MyWordDocument.docx">this</a>
<iframe src='https://docs.google.com/viewer?url=http://vlcata.pohrebnisluzbazlin.cz/help/myFeatures/word//src/MyWordDocument.docx&embedded=true' frameborder='0'></iframe>
<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>
</body>
</html>