<style>
#div_upload{
	position:absolute;
	top:1em;
	left:300px;
	padding:5px;
	margin:0;
	border:solid violet 3px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
.green{ color:green; }
.red{ font-weight:bold; color:red; font-size:14px; }
</style>
<?php
function upload( $string, $name, $passwd )
	{
	$pripony = array( '.xls', '.xlsx' );
	$uploaded = false;
	$warning_typ = false;
	$warning_no_select = false;
	$warning_error = false;
	
	
	
	/*	upload file */
	if ( isset($_REQUEST['upload']) )
	{
		if ( isset($_FILES['file']) )
		{
			if ( $_FILES['file']['error'] > 0)
			{
				$warning_no_select = true;
			}
			else
			{
				$warning_typ = true;
				foreach ( $pripony as $i )
					if ( strstr( strtolower($_FILES['file']['name']), $i ) )
					{
						$warning_typ = false;
						break;
					}
				if ( !$warning_typ )
				{
					if ( file_exists( "files/".$_FILES['file']['name']) )
					{
						unlink( "files/".$_FILES['file']['name'] );
					}
					$newname = "files/".$string.".xlsx";
					move_uploaded_file( $_FILES['file']['tmp_name'], $newname );
					$uploaded = true;
				}
			}
		}
		else
		{
			$warning_error = true;
		}
	}
	/*	upload file */
	
	
	
	
	
	?>
	<div id="div_upload"><p>
	<?php if ( !$uploaded ) {?>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="file" style="min-width:200px;" />
		<input type="hidden" name="name" value="<?php echo $name; ?>" />
		<input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
		<button type="submit" name="upload">Nahrát</button>
	</form>
	<?php }
		echo $warning_typ ? '<span class="red">This is not excel file.</span>' : '';
		echo $warning_error ? '<span class="red">Error.</span>' : '';
		echo $warning_no_select ? '<span class="red">No file selected.</span>' : '';
		echo $uploaded ? '<span class="green">File uploaded successfuly and overwrote previous excel file.</span>' : '';
	?>
	</p></div>
<?php } ?>