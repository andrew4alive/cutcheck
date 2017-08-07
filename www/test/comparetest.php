<?php

require_once  __DIR__.'/../vendor/autoload.php';

use Core\Bwcon\Bwcon;
use Grafika\Grafika; // Import package

include __DIR__.'/../filesetup.php';

if(getG('target')&&getG('recipe')&&getG('layer')){
  $testimg = $tpath.$sl.$_GET['target'];
  $layerimg = $rpath.$sl.$_GET['recipe'].$sl.$_GET['layer'].'.jpg';
  $layerjson = $rpath.$sl.$_GET['recipe'].$sl.$_GET['layer'].'.json';

    $bm= new Bwcon($rpath.$sl.$_GET['recipe'].$sl.'master.jpg');
    $b1 = new Bwcon($testimg);
    $b2 = new Bwcon($layerimg);

    $brm = $bm->get_avg_luminance();
    $br1 = $b1->get_avg_luminance();
    $dbr = $brm - $br1;
    $b1->brightness($dbr);
    $editor = Grafika::createEditor(); // Create editor


    if(file_exists($layerjson)&&file_exists($layerimg)){
    $s  = json_decode(file_get_contents($layerjson),true);
    $cw = $s['width'];
    $ch = $s['height'];
    $cx = $s['x'];
    $cy = $s['y'];
    $lvl =$s['b'];
    $b1->im = imagecrop($b1->im,['x' => $cx, 'y' => $cy, 'width' => $cw, 'height' => $ch]);
    }
    else{
    ////$cw = $b2->getwidth();
  //  $ch = $b2->getheight();
  //  $cx = 0;
  //  $cy = 0;
  //  $lvl =0;
    echo 'error';
    exit();
    }

    $b1->mono($lvl);
  //    header('Content-type: image/jpeg');
    $b1->output($temp.$sl.'temp.jpg');
    $result = $editor->compare( $layerimg, $temp.$sl.'temp.jpg' );
     echo $result.':'.$brm.':'.$br1;
  //  echo json_encode($spec);
  //echo $layerimg.':'.$testimg;

}


function getG($char){

 return isset($_GET[$char]);

}

exit();
 ?>
