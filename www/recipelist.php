<?php

include __DIR__.'/filesetup.php';

$filterfile = array(".","..");

if(isset($_GET['layer'])){
    $layer = $_GET['layer'];
    $filterfile = array(".","..","master.jpg");
    if(!file_exists($rpath.$sl.$layer)) return false;;
    $layerlist = scandir($rpath.$sl.$layer);
    $layerlist = array_diff($layerlist,$filterfile);
    $json_r = json_encode($layerlist,JSON_FORCE_OBJECT);

    echo $json_r;
    exit();
}



$filelist = scandir($rpath);

$filelist = array_diff($filelist,$filterfile);

$json_r = json_encode($filelist,JSON_FORCE_OBJECT);

echo $json_r;

exit();
 ?>
