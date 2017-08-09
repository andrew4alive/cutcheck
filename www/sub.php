<?php

$s = 'sdfgdfghs.jpg';
$type = strtolower(substr($s,strpos($s,'.')+1));
switch ($type)
{
 case 'gif':
  //   $this->im = imagecreatefromgif($source_file);
  echo 'gif';
     break;
 case 'jpg':
  //   $this->im = imagecreatefromjpeg($source_file);
     echo  'jpg';
     break;
 case 'png':
     $this->im = imagecreatefrompng($source_file);
     break;
 default:
    echo 'no find type';
     //throw new Exception('Unrecognized image type ' . $type);
}


echo 'this type: '.$type;

?>
