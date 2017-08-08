<?php
require_once  __DIR__.'/vendor/autoload.php';


include_once __DIR__.'/filesetup.php';


if(getc('recipe')&&getc('layer')){
    $layerp = $rpath.$sl.$_GET['recipe'].$sl.$_GET['layer'];
    if(file_exists($layerp.'.json'))
      $k =  unlink($layerp.'.json');
    if(file_exists($layerp.'.jpg'))
      $k1 =  unlink($layerp.'.jpg');

      if($k&&$k1){

        echo 'fail deleted';
      }
      else {
          echo 'delete fail';
      }

}


function getc($char){

 return isset($_GET[$char]);

}

exit();
?>
