<?php
DEFINE ('DS_ROOT', realpath("../..") );
require_once('../../ds/function.php');
require_once('../../ds/backend.php');
$cssp = glob('../../css/pack/*.txt');
$opt = "<select id='css_select'>\n<option value=''>Select Pack:</option>\n<option value='http://ds.dibiakcom.net/css/reset.css'>reset.css</option>";
$t = "css";
foreach ($cssp as $f) { 	$opt .="<option value='" . "http://" .DOMAIN. "/pack/0/" .getfn($f,$t). "'>" .getfn($f,$t). "</option>\n"; }
$opt .="</select>\n";
?>
<!doctype html>
<html class="windows no-js" lang="en-US" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimun-scale=1" />
<script type="text/javascript" src="http://ds.dibiakcom.net/jquery.js"></script>
<script type="text/javascript" src="http://ds.dibiakcom.net/js/plugins/css_auto-reload.js"></script>
<link id='css_test' rel="stylesheet" type="text/css" href="http://ds.dibiakcom.net/css/reset.css"></link>
<title>Sandbox</title>
<script>
$(document).ready(function(){

$('#css_select').change( function() {
	var go = $(this).children('option:selected').val(); 
	if (go!="") {
		$('head #css_test').attr('href',go);
		document.styleSheets.reload();
	}
});

});
</script>
<style>
html #ds_skel_test { 
	position: fixed; 
	top: 0px; left: 0; width: 100%; 
	height: 24px !important;
	background: #345; 
	padding: 3px 0; 
	z-index:99;
	display: block !important
}

html #ds_skel_test select { 
	background: #fff !important; width: 120px; 
	padding: 1px !important;
	margin-right: 10px !important; 
	font-size: 16px !important; 
	height: 24px !important;
	font-family:arial !important; 
	color:#000 !important; 
	float: right !important;  }
html #ds_skel_test option { color: #000 !important; font-size: 16px !important; font-family:arial; }
html #ds_skel_test { font-size: 16px !important }
</style>
</head>
<body style='margin-top: 30px; '>

<div id="ds_skel_test"><?php echo $opt;?></div>
<div class="content wwrap">
<?php readfile('../../template/lorem.html'); ?>
</div>



</body>
</html>