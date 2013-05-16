<?php
DEFINE ('DS_ROOT', realpath("..") );

require_once('function.php');
require_once('backend.php');

$t = @$_POST['t']; if (!$t) { $t = @$_GET['t']; } 

if ($t == "") { echo "type is missing!"; die(); }

if (@$_POST['s']=="pack") { $res = packer_submit( DS_ROOT."/".$t."/pack/". @$_POST['f'] , @$_POST['w'] ); } else { $res =""; }

$f=getfn(@$_POST['f'],"");

packer_header("$t packer",$res);
plugins_shop($t,$f,@$_POST['w']);
packer_footer();

?>