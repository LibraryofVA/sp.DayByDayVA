<?php
if(isset($_REQUEST["loc"])) {
  $locality = str_replace("_"," ",$_REQUEST["loc"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="false" />
<meta name="copyright" content="2009 (c) Library of Virginia" />
<meta name="robots" content="index, follow" />
<link rel="shortcut icon" href="/img/va.ico" type="image/x-icon" />
<link rel="home" title="home" href="http://daybydayva.org/" />
<title>Places in VA<?php if(isset($locality)) {echo " - " . $locality;} ?> | Day By Day Family-Literacy Calendar</title>
<meta content="Library of Virginia" name="Owner" />
<meta content="Day by Day reading program" name="Description" />
<meta content="day by day reading program" name="Keywords" />
<link href='http://fonts.googleapis.com/css?family=Gorditas' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="/daybyday.css" />
<script type="text/javascript" language="javascript" src="/js/jquery.js"></script>
<script type="text/javascript">
<!--//
$(document).ready(function(){
	var location_value = <?php echo "'" . $locality . "';\n" ?>
	if (location_value != '') {
	  displayResults();
	}
});

/**
 * Lists the entries from the specified JSON feed
 * by creating a new 'dl' element in the DOM.
 */
function showLibraries(json) {

  removeOldResults();
  
  /*** fields ***
	"gsx$libsysname":{"$t":"Alexandria Library"},
	"gsx$fscs":{"$t":"VA0001"},
	"gsx$outletid":{"$t":"002"},
	"gsx$outletfscs":{"$t":"VA0001_002"},
	"gsx$outletcode":{"$t":"CE"},
	"gsx$hq":{"$t":""},
	"gsx$weburl":{"$t":""},
	"gsx$faxnumber":{"$t":""},
	"gsx$branchphone":{"$t":"703-746-1702"},
	"gsx$branchaskusemail":{"$t":""},
	"gsx$outletname":{"$t":"Charles E. Beatley, Jr. Central Library"},
	"gsx$adr1":{"$t":"5005 Duke Street"},
	"gsx$adr2":{"$t":""},
	"gsx$adr3":{"$t":""},
	"gsx$city":{"$t":"Alexandria"},
	"gsx$zip":{"$t":"22304"},
	"gsx$state":{"$t":"VA"},
	"gsx$sundayhours":{"$t":"1pm-5pm"},
	"gsx$mondayhours":{"$t":"10am-9pm"},
	"gsx$tuesdayhours":{"$t":"10am-9pm"},
	"gsx$wednesdayhours":{"$t":"10am-9pm"},
	"gsx$thursdayhours":{"$t":"10am-9pm"},
	"gsx$fridayhours":{"$t":"10am-6pm"},
	"gsx$saturdayhours":{"$t":"10am-5pm"}},
	*/
  
  
  var dl = document.createElement('dl');
  dl.setAttribute('id', 'output');
  
  var currentLIB = "";
  var lastLIB = "";
  var printTitle = 0;

  for (var i = 0; i < json.feed.entry.length; i++) {
    
    var entry = json.feed.entry[i];

	lastLIB = currentLIB;
	currentLIB = entry.gsx$fscs.$t;
	
	if (currentLIB != lastLIB) {
		// this happens only once for each library system //
		printTitle = 0;
	}
	
	
	
	if (entry.gsx$outletcode.$t == "CE") {
		var centralDL = document.createElement('dl');
		var dt = document.createElement('dt');
		var dd = document.createElement('dd');
		var title = document.createTextNode("Central Library");
		dt.appendChild(title);
		centralDL.appendChild(dt);
		var content = document.createTextNode(entry.gsx$outletname.$t);
		dd.appendChild(content);
		centralDL.appendChild(dd);
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$adr1.$t);
		if (entry.gsx$adr2.$t) {
			content = content + document.createTextNode(", " + entry.gsx$adr2.$t);
		}
		dd.appendChild(content);
		centralDL.appendChild(dd);
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$city.$t + ", " + entry.gsx$state.$t + " " + entry.gsx$zip.$t);
		dd.appendChild(content);
		centralDL.appendChild(dd);
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$branchphone.$t);
		dd.appendChild(content);
		centralDL.appendChild(dd);
		
		document.getElementById('central').appendChild(centralDL);
	}
		
	if (entry.gsx$outletcode.$t == "BR") {
		if (printTitle == 0) {
			var dt = document.createElement('dt');
			var title = document.createTextNode("Branch Libraries");
			dt.appendChild(title);
			dl.appendChild(dt);
			printTitle = 1;
		}	
		var dd = document.createElement('dd');
		var content = document.createTextNode(entry.gsx$outletname.$t);
    	dd.appendChild(content);
		dl.appendChild(dd);
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$adr1.$t);
		dd.appendChild(content);
		dl.appendChild(dd);
		
		if (entry.gsx$adr2.$t) {
			dd = document.createElement('dd');
			content = document.createTextNode(entry.gsx$adr2.$t);
			dd.appendChild(content);
			dl.appendChild(dd);
		}
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$city.$t + ", " + entry.gsx$state.$t + " " + entry.gsx$zip.$t);
		dd.appendChild(content);
		dl.appendChild(dd);
		
		dd = document.createElement('dd');
		content = document.createTextNode(entry.gsx$branchphone.$t);
		dd.appendChild(content);
		dl.appendChild(dd);
		
		dd = document.createElement('dd');
		dd.innerHTML = "<br />";
		dl.appendChild(dd);
	}
  }
  
  document.getElementById('branches').appendChild(dl);
}

/**
 * Lists the entries from the specified JSON feed
 * by creating a new 'dl' element in the DOM.
 */
function showFestivals(json) {
  divFest = document.getElementById('festivals');
  if (divFest.firstChild) {
    divFest.removeChild(divFest.firstChild);
  }
  if (json.feed.entry != undefined) {
	var p = document.createElement('p');
    p.className = "subHeading blueText padded";
    p.appendChild(document.createTextNode('Family-Friendly Festivals'));
    divFest.appendChild(p);
	
	var dl = document.createElement('dl');
    dl.setAttribute('id', 'dlFest');
    var currentTown = "";
    var lastTown = "";

    for (var i = 0; i < json.feed.entry.length; i++) {
    
      var entry = json.feed.entry[i];
	  lastTown = currentTown;
	  currentTown = document.createTextNode(entry.gsx$town.$t);
	
	  if (currentTown.data != lastTown.data) {
	    var dt = document.createElement('dt');
	    var title = document.createTextNode(entry.gsx$town.$t);
	    dt.appendChild(title);
	    dl.appendChild(dt);
	  }
	  var dd = document.createElement('dd');
	  var ul = document.createElement('ul');
	  var li = document.createElement('li');

	  if (entry.gsx$website.$t) {
		li.innerHTML = entry.gsx$month.$t + ": <a href='" + entry.gsx$website.$t + "' target='_blank'>" + entry.gsx$festival.$t + "</a>";
	  }
	  else {
		li.innerHTML = entry.gsx$month.$t + ": " + entry.gsx$festival.$t;
	  }
	  ul.appendChild(li);
	  dd.appendChild(ul);
	  dl.appendChild(dd);
    }
  
    document.getElementById('festivals').appendChild(dl);
	var br = document.createElement('br');
	document.getElementById('festivals').appendChild(br);
  }
  
}

/**
 * Lists the entries from the specified JSON feed
 * by creating a new 'dl' element in the DOM.
 */
function showPlaces(json) {
  divPlace = document.getElementById('places');
  if (divPlace.firstChild) {
    divPlace.removeChild(divPlace.firstChild);
  }
  if (json.feed.entry != undefined) {
	var p = document.createElement('p');
    p.className = "subHeading blueText padded";
    p.appendChild(document.createTextNode('Family-Friendly Parks and Places'));
    divPlace.appendChild(p);
  
    var dl = document.createElement('dl');
    dl.setAttribute('id', 'dlPlace');

    for (var i = 0; i < json.feed.entry.length; i++) {
    
      var entry = json.feed.entry[i];
	  
	  var dt = document.createElement('dt');
	  if (entry.gsx$website.$t) {
	    dt.innerHTML  = "<a href='" + entry.gsx$website.$t + "' target='_blank'>" + entry.gsx$place.$t + "</a>";
	  }
	  else {
	    dt.innerHTML  = entry.gsx$place.$t;
	  }
	  dl.appendChild(dt);
	}
  
    document.getElementById('places').appendChild(dl);
	var br = document.createElement('br');
	document.getElementById('places').appendChild(br);
  
  
  }
}

/**
 * Creates a new 
 * script element in the DOM whose source is the JSON feed, 
 * and specifies that the callback function is 
 * 'listEntries' for a list feed and 'cellEntries' for a
 * cells feed (above).
 */
function displayResults() {
  removeOldJSONScriptNodes();
  removeOldResults();

  var branch = "VA0001";
  var loc = "<?php echo $locality ?>";
  switch(loc) {
	case 'Accomack County':
	  branch = "VA0024";
	  break;
	case 'Albemarle County':
	  branch = "VA0040";
	  break;
	case 'Alexandria':
	  branch = "VA0001";
	  break;
	case 'Alleghany County':
	  branch = "VA0015";
	  break;
	case 'Covington':
	  branch = "VA0015";
	  break;
	case 'Amelia County':
	  branch = "VA0039";
	  break;
	case 'Amherst County':
	  branch = "VA0002";
	  break;
	case 'Appomattox County':
	  branch = "VA0003";
	  break;
	case 'Arlington County':
	  branch = "VA0005";
	  break;
	case 'Augusta County':
	  branch = "VA0006";
	  break;
	case 'Bath County':
	  branch = "VA0071";
	  break;
	case 'Bedford County':
	  branch = "VA0007";
	  break;
	case 'Bedford':
	  branch = "VA0007";
	  break;
	case 'Bland County':
	  branch = "VA0077";
	  break;
	case 'Botetourt County':
	  branch = "VA0009";
	  break;
	case 'Bristol':
	  branch = "VA0010";
	  break;
	case 'Brunswick County':
	  branch = "VA0049";
	  break;
	case 'Buchanan County':
	  branch = "VA0011";
	  break;
	case 'Buckingham County':
	  branch = "VA0091";
	  break;
	case 'Buena Vista':
	  branch = "VA0071";
	  break;
	case 'Campbell County':
	  branch = "VA0012";
	  break;
	case 'Caroline County':
	  branch = "VA0013";
	  break;
	case 'Carroll County':
	  branch = "VA0031";
	  break;
	case 'Charles City County':
	  branch = "VA0037";
	  break;
	case 'Charlotte County':
	  branch = "VA0016";
	  break;
	case 'Charlottesville':
	  branch = "VA0040";
	  break;
	case 'Chesapeake':
	  branch = "VA0017";
	  break;
	case 'Chesterfield County':
	  branch = "VA0018";
	  break;
	case 'Clarke County':
	  branch = "VA0035";
	  break;
	case 'Clifton Forge':
	  branch = "VA0019";
	  break;
	case 'Colonial Heights':
	  branch = "VA0020";
	  break;
	case 'Craig County':
	  branch = "VA0093";
	  break;
	case 'Culpeper County':
	  branch = "VA0021";
	  break;
	case 'Cumberland County':
	  branch = "VA0022";
	  break;
	case 'Danville':
	  branch = "VA0023";
	  break;
	case 'Dickenson County':
	  branch = "VA0043";
	  break;
	case 'Dinwiddie County':
	  branch = "VA0004";
	  break;
	case 'Emporia':
	  branch = "VA0049";
	  break;
	case 'Essex County':
	  branch = "VA0025";
	  break;
	case 'Fairfax County':
	  branch = "VA0026";
	  break;
	case 'Fairfax':
	  branch = "VA0026";
	  break;
	case 'Falls Church':
	  branch = "VA0047";
	  break;
	case 'Fauquier County':
	  branch = "VA0028";
	  break;
	case 'Floyd County':
	  branch = "VA0051";
	  break;
	case 'Fluvanna County':
	  branch = "VA0029";
	  break;
	case 'Franklin County':
	  branch = "VA0030";
	  break;
	case 'Franklin':
	  branch = "VA0083";
	  break;
	case 'Frederick County':
	  branch = "VA0035";
	  break;
	case 'Fredericksburg':
	  branch = "VA0014";
	  break;
	case 'Galax':
	  branch = "VA0031";
	  break;
	case 'Giles County':
	  branch = "VA0058";
	  break;
	case 'Gloucester County':
	  branch = "VA0032";
	  break;
	case 'Goochland County':
	  branch = "VA0057";
	  break;
	case 'Grayson County':
	  branch = "VA0087";
	  break;
	case 'Greene County':
	  branch = "VA0040";
	  break;
	case 'Greensville County':
	  branch = "VA0049";
	  break;
	case 'Halifax County':
	  branch = "VA0033";
	  break;
	case 'Hampton':
	  branch = "VA0034";
	  break;
	case 'Hanover County':
	  branch = "VA0057";
	  break;
	case 'Harrisonburg':
	  branch = "VA0072";
	  break;
	case 'Henrico County':
	  branch = "VA0036";
	  break;
	case 'Henry County':
	  branch = "VA0008";
	  break;
	case 'Highland County':
	  branch = "VA0038";
	  break;
	case 'Hopewell':
	  branch = "VA0004";
	  break;
	case 'Isle of Wight County':
	  branch = "VA0083";
	  break;
	case 'James City County':
	  branch = "VA0086";
	  break;
	case 'King and Queen County':
	  branch = "VA0057";
	  break;
	case 'King George County':
	  branch = "VA0042";
	  break;
	case 'King William County':
	  branch = "VA0057";
	  break;
	case 'Lancaster County':
	  branch = "VA0041";
	  break;
	case 'Lee County':
	  branch = "VA0043";
	  break;
	case 'Lexington':
	  branch = "VA0071";
	  break;
	case 'Loudoun County':
	  branch = "VA0044";
	  break;
	case 'Louisa County':
	  branch = "VA0040";
	  break;
	case 'Lunenburg County':
	  branch = "VA0078";
	  break;
	case 'Lynchburg':
	  branch = "VA0045";
	  break;
	case 'Madison County':
	  branch = "VA0046";
	  break;
	case 'Manassas':
	  branch = "VA0064";
	  break;
	case 'Manassas Park':
	  branch = "VA0064";
	  break;
	case 'Martinsville':
	  branch = "VA0008";
	  break;
	case 'Mathews County':
	  branch = "VA0048";
	  break;
	case 'Mecklenburg County':
	  branch = "VA0078";
	  break;
	case 'Middlesex County':
	  branch = "VA0050";
	  break;
	case 'Montgomery County':
	  branch = "VA0051";
	  break;
	case 'Nelson County':
	  branch = "VA0040";
	  break;
	case 'New Kent County':
	  branch = "VA0037";
	  break;
	case 'Newport News':
	  branch = "VA0053";
	  break;
	case 'Norfolk':
	  branch = "VA0054";
	  break;
	case 'Northampton County':
	  branch = "VA0024";
	  break;
	case 'Northumberland County':
	  branch = "VA0090";
	  break;
	case 'Norton':
	  branch = "VA0043";
	  break;
	case 'Nottoway County':
	  branch = "VA0055";
	  break;
	case 'Orange County':
	  branch = "VA0056";
	  break;
	case 'Page County':
	  branch = "VA0072";
	  break;
	case 'Patrick County':
	  branch = "VA0008";
	  break;
	case 'Pearisburg, Town of':
	  branch = "VA0058";
	  break;
	case 'Petersburg':
	  branch = "VA0059";
	  break;
	case 'Pittsylvania County':
	  branch = "VA0060";
	  break;
	case 'Poquoson':
	  branch = "VA0061";
	  break;
	case 'Portsmouth':
	  branch = "VA0062";
	  break;
	case 'Powhatan County':
	  branch = "VA0063";
	  break;
	case 'Prince George County':
	  branch = "VA0004";
	  break;
	case 'Prince William County':
	  branch = "VA0064";
	  break;
	case 'Prince Edward County':
	  branch = "VA0091";
	  break;
	case 'Pulaski County':
	  branch = "VA0065";
	  break;
	case 'Radford':
	  branch = "VA0066";
	  break;
	case 'Rappahannock County':
	  branch = "VA0067";
	  break;
	case 'Richmond County':
	  branch = "VA0092";
	  break;
	case 'Richmond':
	  branch = "VA0068";
	  break;
	case 'Roanoke County':
	  branch = "VA0070";
	  break;
	case 'Roanoke':
	  branch = "VA0069";
	  break;
	case 'Rockbridge County':
	  branch = "VA0071";
	  break;
	case 'Rockingham County':
	  branch = "VA0072";
	  break;
	case 'Russell County':
	  branch = "VA0073";
	  break;
	case 'Salem':
	  branch = "VA0074";
	  break;
	case 'Scott County':
	  branch = "VA0043";
	  break;
	case 'Shenandoah County':
	  branch = "VA0076";
	  break;
	case 'Smyth County':
	  branch = "VA0077";
	  break;
	case 'South Boston':
	  branch = "VA0033";
	  break;
	case 'Southampton County':
	  branch = "VA0083";
	  break;
	case 'Spotsylvania County':
	  branch = "VA0014";
	  break;
	case 'Stafford County':
	  branch = "VA0014";
	  break;
	case 'Staunton':
	  branch = "VA0079";
	  break;
	case 'Suffolk':
	  branch = "VA0080";
	  break;
	case 'Surry County':
	  branch = "VA0083";
	  break;
	case 'Sussex County':
	  branch = "VA0083";
	  break;
	case 'Tazewell County':
	  branch = "VA0081";
	  break;
	case 'Virginia Beach':
	  branch = "VA0082";
	  break;
	case 'Warren County':
	  branch = "VA0075";
	  break;
	case 'Washington County':
	  branch = "VA0084";
	  break;
	case 'Waynesboro':
	  branch = "VA0085";
	  break;
	case 'Westmoreland County':
	  branch = "VA0014";
	  break;
	case 'Williamsburg':
	  branch = "VA0086";
	  break;
	case 'Winchester':
	  branch = "VA0035";
	  break;
	case 'Wise County':
	  branch = "VA0043";
	  break;
	case 'Wythe County':
	  branch = "VA0087";
	  break;
	case 'York County':
	  branch = "VA0088";
	  break;
	default:
	  //default what to do ?
  }
  // Show a "Loading..." indicator.
  var div = document.getElementById('branches');
  var p = document.createElement('p');
  p.appendChild(document.createTextNode('Loading...'));
  div.appendChild(p);

  // Retrieve the JSON feed.
  var script = document.createElement('script');

  script.setAttribute('src', 'http://spreadsheets.google.com/feeds/list/0AjQpFVzYWoqGdHRGYWpmd1FMTnRFaDJXZktqd0dTZ1E/od6/public/values?alt=json-in-script&sq=fscs%3D' + branch + '&callback=showLibraries');
  script.setAttribute('id', 'jsonScript');
  script.setAttribute('type', 'text/javascript');
  document.documentElement.firstChild.appendChild(script);
  
  var divFest = document.getElementById('festivals');
  var script2 = document.createElement('script');
  script2.setAttribute('src', 'http://spreadsheets.google.com/feeds/list/0An2JWOB_ICtOdEEtdUpzSGZNTk5PeU45bElqNGFkOFE/od6/public/values?alt=json-in-script&sq=fscs%3D' + branch + '&callback=showFestivals');
  script2.setAttribute('id', 'jsonScript2');
  script2.setAttribute('type', 'text/javascript');
  divFest.appendChild(script2);
  
  var divPlace = document.getElementById('places');
  var script3 = document.createElement('script');
  script3.setAttribute('src', 'https://spreadsheets.google.com/feeds/list/0An2JWOB_ICtOdE84YzV1OEc4VUk0MHpXUy1OWVVEUVE/od6/public/values?alt=json-in-script&sq=fscs%3D' + branch + '&callback=showPlaces');
  script3.setAttribute('id', 'jsonScript3');
  script3.setAttribute('type', 'text/javascript');
  divPlace.appendChild(script3);
}

/**
 * Removes the script element from the previous result.
 */
function removeOldJSONScriptNodes() {
  var jsonScript = document.getElementById('jsonScript');
  if (jsonScript) {
    jsonScript.parentNode.removeChild(jsonScript);
  }
}

/**
 * Removes the output generated from the previous result.
 */
function removeOldResults() {
  var div = document.getElementById('branches');
  if (div.firstChild) {
    div.removeChild(div.firstChild);
  }
}

function getQuerystring(key, default_)
{
  if (default_==null) default_="";
  key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  var qs = regex.exec(window.location.href);
  if(qs == null)
    return default_;
  else
    return qs[1];
}
//-->
</script>
</head>
<body class="places_page">
  <div id="top_wrap">
    <div class="moduletable_menuhead">
	  <h3>Try a different month:</h3>
      <ul id="head_nav" class="menu"><li class="item387"><a href="/January/01"><span>January</span></a></li><li class="item388"><a href="/February/01"><span>February</span></a></li><li class="item389"><a href="/March/01"><span>March</span></a></li><li class="item390"><a href="/April/01"><span>April</span></a></li><li class="item391"><a href="/May/01"><span>May</span></a></li><li class="item392"><a href="/June/01"><span>June</span></a></li><li class="item393"><a href="/July/01"><span>July</span></a></li><li class="item394"><a href="/August/01"><span>August</span></a></li><li class="item395"><a href="/September/01"><span>September</span></a></li><li class="item396"><a href="/October/01"><span>October</span></a></li><li class="item397"><a href="/November/01"><span>November</span></a></li><li class="item398"><a href="/December/01"><span>December</span></a></li></ul>
    </div>
	<div id="head_logos">
      <h1><a href="/"><img src="/img/logo.png" alt="Day by Day Family Literacy Calendar" class="logo"></a><span class="month_button"></span>Places in Virginia</h1>
	</div>
    <div id="content_container">
<?php if(isset($_REQUEST["loc"])) { ?>
      <br />
      <p class="heading blueText padded"><a href="/places"><img border="0" alt="Back to the map" src="/img/backtomap.png" /></a> <?php echo $locality ?></p>
      <p class="subHeading blueText padded">Public Library Information</p>
	  <div id="central"></div>
	  <div id="branches"></div>
      <div id="festivals"></div>
      <div id="places"></div>
<?php }
else {
?>          
	  <p class="heading blueText padded">Things to Do and See for Your Family</p>
          <table class="contentpaneopen">
            <tbody>
              <tr>
                <td class="contentsubheading">click your county below to explore more!</td>
              </tr>
              <tr>
                <td><img src="/img/virginia.jpg" usemap="#ImageMap_564564891" />
                  <map id="ImageMap_564564891" name="ImageMap_564564891">
                    <area title="Alexandria" alt="Alexandria" coords="219,42,276,51" shape="rect" href="/places/Alexandria" />
                    <area title="Bedford" alt="Bedford" coords="219,51,276,59" shape="rect" href="/places/Bedford" />
                    <area title="Bristol" alt="Bristol" coords="219,59,276,69" shape="rect" href="/places/Bristol" />
                    <area title="Buena Vista" alt="Buena Vista" coords="219,69,276,78" shape="rect" href="/places/Buena_Vista" />
                    <area title="Charlottesville" alt="Charlottesville" coords="219,78,281,87" shape="rect" href="/places/Charlottesville" />
                    <area title="Chesapeake" alt="Chesapeake" coords="219,87,281,96" shape="rect" href="/places/Chesapeake" />
                    <area title="Clifton Forge" alt="Clifton Forge" coords="219,97,281,105" shape="rect" href="/places/Clifton_Forge" />
                    
                    <area title="Colonial Heights" alt="Colonial Heights" coords="219,106,287,106,287,117,272,117,269,115,219,115" shape="poly" href="/places/Colonial_Heights" />
                    <area title="Covington" alt="Covington" coords="219,115,269,124" shape="rect" href="/places/Covington" />
                    <area title="Danville" alt="Danville" coords="219,124,269,133" shape="rect" href="/places/Danville" />
                    <area title="Emporia" alt="Emporia" coords="219,133,283,142" shape="rect" href="/places/Emporia" />
                    <area title="Fairfax" alt="Fairfax" coords="219,142,283,151" shape="rect" href="/places/Fairfax" />
                    <area title="Falls Church" alt="Falls Church" coords="219,151,283,160" shape="rect" href="/places/Falls_Church" />
                    <area title="Franklin" alt="Franklin" coords="219,160,283,169" shape="rect" href="/places/Franklin" />
                    <area title="Fredericksburg" alt="Fredericksburg" coords="219,169,286,178" shape="rect" href="/places/Fredericksburg" />
                    <area title="Galax" alt="Galax" coords="219,178,273,187" shape="rect" href="/places/Galax" />
                    <area title="Hampton" alt="Hampton" coords="219,187,273,196" shape="rect" href="/places/Hampton" />
                    <area title="Hopewell" alt="Hopewell" coords="219,206,273,215" shape="rect" href="/places/Hopewell" />
                    <area title="Harrisonburg" alt="Harrisonburg" coords="219,196,282,196,282,208,275,208,273,206,219,206" shape="poly" href="/places/Harrisonburg" />
                    <area title="Lexington" alt="Lexington" coords="219,215,273,226" shape="rect" href="/places/Lexington" />
                    <area title="Lynchburg" alt="Lynchburg" coords="288,41,343,51" shape="rect" href="/places/Lynchburg" />
                    <area title="Manassas" alt="Manassas" coords="288,51,343,60" shape="rect" href="/places/Manassas" />
                    <area title="Manassas Park" alt="Manassas Park" coords="287,60,356,69" shape="rect" href="/places/Manassas_Park" />
                    <area title="Martinsville" alt="Martinsville" coords="287,69,346,78" shape="rect" href="/places/Martinsville" />
                    <area title="Newport News" alt="Newport News" coords="287,78,353,87" shape="rect" href="/places/Newport_News" />
                    <area title="Norfolk" alt="Norfolk" coords="287,87,334,96" shape="rect" href="/places/Norfolk" />
                    <area title="Norton" alt="Norton" coords="287,96,334,105" shape="rect" href="/places/Norton" />
                    <area title="Petersburg" alt="Petersburg" coords="287,105,341,115" shape="rect" href="/places/Petersburg" />
                    <area title="Poquoson" alt="Poquoson" coords="287,115,341,124" shape="rect" href="/places/Poquoson" />
                    <area title="Portsmouth" alt="Portsmouth" coords="287,124,344,133" shape="rect" href="/places/Portsmouth" />
                    <area title="Radford" alt="Radford" coords="287,133,342,142" shape="rect" href="/places/Radford" />
                    <area title="Richmond" alt="Richmond" coords="287,142,342,151" shape="rect" href="/places/Richmond" />
                    <area title="Roanoke" alt="Roanoke" coords="287,151,342,160" shape="rect" href="/places/Roanoke" />
                    <area title="Salem" alt="Salem" coords="287,160,342,169" shape="rect" href="/places/Salem" />
                    <area title="Staunton" alt="Staunton" coords="287,169,339,178" shape="rect" href="/places/Staunton" />
                    <area title="Suffolk" alt="Suffolk" coords="287,178,339,187" shape="rect" href="/places/Suffolk" />
                    <area title="Virginia Beach" alt="Virginia Beach" coords="287,187,353,197" shape="rect" href="/places/Virginia_Beach" />
                    <area title="Waynesboro" alt="Waynesboro" coords="287,197,350,206" shape="rect" href="/places/Waynesboro" />
                    <area title="Williamsburg" alt="Williamsburg" coords="287,206,350,215" shape="rect" href="/places/Williamsburg" />
                    <area title="Winchester" alt="Winchester" coords="287,215,342,224" shape="rect" href="/places/Winchester" />
                    
                    <area title="Arlington County" alt="Arlington County" coords="687,88,640,88,639,96,632,103,640,108,668,103,687,103" shape="poly" href="/places/Arlington_County" />
                    <area title="Alexandria" alt="Alexandria" coords="688,115,645,116,635,113,636,108,656,106,687,103" shape="poly" href="/places/Alexandria" />
                    <area title="Fairfax County" alt="Fairfax County" coords="644,115,648,118,643,136,628,135,623,125,615,123,600,109,616,84,638,97,631,103,634,112" shape="poly" href="/places/Fairfax_County" />
                    <area title="Prince William County" alt="Prince William County" coords="628,131,623,149,611,141,606,138,601,143,584,110,589,97,596,103,600,105,600,109,616,123,625,127,629,135" shape="poly" href="/places/Prince_William_County" />
                    <area title="Loudoun County" alt="Loudoun County" coords="622,78,600,109,599,104,594,102,589,97,561,90,573,76,582,49,603,57" shape="poly" href="/places/Loudoun_County" />
                    <area title="Frederick County" alt="Frederick County" coords="527,38,556,62,555,62,545,88,531,91,528,80,521,81,517,89,508,85" shape="poly" href="/places/Frederick_County" />
                    <area title="Clarke County" alt="Clarke County" coords="557,62,571,75,573,76,557,95,554,91,547,90,545,87" shape="poly" href="/places/Clarke_County" />
                    <area title="Stafford County" alt="Stafford County" coords="622,149,606,138,593,151,594,162,596,167,598,166,601,169,606,169,610,172,616,178,620,176,620,166,624,165" shape="poly" href="/places/Stafford_County" />
                    <area title="Fauquier County" alt="Fauquier County" coords="601,142,592,153,592,158,582,158,576,145,573,144,570,139,571,134,568,128,563,127,558,125,556,115,547,108,548,105,552,105,553,101,562,91,589,97,584,111" shape="poly" href="/places/Fauquier_County" />
                    <area title="Shenandoah County" alt="Shenandoah County" coords="530,91,527,80,522,80,518,89,508,86,470,110,501,138,510,123,513,123,529,106,528,102,531,101" shape="poly" href="/places/Shenandoah_County" />
                    <area title="Warren County" alt="Warren County" coords="558,94,554,90,530,91,528,96,532,99,525,111,534,120,541,117,548,107,552,106,552,101" shape="poly" href="/places/Warren_County" />
                    <area title="Rappahannock County" alt="Rappahannock County" coords="546,108,542,113,542,117,531,123,529,127,530,129,528,135,538,147,545,146,564,126,558,124,555,115" shape="poly" href="/places/Rappahannock_County" />
                    <area title="Culpeper County" alt="Culpeper County" coords="592,159,583,157,574,144,571,140,571,135,568,129,567,126,564,127,545,146,539,146,548,156,551,161,549,164,551,170,555,170,568,165,567,162,579,163,579,161,587,166,591,163,595,164" shape="poly" href="/places/Culpeper_County" />
                    <area title="King George County" alt="King George County" coords="646,155,620,166,619,177,624,179,626,176,629,177,628,183,632,183,643,188,646,184,646,175,652,172" shape="poly" href="/places/King_George_County" />
                    <area title="Page County" alt="Page County" coords="524,112,512,124,509,122,497,148,515,158,520,147,526,143,529,136,531,129,529,124,535,120" shape="poly" href="/places/Page_County" />
                    <area title="Rockingham County" alt="Rockingham County" coords="498,149,501,139,469,110,446,150,476,172,480,172,491,183,499,177,509,168,515,158" shape="poly" href="/places/Rockingham_County" />
                    <area title="Madison County" alt="Madison County" coords="530,135,525,138,524,144,519,146,520,162,528,175,533,176,539,181,552,172,551,161" shape="poly" href="/places/Madison_County" />
                    <area title="Greene County" alt="Greene County" coords="518,152,509,168,499,175,526,186,534,176,528,175" shape="poly" href="/places/Greene_County" />
                    <area title="Orange County" alt="Orange County" coords="587,165,581,162,579,165,569,162,558,167,557,171,550,171,538,181,534,175,527,186,542,193,552,190,564,193,584,169" shape="poly" href="/places/Orange_County" />
                    <area title="Spotsylvania County" alt="Spotsylvania County" coords="617,178,610,172,607,174,602,169,591,164,586,165,565,192,574,195,592,207" shape="poly" href="/places/Spotsylvania_County" />
                    <area title="Westmoreland County" alt="Westmoreland County" coords="694,198,687,186,705,180,705,168,654,171,646,175,647,184,642,187,647,188,647,194,651,192,656,196,662,190,667,197,670,196,673,202,672,204,683,207,686,202" shape="poly" href="/places/Westmoreland_County" />
                    <area title="Northumberland County" alt="Northumberland County" coords="705,180,686,186,694,198,685,204,684,207,691,211,693,218,701,224,704,223,705,227,709,228,710,236,714,224,717,224,721,218,720,214,706,207,714,196,736,196,728,175" shape="poly" href="/places/Northumberland_County" />
                    <area title="Accomack County" alt="Accomack County" coords="821,193,728,206,720,214,731,254,757,253,762,253,762,262,789,264" shape="poly" href="/places/Accomack_County" />
                    <area title="Northampton County" alt="Northampton County" coords="790,265,761,262,761,255,758,251,730,255,733,310,757,317" shape="poly" href="/places/Northampton_County" />
                    <area title="York County" alt="York County" coords="732,284,711,285,699,291,683,274,676,277,675,280,678,289,694,294,704,307,709,305,707,300,714,299,721,304,731,300" shape="poly" href="/places/York_County" />
                    <area title="Hampton" alt="Hampton" coords="732,300,717,307,711,305,705,307,705,315,710,318,730,316" shape="poly" href="/places/Hampton" />
                    <area title="Newport News" alt="Newport News" coords="705,308,694,292,691,294,691,298,687,300,689,310,704,317" shape="poly" href="/places/Newport_News" />
                    <area title="James City County" alt="James City County" coords="684,276,676,264,673,269,671,269,669,267,662,270,661,278,664,277,664,293,671,293,677,298,679,294,683,293,689,298,691,298,690,289,685,289,681,286,677,285,676,277" shape="poly" href="/places/James_City_County" />
                    <area title="Richmond County" alt="Richmond County" coords="697,222,692,219,691,212,681,205,674,204,670,197,667,197,661,190,655,194,659,206,662,206,665,212,672,218,673,217,683,226,689,225,690,223" shape="poly" href="/places/Richmond_County" />
                    <area title="Lancaster County" alt="Lancaster County" coords="721,251,716,240,709,236,709,229,705,227,703,224,697,222,691,221,683,227,696,246" shape="poly" href="/places/Lancaster_County" />
                    <area title="Mathews County" alt="Mathews County" coords="728,255,706,257,703,261,703,270,706,270,716,283,728,285" shape="poly" href="/places/Mathews_County" />
                    <area title="Middlesex County" alt="Middlesex County" coords="687,231,682,229,674,234,675,240,680,248,688,252,702,260,707,257,722,256,717,249,699,246,693,244" shape="poly" href="/places/Middlesex_County" />
                    <area title="Essex County" alt="Essex County" coords="683,229,672,217,662,207,660,206,657,195,648,194,645,188,640,186,640,189,638,192,635,196,639,203,644,204,644,212,649,214,650,223,656,225,657,229,669,228,674,233" shape="poly" href="/places/Essex_County" />
                    <area title="Caroline County" alt="Caroline County" coords="640,188,628,183,628,179,617,175,593,207,596,212,600,212,608,218,611,218,616,231,621,229,628,218,628,215,635,218,635,210,638,208,644,211,644,204,640,203,636,196" shape="poly" href="/places/Caroline_County" />
                    <area title="King and Queen County" alt="King and Queen County" coords="644,208,638,208,634,210,635,217,643,229,644,233,658,241,670,252,671,260,679,268,683,266,684,261,681,254,682,249,675,240,675,234,669,228,657,228,657,223,649,223,648,214" shape="poly" href="/places/King_and_Queen_County" />
                    <area title="King William County" alt="King William County" coords="670,258,673,256,669,252,662,243,658,240,656,240,646,236,642,228,637,219,629,217,628,221,620,230,625,237,631,238,634,241,641,244,642,248,652,254,656,252,656,254,662,255,665,260" shape="poly" href="/places/King_William_County" />
                    <area title="Gloucester County" alt="Gloucester County" coords="704,260,694,253,682,249,682,258,685,262,683,266,679,268,699,291,712,286,703,276,707,272,707,270,703,270" shape="poly" href="/places/Gloucester_County" />
                    <area title="New Kent County" alt="New Kent County" coords="671,258,668,256,664,259,661,255,653,254,651,254,640,246,639,252,636,251,630,258,636,265,641,266,643,269,663,276,662,270,666,268,672,269,676,267" shape="poly" href="/places/New_Kent_County" />
                    <area title="Hanover County" alt="Hanover County" coords="642,248,640,244,634,244,634,242,630,241,630,239,625,238,621,230,615,230,611,218,607,218,600,211,596,211,589,206,579,237,587,240,596,239,600,243,602,243,605,240,606,240,609,242,612,242,615,250,624,256,631,257,635,252,639,252" shape="poly" href="/places/Hanover_County" />
                    <area title="Henrico County" alt="Henrico County" coords="611,251,601,258,593,256,595,254,593,249,594,240,597,240,600,242,604,240,613,243,615,250,624,256,630,257,637,264,632,272,634,276,630,275,628,279,625,277,618,276,613,269,614,262,616,261,615,256" shape="poly" href="/places/Henrico_County" />
                    <area title="Richmond" alt="Richmond" coords="612,252,604,253,598,258,604,260,607,267,613,268,616,261" shape="poly" href="/places/Richmond" />
                    <area title="Highland County" alt="Highland County" coords="440,160,428,155,412,125,393,173,404,182,422,186,425,182,429,182" shape="poly" href="/places/Highland_County" />
                    <area title="Augusta County" alt="Augusta County" coords="449,153,430,181,425,183,420,190,429,188,425,199,456,222,465,217,469,220,477,215,481,204,489,198,490,183,480,174,475,173" shape="poly" href="/places/Augusta_County" />
                    <area title="Albemarle County" alt="Albemarle County" coords="541,191,501,177,492,182,489,193,491,197,483,202,499,239,503,239,506,235,514,235" shape="poly" href="/places/Albemarle_County" />
                    <area title="Louisa County" alt="Louisa County" coords="579,237,576,234,570,234,564,223,562,223,559,218,540,211,540,208,533,206,541,192,553,190,572,193,586,205" shape="poly" href="/places/Louisa_County" />
                    <area title="Charles City County" alt="Charles City County" coords="636,264,628,283,641,285,642,284,645,284,646,288,652,285,654,285,656,291,661,294,664,293,664,277,651,270,643,269" shape="poly" href="/places/Charles_City_County" />
                    <area title="Fluvanna County" alt="Fluvanna County" coords="555,217,532,206,515,232,519,235,539,243,541,238,546,236" shape="poly" href="/places/Fluvanna_County" />
                    <area title="Goochland County" alt="Goochland County" coords="555,217,545,236,551,240,552,244,563,249,566,247,565,246,567,241,576,248,578,251,582,249,592,256,597,254,592,250,594,240,586,240,575,234,571,234,566,223,560,223" shape="poly" href="/places/Goochland_County" />
                    <area title="Chesterfield County" alt="Chesterfield County" coords="593,257,581,267,579,271,573,274,572,279,576,282,579,282,579,287,584,291,587,287,592,287,593,290,597,290,602,295,612,295,619,292,619,286,629,283,629,280,625,279,624,276,617,276,616,273,612,271,613,268,605,267,603,260,599,259,597,256" shape="poly" href="/places/Chesterfield_County" />
                    <area title="Surry County" alt="Surry County" coords="655,290,652,292,650,296,646,298,638,307,645,310,654,313,658,325,681,313,684,303,683,297,679,302,672,296,663,294" shape="poly" href="/places/Surry_County" />
                    <area title="Prince George County" alt="Prince George County" coords="656,291,652,284,645,288,644,284,629,283,622,285,617,293,623,299,617,301,618,320,639,306,652,296,652,294" shape="poly" href="/places/Prince_George_County" />
                    <area title="Bath County" alt="Bath County" coords="392,173,371,213,376,214,379,211,384,212,389,221,402,221,406,225,411,222,426,198,424,196,430,189,424,189,421,191,422,187,414,184,404,182" shape="poly" href="/places/Bath_County" />
                    <area title="Alleghany County" alt="Alleghany County" coords="374,212,351,237,352,248,362,251,365,254,375,247,376,248,382,244,390,238,394,230,407,235,414,224,410,222,406,225,402,221,392,222,389,219,386,213,379,212,377,214,372,213" shape="poly" href="/places/Alleghany_County" />
                    <area title="Craig County" alt="Craig County" coords="376,246,369,250,366,254,357,251,331,267,338,285,349,280,355,283,360,279,366,278,375,270,377,265,381,259" shape="poly" href="/places/Craig_County" />
                    <area title="Botetourt County" alt="Botetourt County" coords="408,234,395,230,376,249,381,259,372,274,393,286,397,283,398,279,396,275,408,266,415,272,424,261,418,257,417,254,408,247,409,244,407,239" shape="poly" href="/places/Botetourt_County" />
                    <area title="Roanoke County" alt="Roanoke County" coords="371,274,366,278,359,279,355,283,355,287,361,296,362,309,367,309,372,303,378,303,380,307,383,307,389,298,392,297,392,286" shape="poly" href="/places/Roanoke_County" />
                    <area title="Montgomery County" alt="Montgomery County" coords="354,283,348,281,321,295,331,307,326,311,327,323,346,320,361,308,361,297" shape="poly" href="/places/Montgomery_County" />
                    <area title="Pulaski County" alt="Pulaski County" coords="320,295,293,308,296,316,310,336,330,324,326,311,323,307,330,303" shape="poly" href="/places/Pulaski_County" />
                    <area title="Giles County" alt="Giles County" coords="333,267,299,270,287,289,300,305,338,287" shape="poly" href="/places/Giles_County" />
                    <area title="Rockbridge County" alt="Rockbridge County" coords="426,197,410,223,415,224,408,235,407,246,416,253,418,256,424,261,430,257,428,253,438,247,441,242,444,233,448,229,452,233,455,228,455,221,426,198" shape="poly" href="/places/Rockbridge_County" />
                    <area title="Bland County" alt="Bland County" coords="287,287,282,287,265,294,264,296,261,295,263,301,257,302,256,305,262,307,262,308,255,313,247,314,243,316,251,326,255,325,260,318,266,315,269,318,272,318,272,317,276,318,283,315,288,315,293,312,292,308,300,304,286,290" shape="poly" href="/places/Bland_County" />
                    <area title="Tazewell County" alt="Tazewell County" coords="254,282,219,292,217,297,204,302,205,307,214,324,220,323,223,327,226,327,234,321,239,320,246,319,244,316,249,314,254,314,261,310,262,306,256,304,257,303,263,301,260,297,266,294,254,281" shape="poly" href="/places/Tazewell_County" />
                    <area title="Buchanan County" alt="Buchanan County" coords="219,291,202,256,196,256,167,282,173,287,174,296,182,314,189,314,193,311,194,305,204,304,207,300,216,297" shape="poly" href="/places/Buchanan_County" />
                    <area title="Dickenson County" alt="Dickenson County" coords="168,283,144,292,143,301,150,313,161,323,168,318,170,319,177,314,182,314,177,300,172,292,172,287" shape="poly" href="/places/Dickenson_County" />
                    <area title="Wise County" alt="Wise County" coords="143,294,106,313,113,329,122,340,124,337,128,337,130,339,135,331,159,331,167,329,165,321,161,323,150,315,149,311,145,302" shape="poly" href="/places/Wise_County" />
                    <area title="Lee County" alt="Lee County" coords="113,329,93,331,37,357,37,361,101,364,106,352,117,347,117,345,121,341,121,338" shape="poly" href="/places/Lee_County" />
                    <area title="Scott County" alt="Scott County" coords="122,338,122,339,121,342,119,342,117,343,117,347,106,353,102,363,166,366,162,347,157,331,135,331,130,338,125,337" shape="poly" href="/places/Scott_County" />
                    <area title="Russell County" alt="Russell County" coords="204,304,194,304,190,313,179,314,171,319,167,319,163,321,167,329,157,331,162,351,183,342,184,338,185,335,189,335,195,333,199,335,205,332,214,323,210,314" shape="poly" href="/places/Russell_County" />
                    <area title="Washington County" alt="Washington County" coords="209,328,199,336,188,334,183,337,183,342,175,344,162,352,164,366,223,368,224,364,230,364,229,362,221,343,209,327" shape="poly" href="/places/Washington_County" />
                    <area title="Wythe County" alt="Wythe County" coords="294,312,276,318,274,316,271,318,266,314,259,319,251,325,262,348,275,348,281,344,309,335,293,314" shape="poly" href="/places/Wythe_County" />
                    <area title="Smyth County" alt="Smyth County" coords="246,319,240,319,234,320,225,328,223,328,221,323,210,325,209,328,221,344,228,362,236,359,236,355,263,348,252,325" shape="poly" href="/places/Smyth_County" />
                    <area title="Grayson County" alt="Grayson County" coords="282,344,278,345,277,348,262,348,236,355,236,358,229,362,227,364,223,364,223,368,301,373,282,343,278,345,277,348,261,348" shape="poly" href="/places/Grayson_County" />
                    <area title="Carroll County" alt="Carroll County" coords="319,329,315,331,315,333,282,343,301,373,322,373,321,369,320,365,322,361,326,361,328,363,336,359,336,355,321,330,315,332,315,334" shape="poly" href="/places/Carroll_County" />
                    <area title="Floyd County" alt="Floyd County" coords="367,309,361,309,353,313,347,320,328,323,320,329,334,355,336,352,342,352,342,345,346,343,346,341,357,336,361,328,364,327,367,321" shape="poly" href="/places/Floyd_County" />
                    <area title="Patrick County" alt="Patrick County" coords="357,336,347,341,345,344,342,346,340,351,336,351,334,354,336,359,333,362,323,362,320,366,321,373,373,377,373,366,370,354,369,347,374,346,371,340" shape="poly" href="/places/Patrick_County" />
                    <area title="Henry County" alt="Henry County" coords="377,346,370,346,369,354,372,362,374,377,404,377,411,341,404,343,400,346,378,341" shape="poly" href="/places/Henry_County" />
                    <area title="Franklin County" alt="Franklin County" coords="398,297,391,297,389,298,385,304,384,304,382,305,383,306,379,306,378,303,372,303,365,307,368,313,369,320,365,327,362,327,356,337,371,341,376,347,378,342,400,347,404,342,411,342,415,318,411,309,407,306,405,305,403,301" shape="poly" href="/places/Franklin_County" />
                    <area title="Bedford County" alt="Bedford County" coords="434,253,427,252,429,257,424,261,418,267,417,272,408,266,395,275,399,279,393,287,392,296,397,298,415,318,420,317,426,322,428,321,425,316,430,315,448,277,445,272,452,269,450,264,441,264,434,254" shape="poly" href="/places/Bedford_County" />
                    <area title="Pittsylvania County" alt="Pittsylvania County" coords="433,315,426,315,428,320,425,322,420,316,414,319,404,375,425,376,431,363,441,368,439,376,451,375,462,316,458,312,452,317,451,309,448,311,446,307,444,309,441,308,440,307,432,315" shape="poly" href="/places/Pittsylvania_County" />
                    <area title="Campbell County" alt="Campbell County" coords="467,272,461,279,454,283,446,282,430,315,432,315,439,307,445,310,448,308,451,310,452,315,460,312,470,319,472,317,480,321,486,298,484,298,483,295,477,294,477,291,474,288,469,273" shape="poly" href="/places/Campbell_County" />
                    <area title="Halifax County" alt="Halifax County" coords="479,319,473,316,469,319,462,316,449,375,494,375,498,359,502,357,499,351,501,349,500,337,494,330,495,329,493,321,490,327,486,324,480,324,480,320,472,316,470,319,460,315" shape="poly" href="/places/Halifax_County" />
                    <area title="Charlotte County" alt="Charlotte County" coords="498,294,486,299,479,320,480,325,487,324,490,328,493,321,496,325,493,330,501,338,499,352,502,357,517,335,522,312,518,312,512,305,508,305,503,300,499,300" shape="poly" href="/places/Charlotte_County" />
                    <area title="Nelson County" alt="Nelson County" coords="484,202,479,206,477,213,474,214,470,221,463,217,455,221,455,228,462,232,464,239,471,243,480,261,487,260,486,249,495,249,497,242,501,245,503,243,500,238,498,238,499,234" shape="poly" href="/places/Nelson_County" />
                    <area title="Mecklenburg County" alt="Mecklenburg County" coords="517,334,503,356,498,359,494,375,558,376,560,347,548,345,531,339" shape="poly" href="/places/Mecklenburg_County" />
                    <area title="Lunenburg County" alt="Lunenburg County" coords="521,312,517,334,533,339,552,347,552,344,559,347,562,320,555,320,546,315,546,312,540,308,535,310,529,310,527,312" shape="poly" href="/places/Lunenburg_County" />
                    <area title="Prince Edward County" alt="Prince Edward County" coords="507,277,506,282,497,294,498,299,502,300,508,306,512,305,515,309,516,312,526,313,528,310,535,310,540,308,541,279,532,286,525,287,519,283,515,283" shape="poly" href="/places/Prince_Edward_County" />
                    <area title="Amherst County" alt="Amherst County" coords="456,229,452,232,449,229,444,233,438,244,428,252,433,254,440,264,449,265,463,278,463,275,481,262,471,243,464,240,463,232,459,232" shape="poly" href="/places/Amherst_County" />
                    <area title="Appomattox County" alt="Appomattox County" coords="487,260,481,260,468,273,476,290,477,294,481,294,485,299,488,299,489,296,494,296,498,294,506,283,508,278,504,277,502,274,498,272" shape="poly" href="/places/Appomattox_County" />
                    <area title="Buckingham County" alt="Buckingham County" coords="521,236,516,231,514,235,505,235,502,242,498,242,494,250,487,249,486,259,498,272,503,275,504,278,507,277,514,284,519,283,538,249,538,242" shape="poly" href="/places/Buckingham_County" />
                    <area title="Cumberland County" alt="Cumberland County" coords="547,236,544,236,539,243,538,248,518,283,526,287,531,287,540,280,542,276,542,273,548,269,551,261,554,246,551,245,552,241" shape="poly" href="/places/Cumberland_County" />
                    <area title="Powhatan County" alt="Powhatan County" coords="568,242,564,244,566,249,553,246,548,270,552,271,561,265,570,267,574,273,579,272,580,267,594,257,588,254,584,253,583,251,577,251,577,249,574,248" shape="poly" href="/places/Powhatan_County" />
                    <area title="Amelia County" alt="Amelia County" coords="575,273,574,269,570,269,570,267,560,265,559,267,556,267,555,270,547,269,544,270,539,279,541,287,580,299,585,299,593,290,593,287,588,287,585,290,580,286,580,283,576,282,575,280,572,279" shape="poly" href="/places/Amelia_County" />
                    <area title="Nottoway County" alt="Nottoway County" coords="580,298,540,287,539,308,545,313,545,316,556,320,561,320,564,321,572,323,570,305,575,302,579,302" shape="poly" href="/places/Nottoway_County" />
                    <area title="Dinwiddie County" alt="Dinwiddie County" coords="612,295,605,295,598,290,593,290,592,293,585,298,581,298,579,302,575,302,570,304,572,322,578,322,589,330,594,334,598,335,617,320,617,302,614,301,613,299" shape="poly" href="/places/Dinwiddie_County" />
                    <area title="Brunswick County" alt="Brunswick County" coords="561,320,558,375,584,375,595,354,593,332,589,331,589,328,584,324,577,322,571,322,570,323" shape="poly" href="/places/Brunswick_County" />
                    <area title="Greensville County" alt="Greensville County" coords="594,334,594,354,584,373,622,373,623,366,617,361,612,360,610,358,616,353,610,352,611,336,608,338,604,338" shape="poly" href="/places/Greensville_County" />
                    <area title="Sussex County" alt="Sussex County" coords="639,307,617,321,598,335,601,338,608,339,611,335,609,352,611,353,615,354,659,326,657,313,653,314,648,312,645,309" shape="poly" href="/places/Sussex_County" />
                    <area title="Southampton County" alt="Southampton County" coords="667,320,609,357,612,361,617,360,621,365,621,372,663,372,662,370,663,365,666,361,660,358,658,353,661,351,666,343,671,330,668,325" shape="poly" href="/places/Southampton_County" />
                    <area title="Isle of Wight County" alt="Isle of Wight County" coords="684,302,681,312,667,320,669,329,667,341,662,351,664,361,697,329,700,328,703,327,699,319" shape="poly" href="/places/Isle_of_Wight_County" />
                    <area title="Suffolk" alt="Suffolk" coords="702,326,699,328,696,329,663,360,662,371,701,371,705,340,708,332,708,329" shape="poly" href="/places/Suffolk" />
                    <area title="Portsmouth" alt="Portsmouth" coords="709,326,708,333,712,336,709,339,711,342,720,341,720,338,716,333,713,326" shape="poly" href="/places/Portsmouth" />
                    <area title="Norfolk" alt="Norfolk" coords="714,319,714,326,720,337,728,336,731,333,730,324" shape="poly" href="/places/Norfolk" />
                    <area title="Virginia Beach" alt="Virginia Beach" coords="730,320,728,331,731,334,726,337,728,344,731,344,740,351,740,354,736,356,737,368,765,368,765,351,806,352,805,335,753,335,748,321" shape="poly" href="/places/Virginia_Beach" />
                    <area title="Chesapeake" alt="Chesapeake" coords="709,333,705,339,701,370,737,370,736,355,741,353,740,350,733,344,729,344,726,337,720,337,720,341,712,342,710,339,711,336,711,334" shape="poly" href="/places/Chesapeake" />
                </map></td>
              </tr>
            </tbody>
          </table>
<?php } ?>
<br />
    </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/footer.php"); ?>