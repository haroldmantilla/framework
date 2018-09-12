<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Subordinate Archive',
                      'version'    => 1.0,
                      'display'    => 'Subordinate Archive',
                      'tab'        => 'chits',
                      'position'   => 4,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

 if (isset($_REQUEST['restore'])) {

    $chit = $_REQUEST['chit'];

    restore_chit($db, $chit);

    //redirect
    $_SESSION['success'] = "Chit successfully restored!";
    header("Location: {$_SERVER['HTTP_REFERER']}");


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





$subarchivedchits = get_subordinate_archived_chits($db, USER['user']);
if (empty($subarchivedchits)) {
  echo "<h4 class=\"text-center\">There are no archived chits routed to you.</h4>";
}
elseif (!empty($subarchivedchits)){

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
        if($chit['coc_0_status'] == "DISAPPROVED" ||
           $chit['coc_1_status'] == "DISAPPROVED" ||
           $chit['coc_2_status'] == "DISAPPROVED" ||
           $chit['coc_3_status'] == "DISAPPROVED" ||
           $chit['coc_4_status'] == "DISAPPROVED" ||
           $chit['coc_5_status'] == "DISAPPROVED" ||
           $chit['coc_6_status'] == "DISAPPROVED" ||
           $chit['coc_7_status'] == "DISAPPROVED" ||
           $chit['coc_8_status'] == "DISAPPROVED" ){
          $chitstatus = "DENIED";
        }
        elseif($chitstatus != "DENIED"){
          if(!empty($chit['coc_0_username'])){ //dant
            $chitstatus = $chit['coc_0_status'];
          }
          elseif(!empty($chit['coc_1_username'])){ //depdant
            $chitstatus = $chit['coc_1_status'];
          }
          elseif(!empty($chit['coc_2_username'])){ //batt-o
            $chitstatus = $chit['coc_2_status'];
          }
          elseif(!empty($chit['coc_3_username'])){ // co
            $chitstatus = $chit['coc_3_status'];
          }
          elseif(!empty($chit['coc_4_username'])){ //sel
            $chitstatus = $chit['coc_4_status'];
          }
        }


          if($chitstatus == "PENDING"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
          }
          elseif($chitstatus == "APPROVED"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
          }
          elseif($chitstatus == "DISAPPROVED"){
            echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>DISAPPROVED</button></td>";
          }


          $mystatus = "PENDING";
          if(USER['user'] == $chit['coc_0_username']){
            $mystatus = $chit['coc_0_status'];
          }
          elseif(USER['user'] == $chit['coc_1_username']){
            $mystatus = $chit['coc_1_status'];
          }
          elseif(USER['user'] == $chit['coc_2_username']){
            $mystatus = $chit['coc_2_status'];
          }
          elseif(USER['user'] == $chit['coc_3_username']){
            $mystatus = $chit['coc_3_status'];
          }
          elseif(USER['user'] == $chit['coc_4_username']){
            $mystatus = $chit['coc_4_status'];
          }
          elseif(USER['user'] == $chit['coc_5_username']){
            $mystatus = $chit['coc_5_status'];
          }
          elseif(USER['user'] == $chit['coc_6_username']){
            $mystatus = $chit['coc_6_status'];
          }


          if($mystatus == "APPROVED"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
          }
          elseif($mystatus == "DISAPPROVED"){
            echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>DISAPPROVED</button></td>";
          } elseif ($mystatus =! "APPROVED" && $mystatus != "DISAPPROVED"){
            echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
          }




      		echo "<td>";


          echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restore\" value=\"Restore Chit\"></form>";

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




?>



</div>


</body>

</html>
