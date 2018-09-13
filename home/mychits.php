<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'My Chits',
                      'version'    => 1.0,
                      'display'    => 'My Chits',
                      'tab'        => 'chits',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('level'=>'MID'));
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  if (isset($_REQUEST['archive'])) {
    $chit = $_REQUEST['archive'];

    archive_chit($db, $chit);

    unset($_SESSION['chit']);

    header("Location: {$_SERVER['HTTP_REFERER']}");
  }
  elseif (isset($_REQUEST['print'])) {

    header("Location: generate_pdf.php");
    die;
  }


  # Load in The NavBar
  # Note: You too will have automated NavBar generation
  #       support in your future templates...
  require_once(WEB_PATH.'navbar.php');

?>
<div class="container-fluid">

<?php
// session_destroy();
// $_POST = array();
// $_REQUEST = array();
// die;

$debug = false;
// $debug = true;


$mychits = get_user_chits($db, USER['user']);


if(!in_midshipman_table($db, USER['user'])){
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
elseif(is_midshipman($db, USER['user'])){

  if(empty($mychits)){
    echo "<div class='row'>";
    echo "<div class='col-md-2'>";
    echo "</div>";
    echo "<div class='col-md-8 text-center'>";
    echo "<h4>Welcome to eChits!</h4>";
    echo "<button type=button class='btn btn-default' onclick=\"window.location.href='./makechit.php'\">Make Chit</button>";
    echo "</div>";
    echo "<div class='col-md-2'>";
    echo "</div>";
    echo "</div>";
  }
  elseif (!empty($mychits)){

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

    if($chit['coc_0_status'] == "DISAPPROVED" || // this is if anyone from CO and up disapproves the chit, it is disapproved
    $chit['coc_1_status'] == "DISAPPROVED" || // it can be overriden by the next thing in case the CO marks it disapproved but the Batt-O overrides
    $chit['coc_2_status'] == "DISAPPROVED" ||
    $chit['coc_3_status'] == "DISAPPROVED" ||){
      $chitstatus = "DISAPPROVED";
    }

    $count = 0;
    if(!empty($chit['coc_'.$count.'_username'])){ // if dant has selected an option
      $chitstatus = $chit['coc_0_status'];
    } elseif(empty($chit['coc_'.$count.'_username'])) { // elseif dant is null, continue

      while(empty($chit['coc_'.$count.'_username'])){   //continue until we find the top person in coc
        $count++;
        if(!empty($chit['coc_'.$count.'_username'])){
          $chitstatus = $chit['coc_'.$count.'_status']; //select the status of the top person in coc
          break;
        }
      }
    }

    if($chitstatus != "APPROVED" && $chitstatus != "DISAPPROVED"){
      $chitstatus = "PENDING";
    }
    // elseif($chitstatus != "DISAPPROVED"){
    //   while(empty($chit['coc_'.$count.'_username'])){
    //     $count++;
    //
    //   }
    //   if(!empty($chit['coc_0_username'])){ //dant
    //     $chitstatus = $chit['coc_0_status'];
    //   }
    //   elseif(!empty($chit['coc_1_username'])){ //depdant
    //     $chitstatus = $chit['coc_1_status'];
    //   }
    //   elseif(!empty($chit['coc_2_username'])){ //batt-o
    //     $chitstatus = $chit['coc_2_status'];
    //   }
    //   elseif(!empty($chit['coc_3_username'])){ // co
    //     $chitstatus = $chit['coc_3_status'];
    //   }
    //   elseif(!empty($chit['coc_4_username'])){ //sel
    //     $chitstatus = $chit['coc_4_status'];
    //   }
    // }

    if($chitstatus == "PENDING"){
      echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
    }
    elseif($chitstatus == "APPROVED"){
      echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
    }
    elseif($chitstatus == "DISAPPROVED"){
      echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>DISAPPROVED</button></td>";
    }


		echo "<td>";



    if($chitstatus == "APPROVED"){
      echo "<form style=\"float: right;\" action=\"?\" method=\"post\">
      <input type=\"hidden\" name=\"archive\" value=\"{$chit['chitNumber']}\"/>
      <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
      </form>";

        echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\"/><input type=\"submit\" class=\"btn btn-default\" name=\"print\" value=\"Print Chit\">
        </form>";
    }
    elseif ($chitstatus == "DISAPPROVED") {

      echo "<form style=\"float: right;\" action=\"?\" method=\"post\">
      <input type=\"hidden\" name=\"archive\" value=\"{$chit['chitNumber']}\"/>
      <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
      </form>";
    }

    echo "<form style=\"float: right; \" action=\"viewchit.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";


    echo "</td>";

		echo "</tr>";
	}

	echo "</table>";
	echo "</div>";
	echo "<div class='col-md-2'>";
	echo "</div>";
	echo "</div>";

}

}


?>



</div>


</body>

</html>
