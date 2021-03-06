<?php
require_once  __DIR__.'/vendor/autoload.php';

use Core\Bwcon\Bwcon;
include_once __DIR__.'/filesetup.php';


if(!file_exists($bpath)||!file_exists($rpath)||!file_exists($tpath)||!file_exists($temp)){

  print('no file');
  echo '<a href="install.php">click here to setup</a>';
  exit();
}


if(!isset($_GET['recipe'])&&!isset($_GET['layer'])){
    include_once __DIR__.'/recipe.php';
    exit();

}




$b = new Bwcon($rpath.$sl.$_GET['recipe'].$sl.'master.jpg');

$lp = $rpath.$sl.$_GET['recipe'].$sl.$_GET['layer'];
$brightness = $b->get_avg_luminance();
$lvl = 0;
if(file_exists($lp.'.json')){

  $j =json_decode(file_get_contents($lp.'.json'),true);
  //print_r($j);
  //var_dump($j);
  //exit();

  $lvl = $j['b'];
  if(!isset($j['allowt'])){
    $allowt = 0;

  }
  else{
   $allowt = $j['allowt'];

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
    <title>Recipe Editor</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .pos-abs{
          position: absolute;

        }

        body,html{
         margin:0px;
         padding: 0px;

        }
    </style>
    <!-- Bootstrap -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <h1>Hello, world!<a href="./editor.php#<?php echo $_GET['recipe'] ?>"> back</a></h1>
    <div class="container">
      <div class="row">
       <div class="col-lg-6">
         <a class="btn btn-primary btn-block " page="main"  onclick="pagepv(event)"  name="pagetoggle" role="button">Editor</a>
       </div>
       <div class="col-lg-6">
       <a class="btn btn-primary btn-block col-lg-6" page="test"
        onclick="pagepv(event)" name="pagetoggle" role="button">test</a>
     </div>
     </div>
   </div>
 </br>
  <div class="container editor" id="main" name="page">
    <div class="row">

      <span class="col-lg-6">
       <img id="img-ori" class="img-responsive" src="masterimg.php?recipe=<?php echo $_GET['recipe'] ;?>">
       <span id="img-ori-msg" ></span>

       <button  id="reset"  type="button" class="btn btn-primary btn-lg btn-block">reset</button>
     </span>
         <span class="col-lg-6">
          <img id="img-edit" class="img-responsive">
          <span id="img-edit-load"></span>
          <form id="threshold-form" class="form-inline">
          <div class="form-group">
            <label for="threshold">threshold</label>
            <input type="text" class="form-control" id="threshold" value="<?php echo $lvl ?>" placeholder="any number 0-255">
            <input type="hidden" class="form-control" id="oriwidth" placeholder="any number 0-255">
            <input type="hidden" class="form-control" id="oriheight" placeholder="any number 0-255">
          </div>





          <button type="submit" class="btn btn-default">Set</button>
        </form>
        <form action="layer-edit.php" method="get">
        <label for="allowpixel">allow pixel</label>
        <input type="text" class="form-control" id="allowpixel" name="allowt" value="<?php echo $allowt ?>" placeholder="any number">
        <input type="hidden" class="form-control" name="recipe" value="<?php echo $_GET['recipe'] ?>" >
        <input type="hidden" class="form-control"  name="layer" value="<?php echo $_GET['layer'] ?>" >
        </form>
        </span>
      


   </div>
<?php echo 'Brigness :  '.$brightness ?>
    <div>




    </div>

  </div>

  <div  class="container" id="test" name="page">

    <!-- upload test image forms-->
    <?php $redirect = /*(isset($_SERVER['HTTPS']) ? "https" : "http") . */"$_SERVER[REQUEST_URI]"
                        .'#test';
         $redirect = urlencode($redirect);
        //  echo $redirect;
    ?>
    <form class="form-horizontal" action="/test/testupload.php?_r=<?php echo $redirect; ?>" id="testuploadform" method="post" enctype="multipart/form-data">
      <h1>upload test image</h1>
     <input id="fileupload" name="fileupload[]" type="file" multiple="multiple">upload master image</input>
     <input type="hidden" id="recipe" name="recipe" value="<?php echo $_GET['recipe'] ?>" ></input>
     <input type="hidden" id="layer" name="layer" value="<?php echo $_GET['layer'] ?>"></input>
     <button id="testformsubmit" class="btn btn-primary btn-lg btn-block">load test image</button>

    </form>
  </br>
    <!-- end uplaod image form-->
     <!-- list of test upload img-->
     <div class="row">
        <div class="col-xs-6" id="testimglist">

        </div>
        <div class="col-xs-6" id="testimgresult1">
        <div class="col-xs-6">
           <img id="img-ori" class="img-responsive" src="masterimg.php?recipe=<?php echo $_GET['recipe'] ;?>">
         </div>
         <div class="col-xs-6">
            <img id="img-test" class="img-responsive">
          </div>
         <div class="col-xs-12" id="testimgresult">
         </div>
        </div>
     </div>
     <!-- end of list test upload img -->

  </div>
<script src="/js/ajaxr.js"></script>
<script>

if( window.location.hash.substr(1)=='')
  window.location.hash = 'main';
  var crop = {},
  cOrisize={};
   var thre = 0;
  // if(document.getElementById('threshold').value!='')


  //var thre = 0;
   cOrisize = getsize(document.getElementById('img-ori'));
  var offsOri = getOffset(document.getElementById('img-ori'));
   console.log(cOrisize,offsOri);

  var thresholde =  document.getElementById('threshold-form');





document.body.onload=function(){
    thre = document.getElementById('threshold').value;
   var oriwh =    getsize(document.getElementById('img-ori'));
  // console.log('start', oriwh)
     document.getElementById('img-edit').style.height = oriwh.y+"px";
   setquery(thre,oriwh.x,oriwh.y);



  var ele = document.getElementById('img-ori-msg');
  ele.innerHTML='click to start draw recr pint 1';

  document.getElementById('img-edit').onload=function(){

    document.getElementById('img-edit-load').innerHTML="Loaded";




  };


  thresholde.onsubmit=function(e){
      e.preventDefault();
      var thre = parseInt(document.getElementById('threshold').value);
      if(thre>255) thre = 0;
      if(thre<0) thre =0;
      if(thre=='') thre =0;

         var oriwh =    getsize(document.getElementById('img-ori'));


      document.getElementById('img-edit-load').style="display:block;";
      var ele = document.getElementById("rubber");
      if(ele != null){

           var offr = getOffset(ele);
           var sizer= getsize(ele);
           var offo =  getOffset(document.getElementById('img-ori'));
           var x = offr.left - offo.left;
           var x1 = x + sizer.x;
           var y = offr.top - offo.top;
           var y1 = y + sizer.y;
             console.log(x,y,x1,y1,thre);
           oriwh =    getsize(document.getElementById('img-ori'));
            setquery(thre,oriwh.x,oriwh.y,x,y,x1,y1);


      }else{

        var ele = document.getElementById('img-ori')
         var offr = getOffset(ele);
         var sizer= getsize(ele);
         var x1 = sizer.x;
         var y1 = sizer.y;
         setquery(thre,oriwh.x,oriwh.y,0,0,x1,y1);
    //  setquery(thre,oriwh.x,oriwh.y);

    }
    console.log(thre);

  };

  document.getElementById('reset').onclick=function(e){
        crop = {};
      // document.getElementById('threshold').value=0;
       var ele = document.getElementById("rubber");
       if(ele != null) document.getElementById("rubber").remove();

       var ele = document.getElementById('img-ori-msg');
       ele.innerHTML='click to start draw recr pint 1';
      var ele = document.getElementById('img-ori')
       var offr = getOffset(ele);
       var sizer= getsize(ele);
       var x1 = sizer.x;
       var y1 = sizer.y;
       setquery(thre,oriwh.x,oriwh.y,0,0,x1,y1);
  };


  document.getElementById('img-ori').onclick=function(ev){
    ev.preventDefault();

   if(ev.which==1){
    var ele = document.getElementById("rubber");
    if(ele != null) return false;
       var ele = document.getElementById('img-ori-msg');
    if(!crop.hasOwnProperty('y')&&!crop.hasOwnProperty('x')){
       crop.x=ev.pageX;
       crop.y=ev.pageY;

       ele.innerHTML='click to draw point 2 , right click to delete';
      console.log('draw point 1')

      return false;
     }


  if(crop.hasOwnProperty('y')&&crop.hasOwnProperty('x')){
     crop.x1=ev.pageX;
     crop.y1=ev.pageY;
     ele.innerHTML='rec draw , right click to delete';
      drawrec();
     console.log('rec created',crop);
   }

 }
    return false;
  };

  document.getElementById('img-ori').addEventListener('contextmenu', function(e) {

      e.preventDefault();
      var ele = document.getElementById('img-ori-msg');
      ele.innerHTML='click to start draw recr pint 1';
        if(e.which==3){
          crop={};

            var ele = document.getElementById("rubber");
            if(ele != null) document.getElementById("rubber").remove();

      }
  }, false);

  window.onresize=function(){
  location.reload(); return false;
   crop={};
   var ele = document.getElementById("rubber");
   if(ele!=null) ele.remove();
   return false;
    var ori = offsOri;
    var c1={};
    var sc = scale(cOrisize);
    cOrisize = newcrop(cOrisize);


    var oriwh =    getsize(document.getElementById('img-ori'));

    document.getElementById('img-edit').height = oriwh.y;

    var ele = document.getElementById("rubber");
    var n = getOffset(document.getElementById('img-ori'));
    if(ele != null){

       document.getElementById("rubber").remove();


        c1.x = (crop.x - ori.left)/sc.x+ n.left;
        c1.y = (crop.y -ori.top)/sc.y+  n.top;
        c1.x1 = (crop.x1 - ori.left)/sc.x+ n.left;
        c1.y1 = (crop.y1 -ori.top)/sc.y+ n.top;

        offsOri =n;
        crop = c1;
       drawrec();
         return false;
     }else {


      crop={};
      var ele = document.getElementById('img-ori-msg');
      ele.innerHTML='click to start draw recr pint 1';


   }

  };


  //// redraw end



  /////end of main page

  ///start of test page
  var oldtestimg={}, testimg = {};
  setTimeout(listtestimg, 1000);

   function listtestimg(){


     httpAsync('GET','/test/gettestlist.php',function(val){
      testimg = JSON.parse(val);
      var ih = '';
      if(JSON.stringify(testimg)!=JSON.stringify(oldtestimg)){
       console.log(testimg);
         for(ky in testimg){
          ih = ih + '<div class="col-xs-6"><img '+
          'class="img-responsive" onclick="testimgexe(event)" id="'+testimg[ky]+'" src=" /test/testimg.php?file='+
            testimg[ky]
           +'""></a></div>';

         }
         document.getElementById('testimglist').innerHTML = ih;
     }
     oldtestimg = testimg;

       setTimeout(listtestimg, 1000);
     });



   }




 /// page controller
  setTimeout(pgcontroller, 200);
   function pgcontroller(){
     var pe = document.getElementsByName('page');

     var page = window.location.hash.substr(1);
     //var ele = document.getElementById("rubber");

    // if(ele != null&& page!="main") document.getElementById("rubber").remove();
  //   if(ele != null&& page=="main")  drawrec();

     for(var i=0;i<pe.length;i++){
         if(pe[i].id==page){
             pe[i].style.display ="block";

         }
         else {
             pe[i].style.display ="none";
         }

     }
  //   console.log(page,pe);
     setTimeout(pgcontroller, 200);
   }
  ///end of page controller


  //start of  pagebutton controller
   setTimeout(pgbcontroller, 500);
    function pgbcontroller(){
      var pe = document.getElementsByName('pagetoggle');

      var page = window.location.hash.substr(1);
      for(var i=0;i<pe.length;i++){
        var cln = pe[i].className;

        //console.log(cln);
          if(pe[i].getAttribute('page')==page){


            if(cln.search('active')==-1)
             pe[i].className = cln + ' active';

          }
          else {
            var cln1  = cln.replace(' active','');
            pe[i].className = cln1;
          }

      }
   //   console.log(page,pe);
      setTimeout(pgbcontroller, 500);
    }

  /// of onlod body
};
//end of dicuemtn body onload
//start of helper function

  function getOffset( el ) {
     var _x = 0;
     var _y = 0;
     while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
         _x += el.offsetLeft - el.scrollLeft;
         _y += el.offsetTop - el.scrollTop;
         el = el.offsetParent;
     }
     return { top: _y, left: _x };
 }

 function  getsize(img){



   var width = img.clientWidth;
   var height = img.clientHeight;
   return {x:width,y:height};
 }





 function setquery(b,ow,oh,x,y,x1,y1){
        var query = '?'+'_='+(new Date().getTime());
        query = query + '&recipe=' + findget('recipe')+
                '&layer='+findget('layer');
        if(b!=undefined){

            query = query + '&'+'b='+b;
        }

        if(ow!=undefined){

            query = query + '&'+ 'ow='+ow;
        }

        if(oh!=undefined){

            query = query + '&'+'oh='+oh;
        }

        if(x!=undefined){

            query = query +'&' +'x='+x;
        }

        if(y!=undefined){

            query = query+'&' + 'y='+y;
        }
        if(x1!=undefined){

            query = query+'&' + 'x1='+x1;

        }

        if(y1!=undefined){

            query = query+'&' + 'y1='+y1;
        }
        document.getElementById('img-edit-load').innerHTML="Loading ........";
        document.getElementById('img-edit').src="layer-edit.php"+query;


 }


 function drawrec(){
     var ele = document.getElementById("rubber");
     if(ele != null) document.getElementById("rubber").remove();
     var ne = document.createElement('div');

     ne.id='rubber';
     ne.style.position="absolute";
     if(!crop.hasOwnProperty('y')&&!crop.hasOwnProperty('x')) return false;
     if(!crop.hasOwnProperty('y1')&&!crop.hasOwnProperty('x1')) return false;
     var c =  croparrange();
     ne.style.top=c.y+'px';
     ne.style.left=c.x+'px';
     ne.style.width=c.x1-c.x+'px';
     ne.style.height=c.y1-c.y+'px';
     ne.style.border='1px solid red';
    document.getElementById('main').appendChild(ne);
   //document.body.appendChild(ne);
 }



  function croparrange(){
     var c = {};
    if(crop.x<crop.x1){
        c.x =crop.x ;
        c.x1 =crop.x1;
      }
    else {
      c.x =crop.x1 ;
      c.x1 =crop.x;

    }

    if(crop.y<crop.y1){
        c.y =crop.y ;
        c.y1 =crop.y1;
      }
    else {
      c.y =crop.y1 ;
      c.y1 =crop.y;

    }
    return c;
  }

  function newcrop(c){

    var re = {};
     var nc =  getsize(document.getElementById('img-ori'));
     console.log(nc,c);
     var scalex =c.x/nc.x;
    var scalex =c.y/nc.y;
     re.x = Math.round(c.x/scalex);
      re.y = Math.round(c.y/scalex);

     return re;
  }


function scale(c){

  var re = {};
   var nc =  getsize(document.getElementById('img-ori'));

    re.x =c.x/nc.x;
   re.y =c.y/nc.y;


   return re;


}

function findget(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}


function pagepv(e){
   e.preventDefault();
   var h = e.target.getAttribute('page');
   window.location.hash = h;

}

function testimgexe(e){
  //  console.log(e.target.id);
    var url = '/test/cwtest.php?target='+e.target.id+'&recipe='+
              findget('recipe')+'&layer='+findget('layer');
              // console.log(url);
              // return false;
    httpAsync('GET',url,function(val){
      console.log(val);
      var newurl = url+'&pic=autobrightness';
      document.getElementById('img-test').src=newurl;
      var v = JSON.parse(val);
      alert('total black pixel:'+v['result']);
      document.getElementById('testimgresult').innerHTML= '<h1 >total black pixel:'+v['result']+'</h1>'+
                                                          '<h1>test image brightness: '+v['brightness']+'</h1>'+
                                                          '<h1>after auto britngness: '+v['adbr']+'</h1>';
    });


}
</script>

  </body>
</html>
