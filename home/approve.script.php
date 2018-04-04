<?php
session_start();
require_once('./includes/func.inc.php');
require_once("./includes/error.inc.php");
require_once("./includes/nimitz.inc.php");


if (!isset($_SESSION['username'])) {
  header("Location: ./login.php");
}


$debug = true;



if($debug){
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}


$chit = get_chit_information($_SESSION['chit']);
$who = null;

if($chit['coc_0_username'] == $_SESSION['username']){
  $who = "coc_0";
}
elseif($chit['coc_1_username'] == $_SESSION['username']){
  $who = "coc_1";
}
elseif($chit['coc_2_username'] == $_SESSION['username']){
  $who = "coc_2";
}
elseif($chit['coc_3_username'] == $_SESSION['username']){
  $who = "coc_3";
}
elseif($chit['coc_4_username'] == $_SESSION['username']){
  $who = "coc_4";
}
elseif($chit['coc_5_username'] == $_SESSION['username']){
  $who = "coc_5";
}
elseif($chit['coc_6_username'] == $_SESSION['username']){
  $who = "coc_6";
}

$today = date("dMy");
$today = strtoupper($today);
$now = date("Hi");
$chit = $_SESSION['chit'];

action($chit, $who, "APPROVED", $today, $now);


//redirect
header("Location: ./viewchit.php");

 ?>
