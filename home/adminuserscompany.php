<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Manage Users',
                      'version'    => 1.0,
                      'display'    => 'MISLO',
                      'tab'        => 'admin',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('admin'=>'MISLO'));
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


$company = get_company_number($db, USER['user']);

?>

<form action='./adminuserscompany.php' method='POST'>
  <div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-6">

    </div>
    <div class="col-md-4">
      <div class="input-group">
        <input type='text' class='form-control' name='FILTER' placeholder='Search...'>
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

$completemids = get_company($db, $company);


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

    echo "<div id=\"collapse5\" class=\"panel-collapse collapse in "; if(isset($_SESSION['MIDN'])){ echo "in ";} echo "\">";
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



?>

</div>


</body>

</html>
