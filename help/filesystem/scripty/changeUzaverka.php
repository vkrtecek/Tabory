<?php

$file = '../uzaverka.php';
file_put_contents( $file, "<?php \$referenceDate = '".$_REQUEST['date']."';" );
echo 'success';