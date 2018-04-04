
<?php
session_start();
require_once('./includes/func.inc.php');
require_once("./includes/error.inc.php");
require_once("./includes/nimitz.inc.php");


if (!isset($_SESSION['username'])) {
  header("Location: ./login.php");
}

if (!isset($_POST['blast'])) {
  header("Location: ./admin.php");
}


blast_chits();

unset($_SESSION['chit']);

//redirect
header("Location: ./admin.php");



 ?>
