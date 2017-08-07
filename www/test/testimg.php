<?php

require_once  __DIR__.'/../vendor/autoload.php';

use Core\Bwcon\Bwcon;


include __DIR__.'/../filesetup.php';

if(getG('file')){
  $testimg = $tpath.$sl.$_GET['file'];


    $b1 = new Bwcon($testimg);
    header('Content-type: image/jpeg');
    $b1->output();


}


function getG($char){

 return isset($_GET[$char]);

}

exit();
 ?>
