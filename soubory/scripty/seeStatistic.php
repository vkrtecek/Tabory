<?php
function getFileName( $id, & $spojeni ) {
	$sqlFile = $spojeni->query( "SELECT nazev FROM vlc_files WHERE id = ".$id );
	$item = mysqli_fetch_array( $sqlFile, MYSQLI_ASSOC );
	return $item['nazev'];
}


$tableD = $_REQUEST['table_downloaded'];
$tableS = $_REQUEST['table_seen'];

$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		?>
		<table id="tableStatistic" rules="all">
        <tr><th>Table <?= $tableD; ?></th><th>Table <?= $tableS; ?> </th></tr>
        <tr>
        	<td>
          <div>
        		<table rules="all">
              <tr>
                <th>ID</th>
                <th>File name</th>
                <th>User</th>
                <th>date</th>
              </tr>
              <?php
                $sqlD = $spojeni->query( "SELECT * from ".$tableD." ORDER BY date ASC" );
                while ( $item = mysqli_fetch_array($sqlD) ) {
                  echo "<tr>";
                    echo "<td>".$item['id']."</td>";
                    echo "<td>".getFileName( $item['file'], $spojeni )."</td>";
                    echo "<td>".nicknameFromID( $item['user'], $spojeni )."</td>";
                    echo "<td>".dateToReadableFormat( $item['date'] )."</td>";
                  echo "</tr>";
                }
              ?>
            </table>
          </div>
        	</td>
        	<td>
          <div>
        		<table rules="all">
              <tr>
                <th>ID</th>
                <th>File Name</th>
                <th>User</th>
                <th>date</th>
              </tr>
              <?php
                $sqlS = $spojeni->query( "SELECT * from ".$tableS." ORDER BY date ASC" );
                while ( $item = mysqli_fetch_array($sqlS) ) {
                  echo "<tr>";
                    echo "<td>".$item['id']."</td>";
                    echo "<td>".getFileName( $item['file'], $spojeni )."</td>";
                    echo "<td>".nicknameFromID( $item['user'], $spojeni )."</td>";
                    echo "<td>".dateToReadableFormat( $item['date'] )."</td>";
                  echo "</tr>";
                }
              ?>
            </table>
          </div>
        	</td>
        </tr>
        </table>
        <?php
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>