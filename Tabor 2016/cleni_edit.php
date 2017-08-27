<form id="navigate" method="post">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
	<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<button name="BACK">Zpět</button>
</form>

<form id="navigate" method="post">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
	<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<button name="ADD">Vytvořit člena</button>
</form>

<form id="navigate" method="post">
	<input type="hidden" name="name" value="<?php echo $_REQUEST['name']; ?>" />
	<input type="hidden" name="passwd" value="<?php echo $_REQUEST['passwd']; ?>" />
	<button name="EDIT_M">Upravit člena</button>
</form>





<div id="aboveAll">Zbylí členi</div>
<div id="allMembers"></div>






<div id="aboveNow">Členi na táboře</div>
<div id="nowMembers"></div>






<script type="text/javascript">
function showBef( where )
{
	if (window.XMLHttpRequest) {
		xmlhttpB = new XMLHttpRequest();
	} else {
		xmlhttpB = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpB.onreadystatechange = function() {
		if (xmlhttpB.readyState == 4 && xmlhttpB.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttpB.responseText;
		}
	};
	xmlhttpB.open( "POST", "scripty/showMemBef.php", true );
	xmlhttpB.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpB.send( "tableAll=<?php echo $tableAll; ?>&tableNow=<?php echo $tableNow; ?>" );
}
function showAf( where )
{
	if (window.XMLHttpRequest) {
		xmlhttpA = new XMLHttpRequest();
	} else {
		xmlhttpA = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpA.onreadystatechange = function() {
		if (xmlhttpA.readyState == 4 && xmlhttpA.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttpA.responseText;
		}
	};
	xmlhttpA.open( "POST", "scripty/showMemAf.php", true );
	xmlhttpA.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpA.send( "tableAll=<?php echo $tableAll; ?>&tableNow=<?php echo $tableNow; ?>" );
}
showBef( 'allMembers' );
showAf( 'nowMembers' );









function moveToCamp( id )
{
	if (window.XMLHttpRequest) {
		xmlhttpMTC = new XMLHttpRequest();
	} else {
		xmlhttpMTC = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpMTC.onreadystatechange = function() {
		if (xmlhttpMTC.readyState == 4 && xmlhttpMTC.status == 200) {
			document.getElementById( 'tu' ).innerHTML = xmlhttpMTC.responseText;
		}
	};
	xmlhttpMTC.open( "POST", "scripty/moveToCamp.php", true );
	xmlhttpMTC.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpMTC.send( "id=" + id + "&tableNow=<?php echo $tableNow; ?>&who=<?=$name;?>" );
	
	showBef( 'allMembers' );
	showAf( 'nowMembers' );
}
function moveFromCamp( id )
{
	if (window.XMLHttpRequest) {
		xmlhttpMFC = new XMLHttpRequest();
	} else {
		xmlhttpMFC = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpMFC.open( "POST", "scripty/moveFromCamp.php", true );
	xmlhttpMFC.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpMFC.send( "id=" + id + "&tableNow=<?php echo $tableNow; ?>&who=<?=$name;?>" );
	
	showBef( 'allMembers' );
	showAf( 'nowMembers' );
}
</script>