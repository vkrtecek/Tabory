<?php
$img = $_REQUEST['img'];
$name = $_REQUEST['name'];
$preview = $_REQUEST['preview'];
$leftOK = $_REQUEST['leftOK'];
$rightOK = $_REQUEST['rightOK'];
$class = $_REQUEST['class'];
$index = $_REQUEST['index'];
$heading = $_REQUEST['heading'];

$info = getimagesize( '../'.$preview );
print_r( $info );

?>
<div id="photoViewer" onClick="undo()">
	<div id="aroundPic">
    	<h3><?php echo $heading; ?></h3>
    	
    	<div id="bySideImgLeft" onClick="showPhotoByClass( <?php echo "'".$class."', '".($index-1)."'"; ?> )" style="height:30px">
    		<?php if ( $leftOK == 'true' ) { ?> <img src="img/left.png" alt="left" class="toAnotherPic" id="leftArowToAnotherPic" /> <?php } ?>
		</div>
        
        <img src="<?php echo $preview; ?>" alt="photo" id="mainPhoto" title="<?php echo $preview; ?>" />
        
    	<div id="bySideImgRight" onClick="showPhotoByClass( <?php echo "'".$class."', '".($index+1)."'"; ?> )" style="height:500px">
        	<?php if ( $rightOK == 'true' ) { ?> <img src="img/right.png" alt="right" class="toAnotherPic" id="rightArowToAnotherPic" /> <?php } ?>
        </div>
    
    	<p>Název: <?php echo $name; ?></p>
    </div>
</div>