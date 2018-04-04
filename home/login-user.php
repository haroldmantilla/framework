<?php

  require_once('../includes/data.inc.php');
  require_once('../includes/func.inc.php');

  session_start();

  $debug = false;

  if($debug){
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
  }

  if(isset($_SESSION['id'])) {
    $pass = $_POST['password'];
    $username = $_POST['username'];

    $valid = is_user($username);
    echo "$valid";

    if($valid){

      $login = get_login_info($username);

      $salt = $login[0];
      $hash = $login[1];

      $concat = $pass . $salt;
      $md5 = md5($pass . $salt);

      if(md5($concat) == $hash){
        $_SESSION['username'] = $username;
        // echo "valid password!";

        $level = get_access_level($username);
        $_SESSION['accesslevel'] = $level[0];
        $_SESSION['level'] = $level[1];

        if(!$debug){
          echo "<script type=\"text/javascript\">
          function redirect(location){
            window.location = location;
          }
          </script>";
          echo "<script>redirect('../index.php')</script>";

          header("Location: ../index.php");
        }
      }
      else{
        $_SESSION['error'] = "Login failed!";
        if(!$debug){
          header("Location: ../login.php");
        }
      }
    }
    else{
      $_SESSION['error'] = "User not registered!";
      if(!$debug){
        header("Location: ../login.php");
      }
    }

      if(!$debug){
        header("Location: ../login.php");
      }


      if($debug){
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
    }
  }
  ?>
