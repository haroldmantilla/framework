
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


if (!isset($_SESSION['company'])) {
  $company = get_company_number($_SESSION['username']);
  if($company == 0){
    header("Location: ./login.php");
  }
  else{
    $_SESSION['company'] = $company;
  }
}

blast_chits_company($_SESSION['company']);

unset($_SESSION['chit']);

//redirect
header("Location: ./admin.php");



 ?>
