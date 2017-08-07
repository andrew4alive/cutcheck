<?php

include __DIR__.'/../filesetup.php';

$filterfile = array(".","..");


$filelist = scandir($tpath);

$filelist = array_diff($filelist,$filterfile);

$json_r = json_encode($filelist,JSON_FORCE_OBJECT);

echo $json_r;

exit();
 ?>
