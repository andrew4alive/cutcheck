<?php

setcookie('lotn','', time() - (86400 * 365), "/");
setcookie('recipe','', time() - (86400 * 365), "/");
header('Location:/pro/index.php');
?>
