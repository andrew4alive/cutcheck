<?php
require_once  __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../filesetup.php';


$prp = file_get_contents($bpath.$sl.'prodpath.txt');
if($prp==''){
 $prp = 'c:'.$sl.'lot';
}
if(!file_exists($prp)){
  echo 'no lot foler<a href="/index.php">back to main</a>';
  exit();
}
if(isset($_COOKIE['lotn'])&&isset($_COOKIE['recipe'])){
  if($_COOKIE['lotn']!=''&&$_COOKIE['recipe']!=''){

  include __DIR__.'/exe.php';
  exit();
}
}

if(isset($_GET['recipe'])&&isset($_GET['lotn'])){
   if($_GET['recipe']==''&&$_GET['lotn']=='') {
     echo 'no lot number and type exits <a href="/index.php">back to main</a>';

   }
   else{



     if(file_exists($rpath.$sl.$_GET['recipe'])){
      if(!file_exists($prop.$sl.$_GET['lotn'])){
       $m1 = mkdir($prop.$sl.$_GET['lotn']);
       if(!$m1)
       {
         echo 'cannot create lot file 1 <a href="/index.php">back to main</a> ';
        exit();
       }
     }

     if(!file_exists($prop.$sl.$_GET['lotn'].$sl.'fail')){
       $m2 = mkdir($prop.$sl.$_GET['lotn'].$sl.'fail');
       if(!$m2)
       {
         echo 'cannot create lot file 2 <a href="/index.php">back to main</a>';
        exit();
       }
     }
     setcookie('lotn',$_GET['lotn'], time() + (86400 * 365), "/");
     setcookie('recipe',$_GET['recipe'], time() + (86400 * 365), "/");

    /*
     $files = scandir($prop); // get all file names
     //if(!file_exists($tpath)) echo 'no file exis';

     foreach($files as $file){ // iterate files

       //if(is_file($prop.$sl.$file))
         unlink($prop.$sl.$file); // delete file
      }*/


    header('Location:/pro/index.php');
  //  include __DIR__.'/exe.php';
    exit();
    }
     else{
       echo 'no recipe <a href="/index.php">back to main</a>';
       }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
      <h1>production mode  <a href='/'>back to main</a></h1>
      <div class="container" id="load">
         <div class="row">
           <form action="/pro/index.php" method="get">
           <!--<label for="lotn">allow pixel</label>-->
           <input type="text" class="form-control" id="lotn" name="lotn" placeholder="lot number">
           </br>
           <input type="text" class="form-control" id="recipe" name="recipe" placeholder="type">
           <button type="submit">run</button>

           </form>
         </div>
      </div>

  </div>
  <script>
   document.body.onload=function(){
    document.getElementById('lotn').focus();

   };
  </script>


  </body>
</html>
