<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Vojtěch Stuchlík" />
<link type="text/css" rel="stylesheet" href="css/styly.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripty/dbConn.js"></script>

<?php
//main directory in which are all photos including slash (/) at the end
$MAIN_DIR = 'img/all/';
//directory in each series with previews of photos
$PREVIEWS = 'small';
//directory in each series with full photos
$PHOTOS = 'normal';
//at begin shown photos is 0
$photosShown = 0;
?>

<title>Gallery</title>
</head>
<body id="body">

<h1>Gallery</h1>
<?php
$fce = 'scripty/fce.php';
if ( file_exists($fce) && include($fce) ) {
	?>
	<div id="photos">
		<?php
        $line = 1;
        $dir = $MAIN_DIR;
        foreach( ($ARRAY = glob( $dir.'*', GLOB_ONLYDIR )) as $DIR )
        {
			if ( !is_dir($DIR.DIRECTORY_SEPARATOR.$PREVIEWS) || !is_dir($DIR.DIRECTORY_SEPARATOR.$PHOTOS) || count(scandir($DIR.DIRECTORY_SEPARATOR.$PREVIEWS)) < 3 ) continue;
			
			echo '<div class="photoLine">';
				echo '<h2>'.basename($DIR).'</h2>';
				$i = 1;
				$subdir = $MAIN_DIR.DIRECTORY_SEPARATOR.basename($DIR).DIRECTORY_SEPARATOR.$PREVIEWS.DIRECTORY_SEPARATOR;
				foreach ( glob( $subdir.'*' ) as $fileIMG ) {
					if ( is_dir( $fileIMG ) ) continue;
					$id = '_'.$line.'.'.($i++);
					$description = pathinfo( $fileIMG );
					$name = $description['filename'];
					$ext = $description['extension'];
					echo '<img src="'.$fileIMG.'" alt="'.$name.'" onClick="showPhoto( \''.$id.'\' )" id="'.$id.'" class="line'.$line.'" value="'.$DIR.'/'.$PHOTOS.'/'.$name.'.'.findExt( $name, $DIR.'/'.$PHOTOS ).'" heading="'.basename($DIR).'" />';
					$photosShown++;
				}
				$line++;
				echo '<hr />';
			echo '</div>';
		}
		if ( count($ARRAY) == 1 && $ARRAY[0] === $MAIN_DIR ) echo "<p>Missing slash (/) on main dir. $MAIN_DIR -> $MAIN_DIR/</p>";
		else if ( !$photosShown ) echo "<p>Gallery is empty.</p>";
		?>
        <div class="photoLine">
        	<h2>Další dýchánek</h2>
        	<img src="img/all/Zahradni party/small/img2.png" alt="img2" onClick="showPhoto( '_2.1' )" id="_2.1" class="line2" value="img/all/Zahradni party/normal/img2.jpg" heading="Zahradni party" />
        </div>
    </div>
    
	<div id="herePhotoShow"></div>
    
    <?php
}
else echo "<p>File $fce doesn't exist.</p>";
?>

<script type="text/javascript">
	$(document).keyup(function(e){ checkKey(e) });
</script>
</body>
</html>