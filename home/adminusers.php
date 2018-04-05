<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Manage Users',
                      'version'    => 1.0,
                      'display'    => 'Admin',
                      'tab'        => 'user',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('admin'=>'site'));
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
  <div class="row">
    <div class="col-md-12">
    </div>
  </div>
  
<?php

$debug = false;
// $debug = true;


if (!isset($_SESSION['company'])) {
  $company = get_company_number($_SESSION['username']);
  if($company == 0){
    header("Location: ./login.php");
  }
  else{
    $_SESSION['company'] = $company;
  }
}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


echo "<div class=\"row\">";
echo "<div class=\"col-md-1\">";
echo "</div>";
echo "<div class=\"col-md-1\">";

echo "<button class=\"btn btn-primary\" onclick=\"location.href = './adminchits.php';\">View Chits</button>";

echo "</div>";
echo "<div class=\"col-md-6 \">";


echo "<div class=\"row\">";
echo "  <div class=\"col-md-12\" style=\"text-align:center\">";

if($_SESSION['accesslevel'] == "admin"){
  echo "<div class=\"input-group\" style=\"display: inlinie-block;\">";
  echo "<form action=\"?\" method=\"post\" id=\"stayopen\">";
  echo "<label style=\"margin-right: 20px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"Administrators\" value=\"Administrators\" ";
  if(isset($_POST['None'])){
    unset($_SESSION['Administrators']);
    unset($_SESSION['MISLOs']);
    unset($_SESSION['Safety_Officers']);
    unset($_SESSION['Staff']);
    unset($_SESSION['MIDN']);
    unset($_SESSION['NoCompany']);

    unset($_POST['Administrators']);
    unset($_POST['MISLOs']);
    unset($_POST['Safety_Officers']);
    unset($_POST['Staff']);
    unset($_POST['MIDN']);
    unset($_POST['NoCompany']);
  }
  else{
    if(!isset($_SESSION['Administrators']) && isset($_POST['Administrators']) ){
      $_SESSION['Administrators'] = $_POST['Administrators'];
    }
    if(!isset($_SESSION['MISLOs']) && isset($_POST['MISLOs'])){
      $_SESSION['MISLOs'] = $_POST['MISLOs'];
    }
    if(!isset($_SESSION['Safety_Officers']) && isset($_POST['Safety_Officers'])){
      $_SESSION['Safety_Officers'] = $_POST['Safety_Officers'];
    }
    if(!isset($_SESSION['Staff']) && isset($_POST['Staff'])){
      $_SESSION['Staff'] = $_POST['Staff'];
    }
    if(!isset($_SESSION['MIDN']) && isset($_POST['MIDN'])){
      $_SESSION['MIDN'] = $_POST['MIDN'];
    }
    if(!isset($_SESSION['NoCompany']) && isset($_POST['NoCompany'])){
      $_SESSION['NoCompany'] = $_POST['NoCompany'];
    }
  }


  if(isset($_SESSION['Administrators'])){
    echo "checked=checked";
  }
  echo ">Administrators</label>";

  echo "<label style=\"margin-right: 20px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"MISLOs\" value=\"MISLOs\" ";
  if(isset($_SESSION['MISLOs'])){
    echo "checked=checked";
  }
  echo ">MISLOs</label>";

  echo "<label style=\"margin-right: 20px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"Safety_Officers\" value=\"Safety Officers\" ";
  if(isset($_SESSION['Safety_Officers'])){
    echo "checked=checked";
  }
  echo ">Safety Officers</label>";

  echo "<label style=\"margin-right: 20px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"Staff\" value=\"Staff\" ";
  if(isset($_SESSION['Staff'])){
    echo "checked=checked";
  }
  echo ">Staff</label>";

  echo "<label style=\"margin-right: 20px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"MIDN\" value=\"MIDN\" ";
  if(isset($_SESSION['MIDN'])){
    echo "checked=checked";
  }
  echo ">MIDN</label>";

  echo "<label style=\"margin-right: 50px;\"><input onchange=\"this.form.submit()\"  type=\"checkbox\" name=\"NoCompany\" value=\"NoCompany\" ";
  if(isset($_SESSION['NoCompany'])){
    echo "checked=checked";
  }
  echo ">MIDN w/o Company</label>";
  echo "<input class=\"btn btn-dark\" type=\"submit\" name=\"None\" value=\"Close All\">";


  echo "</form>";
  echo " </div>";
}
echo " </div>";
echo "</div> ";

echo "</div> ";



echo "<div class=\"col-md-3 \">";
echo "<form class='navbar-form navbar-right' action='./adminusers.php' method='POST'><div class='form-group'>
<input type='text' class='form-control' name='FILTER' placeholder='Search for Users'>
        </div>
        <button type='submit' class='btn btn-default'>Find User</button>
      </form>";
echo "</div>";

echo "<div class=\"col-md-1\">";
echo "</div>";
echo "</div>";

echo "<div class=\"panel-group\" id=\"accordion\">";

if($_SESSION['accesslevel'] == "admin"){

  $admins = get_admins();
  $MISLOs = get_MISLOs();
  $safeties = get_safeties();
  $staff = get_staff();
  $completemids = get_complete_mids();
  $incompletemids = get_incomplete_mids();


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
    if(isset($_SESSION['Administrators'])){ echo "in ";}
    echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Access</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

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
      echo "<td>{$user['accesslevel']}</td>";
      echo "<td>{$user['level']}</td>";

      echo "<td>";


      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


      echo "<form style=\"float: right; \" action=\"removeadmin.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removeadmin\" value=\"Remove Administrator\"></form>";
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

    echo "<div id=\"collapse2\" class=\"panel-collapse collapse "; if(isset($_SESSION['MISLOs'])){ echo "in ";} echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Company</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($MISLOs as $user){

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
      echo "<td>{$user['company']}</td>";
      echo "<td>{$user['level']}</td>";

      echo "<td>";


      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


      echo "<form style=\"float: right; \" action=\"removeMISLO.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removeadmin\" value=\"Remove MISLO\"></form>";

      echo "<form style=\"float: right; \" action=\"designateadmin.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateadmin\" value=\"Designate Admin\"></form>";


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

    echo "<div id=\"collapse3\" class=\"panel-collapse collapse "; if(isset($_SESSION['Safety_Officers'])){ echo "in ";} echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Company</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

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
      echo "<td>{$user['company']}</td>";
      echo "<td>{$user['level']}</td>";

      echo "<td>";


      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


      echo "<form style=\"float: right; \" action=\"removesafety.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removesafety\" value=\"Remove Safety Officer\"></form>";
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

    echo "<div id=\"collapse4\" class=\"panel-collapse collapse "; if(isset($_SESSION['Staff'])){ echo "in ";} echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Access</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

    foreach ($staff as $user){

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
      echo "<td>{$user['accesslevel']}</td>";
      echo "<td>{$user['level']}</td>";

      echo "<td>";


      echo "
      <form style=\"float: right;\" action=\"deleteuser.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"usertodelete\" id=\"usertodelete\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-danger\" value=\"Delete User\"></form>";

      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


      echo "<form style=\"float: right; \" action=\"designateadmin.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateadmin\" value=\"Designate Administrator\"></form>";
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

    echo "<div id=\"collapse5\" class=\"panel-collapse collapse "; if(isset($_SESSION['MIDN'])){ echo "in ";} echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Company</th><th>Access</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

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
      echo "<td>{$user['accesslevel']}</td>";

      echo "<td>{$user['level']}</td>";

      echo "<td>";

      echo "
      <form style=\"float: right;\" action=\"deleteuser.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"usertodelete\" id=\"usertodelete\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-danger\" value=\"Delete User\"></form>";

      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";

      echo "<form style=\"float: right; \" action=\"designateMISLO.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateMISLO\" value=\"Designate MISLO\"></form>";


      echo "<form style=\"float: right; \" action=\"designatesafety.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designatesafety\" value=\"Designate Safety Officer\"></form>";

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

  if(!empty($incompletemids)){

    echo "<div class='row'>";
    echo "<div class='col-md-1'>";
    echo "</div>";
    echo "<div class='col-md-10'>";
    echo "<div class=\"panel panel-default\">";

    echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse6\" style=\"color: #000000;\">";
    echo "<div class=\"panel-heading\">";
    echo "<h3 class=\"panel-title\">";
    echo "<strong>Midshipmen Unassigned to Companies</strong>";
    echo "</h3>";
    echo "</div>";
    echo "</a>";

    echo "<div id=\"collapse6\" class=\"panel-collapse collapse "; if(isset($_SESSION['NoCompany'])){ echo "in ";} echo "\">";
    echo "<div class=\"panel-body\">";
    //rows go here
    echo "<table class='table table-hover'>";
    echo "<thead>";
    echo "<tr><th>Username</th><th>Name</th><th>Access</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

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

      echo "<td>{$user['accesslevel']}</td>";

      echo "<td>{$user['level']}</td>";

      echo "<td>";

      echo "
      <form style=\"float: right;\" action=\"deleteuser.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"usertodelete\" id=\"usertodelete\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-danger\" value=\"Delete User\"></form>";

      echo "
      <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
      <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
      <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


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

  echo "</div>";
  die;

}
elseif($_SESSION['accesslevel'] == "MISLO"){

  $MISLOs = array();
  $safeties = array();
  $users = get_company($_SESSION['company']);

  foreach ($users as $key => $user) {
    if($user['accesslevel'] == "safety"){
      array_push($safeties, $user);
      unset($users[$key]);

    }
    elseif($user['accesslevel'] == "MISLO"){
      array_push($MISLOs, $user);
      unset($users[$key]);
    }
  }


    if(!empty($MISLOs)){

      echo "<div class='row'>";
      echo "<div class='col-md-1'>";
      echo "</div>";
      echo "<div class='col-md-10'>";
      echo "<div class=\"panel panel-default\">";

      echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse2\" style=\"color: #000000;\">";
      echo "<div class=\"panel-heading\">";
      echo "<h3 class=\"panel-title\">";
      echo "<strong>MISLO</strong>";
      echo "</h3>";
      echo "</div>";
      echo "</a>";

      echo "<div id=\"collapse2\" class=\"panel-collapse collapse in\">";
      echo "<div class=\"panel-body\">";
      //rows go here
      echo "<table class='table table-hover'>";
      echo "<thead>";
      echo "<tr><th>Username</th><th>Name</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

      foreach ($MISLOs as $user){

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
        <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
        <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
        <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


        echo "<form style=\"float: right; \" action=\"removeMISLO.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removeMISLO\" value=\"Remove MISLO\"></form>";


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

    if(!empty($safeties)){

      echo "<div class='row'>";
      echo "<div class='col-md-1'>";
      echo "</div>";
      echo "<div class='col-md-10'>";
      echo "<div class=\"panel panel-default\">";

      echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse3\" style=\"color: #000000;\">";
      echo "<div class=\"panel-heading\">";
      echo "<h3 class=\"panel-title\">";
      echo "<strong>Safety Officer</strong>";
      echo "</h3>";
      echo "</div>";
      echo "</a>";

      echo "<div id=\"collapse3\" class=\"panel-collapse collapse in\">";
      echo "<div class=\"panel-body\">";
      //rows go here
      echo "<table class='table table-hover'>";
      echo "<thead>";
      echo "<tr><th>Username</th><th>Name</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

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
        echo "<td>{$user['level']}</td>";

        echo "<td>";


        echo "
        <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
        <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
        <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


        echo "<form style=\"float: right; \" action=\"removesafety.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"removesafety\" value=\"Remove Safety Officer\"></form>";



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


    if(!empty($users)){

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

      echo "<div id=\"collapse5\" class=\"panel-collapse collapse in\">";
      echo "<div class=\"panel-body\">";
      //rows go here
      echo "<table class='table table-hover'>";
      echo "<thead>";
      echo "<tr><th>Username</th><th>Name</th><th>Access</th><th>Level</th><th class=\"text-right\">Actions</th></tr></thead>";

      foreach ($users as $user){

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

        echo "<td>{$user['accesslevel']}</td>";

        echo "<td>{$user['level']}</td>";

        echo "<td>";
        if($user['accesslevel'] != "admin"){

          echo "<form style=\"float: right; \" action=\"deleteuser.script.php\" method=\"post\"><input type=\"hidden\" name=\"usertodelete\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-danger\" name=\"deleteuser\" value=\"Delete User\"></form>";

          echo "
          <form style=\"float: right;\" action=\"changepass.script.php\" method=\"post\">
          <input type=\"hidden\" name=\"nametochange\" id=\"nametochange\" value=\"{$user['username']}\">
          <input type=\"submit\"  class=\"btn btn-dark\" value=\"Reset Password\"></form>";


          echo "<form style=\"float: right; \" action=\"designateMISLO.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designateMISLO\" value=\"Designate MISLO\"></form>";

          echo "<form style=\"float: right; \" action=\"designatesafety.script.php\" method=\"post\"><input type=\"hidden\" name=\"username\" value=\"{$user['username']}\" /><input type=\"submit\"  class=\"btn btn-default\" name=\"designatesafety\" value=\"Designate Safety Officer\"></form>";

        }

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



  }

  echo "<div class=\"row\">";
  echo "<div class=\"col-sm-5\">";
  echo "</div>";

  echo "<div class=\"col-sm-2\">";
  if($_SESSION['accesslevel'] == "MISLO"){
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#blastModal\">Permanently Delete All Chits for your Company</button>";
  }

  echo "</div>";

  echo "<div class=\"col-sm-5\">";
  echo "</div>";

  echo "</div>";



  echo "</div>";



  echo "
  		<!-- Blast Chits Modal -->
  		<div id=\"blastModal\" class=\"modal fade\" role=\"dialog\">
  			<div class=\"modal-dialog\">

  				<!-- Modal content-->
  				<div class=\"modal-content\">
  					<div class=\"modal-header text-center\">
  						<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
  						<h4 class=\"modal-title\">Are you sure you want to delete all chits for your company?</h4>
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
                  <form action=\"blastcompany.script.php\" method=\"post\">
                  <input type=\"hidden\" name=\"delete\" value=\"blast\">
                  <input type=\"hidden\" name=\"company\" value=\"{$_SESSION['company']}\">
                  <input type=\"submit\" class=\"btn btn-danger\" value=\"Delete All Chits\">
                </form>
  							</div>
  						</div>


  					</div>
  				</div>

  			</div>
  		</div>";


?>

</div>


</body>

</html>
