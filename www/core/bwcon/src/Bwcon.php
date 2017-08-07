<?php
namespace Core\Bwcon;

class Bwcon{

  public $im;
  private $w;
  private $h;
  public $fileName;
  public function __construct($source_file){

    if(!file_exists($source_file)) die('no file');
    $this->fileName = $source_file;
    $this->im = ImageCreateFromJpeg($source_file);

    $this->w = imagesx($this->im);
    $this->h = imagesy($this->im);
  }

  public function grayscale(){

    imagefilter($this->im, IMG_FILTER_GRAYSCALE);


  }


  public function contrast($lvl){


    imagefilter($this->im, IMG_FILTER_CONTRAST, $lvl);

  }

  public function mono($lvl){
    $this->grayscale();
    $this->brightness($lvl);
    $this->contrast(-255);
  }


  public function edge(){

    imagefilter($this->im, IMG_FILTER_EDGEDETECT);
  }
  public function brightness($lvl){

    imagefilter($this->im,IMG_FILTER_BRIGHTNESS,$lvl);
  }

  public function getwidth(){

    return $this->w;
  }

  public function getheight(){

     return $this->h;

  }

  public function convert(){

    $im = $this->im;
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

                    imagesetpixel ($this->im, $i, $j, $val);
            }
    }

  }


    public function output($path = null){
     if($path ==null){

       return imagejpeg($this->im);
     }
     else {
        return imagejpeg($this->im,$path);
     }


    }

    public function get_avg_luminance( $num_samples=30) {
        $img = $this->im;

        $width = imagesx($img);
        $height = imagesy($img);

        $x_step = intval($width/$num_samples);
        $y_step = intval($height/$num_samples);

        $total_lum = 0;

        $sample_no = 1;

        for ($x=0; $x<$width; $x+=$x_step) {
            for ($y=0; $y<$height; $y+=$y_step) {

                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // choose a simple luminance formula from here
                // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
                $lum = ($r+$r+$b+$g+$g+$g)/6;

                $total_lum += $lum;

                // debugging code
     //           echo "$sample_no - XY: $x,$y = $r, $g, $b = $lum<br />";
                $sample_no++;
            }
        }
        $avg_lum  = $total_lum/$sample_no;

       return $avg_lum;
      }



}




//imagejpeg($im,'./2.jpg');
