<?php
class printJidelnicek{
	private $table;
	private $writer;
	private $head;
	private $name;
	public function __construct( $name = 'Jidelnicek' )
	{
		include_once( 'xlsxwriter.class.php' );
		$this->writer = new XLSXWriter();
		$this->table = 'd2016_jidlo';
		$this->head = array(
			'Den' => 'string', 
			'Datum' => 'string',
			'Snídaně' => 'string',
			'Svačina 1' => 'string',
			'Oběd - 1. chod' => 'string',
			'Oběd - 2. chod' => 'string',
			'Svačina 2' => 'string',
			'Večeře' => 'string',
			'Poznámka ke koupi' => 'string'
		);
		$this->name = $name;
	}
	public function makeHead()
	{
		$this->writer->writeSheetHeader( $this->name, $this->head );
	}
	
	public function makeRows( $spojeni )
	{
		$sql = $spojeni->query( 'SELECT * FROM '.$this->table );
		while ( $day = mysqli_fetch_array( $sql ) )
		{
			$dayn =	array(
				'1' => $day['den'], 
				'2' => $day['datum'].' '.$day['denv'],
				'3' => $day['snidane'],
				'4' => $day['sv1'],
				'5' => $day['ob1'],
				'6' => $day['ob2'],
				'7' => $day['sv2'],
				'8' => $day['vecere'],
				'9' => $day['pozn']
			);
			//write actual day into sheet
			$this->writer->writeSheetRow( $this->name, $dayn );
		}
	}
	
	public function finish( $dir = '.' )
	{
		$this->writer->writeToFile( $dir.'/'.$this->name.'.xlsx' );
	}
};

















if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
{
	$file = new printJidelnicek( 'Jidelnicek' );
	$file->makeHead();
	$file->makeRows( $spojeni );
	$file->finish( 'files' );
}
else echo "<p>Connection with database failed.</p>";
?>