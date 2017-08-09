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
      <a class="btn btn-primary" href="#" id="start" role="button">start</a>
      <a class="btn btn-warning" href="#" id="end" role="button">end</a>
      <a class="btn btn-default" href="/pro/endlot.php" role="button">end lot</a>
      <h3 id="info" style="display:inline;"></h3>
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
          <div id="re"></div>
          <div id="recount"></div>
          <div id="restatus"></div>
        </div>
      </div>
  </div>

  <script src="/js/ajaxr.js"></script>
  <script>
  var layer =<?php echo json_encode($sc,JSON_FORCE_OBJECT) ;?>;
  var recipe = "<?php echo $_COOKIE['recipe']  ?>";
  var start = false;


   document.body.onload=function(){
  document.getElementById('info').innerHTML='<span class="badge">'+'stop'+'</span>';

  document.getElementById('start').onclick=function(e){
   e.preventDefault();
  //  console.log('start');
       document.getElementById('info').innerHTML='<span class="badge">'+'start'+'</span>';
    start = true;

  ///  startexe();
  };

  document.getElementById('end').onclick=function(e){
   e.preventDefault();
  //  console.log('end');
   document.getElementById('info').innerHTML='<span class="badge">'+'stop'+'</span>';
    start = false;
  };

 setTimeout(startexe,1000);




   };

   function startexe(){
     if(start){


     httpg('GET','/pro/list.php',function(val){
       //  console.log(val);
         var list = JSON.parse(val);
         if(JSON.stringify(list)=='{}'){
              //var temp =   document.getElementById('re').innerHTML;
            document.getElementById('restatus').innerHTML = '<span class="label label-success">complete test</span';
             setTimeout(startexe,1000);
         }

         for (li in list){
           // console.log(li,list[li]);
         imgtest(list[li],0);

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


   function imgtest(list,lc){
    // document.getElementById('img-test').src='/pro/imgtest.php?file='+list;
       httpg('GET','/pro/cwtest.php?target='+list+'&recipe='+ recipe+'&lc='+lc ,
       function(val1){
         //console.log(val1);

       var val1 = JSON.parse(val1);
       document.getElementById('img-test').src="data:image/jpeg;base64,"+val1['base64'];

       if(lc==0)
        document.getElementById('re').innerHTML = val1['result'];
        else{
        var ot = document.getElementById('re').innerHTML;
        document.getElementById('re').innerHTML=ot+'</br>'+val1['result'];

        }
        if(val1['cfail']>0){
         document.getElementById('recount').innerHTML=
         '<span class="label label-default">'+val1['ctest']+'/'+val1['clot']+'</span>'+
          '<span class="label label-danger">fail: '+val1['cfail']+'</span>'   ;
        }else{
          document.getElementById('recount').innerHTML=
          '<span class="label label-default">'+val1['ctest']+'/'+val1['clot']+'</span>'+
           '<span class="label label-success">fail: '+val1['cfail']+'</span>'   ;


        }
        if(val1['con'])
        imgtest(list,lc+1);
        else
        setTimeout(startexe,1000);
        return false;
      });

   }
  </script>


  </body>
</html>
