<?php
require_once  __DIR__.'/../vendor/autoload.php';

$prp = file_get_contents($bpath.$sl.'prodpath.txt');

if($prp==''){
 $prp = 'c:'.$sl.'lot';
}
if(!file_exists($prp)){
  echo 'no lot foler';
  exit();
}

if(!file_exists($prp.$sl.$_COOKIE['lotn'])){
  echo 'no lot foler';
  setcookie('lotn','', time() - (86400 * 365), "/");
  setcookie('recipe','', time() - (86400 * 365), "/");
  echo 'lot not exits <a href="/index.php">back to main</a>';
  exit();
//  header('Location:/endlot.php');
}

$sc = scandir($rpath.$sl.$_COOKIE['recipe']);
$fl =array('.','..','master.jpg');
$sc = array_diff($sc,$fl);

//var_dump($sc);

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
      <h1>production mode<a href='/'>back to main</a></h1>

      <h3>lot number:<?php echo $_COOKIE['lotn']; ?></h3>
      <h3>Recipe:<?php echo $_COOKIE['recipe']; ?></h3>
      <a class="btn btn-default" href="#" id="start" role="button">start</a>
      <a class="btn btn-default" href="#" id="end" role="button">end</a>
      <a class="btn btn-default" href="/pro/endlot.php" role="button">end lot</a>
      </br>
      <div class="row">
        <div class="col-xs-4">
           <img class="img-responsive" src="/masterimg.php?recipe=<?php echo $_COOKIE['recipe'];  ?>">
        </div>
        <div class="col-xs-4">
           <img class="img-responsive" id="img-test" >
        </div>
        <div class="col-xs-4">
          <h1> Result: </h1>
          <span id="re"></span>
        </div>
      </div>
  </div>

  <script src="/js/ajaxr.js"></script>
  <script>

   document.body.onload=function(){

     var layer =<?php echo json_encode($sc,JSON_FORCE_OBJECT) ;?>;
     var recipe = "<?php echo $_COOKIE['recipe']  ?>";



    // console.log(layerjson);
  //  document.getElementById('lotn').focus();
    var start = false;
  document.getElementById('start').onclick=function(e){
   e.preventDefault();
  //  console.log('start');

    start = true;

  ///  startexe();
  };

  document.getElementById('end').onclick=function(e){
   e.preventDefault();
  //  console.log('end');

    start = false;
  };

 setTimeout(startexe,1000);

  function startexe(){
    if(start){


    httpg('GET','/pro/list.php',function(val){
      //  console.log(val);
        var list = JSON.parse(val);
        if(JSON.stringify(list)=='{}'){
          document.getElementById('re').innerHTML = 'complete test';

            setTimeout(startexe,1000);
        }

        for (li in list){
          // console.log(li,list[li]);
          document.getElementById('img-test').src='/pro/imgtest.php?file='+list[li];
            httpg('GET','/pro/cwtest.php?target='+list[li]+'&recipe='+ recipe ,
            function(val1){
            //  console.log(val1);
             document.getElementById('re').innerHTML = val1;
             setTimeout(startexe,1000);
             return false;
           } );
          return false;

        }
      return false;
    });


    return false;
    }
    else{
    //  console.log('stop testing');

    setTimeout(startexe,1000);
  }
  }



   };
  </script>


  </body>
</html>
