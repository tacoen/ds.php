<?php

DEFINE ('DS_ROOT', realpath("..") );

require_once('function.php');
require_once('backend.php');

$cssp = glob('../css/pack/*.txt');
$jsp  = glob('../js/pack/*.txt');

$n=0;

packer_header("Package Expo",$res);

?><h2>CSS</h2><?php foreach ($cssp as $f) { $n++; line ($f,"css",$n); }
?><div class="clear"></div>
<h2>JS</h2><?php foreach ($jsp as $f)  { $n++; line ($f,"js",$n); } ?>

<?php packer_footer(); ?>