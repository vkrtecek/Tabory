<?php
class printHarmonogram{
	private $table;
	private $writer;
	private $head;
	private $name;
	public function __construct( $name = 'Harmonogram' )
	{
		include_once( 'xlsxwriter.class.php' );
		$this->writer = new XLSXWriter();
		$this->table = 'd2016_harmonogram';
		$this->head = array(
			'head' => array(
				'Harmonogram tábora 2016' => 'string', 
				'string2' => 'string',
				'string3' => 'string',
				'string4' => 'string',
				'string5' => 'string',
				'string6' => 'string',
				'string7' => 'string',
				'string8' => 'string'
			),
			'underHead' => array(
				'1' => 'Den', 
				'2' => 'Datum', 
				'3' => 'Vedoucí dne', 
				'4' => 'Dopoledne I', 
				'5' => 'Dopoledne II', 
				'6' => 'Odpoledne I', 
				'7' => 'Odpoledne II', 
				'8' => 'Večer'
			)
		);
		$this->name = $name;
	}
	
	private function makeStartingMergeCells()
	{
		$this->writer->markMergedCell( $this->name, 0, 0, 0, 7 ); //3A 5C
	}
	public function makeMergeCells( $spojeni, $print = false )
	{
		$this->makeStartingMergeCells();
		for ( $i = 2; $i <= 44; $i+=3 )
		{
			$this->writer->markMergedCell( $this->name, $i  , 0, $i+2, 0 ); //den
			$this->writer->markMergedCell( $this->name, $i  , 1, $i+2, 1 ); //datum
		}
		
		$cnt = 0;
		$sql = $spojeni->query( 'SELECT * FROM '.$this->table );
		while ( $day = mysqli_fetch_array( $sql ) )
		{
			$k = $day['colspan1'];
			if ( $k = $day['colspan1'] ) 
			{
				if ( $print ) echo 'if ( $k = '.$day['colspan1'].' ) $this->writer->markMergedCell( \''.$this->name.'\', '.((3*$cnt)+3).', 3, '.((3*$cnt)+4).', '.(2+$k).' ); 1<br />';
				$this->writer->markMergedCell( $this->name, (3*$cnt)+3, 3, (3*$cnt)+4, 2+$k ); //colspan1
				$this->writer->markMergedCell( $this->name, (3*$cnt)+2, 3, (3*$cnt)+2, 2+$k ); //colspan1
			}
			if ( $k = $day['colspan2'] )
			{
				if ( $print ) echo 'if ( $k = '.$day['colspan2'].' ) $this->writer->markMergedCell( \''.$this->name.'\', '.((3*$cnt)+3).', 4, '.((3*$cnt)+4).', '.(3+$k).' ); 2<br />';
				$this->writer->markMergedCell( $this->name, (3*$cnt)+3, 4, (3*$cnt)+4, 3+$k ); //colspan2
				$this->writer->markMergedCell( $this->name, (3*$cnt)+2, 4, (3*$cnt)+2, 3+$k ); //colspan2
			}
			if ( $k = $day['colspan3'] )
			{
				if ( $print ) echo 'if ( $k = '.$day['colspan3'].' ) $this->writer->markMergedCell( \''.$this->name.'\', '.((3*$cnt)+3).', 5, '.((3*$cnt)+4).', '.(4+$k).' ); 3<br />';
				$this->writer->markMergedCell( $this->name, (3*$cnt)+3, 5, (3*$cnt)+4, 4+$k ); //colspan3
				$this->writer->markMergedCell( $this->name, (3*$cnt)+2, 5, (3*$cnt)+2, 4+$k ); //colspan3
			}
			if ( $k = $day['colspan4'] )
			{
				if ( $print ) echo 'if ( $k = '.$day['colspan4'].' ) $this->writer->markMergedCell( \''.$this->name.'\', '.((3*$cnt)+3).', 6, '.((3*$cnt)+4).', '.(5+$k).' ); 4<br />';
				$this->writer->markMergedCell( $this->name, (3*$cnt)+3, 6, (3*$cnt)+4, 5+$k ); //colspan3
				$this->writer->markMergedCell( $this->name, (3*$cnt)+2, 6, (3*$cnt)+2, 5+$k ); //colspan3
			}
			if ( $k = $day['colspan5'] )
			{
				if ( $print ) echo 'if ( $k = '.$day['colspan5'].' ) $this->writer->markMergedCell( \''.$this->name.'\', '.((3*$cnt)+3).', 7, '.((3*$cnt)+4).', '.(6+$k).' ); 4<br />';
				$this->writer->markMergedCell( $this->name, (3*$cnt)+3, 7, (3*$cnt)+4, 6+$k ); //colspan4
				$this->writer->markMergedCell( $this->name, (3*$cnt)+2, 7, (3*$cnt)+2, 6+$k ); //colspan4
			}
			
			$cnt++;
		}
	}
	public function makeHead()
	{
		$this->writer->writeSheetHeader( $this->name, $this->head['head'] );
		$this->writer->writeSheetRow( $this->name, $this->head['underHead'] );
	}
	
	public function makeRows( $spojeni, $print = false )
	{
		$sql = $spojeni->query( 'SELECT * FROM '.$this->table );
		while ( $day = mysqli_fetch_array( $sql ) )
		{
			$dayn =	array(
				array(
					'1' => $day['den'].'.', 
					'2' => str_replace( '<br />', ' ', $day['datum']),
					'3' => $this->subArray( $day['vedouci'], $spojeni ),
					'4' => $this->subArray( $day['gMor1'], $spojeni ),
					'5' => $this->subArray( $day['gMor2'], $spojeni ),
					'6' => $this->subArray( $day['gAf1'], $spojeni ),
					'7' => $this->subArray( $day['gAf2'], $spojeni ),
					'8' => $this->subArray( $day['gNig'], $spojeni )
				),
				array(
					'1' => '',
					'2' => '',
					'3' => $this->subArray( $day['dira1'], $spojeni ),
					'4' => $day['Mor1'],
					'5' => $day['Mor2'],
					'6' => $day['Af1'],
					'7' => $day['Af2'],
					'8' => $day['Nig']
				),
				array(
					'1' => '', 
					'2' => '',
					'3' => $this->subArray( $day['dira2'], $spojeni ),
					'4' => '',
					'5' => '',
					'6' => '',
					'7' => '',
					'8' => ''
				)
			);
			//write actual day into sheet
			$this->writer->writeSheetRow( $this->name, $dayn[0] );
			$this->writer->writeSheetRow( $this->name, $dayn[1] );
			$this->writer->writeSheetRow( $this->name, $dayn[2] );
		}
	}
	
	private function subArray( $in, $spojeni )
	{
		$str = '';
		$in = explode( ' - ', $in );
		foreach ( $in as $mem )
			$str .= toHacky( $mem, $spojeni ).' ';
		return $str;
	}
	
	
	public function finish( $dir = '.' )
	{
		$this->writer->writeToFile( $dir.'/'.$this->name.'.xlsx' );
	}
};
















if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
{
	$file = new printHarmonogram( 'Harmonogram' );
	$file->makeHead();
	$file->makeRows( $spojeni, false );
	$file->makeMergeCells( $spojeni, false );
	$file->finish( 'files' );
}
else echo "<p>Connection with database failed.</p>";
?>