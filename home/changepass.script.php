<?php
session_start();
require_once('./includes/nimitz.inc.php');
require_once('./includes/func.inc.php');

if(!isset($_SESSION['username'])){
  //redirect
  header("Location: ./login.php");

}
if(!isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] != "admin"){
  //redirect
  header("Location: ./login.php");

}
if(!isset($_POST['nametochange'])){
  header("Location: ./admin.php");
}

//change pass
$salt = generateRandomString();
$hash = md5("echitsdefault" . $salt );
change_password($_POST['nametochange'], $salt, $hash);

header("Location: ./admin.php");


 ?>
