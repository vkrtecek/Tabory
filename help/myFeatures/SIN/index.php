<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIN work</title>
</head>
<body>
	<h1>Choose project</h1>
    <ul>
	<?php
		$array = array_diff( glob('*', GLOB_ONLYDIR), array( '.', '..' ) );
		foreach ( $array as $item ) {
			echo '<li><a href="'.$item.'">'.$item.'</a></li>';
		}
	?>
    </ul>
</body>
</html>