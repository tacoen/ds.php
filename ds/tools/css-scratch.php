<?php
$textarea_style = "background:#fff; font-family: courier; font-size: 11px; width: 98%; height: 80px; padding: 1%";
$h2_style       = "margin: 1em 0 0 0; padding: 0; color: #009";
$div_style      = "position: relative; width: 90%; margin: 0 auto;";
$body_style     = "background: #ddd;";
$view_style     = "border: 2px inset #ccc; height: 300px; background:#fff; overflow: auto"
?>
<!doctype html>
<html class="windows no-js" lang="en-US" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>CED</title>
<script type="text/javascript" src="/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="/reset.css"></link>
<style>
@font-face{font-family:"inconsolata";font-style:normal;font-weight:normal;src:url("http://ds.dibiakcom.net/font/incons/inconsolata.eot")format("eot"),url("http://ds.dibiakcom.net/font/incons/inconsolata.svg")format("svg"),url("http://ds.dibiakcom.net/font/incons/inconsolata.ttf")format("truetype"),url("http://ds.dibiakcom.net/font/incons/inconsolata.woff")format("woff");}
body { background: #ddd;  font-family: "lucida sans"; margin:0; padding:0}
textarea { font-family:inconsolata; font-size: 12px; line-height:1.3em; background:#fff; width: 98%; height: 86px; padding: 1% }
div.frame { background:#89a; padding: 1%; width: 100%; }
div.wrap { position: relative; width: 95%; margin: .5em auto; }
div.meh { padding: 1%; width: 100%; background: #567; }
div.meh h2 { color: #fff; font-size: 1em; margin: 0;}
#html-view {background: #fff; width: 100%;height: 300px; }

</style>
</head>

<body>
<div class="wrap">
 
<div class="frame">
<iframe id="html-view" src="dummy.html?<?php echo time()?>"></iframe>
</div>
<div class="txtareas">
<div class="meh">
	<h2>HTML</h2>
	<textarea class="body" ></textarea>
</div>
<div class="meh">
	<h2>CSS</h2>
	<textarea class="style"></textarea>
</div>
</div>
</div>

<script type="text/javascript">

document.domain= 'dibiakcom.net'

$(window).resize( function() {
	var hm = $(window).height() - $('div.txtareas').outerHeight(); $('#html-view').height(hm-60);
});

// Init
var hm = $(window).height() - $('div.txtareas').outerHeight(); $('#html-view').height(hm-60);
$('textarea.body').bind('input propertychange', function() {  $('#html-view').contents().find('body').html($(this).val());  });
$('textarea.style').bind('input propertychange', function() { $('#html-view').contents().find('style').text($(this).val()); });

$(document).ready(function(){
	var html = $('#html-view').contents().find('body').html();
	$('textarea.body').text(html);
	var txt = $('#html-view').contents().find('style').text();
	$('textarea.style').text(txt);
});

</script>
</body>
</html> 
