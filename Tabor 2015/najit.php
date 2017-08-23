<form method="get" action="">
<p>Najít úkoly pro:
    <select name="radce" size="1">
        <option value="" selected="selected">---vyber---</option>
        <option value="anicka">Anička</option>
        <option value="broskev">Broskev</option>
        <option value="dale">Dale</option>
        <option value="flieger">p. Flieger</option>
        <option value="holub">Holub</option>
        <option value="jana">Jana</option>
        <option value="jena">Jeňa</option>
        <option value="johny">Johny</option>
        <option value="krtek">Krtek</option>
        <option value="leos">Leoš</option>
        <option value="lexa">Lexa</option>
        <option value="mac">Mac</option>
        <option value="magda">Magda</option>
        <option value="mara">Mára</option>
        <option value="misa">Míša</option>
        <option value="nemo">Nemo</option>
        <option value="rony">Rony</option>
        <option value="salo">Salo</option>
        <option value="tazi">Tazi</option>
        <option value="zdena">Zdeňa</option>
        <option value="zena">Žena</option>
    </select>
    <input type="hidden" name="name" value="<?php echo $name;?>" />
    <input type="hidden" name="passwd" value="<?php echo $passwd;?>" />
    <button>Potvrdit</button></p>
</form>