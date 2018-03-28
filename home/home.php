<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Default Home Page',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => '',
                      'position'   => 0,
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

<div class=container>
  <div class="row">
    <div class="col-md-2">
      <center><img src="<?php echo WEB_PATH; ?>images/usna.jpg" width=140></center>
    </div>
    <div class="col-md-8">
      <div class='jumbotron'>
        <h4>Welcome to the Default Template</h4>
        <font face='Arial' size=3>
          This template is available as a simple starting point for web
          based projects, providing database, API access, and web functionality.
        </font>
        <?php
        if (USER['user'] == 'guest' || USER['user'] == 'no-one' || USER['user'] == '') {
          echo "<br><br>";
          echo "Please use the menus above to logon to the system.";
        } elseif (STUDENT) {
          echo "<br><br>";
          echo "Welcome Student";
        } elseif (INSTRUCTOR) {
          echo "<br><br>";
          echo "Welcome Faculty";
        }
        if (ADMIN) {
          echo "<br><br>";
          echo "Welcome Administrator";
        }
        ?>
      </div>
    </div>
    <div class="col-md-2">
      <br>
      <center><img src="<?php echo WEB_PATH; ?>images/cs.jpg" width=140></center>
    </div>
  </div>
</div>
