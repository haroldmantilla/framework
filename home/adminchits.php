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

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  # Load in The NavBar
  # Note: You too will have automated NavBar generation
  #       support in your future templates...
  require_once(WEB_PATH.'navbar.php');

  if(isset($_REQUEST['delete']) && !empty($_REQUEST['delete'])){
    blast_chits($db);
  }

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
    echo "<tr><th>Creator</th><th>Date</th><th>Company</th><th>Description</th><th>Status</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($activechits as $chit){

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


      echo "<form style=\"float: right;\" action=\"delete.script.php\" method=\"post\">
        <input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\"/>
        <input type=\"submit\" class=\"btn btn-danger\" value=\"Archive\">
        </form>";

        echo "<form style=\"float: right;\" action=\"view.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";
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


  //archived chits
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

      echo "<form style=\"float: right;\" action=\"permanentlydelete.script.php\" method=\"post\"><input type=\"hidden\" name=\"delete\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-danger\" name=\"restorewbutton\" value=\"Delete Forever\"></form>";

      echo "<form style=\"float: right;\" action=\"restore.script.php\" method=\"post\"><input type=\"hidden\" name=\"restore\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restorewbutton\" value=\"Restore Chit\"></form>";

      echo "<form style=\"float: right;\" action=\"view.script.php\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-default\" name=\"viewbutton\" value=\"View Chit\"></form>";





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


echo "<div class=\"navbar navbar-fixed-bottom text-center\">";

  echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#blastModal\">Permanently Delete All Chits</button>";


echo "</div>";


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
                <input type=\"hidden\" name=\"delete\" value=\"blast\">
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
