<?php

require_once  __DIR__.'/vendor/autoload.php';

use Core\Bwcon\Bwcon;

include __DIR__.'/filesetup.php';



$lvl =0;

if(getcn('b')){

$lvl = $_GET['b'];
}



if(isset($_GET['createrecipe'])&&isset($_GET['layer'])){

  $lp = $rpath.$sl.$_GET['createrecipe'].$sl.$_GET['layer'];
  $mp = $rpath.$sl.$_GET['createrecipe'].$sl.'master.jpg';
  $bwcon = new Bwcon($mp);
  $cw = $bwcon->getwidth();
  $ch = $bwcon->getheight();
  $cx = 0;
  $cy = 0;
  $d = array(
       'x' => $cx, 'y' => $cy, 'width' => $cw, 'height' => $ch ,'b'=>(int)$lvl
  );
  file_put_contents($lp.'.json',json_encode($d));
  $bwcon->output($lp.'.jpg');
  //header('Location:'.)
  exit();
}
//else {




if(isset($_GET['recipe'])&&isset($_GET['layer'])){

  $lp = $rpath.$sl.$_GET['recipe'].$sl.$_GET['layer'];
  $mp = $rpath.$sl.$_GET['recipe'].$sl.'master.jpg';

}
else {

  echo 'some thing wrong,1 ';
  exit();
}
//}

/*if((scandir($lp)&&scandir($mp))) {
    echo'recipe file missing';

 exit();
}*/


if(getcn('allowt')){
 $j =json_decode(file_get_contents($lp.'.json'),true);
 $j['allowt'] = $_GET['allowt'];
 file_put_contents($lp.'.json',json_encode($j));
  var_dump($j);
 header('Location:'.'editor.php?recipe='.$_GET['recipe'].'&layer='.$_GET['layer']);
exit();
}


$bwcon = new Bwcon($mp);


if(getcn('ow')&&getcn('oh')){

$ow = $_GET['ow'];
$oh = $_GET['oh'];
$scy=scale($oh,$bwcon->getheight());
$scx=scale($ow,$bwcon->getwidth());
}
else
   exit();

$cw = $bwcon->getwidth();
$ch = $bwcon->getheight();
$cx = 0;
$cy = 0;
/*
if(isset($_GET['createrecipe'])&&isset($_GET['layer'])){

  $bwcon->output($lp.'.jpg');
  echo 'created layer';
  exit();

}*/









///crop action





if(getcn('x')&&getcn('y')&&getcn('x1')&&getcn('y1')){

  $cr = arrangecrop($_GET['x'],$_GET['y'],$_GET['x1'],$_GET['y1']);

  $cw = ($cr['x1']-$cr['x'])/$scx;
  $ch = ($cr['y1']-$cr['y'])/$scy;
  $cx = $cr['x']/$scx;
  $cy = $cr['y']/$scy;
  if($cw==0) $cw=1;
  if($ch==0) $ch=1;
//echo $cw.':'.$ch.':'.$cx.':'.$cy.':'.$scx.':'.$scy;
//echo $bwcon->getwidth().':'.$bwcon->getheight().':'.$scx.':'.$scy;
//  $bwcon->im = imagecrop($bwcon->im,['x' => $cx, 'y' => $cy, 'width' => $cw, 'height' => $ch]);
//exit();
$d = array(
     'x' => $cx, 'y' => $cy, 'width' => $cw, 'height' => $ch ,'b'=>(int)$lvl
);

file_put_contents($lp.'.json',json_encode($d));
}




if(file_exists($lp.'.json')){

  $j =json_decode(file_get_contents($lp.'.json'),true);

  $cw = $j['width'];
  $ch = $j['height'];
  $cx = $j['x'];
  $cy = $j['y'];
  $lvl = (int)$j['b'];
  if(getcn('b')){

  $lvl = $_GET['b'];
  }

  if(is_numeric($cw)&&is_numeric($ch)&&is_numeric($cx)&&is_numeric($cy))
  $bwcon->im = imagecrop($bwcon->im,['x' => $cx, 'y' => $cy, 'width' => $cw, 'height' => $ch]);

}

//$bwcon->convert();
//$bwcon->grayscale();
//$bwcon->brightness($lvl);
//$bwcon->contrast(-255);
$bwcon->mono($lvl);
//$bwcon->s();
//$bwcon->edge();
$bwcon->output($lp.'.jpg');
header('Content-type: image/jpeg');
$bwcon->output();


function getcn($char){

 return isset($_GET[$char])&&is_numeric($_GET[$char]);

}

function scale($x,$x1){
   return $x/$x1;

}

function arrangecrop($x,$y,$x1,$y1){
   $re = array();
   if($x<$x1){
       $re['x'] = $x;
       $re['x1'] = $x1;

   }else{
     $re['x'] = $x1;
     $re['x1'] = $x;

   }

   if($y<$y1){
       $re['y'] = $y;
       $re['y1'] = $y1;

   }else{
     $re['y'] = $y1;
     $re['y1'] = $y;

   }

   return $re;

}

exit();

/*
$source_file = "1.JPG";

$im = ImageCreateFromJpeg($source_file);

$imgw = imagesx($im);
$imgh = imagesy($im);

for ($i=0; $i<$imgw; $i++)
{
        for ($j=0; $j<$imgh; $j++)
        {

                // Get the RGB value for current pixel

                $rgb = ImageColorAt($im, $i, $j);

                // Extract each value for: R, G, B

                $rr = ($rgb >> 16) & 0xFF;
                $gg = ($rgb >> 8) & 0xFF;
                $bb = $rgb & 0xFF;

                // Get the value from the RGB value

                $g = round(($rr + $gg + $bb) / 3);

                // Gray-scale values have: R=G=B=G

                $val = imagecolorallocate($im, $g, $g, $g);

                // Set the gray value

                imagesetpixel ($im, $i, $j, $val);
        }
}

//imagejpeg($im,'./2.jpg');

header('Content-type: image/jpeg');
imagejpeg($im);
*/
?>
