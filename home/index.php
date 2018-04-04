<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="./imgs/icon.ico"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eChits</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->


    <script type="text/javascript">
      function redirect(location){
        window.location = location;
      }
    </script>


    <script type="text/javascript">
    function idleTimer() {
      var t;
      //window.onload = resetTimer;
      window.onmousemove = resetTimer; // catches mouse movements
      window.onmousedown = resetTimer; // catches mouse movements
      window.onclick = resetTimer;     // catches mouse clicks
      window.onscroll = resetTimer;    // catches scrolling
      window.onkeypress = resetTimer;  //catches keyboard actions

      function logout() {
        window.location.href = './logout.php';  //Adapt to actual logout script
      }

      function reload() {
        window.location = self.location.href;  //Reloads the current page
      }

      function resetTimer() {
        clearTimeout(t);
        t= setTimeout(reload, 600000);  // time is in milliseconds (1000 is 1 second)
        t = setTimeout(logout, 1200000);  // time is in milliseconds (1000 is 1 second)
      }
    }
    idleTimer();
    </script>

  </head>
  <body>
    <?php

    session_start();
    require_once('./includes/func.inc.php');
    require_once('./includes/nav.inc.php');
    require_once("./includes/nimitz.inc.php");
    require_once("./includes/error.inc.php");


    if (!isset($_SESSION['username'])) {
    	header("Location: ./login.php");
    }
    //
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";

    nav();
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>

<?php
// session_destroy();
// $_POST = array();
// $_REQUEST = array();
// die;

$debug = false;
// $debug = true;


if (!isset($_SESSION['username'])) {
	header("Location: ./login.php");
}

unset($_SESSION['success']);

$mychits = get_user_chits($_SESSION['username']);
$subchits = get_subordinate_chits($_SESSION['username']);



if($debug){
  echo "<pre>";
  print_r($mychits);
  echo "</pre>";

  echo "<pre>";
  print_r($subchits);
  echo "</pre>";

  echo "<pre>";
  print_r($_POST);
  echo "</pre>";


}



if($_SESSION['level'] == "MID" && !in_midshipman_table($_SESSION['username'])){
  echo "<div class=\"alert alert-danger text-center\">Your profile is <strong>incomplete!</strong> You will be unable to make chits or be chosen for someone else's Chain of Command until you complete your profile. Click the \"Edit Profile\" button to proceed.</div>";
  echo "<div class='row'>";
  echo "<div class='col-md-2'>";
  echo "</div>";
  echo "<div class='col-md-8 text-center'>";
  echo "<h2>Welcome to eChits!</h2>";
  echo "<h4>Complete your profile to make chits!</h4>";
  echo "<button type=button class='btn btn-default' onclick=\"window.location.href='./profile.php'\">Edit Profile</button>";
  echo "</div>";
  echo "<div class='col-md-2'>";
  echo "</div>";
  echo "</div>";

}
elseif($_SESSION['level'] == "MID" && is_midshipman($_SESSION['username'])){

  if(empty($mychits) && empty($subchits)){
    echo "<div class='row'>";
    echo "<div class='col-md-2'>";
    echo "</div>";
    echo "<div class='col-md-8 text-center'>";
    echo "<h2>Welcome to eChits!</h2>";
    echo "<button type=button class='btn btn-default' onclick=\"window.location.href='./makechit.php'\">Make Chit</button>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "</div>";
    echo "</div>";

  }
}
elseif($_SESSION['level'] != "MID" && empty($subchits)){
  echo "<div class='row'>";
  echo "<div class='col-md-2'>";
  echo "</div>";
  echo "<div class='col-md-8 text-center'>";
  echo "<h2>Welcome to eChits!</h2>";
  echo "<h4>You do not currently have any chits routed to you.</h4>";

  echo "</div>";
  echo "<div class='col-md-2'>";
  echo "</div>";
  echo "</div>";

}




if($debug){
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
}

if (!empty($mychits)){

	echo "<div class='row'>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "<div class='col-md-8'>";
  echo "<h4 style=\"padding: 8px;\"><strong>My Chits</strong></h4>";
	echo "<table class='table table-hover'>";
	echo "<thead>";
  echo "<tr><th>Chit Start Date</th><th>Description</th><th>Status</th><th class=\"text-right\">Actions</th></tr></thead>";

	foreach ($mychits as $chit){

    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

      $datepos = stripos($chit['startDate'], $_POST['FILTER']);
      $descpos = stripos($chit['description'], $_POST['FILTER']);

      if($datepos === false && $descpos === false) {
        continue;
      }

    }

    $chit['description'] = stripslashes($chit['description']);

		echo "<tr>";
    echo "<td>{$chit['startDate']}</td>";
    echo "<td>{$chit['description']}</td>";

    $chitstatus = "PENDING";
    if($chit['coc_0_status'] == "DENIED" || $chit['coc_1_status'] == "DENIED" || $chit['coc_2_status'] == "DENIED" || $chit['coc_3_status'] == "DENIED" || $chit['coc_4_status'] == "DENIED" || $chit['coc_5_status'] == "DENIED" || $chit['coc_6_status'] == "DENIED"){
      $chitstatus = "DENIED";
    }

    if($chitstatus != "DENIED"){
      if(!empty($chit['coc_0_username'])){
        $chitstatus = $chit['coc_0_status'];
      }
      elseif(!empty($chit['coc_1_username'])){
        $chitstatus = $chit['coc_1_status'];
      }
      elseif(!empty($chit['coc_2_username'])){
        $chitstatus = $chit['coc_2_status'];
      }
    }

    if($chitstatus == "PENDING"){
      echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
    }
    elseif($chitstatus == "APPROVED"){
      echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
    }
    elseif($chitstatus == "DENIED"){
      echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
    }


		echo "<td>";



    if($chitstatus == "APPROVED"){
      echo "<form style=\"float: right;\" action=\"delete.script.php\" method=\"post\">
        <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
        <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
        </form>";

        echo "<form style=\"float: right;\" action=\"print.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"Print Chit\"></form>";
    }
    elseif ($chitstatus == "DENIED") {

      echo "<form  style=\"float: right;\" action=\"delete.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
      <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
      </form>";
    }

    echo "<form style=\"float: right; \" action=\"view.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";


    echo "</td>";

		echo "</tr>";
	}

	echo "</table>";
	echo "</div>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "</div>";

}


$readychits = array();
$subchitsloop = $subchits;

foreach($subchitsloop as $key =>$chit){

  if(isset($chit['coc_6_username']) && $chit['coc_6_username'] == $_SESSION['username'] && $chit['coc_6_status'] != "PENDING"){
  continue;
  }
  elseif(isset($chit['coc_5_username']) && $chit['coc_5_username'] == $_SESSION['username'] && $chit['coc_5_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_4_username']) && $chit['coc_4_username'] == $_SESSION['username'] && $chit['coc_4_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_3_username']) && $chit['coc_3_username'] == $_SESSION['username'] && $chit['coc_3_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_2_username']) && $chit['coc_2_username'] == $_SESSION['username'] && $chit['coc_2_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_1_username']) && $chit['coc_1_username'] == $_SESSION['username'] && $chit['coc_1_status'] != "PENDING"){
  continue;
  }


  elseif(isset($chit['coc_0_username']) && $chit['coc_0_username'] == $_SESSION['username'] && $chit['coc_0_status'] != "PENDING"){
    continue;
  }




  elseif(!isset($chit['coc_6_username']) && isset($chit['coc_5_username']) && $chit['coc_5_username'] == $_SESSION['username'] && $chit['coc_5_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && isset($chit['coc_4_username']) && $chit['coc_4_username'] == $_SESSION['username'] && $chit['coc_4_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && isset($chit['coc_3_username']) && $chit['coc_3_username'] == $_SESSION['username'] && $chit['coc_3_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && isset($chit['coc_2_username']) && $chit['coc_2_username'] == $_SESSION['username'] && $chit['coc_2_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && !isset($chit['coc_2_username']) && isset($chit['coc_1_username']) && $chit['coc_1_username'] == $_SESSION['username'] && $chit['coc_1_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && !isset($chit['coc_2_username']) && !isset($chit['coc_1_username']) && isset($chit['coc_0_username']) && $chit['coc_0_username'] == $_SESSION['username'] && $chit['coc_0_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

  elseif(isset($chit['coc_5_username']) && $chit['coc_5_username'] == $_SESSION['username'] && $chit['coc_6_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

  elseif(isset($chit['coc_4_username']) && $chit['coc_4_username'] == $_SESSION['username'] && $chit['coc_5_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_3_username']) && $chit['coc_3_username'] == $_SESSION['username'] && $chit['coc_4_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_2_username']) && $chit['coc_2_username'] == $_SESSION['username'] && $chit['coc_3_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_1_username']) && $chit['coc_1_username'] == $_SESSION['username'] && $chit['coc_2_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_0_username']) && $chit['coc_0_username'] == $_SESSION['username'] && $chit['coc_1_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

}
//
// echo "<pre>";
// print_r($subchits);
// echo "</pre>";
//
//
//
// echo "<pre>";
// print_r($readychits);
// echo "</pre>";




// Ready Chits
if (!empty($readychits)){

	echo "<div class='row'>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "<div class='col-md-8'>";
  echo "<h4 style=\"padding: 8px;\"><strong>Subordinate Chits Ready for My Approval</strong></h4>";
	echo "<table class='table table-hover'>";
	echo "<thead>";
  echo "<tr><th>Owner</th><th>Chit Start Date</th><th>Description</th><th>Overall Status</th><th>My Status</th><th class=\"text-right\">Actions</th></tr></thead>";


	foreach ($readychits as $chit){
    // $chit = get_user_information($chit['creator']);

    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

      $datepos = stripos($chit['startDate'], $_POST['FILTER']);
      $descpos = stripos($chit['description'], $_POST['FILTER']);
      $ownrpos = stripos($chit['lastName'], $_POST['FILTER']);

      if($datepos === false && $descpos === false && $ownrpos === false) {
        continue;
      }

    }


        $chit['description'] = stripslashes($chit['description']);

  		echo "<tr>";


      echo "<td>{$chit['rank']} {$chit['firstName']} {$chit['lastName']}</td>";
      echo "<td>{$chit['startDate']}</td>";
      echo "<td>{$chit['description']}</td>";



        $chitstatus = "PENDING";
        if($chit['coc_0_status'] == "DENIED" || $chit['coc_1_status'] == "DENIED" || $chit['coc_2_status'] == "DENIED" || $chit['coc_3_status'] == "DENIED" || $chit['coc_4_status'] == "DENIED" || $chit['coc_5_status'] == "DENIED" || $chit['coc_6_status'] == "DENIED"){
          $chitstatus = "DENIED";
        }


        if(!empty($chit['coc_0_username'])){
          if($chit['coc_0_status'] != "PENDING"){
            $chitstatus = $chit['coc_0_status'];
          }
        }
        elseif(!empty($chit['coc_1_username'])){
          if($chit['coc_1_status'] != "PENDING"){
            $chitstatus = $chit['coc_1_status'];
          }
        }
        elseif(!empty($chit['coc_2_username'])){
          if($chit['coc_1_status'] != "PENDING"){
            $chitstatus = $chit['coc_2_status'];
          }
        }


        if($chitstatus == "PENDING"){
          echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($chitstatus == "APPROVED"){
          echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($chitstatus == "DENIED"){
          echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
        }


        $mystatus = "PENDING";
        if($_SESSION['username'] == $chit['coc_0_username']){
          $mystatus = $chit['coc_0_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_1_username']){
          $mystatus = $chit['coc_1_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_2_username']){
          $mystatus = $chit['coc_2_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_3_username']){
          $mystatus = $chit['coc_3_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_4_username']){
          $mystatus = $chit['coc_4_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_5_username']){
          $mystatus = $chit['coc_5_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_6_username']){
          $mystatus = $chit['coc_6_status'];
        }

        if($mystatus == "PENDING"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($mystatus == "APPROVED"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($mystatus == "DENIED"){
          echo "<td class=\"min\"><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
        }



    		echo "<td>";

        if($chitstatus == "APPROVED"){

          echo "<form style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
            <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
            <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
            </form>";

            echo "<form style=\"float: right;\" action=\"print.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"Print Chit\"></form>";
        }
        elseif ($chitstatus == "DENIED") {

          echo "<form  style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
          <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
          <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
          </form>";

        }


        echo "<form style=\"float: right; \" action=\"view.script.php\" id=\"viewform\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" />";
        echo "<button type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" for=\"viewform\" value=\"View Chit\">View Chit</button>";
        echo "</form>";


        echo "</tr>";
	}

	echo "</table>";
	echo "</div>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "</div>";

}



//subordinate Chits
if (!empty($subchits)){

	echo "<div class='row'>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "<div class='col-md-8'>";
  echo "<h4 style=\"padding: 8px;\"><strong>Subordinate Chits in Routing</strong></h4>";
	echo "<table class='table table-hover'>";
	echo "<thead>";
  echo "<tr><th>Owner</th><th>Chit Start Date</th><th>Description</th><th>Overall Status</th><th>My Status</th><th class=\"text-right\">Actions</th></tr></thead>";


	foreach ($subchits as $chit){
    //$chit = get_user_information($chit['creator']);

    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

      $datepos = stripos($chit['startDate'], $_POST['FILTER']);
      $descpos = stripos($chit['description'], $_POST['FILTER']);
      $ownrpos = stripos($chit['lastName'], $_POST['FILTER']);

      if($datepos === false && $descpos === false && $ownrpos === false) {
        continue;
      }

    }


        $chit['description'] = stripslashes($chit['description']);

  		echo "<tr>";


      echo "<td>{$chit['rank']} {$chit['firstName']} {$chit['lastName']}</td>";
      echo "<td>{$chit['startDate']}</td>";
      echo "<td>{$chit['description']}</td>";



        $chitstatus = "PENDING";
        if($chit['coc_0_status'] == "DENIED" || $chit['coc_1_status'] == "DENIED" || $chit['coc_2_status'] == "DENIED" || $chit['coc_3_status'] == "DENIED" || $chit['coc_4_status'] == "DENIED" || $chit['coc_5_status'] == "DENIED" || $chit['coc_6_status'] == "DENIED"){
          $chitstatus = "DENIED";
        }


        if(!empty($chit['coc_0_username'])){
          if($chit['coc_0_status'] != "PENDING"){
            $chitstatus = $chit['coc_0_status'];
          }
        }
        elseif(!empty($chit['coc_1_username'])){
          if($chit['coc_1_status'] != "PENDING"){
            $chitstatus = $chit['coc_1_status'];
          }
        }
        elseif(!empty($chit['coc_2_username'])){
          if($chit['coc_1_status'] != "PENDING"){
            $chitstatus = $chit['coc_2_status'];
          }
        }


        if($chitstatus == "PENDING"){
          echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($chitstatus == "APPROVED"){
          echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($chitstatus == "DENIED"){
          echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
        }


        $mystatus = "PENDING";
        if($_SESSION['username'] == $chit['coc_0_username']){
          $mystatus = $chit['coc_0_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_1_username']){
          $mystatus = $chit['coc_1_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_2_username']){
          $mystatus = $chit['coc_2_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_3_username']){
          $mystatus = $chit['coc_3_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_4_username']){
          $mystatus = $chit['coc_4_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_5_username']){
          $mystatus = $chit['coc_5_status'];
        }
        elseif($_SESSION['username'] == $chit['coc_6_username']){
          $mystatus = $chit['coc_6_status'];
        }

        if($mystatus == "PENDING"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($mystatus == "APPROVED"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($mystatus == "DENIED"){
          echo "<td class=\"min\"><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
        }



    		echo "<td>";

        if($chitstatus == "APPROVED"){

          echo "<form style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
            <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
            <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
            </form>";

            echo "<form style=\"float: right;\" action=\"print.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"Print Chit\"></form>";
        }
        elseif ($chitstatus == "DENIED") {

          echo "<form  style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
          <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
          <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
          </form>";

        }


        echo "<form style=\"float: right; \" action=\"view.script.php\" id=\"viewform\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" />";
        echo "<button type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" for=\"viewform\" value=\"View Chit\">View Chit</button>";
        echo "</form>";


        echo "</tr>";
	}

	echo "</table>";
	echo "</div>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "</div>";

}


echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";


$myarchivedchits = get_user_archived_chits($_SESSION['username']);
$subarchivedchits = get_subordinate_archived_chits($_SESSION['username']);

if(!empty($myarchivedchits) || !empty($subarchivedchits)){

  echo "<div class=\"row\">";
  echo "<div class=\"col-sm-12 text-center\">";
  echo "<button class=\"btn btn-primary\" type=\"button\" data-toggle=\"collapse\" data-target=\"#hiddenChits\" aria-expanded=\"false\" aria-controls=\"hiddenChits\">Archived Chits</button>";
  echo "</div>";
  echo "</div>";
  echo "<div class=\"collapse\" id=\"hiddenChits\">
  <div class=\"card card-block\">";


  if (!empty($myarchivedchits)){

  	echo "<div class='row'>";
  	echo "<div class='col-md-2'>";
  	echo "</div>";
  	echo "<div class='col-md-8'>";
    echo "<h4 style=\"padding: 8px;\"><strong>My Archived Chits</strong></h4>";
  	echo "<table class='table table-hover'>";
  	echo "<thead>";
    echo "<tr><th>Chit Start Date</th><th>Description</th><th>Status</th><th class=\"text-right\">Actions</th></tr></thead>";

  	foreach ($myarchivedchits as $chit){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $datepos = stripos($chit['startDate'], $_POST['FILTER']);
        $descpos = stripos($chit['description'], $_POST['FILTER']);

        if($datepos === false && $descpos === false) {
          continue;
        }

      }


      $chit['description'] = stripslashes($chit['description']);

  		echo "<tr>";
      echo "<td>{$chit['startDate']}</td>";
      echo "<td>{$chit['description']}</td>";

      $chitstatus = "PENDING";
      if($chit['coc_0_status'] == "DENIED" || $chit['coc_1_status'] == "DENIED" || $chit['coc_2_status'] == "DENIED" || $chit['coc_3_status'] == "DENIED" || $chit['coc_4_status'] == "DENIED" || $chit['coc_5_status'] == "DENIED" || $chit['coc_6_status'] == "DENIED"){
        $chitstatus = "DENIED";
      }

      if($chitstatus != "DENIED"){
        if(!empty($chit['coc_0_username'])){
          $chitstatus = $chit['coc_0_status'];
        }
        elseif(!empty($chit['coc_1_username'])){
          $chitstatus = $chit['coc_1_status'];
        }
        elseif(!empty($chit['coc_2_username'])){
          $chitstatus = $chit['coc_2_status'];
        }
      }

      if($chitstatus == "PENDING"){
        echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
      }
      elseif($chitstatus == "APPROVED"){
        echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
      }
      elseif($chitstatus == "DENIED"){
        echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
      }


  		echo "<td>";

      echo "<form style=\"float: right;\" action=\"restore.script.php\" method=\"post\"><input type=\"hidden\" name=\"restore\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restorebutton\" value=\"Restore Chit\"></form>";

      echo "<form style=\"float: right; \" action=\"view.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";


      echo "</td>";

  		echo "</tr>";
  	}

  	echo "</table>";
  	echo "</div>";
  	echo "<div class='col-md-2'>";
  	echo "</div>";
  	echo "</div>";

  }


  if (!empty($subarchivedchits)){

  	echo "<div class='row'>";
  	echo "<div class='col-md-2'>";
  	echo "</div>";
  	echo "<div class='col-md-8'>";
    echo "<h4 style=\"padding: 8px;\"><strong>Subordinate Archived Chits</strong></h4>";
  	echo "<table class='table table-hover'>";
  	echo "<thead>";
    echo "<tr><th>Owner</th><th>Chit Start Date</th><th>Description</th><th>Overall Status</th><th>My Status</th><th class=\"text-right\">Actions</th></tr></thead>";


  	foreach ($subarchivedchits as $chit){
      // $chit = get_user_information($chit['creator']);

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $datepos = stripos($chit['startDate'], $_POST['FILTER']);
        $descpos = stripos($chit['description'], $_POST['FILTER']);
        $ownrpos = stripos($chit['lastName'], $_POST['FILTER']);

        if($datepos === false && $descpos === false && $ownrpos === false) {
          continue;
        }

      }

      $chit['description'] = stripslashes($chit['description']);

    		echo "<tr>";


        echo "<td>{$chit['rank']}  {$chit['firstName']} {$chit['lastName']}</td>";
        echo "<td>{$chit['startDate']}</td>";
        echo "<td>{$chit['description']}</td>";



          $chitstatus = "PENDING";
          if($chit['coc_0_status'] == "DENIED" || $chit['coc_1_status'] == "DENIED" || $chit['coc_2_status'] == "DENIED" || $chit['coc_3_status'] == "DENIED" || $chit['coc_4_status'] == "DENIED" || $chit['coc_5_status'] == "DENIED" || $chit['coc_6_status'] == "DENIED"){
            $chitstatus = "DENIED";
          }


          if(!empty($chit['coc_0_username'])){
            if($chit['coc_0_status'] != "PENDING"){
              $chitstatus = $chit['coc_0_status'];
            }
          }
          elseif(!empty($chit['coc_1_username'])){
            if($chit['coc_1_status'] != "PENDING"){
              $chitstatus = $chit['coc_1_status'];
            }
          }
          elseif(!empty($chit['coc_2_username'])){
            if($chit['coc_1_status'] != "PENDING"){
              $chitstatus = $chit['coc_2_status'];
            }
          }


          if($chitstatus == "PENDING"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
          }
          elseif($chitstatus == "APPROVED"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
          }
          elseif($chitstatus == "DENIED"){
            echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
          }


          $mystatus = "PENDING";
          if($_SESSION['username'] == $chit['coc_0_username']){
            $mystatus = $chit['coc_0_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_1_username']){
            $mystatus = $chit['coc_1_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_2_username']){
            $mystatus = $chit['coc_2_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_3_username']){
            $mystatus = $chit['coc_3_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_4_username']){
            $mystatus = $chit['coc_4_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_5_username']){
            $mystatus = $chit['coc_5_status'];
          }
          elseif($_SESSION['username'] == $chit['coc_6_username']){
            $mystatus = $chit['coc_6_status'];
          }

          if($mystatus == "PENDING"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
          }
          elseif($mystatus == "APPROVED"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
          }
          elseif($mystatus == "DENIED"){
            echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
          }




      		echo "<td>";

          echo "<form  style=\"float: right; \" action=\"restore.script.php\" method=\"post\"><input type=\"hidden\" name=\"restore\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restorewbutton\" value=\"Restore Chit\"></form>";

          echo "<form style=\"float: right; \" action=\"view.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";


          echo "</td>";
          echo "</tr>";
  	}

  	echo "</table>";
  	echo "</div>";
  	echo "<div class='col-md-2'>";
  	echo "</div>";
  	echo "</div>";

  }




  echo  "</div>
  </div>";
  echo "</div>";

}

if($debug){
	echo "<pre>";
	echo "SESSION: ";
	print_r($_SESSION);
	echo "</pre>";
}
?>



</div>


</body>

</html>
