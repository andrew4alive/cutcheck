<?php

require_once  __DIR__.'/../vendor/autoload.php';

use Core\Bwcon\Bwcon;


include __DIR__.'/../filesetup.php';


$prp = file_get_contents($bpath.$sl.'prodpath.txt');

if($prp==''){
 $prp = 'c:'.$sl.'lot';
}
if(!file_exists($prp)){
  echo 'no lot foler';
  exit();
}

if(getG('file')){
  $testimg = $prp.$sl.$_COOKIE['lotn'].$sl.$_GET['file'];


    $b1 = new Bwcon($testimg);
    header('Content-type: image/jpeg');
    $b1->output();


}


function getG($char){

 return isset($_GET[$char]);

}

exit();
 ?>
