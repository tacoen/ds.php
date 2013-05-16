<?php

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

?>