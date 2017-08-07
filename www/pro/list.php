<?php
require_once  __DIR__.'/../vendor/autoload.php';

include_once __DIR__.'/../filesetup.php';

$prp = file_get_contents($bpath.$sl.'prodpath.txt');

if($prp==''){
 $prp = 'c:'.$sl.'lot';
}
$after = $prop.$sl.$_COOKIE['lotn'];

$prpl = scandir($prp.$sl.$_COOKIE['lotn']);

$afterl = scandir($after);

$fl = array('fail');

$r = array_diff($prpl,$afterl);
$r = array_diff($r,$fl);
echo json_encode($r,JSON_FORCE_OBJECT);
?>
