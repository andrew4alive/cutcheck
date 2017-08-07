<?php

include_once __DIR__.'/filesetup.php';
//if(!file_exists($bpath)){



$setupcom =   true;
$setupcomr =  true;
$setupcomt =  true;
$setuptemp =  true;
$setuppro =  true;


 if(!file_exists($bpath))
 $setupcom =   mkdir($bpath,true);
 if(!file_exists($rpath))
 $setupcomr =   mkdir($rpath,true);
 if(!file_exists($tpath))
 $setupcomt =   mkdir($tpath,true);
 if(!file_exists($temp))
 $setuptemp =   mkdir($temp,true);
 if(!file_exists($prop))
 $setuppro =   mkdir($prop,true);
 if(!file_exists($bpath.$sl.'prodpath.txt'))
 $sprod = file_put_contents($bpath.$sl.'prodpath.txt','');

  if($setupcom&&$setupcomr&&$setupcomt&&$setuptemp&&$setuppro&&$sprod==false){

    echo 'setup complete  <a href="./editor.php"> click here to continues</a>';
  }
  else {
    echo 'setup fail';
  }
//}
?>
