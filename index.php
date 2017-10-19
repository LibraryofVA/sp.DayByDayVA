<?php
$valid_months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
if(isset($_REQUEST["m"]) && in_array(ucwords($_REQUEST["m"]), $valid_months) && isset($_REQUEST["d"])){
//month and day provided in query string (false directories)
	$today_month = ucfirst($_REQUEST["m"]);
	if($_REQUEST["d"] > 1 && $_REQUEST["d"] < 32){
		$today_day = (int)$_REQUEST["d"];
	} else {
		$today_day = 1;
	}
}
elseif(isset($_REQUEST["m"]) && in_array(ucwords($_REQUEST["m"]), $valid_months)) {
//only month is provided, show montly activites
	$today_month = ucfirst($_REQUEST["m"]);
	$today_day = "Actividades mensuales";
}
else {
//else no query string provided, use todays date
	$today_month = $valid_months[date("n", time())-1];
	$today_day = date("j",time());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="false" />
<meta name="copyright" content="2015 (c) Library of Virginia" />
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="home" title="home" href="http://sp.daybydayva.org/" />
<title><?php echo $today_day . " " . $today_month; ?> | DayByDayVA Calendario de alfabetización familiar</title>
<meta content="Library of Virginia" name="Owner" />
<meta content="Day by Day reading program" name="Description" />
<meta content="day by day reading program" name="Keywords" />
<link href='http://fonts.googleapis.com/css?family=Gorditas' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="/daybyday.css" />
</head>
<body class="<?php echo $today_month . "_page day_" . $today_day;?>">
<?php
	$xml = simplexml_load_file(strtolower($today_month.".xml"));
	foreach ($xml->channel->item as $it3m) { 
      if ($it3m->title == $today_day . " de " . strtolower($today_month)) {
		 print_out($it3m->title,$it3m->description,$today_month);
      }
	} 
?>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>
<?php
function print_out($t,$desc,$month) {
  echo '<div id="top_wrap">' . "\n";
  echo '<div class="moduletable_menuhead">' . "\n";
  echo '<h3>Otros meses:</h3>' . "\n";
  echo '<ul id="head_nav" class="menu"><li class="item387"><a href="/Enero/01"><span>Enero</span></a></li><li class="item388"><a href="/Febrero/01"><span>Febrero</span></a></li><li class="item389"><a href="/Marzo/01"><span>Marzo</span></a></li><li class="item390"><a href="/Abril/01"><span>Abril</span></a></li><li class="item391"><a href="/Mayo/01"><span>Mayo</span></a></li><li class="item392"><a href="/Junio/01"><span>Junio</span></a></li><li class="item393"><a href="/Julio/01"><span>Julio</span></a></li><li class="item394"><a href="/Agosto/01"><span>Agosto</span></a></li><li class="item395"><a href="/Septiembre/01"><span>Septiembre</span></a></li><li class="item396"><a href="/Octubre/01"><span>Octubre</span></a></li><li class="item397"><a href="/Noviembre/01"><span>Noviembre</span></a></li><li class="item398"><a href="/Diciembre/01"><span>Diciembre</span></a></li></ul>		</div>' . "\n";
  echo '<div id="head_logos">' . "\n";
  echo '<h1><a href="/">' . "\n";
  echo '<img src="/img/logo.png" alt="Day by Day VA - Calendario de alfabetización familiar" class="logo"></a>' . "\n";
  echo '<span class="month_button"><a href="/' . $month . '/">Actividades Mensuales</a></span>' . $month . '</h1>' . "\n";
  echo '</div>' . "\n";
  echo '<div id="subnav">' . "\n";
  echo '<div class="moduletable_days">' . "\n";
  echo '<ul class="menu">' . "\n";
  //date("n", strtotime($month)) was used as the second parameter in the cal_days_in_month() function below
  //but due to months being in Spanish we have to assign numbers manually
  switch ($month) {
    case 'Enero':
        $monthNum = 1;
        break;
    case 'Febrero':
		$monthNum = 2;
        break;
	case "Marzo":
		$monthNum = 3;
        break;
	case "Abril":
		$monthNum = 4;
        break;
	case "Mayo":
		$monthNum = 5;
        break;
	case "Junio":
		$monthNum = 6;
		break;
	case "Julio":
		$monthNum = 7;
		break;
	case "Agosto":
		$monthNum = 8;
		break;
	case "Septiembre":
		$monthNum = 9;
		break;
	case "Octubre":
		$monthNum = 10;
		break;
	case "Noviembre":
		$monthNum = 11;
		break;
	case "Diciembre":
		$monthNum = 12;
		break;
  }
  $numofdays = cal_days_in_month(CAL_GREGORIAN, $monthNum, date("Y"));
  for ($i = 1; $i <= $numofdays; $i++) {
    echo '<li><a class="nav_' . $i . '" href="/' . $month . '/' . str_pad($i,2,"0",STR_PAD_LEFT) . '"><span>' . $i . '</span></a></li>';
  }
  echo '</ul></div>' . "\n";
  echo '</div>' . "\n";
  echo '<div id="content_container">' . "\n";
  echo '<table class="contentpaneopen">';
  echo '<tbody><tr>';
  echo '<td width="100%" class="contentheading">' . $t . '</td>';
  echo '</tr>';
  echo '</tbody></table>';
  echo '<table class="contentpaneopen">';
  echo '<tbody><tr>';
  echo '<td valign="top">';
  echo $desc;
  echo '</td>';
  echo '</tr>';
  echo '</tbody></table>';
  echo '</div>';
  echo '</div>';
}
?>