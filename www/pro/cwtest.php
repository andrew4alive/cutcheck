<?php

require_once  __DIR__.'/../vendor/autoload.php';

use Core\Bwcon\Bwcon;
//use Grafika\Grafika; // Import package

include __DIR__.'/../filesetup.php';

$prp = file_get_contents($bpath.$sl.'prodpath.txt');

if($prp==''){
 $prp = 'c:'.$sl.'lot';
}

if(getG('target')&&getG('recipe')){

  $testimg = $prp.$sl.$_COOKIE['lotn'].$sl.$_GET['target'];

  $filterfile = array(".","..","master.jpg");

  $layerlist = scandir($rpath.$sl.$_GET['recipe']);

  if(!$layerlist)
  {  echo  'scan '.$rpath.$sl.$_GET['recipe'].'dir fail';
  exit();
  }
  $layerlist = array_diff($layerlist,$filterfile);
  $ll =  array();
 foreach($layerlist as $la){
   if(strpos($la,'.json')!=false)
   array_push($ll,str_replace(".json","",$la));

 }

//  $layer = array();
 $glc = $_GET['lc'];

  $lc = count($ll);

  $layerimg = $rpath.$sl.$_GET['recipe'].$sl.$ll[$glc].'.jpg';
  $layerjson = $rpath.$sl.$_GET['recipe'].$sl.$ll[$glc].'.json';

//  var_dump($layerimg);

//  var_dump($layerlist);
  //exit();

    $bm= new Bwcon($rpath.$sl.$_GET['recipe'].$sl.'master.jpg');
    $b1 = new Bwcon($testimg);
    $b1->output($prop.$sl.$_COOKIE['lotn'].$sl.$_GET['target']);
  //  $b2 = new Bwcon($layerimg);

    $brm = $bm->get_avg_luminance();
    $br1 = $b1->get_avg_luminance();
   $dbr = $br1 - $brm;
    $b1->brightness($dbr);
  // $editor = Grafika::createEditor(); // Create editor


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

   if($tr=='fail'){
     $b1 = new Bwcon($testimg);
    // mkdir($prop.$sl.'fail' , 0777);
     $b1->output($prop.$sl.$_COOKIE['lotn'].$sl.'fail'.$sl.$ll[$glc].'-'.$_GET['target']);

   }




    if(($lc-$_GET['lc']-1)>0&&$tr=='pass'){

      $t = true;
    }
    else {
      $t = false;
    }

    $totaltest = scandir($prop.$sl.$_COOKIE['lotn']);
    $totaltest = array_diff($totaltest,array('.','..','fail'));
    $totallot = scandir($prp.$sl.$_COOKIE['lotn']);
    $totallot = array_diff($totallot,array('.','..'));
    $totalfail = scandir($prop.$sl.$_COOKIE['lotn'].$sl.'fail');
    $totalfail = array_diff($totalfail,array('.','..'));
    $r =array(
        'result'=>$ll[$glc].':'.$result.':'.$tr,
        'layercount'=>$lc-$_GET['lc']-1,
        'con'=>$t ,///continues test??
        'ctest'=>count($totaltest),'clot'=>count($totallot),'cfail'=>count($totalfail)
    );

    echo json_encode($r);

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

function status(){



}
exit();
 ?>
