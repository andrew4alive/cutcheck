<?php
require_once  __DIR__.'/vendor/autoload.php';

use Core\Bwcon\Bwcon;

$b = new Bwcon('1.JPG');

$brightness = $b->get_avg_luminance();

$b = new Bwcon('3.JPG');

$brightness1 = $b->get_avg_luminance();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <div class="container main">
      <h1>Binary inspection</h1>
      <a href="./editor.php">editor</a>
    </br>
      <a href="./pro/index.php">production</a>
  </div>



  </body>
</html>