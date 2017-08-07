<?php

require_once  __DIR__.'/vendor/autoload.php';

use Core\Bwcon\Bwcon;

//include './core/bwcon/src/Bwcon.php';

$f = '3.JPG';

$bwcon = new Bwcon($f);
$lvl = $_GET['b'];
//$bwcon->convert();

$bwcon->brightness($lvl);


//$bwcon->s();
//$bwcon->edge();

header('Content-type: image/jpeg');
$bwcon->output();



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
