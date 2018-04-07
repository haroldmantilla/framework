<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Statistics',
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

<div class="row">
  <div class="col-sm-2">
  </div>
  <div class="col-sm-4 text-center">
    <button class="btn btn-primary" onclick="location.href = './adminchits.php';">View Chits</button>
  </div>

  <div class="col-sm-4 text-center">
    <button class="btn btn-primary" onclick="location.href = './adminusers.php';">View Users</button>
  </div>
  <div class="col-sm-2">
  </div>
</div>

<?php

echo " <div class=\"row\">";
echo "<div class=\"col-md-2\">";
echo "</div>";
echo "<div class=\"col-md-8 text-center\">";

//get num Users
$num_users = get_num_users($db);

//get num mids
$num_mids = get_num_mids($db);

//get unique companies
$num_companies = get_num_companies($db);

//get num chits
$num_total_chits = get_num_total_chits($db);

//get num active chits
$num_active_chits = get_num_active_chits($db);

//get num battOs
$num_bigOs = get_num_bigOs($db);

//get num officers
$num_officers = get_num_officers($db);

//get num SELs
$num_SELs = get_num_SELs($db);
echo "<br>";
echo "<br>";
echo "<br>";


echo "<div class=\"panel-group\">";
echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Total Users:<p class=\"text-center\"> {$num_users}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Total Mids:<p class=\"text-center\"> {$num_mids}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Unique Companies:<p class=\"text-center\"> {$num_companies}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Total Number of Chits:<p class=\"text-center\"> {$num_total_chits}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Active Chits<p class=\"text-center\"> {$num_active_chits}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "O-5s & O-6s :<p class=\"text-center\"> {$num_bigOs}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "Officers:<p class=\"text-center\"> {$num_officers}</p><br>";
echo "</div>";
echo "</div>";


echo "<div class=\"panel panel-default\">";
echo "<div class=\"panel-body text-left\">";
echo "SELs:<p class=\"text-center\"> {$num_SELs}</p><br>";
echo "</div>";
echo "</div>";

echo "</div>";

echo "</div>";
echo "<div class=\"col-md-2\">";
echo "</div>";
echo "</div>";

 ?>

</div>


</body>

</html>
