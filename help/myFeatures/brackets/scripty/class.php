<?php

class sqlConn {
	private $db_host;
	private $db_username;
	private $db_passwd;
	private $db_name;
	private $spojeni;
	
	function __construct( $a, $b, $c, $d ){
		$this->db_host = $a;
		$this->db_username = $b;
		$this->db_passwd = $c;
		$this->db_name = $d;
		
		$this->spojeni = mysqli_connect( $this->db_host, $this->db_username, $this->db_passwd, $this->db_name );
		if ( !$this->spojeni->query( "SET CHARACTER SET UTF8" ) ) echo '<h1>Connection with database had failed.</h1>';
	}
	
	public function printTable( $tableName ) {
		$sql = $this->spojeni->query( "SELECT * FROM ".$tableName );
		$head = mysqli_fetch_assoc( $sql );
		
		echo '<table rules="none">';
		echo '<tr>';
			echo '<th colspan="'.count($head).'	">'.$tableName.'</th>';
		echo '</tr>';
		echo '<tr>';
		foreach ( $head as $key => $value )
			echo '<th>'.$key.'</th>';
		echo '</th>';		
		
		while ( $personArr = mysqli_fetch_array( $sql, MYSQLI_NUM ) ) {
			echo '<tr>';
			foreach ( $personArr as $person ) {
				echo '<td>'.$person.'</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		
	}
	
	function __destruct() {
		mysqli_close( $this->spojeni );
	}
}
?>