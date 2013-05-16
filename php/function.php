<?php

DEFINE (DOMAIN,"myhost.com");

function scandir_thru($dir,$wildcard) {
    $items = glob($dir . '/*');
    for ($i = 0; $i < count($items); $i++) {
        if (is_dir($items[$i])) {
            $add = glob($items[$i] . '/*');
            $items = array_merge($items, $add);
        }
    }
	$found = array();
	foreach ($items as $item) {
		if (preg_match('#\.'.$wildcard.'$#',$item)) { array_push($found,$item); }
	}
	return $found;
}

function E($str) { echo $str; }

function render($ctype,$output,$cache_file) {
	global $operand;
	if(extension_loaded('zlib')){ ob_start('ob_gzhandler'); }

	if ($output != "") {
		if ($operand==0 || $operand==9) { file_put_contents($cache_file,$output); }
		DS_headerCache(60*60*3);
	}

	DS_headerType($ctype); echo $output;

	if(extension_loaded('zlib')){ ob_end_flush();}

}

function DS_headerCache($expires=3600) {
	global $operand;
	if ($operand == 3)    { 
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()-$expires) . ' GMT');
	} else {
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	}
}

function DS_headerType($ctype="css") {
	if ($ctype == "js") { header ("content-type: application/javascript; charset: UTF-8"); }
	else                { header ("content-type: text/css; charset: UTF-8"); }
}


function txt_compress($buffer) {
	$buffer = str_replace(array("\r",'\s+',"\t"), '', $buffer);
	$buffer = preg_replace('/\n/','', $buffer);
	return $buffer;
}

function short_name($buffer) {
	$buffer = str_replace(array("plugins",'lib',"js","css","jquery"), '', $buffer);
	$buffer = preg_replace('#[aiueo,.-_]#', '', $buffer);
	return $buffer;
}

function make_nicename($buffer) {
	$buffer = preg_replace('#,#', '', $buffer);
	return $buffer;
}

function css_compress($buffer,$cl=0) {

	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	$buffer = preg_replace('#[\r|\n|\t]#', '', $buffer);
	$buffer = preg_replace('#\s\s+#',' ', $buffer);
	$buffer = preg_replace('#(\s+>\s+)|(\s?>\s?)#', '>', $buffer);
	$buffer = preg_replace('#(\s+;\s+)|(\s?;\s?)#', ';', $buffer);
	$buffer = preg_replace('#(\s+:\s+)|(\s?:\s?)#', ':', $buffer);
	$buffer = preg_replace('#(\s+{\s+)|(\s?{\s?)#', '{', $buffer);
	$buffer = preg_replace('#(\s+}\s+)|(\s?}\s?)#', '}', $buffer);
	$buffer = preg_replace('#(\s+,\s+)|(\s?,\s?)#', ',', $buffer);
	$buffer = preg_replace('#\"#','\'', $buffer);

	if ($cl==1) $buffer = preg_replace('/}/', "}\n", $buffer);
	return $buffer;
}

function css_sort($buffer) {	
	$O = explode("\n",$buffer); sort($O); $dot = ""; $hash = ""; $norm = "";
	foreach ($O as $l) {
		if (preg_match("/^\./",$l)) { $dot .="$l\n"; }
		else if (preg_match("/^\#/",$l)) { $hash .="$l\n"; }
		else { $norm .="$l\n"; }
	}
	return $norm.$hash.$dot;
}

function js_compress($buffer,$cl=0) {
		$buffer = preg_replace('#\t| \s#', '', $buffer);
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	if ($cl == 0) {
		$buffer = preg_replace('#//#', "\n//", $buffer);
		$buffer = preg_replace('#//(.+)\n#', "", $buffer);
		$buffer = preg_replace('#//#', "", $buffer);
		$buffer = preg_replace('#(\s+|\s)?(;|\+|,|=|\)|\(|\.|\&)(^\s+|\s)?#', "\\2", $buffer);
		$buffer = preg_replace('#(\s+|\s)?(;|\+|,|=|\)|\(|\.|\&)(^\s+|\s)?#', "\\2", $buffer);
		$buffer = preg_replace('#\}\n#',"}",$buffer);
		$buffer = preg_replace('#\{\n#',"{",$buffer);
		$buffer = preg_replace('#\{(\s|\s+)#',"{ ",$buffer);
		$buffer = preg_replace('#\,\n#',",",$buffer);
		$buffer = preg_replace('#\%#',"% ",$buffer);
		$buffer = preg_replace('#(\s|\s+)\}\);(\s|\s+)?#',"}); ",$buffer);
		$buffer = preg_replace('#(\s|\s+)\}\);(\s|\s+)?#',"}); ",$buffer);
		$buffer = preg_replace('#(\s|\s+|\n)?:(\s|\s+|\n)#'," : ",$buffer);
		$buffer = preg_replace('#;(\s|\n|\s+|\r)#',"; ",$buffer);
		$buffer = preg_replace('#\s{2}#'," ",$buffer);
		$buffer = preg_replace('#\n{2}#',"\n",$buffer);
		$buffer = preg_replace('#\n{2}#',"\n",$buffer);
		$buffer = preg_replace('#\n{2}#',"\n",$buffer);
	}
	return $buffer;
}

function minjs_compress ($output,$cl) {
	if ($cl==0) { require_once(DS_ROOT."/minify/lib/JSMin.php"); $output = JSMin::minify($output); } 
	return $output;
}

function plungins_shop($type) {
	$F = scandir_thru("plugins",$type);
	echo "<div class='tab' id='plugins'><h2>Plugins for $type</h2><div id='plugins_list'>";
	foreach ($F as $f) {
		if (!$f) continue; 
		$fa = explode('/',$f); $fn = $fa[count($fa)-1]; $fncode = short_name($fn); $fz = filesize($f)/1000;
		echo "<div class='li clear $type_dir'>\n";
		echo "\t<div class='fn' rel='$f' data='$fncode'><a href='#'>$fn</a></div>\n";
		echo "\t<div class='fz' title='file size'>$fz</div>\n";
		echo "\t<div class='di'><a href='http://".DOMAIN."/$type/$f'>source</a></div>\n";
		echo "\t<div class='di'><a href='http://".DOMAIN."/min/$type/$f'>minify</a></div>\n";
		echo "</div>\n";
	}
	echo "</div><div id='plugins_pack'><textarea></textarea>";
	echo "<p>Pack Name: <input type='text' name='fn' class='fn' value='$type' /><button id='pack'>Pack</button></p>";
	echo "<pre class='sample'>File:<span></span>.txt<br/>http://".DOMAIN."/ds.php?t=$type&amp;o=0&amp;p=<span></span><br>http://".DOMAIN."/pack/0/<span></span>.$type</pre>";
	echo "</div><div class='clear'></div></div>";
}

function packer_header($type) {?><!doctype html>
<html class="windows no-js" lang="en-US" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Plugins Packer</title>
<style rel="stylesheet" media="screen" type="text/css">
body { font-family: Lucida console; font-size: 12px; line-height: 18px; }
#plugins_list { width: 49%; float: left; margin-right: 1%}
#plugins_pack { width: 50%; float: left; }
#plugins_pack textarea { width: 100%; height: 300px }
div.clear { clear: both }
div.li { border-bottom: 1px solid #dedede; line-height: 24px; height: 24px; }
div.li div { float: left; }
.li .fn { width: 59%}
.li .fz { width: 15%}
.li .di { width: 10%}
div.li div.fz { text-align: center; font-size: .8em; }
div.li div.di { text-align: center; } 
div.fn a { color: #fff; background: #356; display: block; text-decoration: none; padding-left: 1%;}
.fn a:hover:after { content: " >"; color: #ff0;}
</style>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">

var c =0;

$(document).ready(function(){

	$('div.fn a').click( function() {
		var s = $(this).parent('div.fn').attr('rel');
		var d = $(this).parent('div.fn').attr('data');
		var txt = $('#plugins_pack textarea').text();
		var fnc = $('input.fn').val();
		var str = s+"\n";
		$('#plugins_pack textarea').text(txt+str);
		$('input.fn').val( fnc +"-" + d)
	});

	$('#pack').click( function() {
		$('pre.sample span').text( $('input.fn').val() )
	});
		
});

</script>
<head>
<body><?php }

function packer_footer() { echo "</body></html>"; }
?>
