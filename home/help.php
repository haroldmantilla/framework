<?php


  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Help',
                      'version'    => 1.0,
                      'display'    => 'help',
                      'tab'        => 'user',
                      'position'   => 4,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => true,
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

<div class = "container">
<div class = "row">
<div class = "col-md-2">

</div>
<div class = "col-md-8">
Website Administrator is Harold Mantilla. If you run into any issues please contact me at:
<br>
m194020@usna.edu
</div>
<div class = "col-md-2">

</div>

</div>
</div>
