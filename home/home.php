<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Default Home Page',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'user',
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
      <!-- <div class='jumbotron'> -->
        <h4 class="text-center">Welcome to eChits!</h4>
        
        <?php
        if (USER['user'] == 'guest' || USER['user'] == 'no-one' || USER['user'] == '') {
          echo "<br><br>";
          echo "Please use the menus above to logon to the system.";
        } 

        ?>
      </div>
    <!-- </div> -->
    <div class="col-md-2">
      <br>
      <center><img src="<?php echo WEB_PATH; ?>images/navycrest.png" width=140></center>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
    </div>
    <div class="col-md-2">
    </div>
  </div>
  


</div>
</body>
</html>
