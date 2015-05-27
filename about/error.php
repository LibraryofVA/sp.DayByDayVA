<?php 
if(isset($_REQUEST["err"])){
	$error = $_REQUEST["err"];	
} else {
	$error = "Unknown";
}
$title = "Error";
	if(isset($error) && $error != "Unknown"){
		$title .= " " . $error;
	}
    $title .= ": ". get_error_msg($error);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="imagetoolbar" content="false" />
<meta name="copyright" content="2014 (c) Library of Virginia" />
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="/img/va.ico" type="image/x-icon" />
<link rel="home" title="home" href="http://daybydayva.org/" />
<title><?php echo $title ?> | DayByDayVA Calendario de alfabetización familiar</title>
<meta content="Library of Virginia" name="Owner" />
<meta content="Day by Day reading program" name="Description" />
<meta content="day by day reading program" name="Keywords" />
<link href='http://fonts.googleapis.com/css?family=Gorditas' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="/daybyday.css" />
</head>
<body class="places_page">
  <div id="top_wrap">
	<div class="moduletable_menuhead">
	<h3>Try a different month:</h3>
	<ul id="head_nav" class="menu"><li class="item387"><a href="/Enero/01"><span>Enero</span></a></li><li class="item388"><a href="/Febrero/01"><span>Febrero</span></a></li><li class="item389"><a href="/Marzo/01"><span>Marzo</span></a></li><li class="item390"><a href="/Abril/01"><span>Abril</span></a></li><li class="item391"><a href="/Mayo/01"><span>Mayo</span></a></li><li class="item392"><a href="/Junio/01"><span>Junio</span></a></li><li class="item393"><a href="/Julio/01"><span>Julio</span></a></li><li class="item394"><a href="/Agosto/01"><span>Agosto</span></a></li><li class="item395"><a href="/Septiembre/01"><span>Septiembre</span></a></li><li class="item396"><a href="/Octubre/01"><span>Octubre</span></a></li><li class="item397"><a href="/Noviembre/01"><span>Noviembre</span></a></li><li class="item398"><a href="/Diciembre/01"><span>Diciembre</span></a></li></ul>		</div>
	<div id="head_logos">
	  <h1><a href="/">
        <img src="/img/logo.png" alt="Day by Day VA - Calendario de alfabetización familiar" class="logo"></a>
        <span class="month_button">&nbsp;</span><?php echo $error ?> Error</h1>
    </div>
    <div id="content_container">
      <p class="contentheading"><?php echo $title ?></p>
    </div>
  </div>
  <div id="bottom_wrap">
	<div class="moduletable">
	  <div id="activity_buttons">
        <h2>More Activities:</h2>
		<div style="float: left;"><p><a href="/arts/">ARTS &amp; CRAFTS</a></p></div>
		<div style="float: right;"><p><a href="/be-healthy/">BE HEALTHY</a></p></div>
		<div style="float: left;"><p><a href="/places">PLACES IN VA</a></p></div>
		<div style="float: right;"><p><a href="/reading/read-with-me">READ WITH ME</a></p></div>
	  </div>
  </div>
  <div class="moduletable">
    <div id="footer_logos">
      <p><a target="_blank" href="http://www.lva.virginia.gov/"><img alt="Librayr of Virginia Logo" src="/img/lva_logo.png"></a><a target="_blank" href="http://www.imls.gov/"><img alt="IMLS Logo" src="/img/imls_logo.png" style="margin-right: 10px;"></a>DayByDayVA is supported in part by a grant from the U.S. Institute of Museum and Library Services.</p>
	</div>
  </div>
  <div class="moduletable_footer_nav">
    <ul class="menu"><li><a href="/about"><span>About DayByDayVA</span></a></li><li><a href="/additional-resources"><span>Additional Resources</span></a></li><!--<li><a href="/partners-sponsors"><span>Partners &amp; Sponsors</span></a></li><li><a href="/print"><span>Print Version</span></a></li>--><li><a href="/site-map"><span>Site Map</span></a></li></ul>
  </div>
  </div>
</body>
</html>
<?php
function get_error_msg($e){
	switch($e){
		case "400":
			return "The request contains bad syntax or cannot be fulfilled.";
			break;
		case "401":
			return "You are not authorized to access the requested resource.";
			break;
		case "403":
			return "Access to the requested resource is forbidden.";
			break;
		case "404":
			return "The requested page cannot be found.";
			break;
		case "500":
			return "Internal Server Error";
			break;
		default:
			return "An error has occurred while processing your request.";
			break;
	}
}
?>