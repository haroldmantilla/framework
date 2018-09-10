<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Manage All Users',
                      'version'    => 1.0,
                      'display'    => 'Admin',
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

  if (isset($_REQUEST['deleteuser'])) {                                         //check if someone wants to delete a user
    delete_user($db, $_REQUEST['username']);                                    //delete the user
  }
  elseif (isset($_REQUEST['designatemislo'])) {                                 //check if someone wants to designate MISLO
    designate_MISLO($db, $_POST['username']);                                   //designate MISLO
  }
  elseif (isset($_REQUEST['designatesafety'])) {
    designate_safety($db, $_REQUEST['username']);
  }
  elseif (isset($_REQUEST['designateadmin'])) {
    designate_admin($db, $_REQUEST['username']);
  }
  elseif (isset($_REQUEST['removemislo'])) {
    remove_MISLO($db, $_POST['username']);
  }
  elseif (isset($_REQUEST['removesafety'])) {
    remove_safety($db, $_REQUEST['username']);
  }
  elseif (isset($_REQUEST['removeadmin'])) {
    remove_admin($db, $_REQUEST['username']);
  }



  # Load in The NavBar
  # Note: You too will have automated NavBar generation
  #       support in your future templates...
  require_once(WEB_PATH.'navbar.php');

?>

<div class="container-fluid">

<?php

$debug = false;

$company = get_company_number($db, USER['user']);                               //get user's company


?>


<form action='./adminusersall.php' method='POST'>
  <div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-6">

    </div>
    <div class="col-md-4">
      <div class="input-group">
        <input type='text' class='form-control' name='FILTER' id="search" placeholder='Search...' autofocus>
        <span class="input-group-btn">
          <button type='submit' class='btn btn-default'>Find User</button>
        </span>
      </div>
    </div>
    <div class="col-md-1">

    </div>
  </div>
</form>

<div class="panel-group" id="accordion">

<?php


$admins = get_admins($db);                                                      // get list of admins
$MISLOs = get_MISLOs($db);                                                      // get list of mislos
$safeties = get_safeties($db);                                                  // get list of safeties
$staff = get_staff($db);                                                        // get officers
$completemids = get_complete_mids($db);                                         // get mids that have all info updated
$incompletemids = get_incomplete_mids($db);                                     // get mids that do not have all info updated


//************************** FILTER AND DISPLAY ADMINS ***********************//
  if(!empty($admins)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse1\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Administrators</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse1\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($admins as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false) {
          $in=true;
          break;
        }
      }
    }
    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }

    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($admins as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false) {
          continue;
        }

      }


      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";
      echo "<td>{$user['level']}</td>";

      echo "<td>";


      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removeadmin\" value=\"Remove Administrator\"></form>";
      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel
    echo "</div>"; //panel
    echo "</div>"; // col


    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }

//************************** FILTER AND DISPLAY MISLOs ***********************//
  if(!empty($MISLOs)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse2\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>MISLOs</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse2\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($MISLOs as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false) {
          $in=true;
          break;
        }
      }
    }
    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }

    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($MISLOs as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);

        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false) {
          continue;
        }

      }


      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";

      echo "<td>";


      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removemislo\" value=\"Remove MISLO\"></form>";

      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateadmin\" value=\"Designate Admin\"></form>";


      echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel

    echo "</div>"; //panel
    echo "</div>"; // col


    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }

//************************** FILTER AND DISPLAY SAFETIES *********************//
  if(!empty($safeties)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse3\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Safety Officers</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse3\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($safeties as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false) {
          $in=true;
          break;
        }
      }
    }
    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }

    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($safeties as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false) {
          continue;
        }

      }


      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";

      echo "<td>";


      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removesafety\" value=\"Remove Safety Officer\"></form>";
      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel

    echo "</div>"; //panel
    echo "</div>"; // col


    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }

//************************** FILTER AND DISPLAY STAFF ************************//
  if(!empty($staff)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse4\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Officers and Senior Enlisted</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse4\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($staff as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false || $levelpos !== false) {
          $in=true;
          break;
        }
      }
    }
    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }


    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Level</th><th>Billet</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($staff as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);
        $billetpos = stripos($user['billet'], $_POST['FILTER']);


        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false && $billetpos === false) {
          continue;
        }

      }


      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";
      echo "<td>{$user['level']}</td>";
      echo "<td>{$user['billet']}</td>";


      echo "<td>";


      echo "
      <form style=\"float: right;\" action=\"?\" method=\"post\">
      <input type=\"hidden\" name=\"username\" id=\"username\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-danger\" value=\"Delete User\"></form>";


      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateadmin\" value=\"Designate Administrator\"></form>";
      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel

    echo "</div>"; //panel
    echo "</div>"; // col


    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }

//************************** FILTER AND DISPLAY COMPLETE MIDS ****************//
  if(!empty($completemids)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse5\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Midshipmen</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse5\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($completemids as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false || $levelpos !== false) {
          $in=true;
          break;
        }
      }
    }

    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }

    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Company</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($completemids as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $company_matches = array();
        preg_match('/company:\d\d?/', $_POST['FILTER'], $company_matches);

        $year_matches = array();
        preg_match('/year:\d\d/', $_POST['FILTER'], $year_matches);

        if(!empty($company_matches)){
          if(!in_array("company:" . $user['company'], $company_matches) && !in_array("company:0" . $user['company'], $company_matches) ){
            continue;
          }
        }
        if(!empty($year_matches)){
          $year = substr($user['username'], 1, 2);
          if(!in_array("year:" . $year, $year_matches)){
            continue;
          }
        }

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false && empty($company_matches) && empty($year_matches)) {
          continue;
        }

      }



      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";

      echo "<td>{$user['company']}</td>";

      echo "<td>{$user['level']}</td>";

      echo "<td>";

      echo "
      <form style=\"float: right;\" action=\"?\" method=\"post\">
      <input type=\"hidden\" name=\"username\" id=\"username\" value=\"{$user['username']}\">
      <input type=\"submit\" name=\"deleteuser\" class=\"btn btn-danger\" value=\"Delete User\"></form>";

      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designatemislo\" value=\"Designate MISLO\"></form>";


      echo "<form style=\"float: right; \" action=\"?\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designatesafety\" value=\"Designate Safety Officer\"></form>";

      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel

    echo "</div>"; //panel
    echo "</div>"; // col


    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }

//************************** FILTER AND DISPLAY INCOMPLETE MIDS ****************//
  if(!empty($incompletemids)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse6\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Midshipmen Unassigned to Companies</strong>";
    echo "</h3>";
    echo "</div>"; // panel heading
    echo "</a>";

    echo "<div id=\"collapse6\" class=\"panel-collapse collapse ";
    $in = false;
    if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){
      foreach ($incompletemids as $user){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos !== false || $unamepos !== false || $firstpos !== false || $rankpos !== false || $levelpos !== false) {
          $in=true;
          break;
        }
      }
    }
    if($in){ echo "in \"> ";}
    else{
      echo " \"> ";
    }

    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($incompletemids as $user){

      if(isset($_POST['FILTER']) && !empty($_POST['FILTER'])){

        $namepos = stripos($user['lastName'], $_POST['FILTER']);
        $firstpos = stripos($user['firstName'], $_POST['FILTER']);
        $unamepos = stripos($user['username'], $_POST['FILTER']);
        $rankpos = stripos($user['rank'], $_POST['FILTER']);
        $levelpos = stripos($user['level'], $_POST['FILTER']);

        if($namepos === false && $unamepos === false && $firstpos === false && $rankpos === false && $levelpos === false) {
          continue;
        }

      }


      echo "<tr>";
      echo "<td>{$user['username']}</td>";
      echo "<td>{$user['rank']} {$user['firstName']} {$user['lastName']}, {$user['service']} </td>";


      echo "<td>{$user['level']}</td>";

      echo "<td>";

      echo "
      <form style=\"float: right;\" action=\"?\" method=\"post\">
      <input type=\"hidden\" name=\"username\" id=\"username\" value=\"{$user['username']}\">
      <input type=\"submit\"  name=\"deleteuser\" class=\"btn btn-danger\" value=\"Delete User\"></form>";


      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; //panel
    echo "</div>"; //panel

    echo "</div>"; //panel
    echo "</div>"; // col

    echo "<div class='col-md-1'>";
    echo "</div>"; // col
    echo "</div>"; // row
  }


  echo "</div>"; //panel-group

  echo "</div>"; //container-fluid

?>

</div>

<script type="text/javascript">

$(document).keypress(function(e){
	 $("#search").focus();
   return true;
});
//
// $(function () {
//   $("#query").keypress(function (e) {
//       var code = (e.keyCode ? e.keyCode : e.which);
//       // alert(code);
//
//       if (code == 13) {
//           $("#submit").trigger('click');
//           return false;
//       }
//   });
// });

</script>

</body>

</html>
