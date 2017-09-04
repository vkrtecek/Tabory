<?php
$id = $_REQUEST['id'];

if ( file_exists( "../../promenne.php") && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM vlc_boys WHERE id = ".$id );
		$mem = mysqli_fetch_array( $sql );
		?>
		<form method="post" onSubmit="return check()" enctype="multipart/form-data">
		<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
		<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
		<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']; ?>" />
		<table rules="none">
			<tr>
				<td>
					<label for="Dname">Jméno: </label>
				</td>
				<td>
					<input id="Dname" type="text" name="Dname" class="im" value="<?php echo $mem['name']; ?>" /><span class="red">*</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sname">Příjmení: </label>
				</td>
				<td>
					<input id="sname" type="text" name="sname" class="im" value="<?php echo $mem['sname']; ?>" /><span class="red">*</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="nick">Přezdívka: </label>
				</td>
				<td>
					<input id="nick" type="text" name="nick" value="<?php echo $mem['nick']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="address">Adresa: </label>
				</td>
				<td>
					<input id="address" type="text" name="address" class="im" value="<?php echo $mem['address']; ?>" /><span class="red">*</span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="birthdate">Datum narození: </label>
				</td>
				<td>
					<input id="birthdate" type="date" name="birthdate" class="im" value="<?php echo $mem['birthdate']; ?>" /><span class="red">*</span>
				</td>
			</tr><tr>
				<td>
					<label for="RC">Rodné číslo: </label>
				</td>
				<td>
					<input id="RC" type="text" name="RC" value="<?php echo $mem['RC']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="zdravi">Zdravotní omezení: </label>
				</td>
				<td>
					<textarea id="zdravi" type="text" name="zdravi"><?php echo $mem['zdravi']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="telO">Telefon na otce</label>
				</td>
				<td>
					<input id="telO" type="tel" name="telO" value="<?php echo $mem['telO'] == '0' ? '' : $mem['telO']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="mailO">E-mail na otce</label>
				</td>
				<td>
					<input id="mailO" type="mail" name="mailO" value="<?php echo $mem['mailO']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="telM">Telefon na matku</label>
				</td>
				<td>
					<input id="telM" type="tel" name="telM" value="<?php echo $mem['telM'] == '0' ? '' : $mem['telM']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="mailM">E-mail na matku</label>
				</td>
				<td>
					<input id="mailM" type="mail" name="mailM" value="<?php echo $mem['mailM']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="photo">Fotka</label>
				</td>
				<td>
					<input id="photo" type="file" name="photo" />
				</td>
			</tr>
            <tr>
				<td>
					<label for="mailM">Stále členem</label>
				</td>
				<td>
					<select name="member">
                    	<option value="1" <?php echo $mem['member'] ? 'selected=""' : ''; ?>>ANO</option>
                    	<option value="0" <?php echo !$mem['member'] ? 'selected=""' : ''; ?>>NE</option>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button name="EDIT_M">Uložit</button>
				</td>
                <td>
                	<span class="red">* Povinné pole</span>
                </td>
			</tr>
		</table>
		</form>
    	<div id="placeToPhotoOfMem"><img src="../help/img/members/small/<?php echo $mem['photo']; ?>" alt="fotka člena" /></div>
      
      
        <button class="blue" onclick="mvBoyToUses( <?=$_REQUEST['id'];?>, '<?=$_REQUEST['name'];?>' )">Přesunout do vedoucích</button>
      
        <form method="post" onsubmit="return confirm( 'Opravdu smazat?' )">                
            <input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
            <input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
			<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
            <input type="hidden" name="delMem" />
            <button name="EDIT_M" class="red">Smazat člena z databáze</button>
        </form>
    	<?php
	}
	else echo '<p>Connection with database failed.</p>';
}
else echo "<p>File ../../promenne.php doesn't exists.</p>";

?>