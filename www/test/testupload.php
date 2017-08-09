<?php
include_once __DIR__.'/../filesetup.php';

  //$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  // print('recipe:'.$_POST['recipe'].'layer'.$_POST['layer'].$url.':'.


     //$_SERVER['REQUEST_URI']);
    $redirect = $_GET['_r'];
  //  echo $redirect;
   $files = scandir($tpath); // get all file names
   if(!file_exists($tpath)) {echo 'no file exis'; exit();}

   foreach($files as $file){ // iterate files

     if(is_file($tpath.$sl.$file))
       unlink($tpath.$sl.$file); // delete file
    }
    $total = count($_FILES['fileupload']['name']);

    for($i=0;$i<$total;$i++){
       move_uploaded_file($_FILES['fileupload']['tmp_name'][$i],$tpath.$sl.$_FILES['fileupload']['name'][$i]);

    }
  header('Location:'.$redirect);
  //  echo $redirect;
?>
<html>
<body>
<script>

//window.location.href = "<?php echo $redirect; ?>";
</script>
</body>
<html>
<?php
   exit();

?>
