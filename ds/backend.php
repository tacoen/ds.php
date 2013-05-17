<?php 

require("config.php");

function scandir_thru($dir,$type) {
	$dir = DS_ROOT."/$type/$dir";
    $items = glob($dir . '/*');
    for ($i = 0; $i < count($items); $i++) {
        if (is_dir($items[$i])) {
            $add = glob($items[$i] . '/*');
            $items = array_merge($items, $add);
        }
    }
	$found = array();
	foreach ($items as $item) {
		if (preg_match('#\.'.$type.'$#',$item)) { array_push($found,$item); }
	}
	return $found;
}

function E($str) { echo $str; }

function getfn($f,$e="txt") {
	$da = explode("/",$f); $F = $da[count($da)-1]; $fa = explode(".",$F); if ($e!="") { $f= $fa[0].".$e"; } else { $f=$fa[0]; }
	return $f;
}

function plugins_shop($type,$s="",$W="") {
	$F = scandir_thru("plugins",$type);
	echo "<div class='tab' id='plugins'><div id='plugins_list'>";
	foreach ($F as $f) {
		if (!$f) continue; 
		$fa = explode('/',$f); $fn = $fa[count($fa)-1]; $fncode = short_name($fn); $fz = filesize($f)/1000;
		$f = preg_replace('#'.DS_ROOT."/".$type.'/#','',$f);
		echo "<ul class='clear itemiz $type_dir ndir'>\n";
		echo "\t<li class='fn' rel='$f' data='$fncode'><a href='#'>$fn</a></li>\n";
		echo "\t<li class='fz' title='file size'>$fz</li>\n";
		echo "\t<li class='di'><a href='http://".DOMAIN."/$type/$f'>source</a></li>\n";
		echo "\t<li class='di'><a href='http://".DOMAIN."/min/$type/$f'>minify</a></li>\n";
		echo "</ul>\n";
	}
	echo "</div><div id='plugins_pack' class='no-scroll'><h3>Packer</h3><form action='pc.php' method='post'><textarea name='w'>$W</textarea>";
	echo "<input type='hidden' name='t' value='".$type."' />";
	echo "<p>Pack Name: <input type='text' name='f' class='fn  autoselect' value='$s' /> <input type='submit' name='s' value='pack' id='pack'/></p></form>";
	echo "<div class='introd'>";
	echo "<h5>File:</h5>";
	echo "<p>".DS_ROOT."/$type/pack/<span>$s</span>.txt</p>";
	echo "<h5>URL:</h5>";
	echo "<p>http://".DOMAIN."/ds.php?t=$type&amp;o=0&amp;p=<span>$s</span></p>";
	echo "<h5>Using .htaccess:</h5>";
	echo "<p>http://".DOMAIN."/pack/0/<span>$s</span>.$type</p></div>";
	echo "</div><div class='clear'></div></div>";
}

function packer_submit($f,$w="") {
	$fn = "$f.txt"; $res = "saved";
	if ( file_exists($fn) ) { $nfn = $fn.".".time(); rename ($fn,$nfn); $res = "revisited"; }
	if ($w != "") { file_put_contents($fn,$w); }
	return $res;
}

function packer_header($type,$res) {?><!doctype html>
<html class="windows no-js" lang="en-US" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>DS: <?php E($type); ?></title>
<link rel="stylesheet" type="text/css" href="/css/reset.css"></link>
<script type="text/javascript" src="/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="/pack/9/ds.css"></link>
<script type="text/javascript" src="/js/plugins/ds.js"></script>
<head>
<body class="ds">
<?php if ($res != "") {?><div class="res"><?php E($res); ?></div><?php }?>
<?php }

function line($f,$t="css",$n) {
	echo "<h3>";
	echo "<a class='vs' href='http://".DOMAIN."/pack/0/".getfn($f,$t)."'>ds</a>";
	echo "<a class='rz' href='../ds.php?z=1&p=".getfn($f,"")."&t=$t'>reset cache</a>";
	echo getfn($f,$t)."</h3>";
	echo "<div class='p $t'>"; 
	echo "<input type='text' size='45' name='$t_$n' class='packed autoselect' value='http://".DOMAIN."/pack/0/".getfn($f,$t)."' />";
	echo "<ul class='itemiz'>";
	$L = file($f); foreach($L as $l) {$l=trim($l); if ($l!="") { echo "<li><a href='../$t/".$l."'>$l</a></li>"; } }
	echo "</ul>";
	echo "</div>";
}

function packer_footer() { ?>
<div id="ds_menu">
<select name="go" class="go li-style">
	<option value="#">menu</a>
	<option value="/ds/pc.php?t=css">CSS</a>
	<option value="/ds/pc.php?t=js">Javascript</a>
	<option value="/ds/pe.php?">Gallery</a>
	<option value="/font/">Fonts</a>
</select>
<p class="footer">github.com/tacoen/ds.php</p>
</div>
<?php } ?>