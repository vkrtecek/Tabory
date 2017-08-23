<?php
function resizeImage( $src_image, $newW = 100, $newH = 100, $des = "." ) //../help/img/members/Matej_Baso.JPG, 120, 150, ../help/img/members/small
{
	$bool = false;
	if ( file_exists( $des ) ) {
		if ( file_exists( $src_image ) ){
			list( $src_w, $src_h ) = getimagesize( $src_image );
			
			$target = imagecreatetruecolor( $newW, $newH );
			
			if ( strstr( strtolower($src_image), '.jpg' ) || strstr( strtolower($src_image), '.jpeg' ) ) {
				$source = imagecreatefromjpeg( $src_image );
			}
			else if ( strstr( strtolower($src_image), '.png' ) ) {
				$source = imagecreatefrompng( $src_image );
			}
			else if ( strstr( strtolower($src_image), '.gif' ) ) {
				$source = imagecreatefromgif( $src_image );
			}
			
			$bool = imagecopyresized ( $target, $source, 0, 0, 0, 0, $newW, $newH, $src_w, $src_h );
			
			$tecky = explode( '.', $src_image );
			$lomitka = explode( '/', $src_image );
			
			//set name to path + name of picture without extention
			$name = '';
			for ( $i = 0; $i < count( $lomitka ) - 1; $i++ ) $name .= $lomitka[$i].'/';
			$tecky_small = explode( '.', $lomitka[$i] );
			$name_pic = '';
			for ( $i = 0; $i < count( $tecky_small ) - 1; $i++ ) $name_pic .= $tecky_small[$i];
			$name .= $name_pic;
			
			//get the last field separated by dot
			$ext = $tecky[count($tecky)-1];
			
			
			$newname = $des.'/'.$name_pic.'.'.$ext;
			imagejpeg( $target, $newname );
		} else echo "<p>Image <strong>".$src_image."</strong> not found.</p>";
	} else echo '<p>Target not found.</p>';
	
	return $bool;
}
?>