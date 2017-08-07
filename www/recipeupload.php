<?php
include_once __DIR__.'/filesetup.php';

  if(isset($_POST['recipename'])){
      $rn = $_POST['recipename'];
      print($rn);
      print($_FILES["fileupload"]["name"]);
  }
  else{

    echo 'something wrong <a href="/editor.php">back to recipe manager</a>';
    exit();
  }
  if(!file_exists($rpath.$sl.$rn)){
   $mk = mkdir($rpath.$sl.$rn);
 }else{
   echo 'recipe already created <a href="/editor.php">back to recipe manager</a>';
   exit();
 }

 if($mk){
     if(move_uploaded_file($_FILES["fileupload"]["tmp_name"], $rpath.$sl.$rn.$sl.'master.jpg')){
       $newURL = '/editor.php';
       header('Location: '.$newURL);

     }
     else{

       echo 'upload master image fail <a href="/editor.php">back to recipe manager</a>';
       exit();
     }

 }
//$newURL = '/editor.php';
//header('Location: '.$newURL);
exit();



?>
