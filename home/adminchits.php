<?php
  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Manage Chits',
                      'version'    => 1.0,
                      'display'    => 'Manage Chits',
                      'tab'        => 'admin',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('admin'=>'admin'));
  ###############################################################

 ################################################################
 #                  Only admins may use this page               #
 #                  used to see all chits on the system         #
 ################################################################

 ################################################################
 #                  Commented on 16DEC18 by                     #
 #                       Harold Mantilla                        #
 ################################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  #if archived chit is selected to be restored to active status
  if (isset($_REQUEST['restore'])) {
    #set $chit variable to the chit requested to be restored
    $chit = $_REQUEST['chit'];
    #restore chit
    restore_chit($db, $chit);
    #redirect
    $_SESSION['success'] = "Chit successfully restored!";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    die;
  }
  elseif (isset($_REQUEST['view'])) {
    #if admin selects a chit to be viewed
    $chit = $_REQUEST['chit'];
    #set current chit session variable to chit to be viewed
    $_SESSION['chit'] = $chit;
    #redirect
    header("Location: viewchit.php");
    die;
  }
  elseif (isset($_REQUEST['archive'])) {
    #if admin is archiving a chit
    $chit = $_REQUEST['archive'];
    #archive chit
    archive_chit($db, $chit);
    #unset current chit session variable
    unset($_SESSION['chit']);
    #redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }
  elseif (isset($_REQUEST['delete'])) {
    #if admin is deleting a chit
    $chit = $_REQUEST['delete'];
    #delete chit
    delete_chit($db, $chit);
    #unset chit session variable
    unset($_SESSION['chit']);
    #redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }
  elseif(isset($_REQUEST['deleteall']) && !empty($_REQUEST['deleteall'])){
    #if deleting all chits on the system
    #i've only used this once
    blast_chits($db);
  }

  # Load in The NavBar
  # Note: You too will have automated NavBar generation
  #       support in your future templates...
  require_once(WEB_PATH.'navbar.php');


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

?>
<form action='./adminchits.php' method='POST'>
  <div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-6">

    </div>
    <div class="col-md-4">
      <div class="input-group">
        <input type='text' class='form-control' name='FILTER' placeholder='Search Chit Description'>
        <span class="input-group-btn">
          <button type='submit' class='btn btn-default'>Find Chit</button>
        </span>
      </div>
    </div>
    <div class="col-md-1">

    </div>
  </div>
</form>

<div class="panel-group" id="accordion">

<?php

#grab active and archived chits from DB
$activechits = get_active_chits($db);
$archivedchits = get_archived_chits($db);

  //active chits
  if(!empty($activechits)){
    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse3\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Active Chits</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse3\" class=\"panel-collapse collapse in\">";
    echo "<div class=\"panel-body\" id=\"activesection\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    #display creator, date, company, descrition, status
    echo "<tr><th>Creator</th><th>Date</th><th>Company</th><th>Description</th><th>Status</th><th class=\"text-right\">Actions</th></tr></thead>";

    #sort through active chits
    foreach ($activechits as $chit){
      #if admin is querying chits by a filter
      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
        $datepos = stripos($chit['createdDate'], $_POST['FILTER']);
        $descpos = stripos($chit['description'], $_POST['FILTER']);
        $unamepos = stripos($chit['lastName'], $_POST['FILTER']);
        if($datepos === false && $descpos === false && $unamepos === false) {
          continue;
        }
      }

      #past chit querying via filter
      #grab description from current chit
      $chit['description'] = stripslashes($chit['description']);
      #print rank, firstname, lastname, and service on same row
      echo "<tr>";
      echo "<td>{$chit['rank']} {$chit['firstName']} {$chit['lastName']}, {$chit['service']} </td>";
      #print date created, company, and description
      echo "<td>{$chit['createdDate']}</td>";
      echo "<td>{$chit['company']}</td>";
      echo "<td>{$chit['description']}</td>";
      $chitstatus = "PENDING";

     if(!empty($chit['coc_2_username'])){ //batt-o
       $chitstatus = $chit['coc_2_status'];
     }
     elseif(empty($chit['coc_2_username']) && !empty($chit['coc_3_username'])){ // co
       $chitstatus = $chit['coc_3_status'];
     }
     elseif(empty($chit['coc_2_username']) && empty($chit['coc_3_username'])&&!empty($chit['coc_4_username'])){ //sel
       $chitstatus = $chit['coc_4_status'];
     }
     ####################    old code ignore    ###############################
      // $chitstatus = "PENDING";
      // if($chit['coc_0_status'] == "DISAPPROVED" ||
      //    $chit['coc_1_status'] == "DISAPPROVED" ||
      //    $chit['coc_2_status'] == "DISAPPROVED" ||
      //    $chit['coc_3_status'] == "DISAPPROVED" ||
      //    $chit['coc_4_status'] == "DISAPPROVED" ||
      //    $chit['coc_5_status'] == "DISAPPROVED" ||
      //    $chit['coc_6_status'] == "DISAPPROVED" ||
      //    $chit['coc_7_status'] == "DISAPPROVED" ||
      //    $chit['coc_8_status'] == "DISAPPROVED" ){
      //   $chitstatus = "DISAPPROVED";
      // }
      // elseif($chitstatus != "DISAPPROVED"){
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
      ####################    old code ignore    ###############################

      #set buttons depending on chit status
      if($chitstatus == "PENDING"){
        echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-secondary\" disabled>Pending</button></td>";
      }
      elseif($chitstatus == "APPROVED"){
        echo "<td><button style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-success\" disabled>Approved</button></td>";
      }
      elseif($chitstatus == "DISAPPROVED"){
        echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
      }
      echo "<td>";
      echo "<form style=\"float: right;\" action=\"?\" method=\"post\">
        <input type=\"hidden\" name=\"archive\" value=\"{$chit['chitNumber']}\"/>
        <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
        </form>";
        echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"view\" value=\"View Chit\"></form>";
      echo "<td>";
      echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo  "</div>";
  }


  //same process as above but for archived chits
  if(!empty($archivedchits)){
    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse4\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Archived Chits</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse4\" class=\"panel-collapse collapse in\">";
    echo "<div class=\"panel-body\"  id=\"archivedsection\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Creator</th><th>Date</th><th>Company</th><th>Description</th><th>Status</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($archivedchits as $chit){
      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
        $datepos = stripos($chit['createdDate'], $_POST['FILTER']);
        $descpos = stripos($chit['description'], $_POST['FILTER']);
        $unamepos = stripos($chit['lastName'], $_POST['FILTER']);
        if($datepos === false && $descpos === false && $unamepos === false) {
          continue;
        }
      }

      $chit['description'] = stripslashes($chit['description']);
      echo "<tr>";
      echo "<td>{$chit['rank']} {$chit['firstName']} {$chit['lastName']}, {$chit['service']} </td>";
      echo "<td>{$chit['createdDate']}</td>";
      echo "<td>{$chit['company']}</td>";
      echo "<td>{$chit['description']}</td>";
      $chitstatus = "PENDING";

     if(!empty($chit['coc_2_username'])){ //batt-o
       $chitstatus = $chit['coc_2_status'];
     }
     elseif(empty($chit['coc_2_username']) && !empty($chit['coc_3_username'])){ // co
       $chitstatus = $chit['coc_3_status'];
     }
     elseif(empty($chit['coc_2_username']) && empty($chit['coc_3_username'])&&!empty($chit['coc_4_username'])){ //sel
       $chitstatus = $chit['coc_4_status'];
     }


      // $chitstatus = "PENDING";
      // if($chit['coc_0_status'] == "DISAPPROVED" ||
      //    $chit['coc_1_status'] == "DISAPPROVED" ||
      //    $chit['coc_2_status'] == "DISAPPROVED" ||
      //    $chit['coc_3_status'] == "DISAPPROVED" ||
      //    $chit['coc_4_status'] == "DISAPPROVED" ||
      //    $chit['coc_5_status'] == "DISAPPROVED" ||
      //    $chit['coc_6_status'] == "DISAPPROVED" ||
      //    $chit['coc_7_status'] == "DISAPPROVED" ||
      //    $chit['coc_8_status'] == "DISAPPROVED" ){
      //   $chitstatus = "DENIED";
      // }
      // elseif($chitstatus != "DENIED"){
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
        echo "<td><button  style=\"cursor: auto !important\" type=\"button\" class=\"btn btn-danger\" disabled>Denied</button></td>";
      }

      echo "<td>";
      echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-danger\" name=\"deletebutton\" value=\"Delete Forever\"></form>";
      echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restore\" value=\"Restore Chit\"></form>";
      echo "<form style=\"float: right;\" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"view\" value=\"View Chit\"></form>";

      echo "<td>";
      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo  "</div>";
  }

  echo "</div>";


// echo "<div class=\"navbar navbar-fixed-bottom text-center\">";
//
//   echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#blastModal\">Permanently Delete All Chits</button>";
//
//
// echo "</div>";

echo "
		<!-- Blast Chits Modal -->
		<div id=\"blastModal\" class=\"modal fade\" role=\"dialog\">
			<div class=\"modal-dialog\">

				<!-- Modal content-->
				<div class=\"modal-content\">
					<div class=\"modal-header text-center\">
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
						<h4 class=\"modal-title\">Are you sure you want to delete all chits FOR ALL COMPANIES?</h4>
            <h5 class=\"modal-title\">This action cannot be undone.</h5>
					</div>
					<div class=\"modal-footer\">

						<div class=\"col-xs-6 text-left\">
							<div class=\"previous\">
								<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
							</div>
						</div>
						<div class=\"col-xs-6 text-right\">
							<div class=\"next\">
                <form action=\"?\" method=\"post\">
                <input type=\"hidden\" name=\"deleteall\" value=\"blast\">
                <input type=\"submit\" class=\"btn btn-danger\" value=\"Delete All Chits\">
              </form>
							</div>
						</div>


					</div>
				</div>

			</div>
		</div>
";
?>

</div>


</body>

</html>
