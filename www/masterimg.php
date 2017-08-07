<?php

require_once  __DIR__.'/vendor/autoload.php';

use Core\Bwcon\Bwcon;

include __DIR__.'/filesetup.php';

if(getG('recipe')){
  $mp = $rpath.$sl.$_GET['recipe'].$sl.'master.jpg';
    $bwcon = new Bwcon($mp);
    header('Content-type: image/jpeg');
    $bwcon->output();

}


function getG($char){

 return isset($_GET[$char]);

}

exit();
 ?>
