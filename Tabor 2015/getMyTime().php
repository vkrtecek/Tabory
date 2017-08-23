<?php
function getMyTime()
{
  $year = date("Y");
  $month_h = date("m");
  switch ( $month_h )
  {
	  case '1':
	    $month = "leden";
		break;
	  case '2':
	    $month = "únor";
		break;
	  case '3':
	    $month = "březen";
		break;
      case '4':
	    $month = "duben";
		break;
      case '5':
	    $month = "květen";
		break;
      case '6':
	    $month = "červen";
		break;
      case '7':
	    $month = "červenec";
		break;
      case '8':
	    $month = "srpen";
		break;
      case '9':
	    $month = "září";
		break;
      case '10':
	    $month = "říjen";
		break;
      case '11':
	    $month = "listopad";
		break;
      case '12':
	    $month = "prosinec";
		break;
	  default:
	    $month = "undefined";
		break;
  }
  $day = date("d");
  $hour = date("H");
  $minute = date("i");
  $second = date("s");
  
  $cas_ted = $day.". ".$month." ".$year." | ".$hour.":".$minute.":".$second;
  
  return $cas_ted;
}
?>