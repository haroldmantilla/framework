<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Show Variables',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'tools',
                      'position'   => 6,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('admin'=>'developer'));
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  require_once(WEB_PATH.'navbar.php');

  echo "<pre>";
  echo "USER:";
  print_r(USER);
  echo "</pre>";

  echo "<pre>";
  echo "\$_REQUEST:";
  print_r($_REQUEST);
  echo "</pre>";

  $query = "show tables;";
  $data = query($db, $query);
  echo "<pre>";
  echo "CUSTOM: ";
  print_r($data);
  echo "</pre>";

?>
