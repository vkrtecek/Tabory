<?php
$row = $_REQUEST['row'];
$cel = $_REQUEST['cel'];


echo '<table id="mainTable">';
for ( $i = 0; $i < $cel; $i++ )
{
	echo '<tr>';
	for ( $l = 0; $l < $row; $l++ )
	{
		echo '<td class="tableToTd" id="'.$i.'_'.$l.'">';
		echo '<img src="" alt="obr" height="80" width="80" />';
		echo '</td>';
	}
	echo '</tr>';
}
echo '</table>';
?>