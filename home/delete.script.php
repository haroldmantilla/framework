
<?php
session_start();
require_once('./includes/func.inc.php');
require_once("./includes/error.inc.php");
require_once("./includes/nimitz.inc.php");


if (!isset($_SESSION['username'])) {
  header("Location: ./login.php");
}

if (!isset($_POST['delete'])) {
  header("Location: ./index.php");
}


$debug = true;

if($debug){
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}

$chit = $_POST['delete'];

delete_from_database($chit);

unset($_SESSION['chit']);

//redirect
if(isset($_SERVER['HTTP_REFERER'])){
  if(strpos($_SERVER['HTTP_REFERER'], "viewchit.php")){
    header("Location: ./index.php");
  }
}

header("Location: {$_SERVER['HTTP_REFERER']}");


//header("Location: ./admin.php");



 ?>
