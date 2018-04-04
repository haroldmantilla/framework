
<?php
session_start();
require_once('./includes/func.inc.php');
require_once("./includes/error.inc.php");
require_once("./includes/nimitz.inc.php");


if (!isset($_SESSION['username'])) {
  header("Location: ./login.php");
}

if (!isset($_SESSION['accesslevel']) || $_SESSION['accesslevel'] != "admin") {
  header("Location: ./index.php");
}

if (!isset($_POST['username'])) {
  header("Location: ./admin.php");
}


$debug = true;

if($debug){
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}

remove_admin($_POST['username']);

//redirect
header("Location: ./adminusers.php");


 ?>
