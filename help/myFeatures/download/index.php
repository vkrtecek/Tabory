<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My files</title>
</head>
<body>
	<h1>Files to download</h1>
    <?php
		$dir = "toDown";
		$dir = array_diff(scandir($dir), array('..', '.'));
		foreach ( $dir as $a ) {
			echo '<li><a href="toDown/'.$a.'">'.$a.'</a></li>';
		}
	?>
</body>
</html>