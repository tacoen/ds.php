<?php
DEFINE ('DS_ROOT', realpath("..") );
require_once('config.php');
require_once('function.php');
require_once('backend.php');

$t = @$_POST['t'];  if (!$t)  { $t = @$_GET['t']; } 

$f = "";

if (@$_GET['f'])  { $f = @$_GET['f']; }
if (@$_POST['f']) { $f = getfn(@$_POST['f'],""); }

if ($t == "") { echo "type is missing!"; die(); }

if (@$_POST['s']=="pack") { 
	$res = packer_submit( DS_ROOT."/".$t."/pack/". $f, @$_POST['w'] ); 
	$wcon = @$_POST['w'];
} else { 
	$res ="";
	if ($f != "") { $wcon = file_get_contents(DS_ROOT."/$t/pack/$f.txt"); }
}
flush();
packer_header("$t packer",$res);
plugins_shop($t,$f,$wcon);
packer_footer();

?>