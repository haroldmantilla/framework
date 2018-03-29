<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Test',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'debug',
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

  require_once(WEB_PATH.'navbar.php');

  echo "<pre>";
  print_r(USER);
  echo "</pre>";

?>
