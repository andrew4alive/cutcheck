<?php
require_once  __DIR__.'/vendor/autoload.php';



//echo $_POST['recipename'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Recepi</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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
    <h1>Recipe Manager<a href="./index.php">back to main</a></h1>
    <div class="container" id="main">
      <div class="row">
      <div class="col-xs-12">
         <button  id="new"  type="button" class="btn btn-primary btn-lg btn-block">New Recipe</button>
    </div>


         <div class="col-xs-6">
           <h1>Recipe :</h1>
           <div id="recipe"class="col-xs-12">

           </div>
           <input id="activerecipe" type="hidden"></input>

         </div>


           <div class="col-xs-6">
             <h1>Layer :</h1>
             <form class="form-inline">

  <!-- form star-->
   <div class="form-group">
     <label class="sr-only" for="newlayername">new layer</label>
     <input type="text" class="form-control" id="newlayername" placeholder="new layer name">
   </div>


   <button type="submit" id="newlayersubmit" class="btn btn-default">create</button>
 </form>

             <!--form end-->
             <div id="layer" class="col-xs-12" style="display:block;" >

             </div>


         </div>



       </div>

    </div>


       <div class="container" id="upload">
         <form class="form-horizontal" action="recipeupload.php" id="recipeform" method="post" enctype="multipart/form-data">
           <label for="recipename">Recipe name</label>
          <input type="text" class="form-control" id="recipename" name="recipename" placeholder="Email">
          <input id="fileupload" name="fileupload" type="file">upload master image</input>
          <button id="recipeformsubmit" class="btn btn-primary btn-lg btn-block">create recipe</button>
          <button  id="recipeformcancel" class="btn btn-primary btn-lg btn-block">cancel</button>
         </form>

         <span id="formmsg"></span>
       </div>




   <script>

   var oldlist = {},filelist={};
   var oldlayer = {},layerlist={};
    var uploadmode =false;

     document.body.onload=function(){


      document.getElementById('main').style.display = 'block';
      document.getElementById('upload').style.display = 'none';


      getrecipe();
      getlayer();
       document.getElementById('recipeformcancel').onclick=function(e){
               e.preventDefault();
               document.getElementById('main').style.display = 'block';
               document.getElementById('upload').style.display = 'none';
               document.getElementById('recipeform').reset();

       };

       document.getElementById('recipeformsubmit').onclick=function(e){
               e.preventDefault();
               var fileupload = document.getElementById('fileupload').value;
               var recipename = document.getElementById('recipename').value;
               console.log(fileupload,recipename);
               if(fileupload==""||recipename==""){
                 document.getElementById('formmsg').innerHTML=
                         '<span class="label label-default">'+
                         'select master image and insert recipe name'+
                         '</span>';
                 return false;
               }
               document.getElementById('formmsg').innerHTML='';
               document.getElementById('recipeform').submit();

       };
       document.getElementById('new').onclick=function(e){
               e.preventDefault();
               document.getElementById('main').style.display = 'none';
               document.getElementById('upload').style.display = 'block';


       };

       document.getElementById('newlayersubmit').onclick=function(e){
               e.preventDefault();
               var type = window.location.hash.substr(1);
               var layername =  document.getElementById('newlayername').value;
               if(layername==''){
                 alert('plase insert layer name');
                 return false;
               }
               httpGetAsync('layer-edit.php?createrecipe='+type+'&layer='+layername, function(val){
                      console.log(val);
                      document.getElementById('newlayername').value='';



             });




       };




     };


     function getrecipe(){
       var theUrl = "recipelist.php?_="+(new Date().getTime());
        httpGetAsync(theUrl, function(val){

            filelist = JSON.parse(val);
            if(JSON.stringify(oldlist) != JSON.stringify(filelist)) {
            oldlist = filelist;
            updatedom(filelist);
            console.log(val,':',filelist,oldlist);

          }
          setTimeout(function () {
            getrecipe();
          }, 1000);

        });

        function updatedom(f){
          var ih = '';
          for (ky in f){
             ih =ih+'<a href="#" value="'+f[ky]+'" onclick="selectr(event)" id=recipe-'+f[ky]+'>'+f[ky]+'</a></br>';
             if(window.location.hash.substr(1)=='')
            window.location.hash = f[ky].toString();
          }
         document.getElementById('recipe').innerHTML=ih;
        }


     }

     function getlayer(){
       var type = window.location.hash.substr(1);
       //console.log(type);


         if(type=='') {
          // console.log(type,document.getElementById('layer').style.display);
           document.getElementById('layer').style.display='none';
           setTimeout(getlayer,1000)
         return false;
       }
       document.getElementById('layer').style.display='block';

       exe();
        function exe(){
            httpGetAsync('recipelist.php?layer='+type, function(val){
                  // console.log(val);
                  layerlist =JSON.parse(val);
                  if(JSON.stringify(oldlayer) != JSON.stringify(layerlist)) {
                  oldlayer = layerlist;

                updatedom(layerlist);
              }
                 setTimeout(getlayer,1000);

          });
        }

       function updatedom(f){
         var ih = '';
         for (ky in f){
           var ffk = f[ky].toString();
           var sf = ffk.indexOf('.');
             sf =  sf- ffk.length;
           var im = f[ky].slice(0,sf);

           if(ffk.toLowerCase().search('.json')<0){
            ih =ih+'<a href="editor.php?recipe='+ type+'&layer='+ im
               +'" value="'+f[ky]+'" id=layer-'+ky+'>'+f[ky]+'</a></br>';
            }
         }
        document.getElementById('layer').innerHTML=ih;

       }
     }



  function selectr(e){
   e.preventDefault();

    window.location.hash= e.target.getAttribute('value');
  }


  function httpGetAsync(theUrl, callback)
 {
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
          callback(xmlHttp.responseText);
  }
  xmlHttp.open("GET", theUrl, true); // true for asynchronous
  xmlHttp.send(null);
   }

   </script>

   <script id="recipelist"></script>

  </body>
</html>
