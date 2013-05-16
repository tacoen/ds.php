<?php
require_once('../php/function.php');
if (@$_POST['s']=="pack") { $res = packer_submit( dirname(__FILE__)."/pack/". @$_POST['f'] , @$_POST['w'] ); } else { $res =""; }
packer_header("css",$res);
plungins_shop("css");
packer_footer("css");
?>