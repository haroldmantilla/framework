<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Subordinate Chits',
                      'version'    => 1.0,
                      'display'    => 'Subordinate Chits',
                      'tab'        => 'chits',
                      'position'   => 3,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

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


$subchits = get_subordinate_chits($db, USER['user']);


if(empty($subchits)){
  echo "<h4 class=\"text-center\">There are no chits routed to you.</h4>";
}

$readychits = array();
$subchitsloop = $subchits;
  
foreach($subchitsloop as $key =>$chit){

  if(isset($chit['coc_6_username']) && $chit['coc_6_username'] == USER['user'] && $chit['coc_6_status'] != "PENDING"){
  continue;
  }
  elseif(isset($chit['coc_5_username']) && $chit['coc_5_username'] == USER['user'] && $chit['coc_5_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_4_username']) && $chit['coc_4_username'] == USER['user'] && $chit['coc_4_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_3_username']) && $chit['coc_3_username'] == USER['user'] && $chit['coc_3_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_2_username']) && $chit['coc_2_username'] == USER['user'] && $chit['coc_2_status'] != "PENDING"){
  continue;
  }

  elseif(isset($chit['coc_1_username']) && $chit['coc_1_username'] == USER['user'] && $chit['coc_1_status'] != "PENDING"){
  continue;
  }


  elseif(isset($chit['coc_0_username']) && $chit['coc_0_username'] == USER['user'] && $chit['coc_0_status'] != "PENDING"){
    continue;
  }




  elseif(!isset($chit['coc_6_username']) && isset($chit['coc_5_username']) && $chit['coc_5_username'] == USER['user'] && $chit['coc_5_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && isset($chit['coc_4_username']) && $chit['coc_4_username'] == USER['user'] && $chit['coc_4_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && isset($chit['coc_3_username']) && $chit['coc_3_username'] == USER['user'] && $chit['coc_3_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && isset($chit['coc_2_username']) && $chit['coc_2_username'] == USER['user'] && $chit['coc_2_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && !isset($chit['coc_2_username']) && isset($chit['coc_1_username']) && $chit['coc_1_username'] == USER['user'] && $chit['coc_1_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }
  elseif(!isset($chit['coc_6_username']) && !isset($chit['coc_5_username']) && !isset($chit['coc_4_username']) && !isset($chit['coc_3_username']) && !isset($chit['coc_2_username']) && !isset($chit['coc_1_username']) && isset($chit['coc_0_username']) && $chit['coc_0_username'] == USER['user'] && $chit['coc_0_status'] == "PENDING"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

  elseif(isset($chit['coc_5_username']) && $chit['coc_5_username'] == USER['user'] && $chit['coc_6_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

  elseif(isset($chit['coc_4_username']) && $chit['coc_4_username'] == USER['user'] && $chit['coc_5_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_3_username']) && $chit['coc_3_username'] == USER['user'] && $chit['coc_4_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_2_username']) && $chit['coc_2_username'] == USER['user'] && $chit['coc_3_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_1_username']) && $chit['coc_1_username'] == USER['user'] && $chit['coc_2_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }


  elseif(isset($chit['coc_0_username']) && $chit['coc_0_username'] == USER['user'] && $chit['coc_1_status'] == "APPROVED"){
    array_push($readychits, $chit);
    unset($subchits[$key]);
  }

}



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
        if($chit['coc_0_status'] == "DISAPPROVED" || $chit['coc_1_status'] == "DISAPPROVED" || $chit['coc_2_status'] == "DISAPPROVED" || $chit['coc_3_status'] == "DISAPPROVED" || $chit['coc_4_status'] == "DISAPPROVED" || $chit['coc_5_status'] == "DISAPPROVED" || $chit['coc_6_status'] == "DISAPPROVED"){
          $chitstatus = "DISAPPROVED";
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

        if($mystatus == "PENDING"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($mystatus == "APPROVED"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($mystatus == "DISAPPROVED"){
          echo "<td class=\"min\"><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>DISAPPROVED</button></td>";
        }



    		echo "<td>";

        if($chitstatus == "APPROVED"){

          echo "<form style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
            <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
            <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
            </form>";

            echo "<form style=\"float: right;\" action=\"print.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"Print Chit\"></form>";
        }
        elseif ($chitstatus == "DISAPPROVED") {

          echo "<form  style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
          <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
          <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
          </form>";

        }


        echo "<form style=\"float: right; \" action=\"viewchit.php\" id=\"viewform\" method=\"post\">";
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
        if($chit['coc_0_status'] == "DISAPPROVED" || $chit['coc_1_status'] == "DISAPPROVED" || $chit['coc_2_status'] == "DISAPPROVED" || $chit['coc_3_status'] == "DISAPPROVED" || $chit['coc_4_status'] == "DISAPPROVED" || $chit['coc_5_status'] == "DISAPPROVED" || $chit['coc_6_status'] == "DISAPPROVED"){
          $chitstatus = "DISAPPROVED";
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

        if($mystatus == "PENDING"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
        }
        elseif($mystatus == "APPROVED"){
          echo "<td class=\"min\"><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
        }
        elseif($mystatus == "DISAPPROVED"){
          echo "<td class=\"min\"><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>DISAPPROVED</button></td>";
        }



    		echo "<td>";

        if($chitstatus == "APPROVED"){

          echo "<form style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
            <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
            <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
            </form>";

            echo "<form style=\"float: right;\" action=\"print.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"Print Chit\"></form>";
        }
        elseif ($chitstatus == "DISAPPROVED") {

          echo "<form  style=\"float: right;\"  action=\"delete.script.php\" method=\"post\">
          <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
          <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
          </form>";

        }


        echo "<form style=\"float: right; \" action=\"viewchit.php\" id=\"viewform\" method=\"post\">";
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



?>



</div>


</body>

</html>
