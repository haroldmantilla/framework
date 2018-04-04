<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Chit Register</title>
    <link href="../includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <body>
<?php
  require('../includes/nav.inc.php');
  require('../includes/data.inc.php');
  require('../includes/func.inc.php');
  require('../includes/nimitz.inc.php');
  nav(2);


// PLAN ON REMOVING THE OPTION TO ALLOW USERS TO CREATE OWN USERNAME. ONLY
// TAKE EMAIL AND PASSWORD AS INPUTS SO EACH EMAIL CAN ONLY REGISTER ONCE AND
// NOT HAVE MULTIPLE USERNAMES


session_start();
unset($_SESSION['error']);
unset($_SESSION['success']);

$debug = true;


if($debug){
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
}

if($_POST['password1'] != $_POST['password2']){
  $_SESSION['error'] = "Passwords do not match!";
  header("Location: ../register.php");
}

if(strlen($_POST['username']) > 10){
  $_SESSION['error'] = "Username too long!";
}

if(strlen($_POST['firstname']) > 20){

  $_SESSION['error'] = "Firstname too long!";
}


if(strlen($_POST['lastname']) > 20){

  $_SESSION['error'] = "Lastname too long!";
}


if(strlen($_POST['billet']) > 40){

  $_SESSION['error'] = "Billet too long!";
}


if(strpos($_POST['password1'], "'") !== false){
  //' symbol in password'

  $_SESSION['error'] = "Invalid character in password!";
}



if(strpos($_POST['username'], "@") !== false){
  //@ symbos in username

  $_SESSION['error'] = "Invalid character (@) in username!";

}

$before = strstr($_POST['email'], "@usna.edu", true);

if($before !== $_POST['username']){

  $_SESSION['error'] = "Username does not appear in email!";

}

$username_exists = is_user($_POST['username']);

if($username_exists){
  $_SESSION['error'] = "Username already taken!";
}


if(isset($_SESSION['error'])) {
  header("Location: ../register.php");
  die();
}




$level = $_POST['level'];
$first = $_POST['firstname'];
$last = $_POST['lastname'];
$email = $_POST['email'];
$billet = $_POST['billet'];
$username = $_POST['username'];
$service = $_POST['service'];
$rank = $_POST['rank'];

$salt = generateRandomString();
$hash = md5($_POST['password1'] . $salt );

unset($_POST['password1']);
unset($_POST['password2']);

register_leader($username, $salt, $hash, $first, $last, $billet, $rank, $service, $level);

$successful_write = is_user($username);


if(!$successful_write) {
  $_SESSION['error'] = "Unsuccessful write to database!";
  header("Location: ../register.php");
  die();
}
else{
  $_SESSION['success'] = "Registration success!";
  $_SESSION['username'] = $_POST['username'];

  $level = get_access_level($username);
  $_SESSION['accesslevel'] = $level[0];
  $_SESSION['level'] = $level[1];

  header("Location: ../index.php");
}

if($debug){
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}

die();

?>
</body>
</html>
