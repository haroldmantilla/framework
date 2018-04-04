<?php
require_once('./includes/func.inc.php');
session_start();

if(!isset($_SESSION['username'])){
header("Location: ./login.php");
}

$midshipmaninfo = get_midshipman_information($_SESSION['username']);

$response = "";
$pos_0 = null;
$pos_1 = null;
$pos_2 = null;


if(isset($_REQUEST['to'])){
  $user_info = get_user_information($_REQUEST['to']);

  if($_REQUEST['to'] == $midshipmaninfo['coc_0']){

      if(!empty($midshipmaninfo['coc_0'])){
      $info = get_user_information($midshipmaninfo['coc_0']);
      $pos_0 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }

    if(!empty($midshipmaninfo['coc_1'])){
      $info = get_user_information($midshipmaninfo['coc_1']);
      $pos_1 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }

    if(!empty($midshipmaninfo['coc_2'])){
      $info = get_user_information($midshipmaninfo['coc_2']);
      $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }


  }
  elseif($_REQUEST['to'] == $midshipmaninfo['coc_1']){
    $pos_0 = "<br><br><br>";

    if(!empty($midshipmaninfo['coc_1'])){
      $info = get_user_information($midshipmaninfo['coc_1']);
      $pos_1 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }

    if(!empty($midshipmaninfo['coc_2'])){
      $info = get_user_information($midshipmaninfo['coc_2']);
      $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }

  }
  elseif($_REQUEST['to'] == $midshipmaninfo['coc_2']){

    $pos_0 = "<br><br><br>";
    $pos_1 = "<br><br><br>";


    if(!empty($midshipmaninfo['coc_2'])){
      $info = get_user_information($midshipmaninfo['coc_2']);
      $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    }

  }



  if(!empty($midshipmaninfo['coc_3'])){
    $info = get_user_information($midshipmaninfo['coc_3']);
    $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
  }
  else{
    $pos_3 = "<br><br><br>";
  }

  if(!empty($midshipmaninfo['coc_4'])){
    $info = get_user_information($midshipmaninfo['coc_4']);
    $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
  }
  else{
    $pos_4 = "<br><br><br>";
  }

  if(!empty($midshipmaninfo['coc_5'])){
    $info = get_user_information($midshipmaninfo['coc_5']);
    $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
  }
  else{
    $pos_5 = "<br><br><br>";
  }

  if(!empty($midshipmaninfo['coc_6'])){
    $info = get_user_information($midshipmaninfo['coc_6']);
    $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_5']);
    $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_4']);
    $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_3']);
    $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

  }
  elseif(!empty($midshipmaninfo['coc_5'])){
    $pos_3 = "<br><br><br>";

    $info = get_user_information($midshipmaninfo['coc_5']);
    $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_4']);
    $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_3']);
    $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

  }
  elseif(!empty($midshipmaninfo['coc_4'])){
    $pos_3 = "<br><br><br>";
    $pos_4 = "<br><br><br>";

    $info = get_user_information($midshipmaninfo['coc_4']);
    $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

    $info = get_user_information($midshipmaninfo['coc_3']);
    $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

  }

  elseif(!empty($midshipmaninfo['coc_3'])){
    $pos_3 = "<br><br><br>";
    $pos_4 = "<br><br><br>";
    $pos_5 = "<br><br><br>";

    $info = get_user_information($midshipmaninfo['coc_3']);
    $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
  }
  else{
    $pos_3 = "<br><br><br>";
    $pos_4 = "<br><br><br>";
    $pos_5 = "<br><br><br>";
    $pos_6 = "<br><br><br>";
  }


  echo $pos_0 . ";" . $pos_1 . ";" . $pos_2 . ";" . $pos_3 . ";" . $pos_4 . ";". $pos_5 . ";". $pos_6 ;

}

?>
