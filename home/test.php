<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Show Variables',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'debug',
                      'position'   => 0,
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
  //
  // echo "<pre>";
  // print_r(USER);
  // echo "</pre>";


  $num_users = get_num_users($db); 
  echo "<pre>";

  print_r($num_users);
  // echo "$result";
  echo "</pre>";

?>
