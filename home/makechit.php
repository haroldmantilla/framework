<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Make Chit',
                      'version'    => 1.0,
                      'display'    => 'Make Chit',
                      'tab'        => '',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('level'=>'MID'));
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  ?>
  <div class="container-fluid">

<?php
echo "<h4 class=\"text-center\">Chit creation removed due to eChits shutdown on 31OCT2018</h4>";
?>

</div>
