<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Test',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => '',
                      'position'   => 0,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  # The only change was that 'guest' => false now, so you must log on...

  echo "<pre>";
  print_r(USER);
  echo "</pre>";

?>
