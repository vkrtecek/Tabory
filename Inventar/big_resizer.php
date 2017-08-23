<?php
function resize_all()
{
	if ( file_exists('image_resizer.php') )
	{
		require('image_resizer.php');
		$pol = scandir( "obrazky/" );
		echo '<ul>';
		for ( $i = 0; $i < count($pol); $i++ )
		{
			$bool = false;
			$p = $pol[$i];
			if ( strstr($p, 'jpg') || strstr($p, 'jpeg') || strstr($p, 'png') || strstr($p, 'gif') )
			{
				$bool = resizeImage( 'obrazky/'.$p, 100, 100, 'obrazky/male' );
				if ( $bool ) echo '<li>'.$p.' - ('.($i+1).'/'.count($pol).')</li>';
				else echo '<li><strong>'.$p.'</strong></li>';
			}
			
		}
		echo '</ul>';
	} else echo '<h2>File <strong>image_resizer.php</strong> not found.</h2>';
}
?>