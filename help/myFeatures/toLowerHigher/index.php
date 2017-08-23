<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Make string to lowwercase/highercase</title>
<style type="text/css">
	#insert, #output{
		display:block;
		width:80%;
		margin-left:10%;
		margin-top:5vh;
		height:35vh;
	}
	#buttons{
		margin:auto;
		text-align:center;
		padding-top:5vh;
	}
</style>
</head>
<body>
	<form action="" method="post" >
        <textarea id="insert" onClick="delText( 'insert' )" name="input">Some text</textarea>
        <div id="buttons">
            <button onclick="toLowwer( 'insert', 'output' )" name="lower">Lowercase</button>
            <button onclick="toHigher( 'insert', 'output' )" name="higher">Highercase</button>
        </div>
        <textarea id="output" disabled="disabled"><?php echo isset($_POST['lower']) ? mb_strtolower($_POST['input'], 'UTF8') : (isset($_POST['higher']) ? mb_strtoupper($_POST['input'], 'UTF8') : "") ?></textarea>
	</form>


<script type="text/javascript">
	function delText( what ) {
		document.getElementById( what ).innerHTML = "";
	}
	/*function toLowwer( from, to ) {
		var input = document.getElementById( from ).innerHTML;
		alert( input );
		document.getElementById( to ).innerHTML = input.toLowerCase();
	}
	function toHigher( from, to ) {
		var input = document.getElementById( from ).innerHTML;
		alert( input );
		document.getElementById( to ).innerHTML = input.toUpperCase();
	}*/
</script>
</body>
</html>