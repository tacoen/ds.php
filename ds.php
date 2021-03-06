<?php
/*
	.htaccess
	RewriteEngine on
	RewriteBase /
	Rewriterule  ^(pack/([0-9])/)(.+)\.(.+)$ /ds.php?t=$4&p=$3&o=$2	[QSA,L]

	Operand [0-9]
	--------------	
	0 - compress high, will be cache
	1 - readable css
	3 - pragma no-cache

	9 - use cache, don't waste the php process. Final Form!
	*/

DEFINE ('DS_ROOT', dirname(__FILE__) );
DEFINE ('DS_CACHEDIR', DS_ROOT."/.cache");
DEFINE ('DS_CACHE_TIME',60*60*24*3);

require_once('ds/config.php');
require_once('ds/function.php');

if (!is_dir(DS_CACHEDIR)) { mkdir(DS_CACHEDIR); } 
 
$pack      = @$_GET['p']; if (!$pack)    { echo "Missing package name!"; die(); }
$type      = @$_GET['t']; if (!$type)    { $type="css"; }
$operand   = @$_GET['o']; if (!$operand) { $operand=0;  }
$output    = "";


if (file_exists(DS_ROOT."/$type/pack/$pack.txt")) { 
	$FILE=file(DS_ROOT."/$type/pack/$pack.txt"); 
	$FILE=fileClean($FILE); 
} else {  
	echo "Missing package file!"; die(); 
}

DEFINE ('CACHE_FILE', DS_CACHEDIR."/$pack.$type");

if (@$_GET['z'] == 1) { 
	if (file_exists(CACHE_FILE)) { 
		unlink (CACHE_FILE); echo "done"; 
	} else { echo "not found"; }
	exit; 
}

if ((file_exists(CACHE_FILE)) && $operand==9) { 
	DS_headerCache(DS_CACHE_TIME);
	DS_headerType($ctype);
	readfile(CACHE_FILE);
	exit;
}

foreach ($FILE as $F) { 
	if (($F!="")  && ( file_exists(DS_ROOT."/$type/".$F))) {
		$output .= "\n".file_get_contents(DS_ROOT."/$type/".$F); 
	}
}

if ($operand !=1) { $cl = 0; } else { $cl = 1; }

if ($type=="js") {	

	$pre  = '';
	$suf  = file_get_contents(DS_ROOT."/$type/script.js");
	
	if (DS_MINIFY==1) {
		render("css",minjs_compress($pre.$output.$suf,$cl),CACHE_FILE);
	} else {
		render("css",js_compress($pre.$output.$suf,$cl),CACHE_FILE);
	}
	
} else if ($type=="css") {

	$pre  = file_get_contents(DS_ROOT."/$type/reset.css");
	$suf  = '';
	render("css",css_compress($pre.$output.$suf,$cl),CACHE_FILE);

}

exit;

?>