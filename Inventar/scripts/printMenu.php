<?php
$name = $_REQUEST['n'];
$passwd = $_REQUEST['p'];
?>

<form method="post" action="../" id="form_back">
    <input type="hidden" name="name" value="<?php echo $name; ?>" />
    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
    <button name="back" id="back"></button>
</form><br  />

<form method="post" action="pridat.php">
    <input type="hidden" name="name" value="<?php echo $name; ?>" />
    <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
    <button type="submit" name="pridat" class="menu">Přidat předmět</button>
</form>
<?php if ( file_exists( '../../promenne.php' ) && require( '../../promenne.php' ) ) {
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) && isAdmin( $name, $spojeni ) ) {?>
        <form method="post">
            <input type="hidden" name="name" value="<?php echo $name; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $passwd; ?>" />
            <button type="submit" name="resize" class="menu">Zmenšit obrázky</button>
        </form>
        <?php 
        if ( isset($_REQUEST['resize']) )
        {
            $file = '../big_resizer.php';
            if ( file_exists($file) && require($file) ) resize_all();
            else echo '<p>Resizer not found</p>';
        }
	}
}?>