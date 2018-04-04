
<?php
session_start();
require_once('./includes/func.inc.php');
require_once("./includes/error.inc.php");
require_once("./includes/nimitz.inc.php");


if (!isset($_SESSION['username'])) {
  header("Location: ./login.php");
}

if(!isset($_POST['restore'])){
  header("Location: ./index.php");
}

$chit = $_POST['restore'];

$debug = true;
if($debug){

  echo "<pre>";
  print_r($_POST);
  echo "</pre>";


  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";

}


restore_from_database($chit);

//redirect
$_SESSION['success'] = "Chit successfully restored!";
header("Location: {$_SERVER['HTTP_REFERER']}");


 ?>
