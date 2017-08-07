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
  //  $b2 = new Bwcon($layerimg);

    $brm = $bm->get_avg_luminance();
    $br1 = $b1->get_avg_luminance();
   $dbr = $br1 - $brm;
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
    $img = imagecreatetruecolor($cw, $ch);
    $bg = imagecolorallocate ( $img, 255, 255, 255 );
    imagefilledrectangle($img,0,0,$cw,$ch,$bg);
    imagejpeg($img,$temp.$sl."white.jpg");
  //    header('Content-type: image/jpeg');
    $b1->output($temp.$sl.'temp.jpg');
    //$result = $editor->equal( $temp.$sl."white.jpg", $temp.$sl.'temp.jpg' );
   $result = compareimgwhite($b1->im);
   $tr = 'fail';
   if(isset($s['allowt'])){
     if($result<$s['allowt']){
       $tr='pass';
     }

   }

   else{
     if($result==0){
       $tr='pass';
     }

   }
  /*  if($result==true){
      $result = 1;

    }
    else
    $result =0;*/
    //var_dump($result);
     echo (string)$result.':'.$tr;
  //  echo json_encode($spec);
  //echo $layerimg.':'.$testimg;

}


function getG($char){

 return isset($_GET[$char]);

}

function compareimgwhite($i1){

$im = $i1;
$sy = imagesy($im);
$sx = imagesx($im);
$c = 0;
for($i = 0;$i<$sx;$i++){
    for($j = 0; $j<$sy;$j++){
      $rgb = imagecolorat($im, $i, $j);
      $r = ($rgb >> 16) & 0xFF;
      $g = ($rgb >> 8) & 0xFF;
      $b = $rgb & 0xFF;
      if(!($r==255&&$g==255&&$b==255))
       $c = $c + 1;
    }
}

return $c;

}
exit();
 ?>
