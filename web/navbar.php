<?php

  #############################################################################
  # Load in template, if not already loaded
  #############################################################################
  if (defined('LIBRARY_PATH')) {
    require_once(LIBRARY_PATH.'template.php');
  } else {
    require_once('../lib/template.php');
  }

  #############################################################################
  # Set Default Page Title / Information
  #############################################################################
  if (!isset($PAGE_TITLE)) {
    $PAGE_TITLE = 'USNA';
    if (defined('PAGE_TITLE')) {
      $PAGE_TITLE = PAGE_TITLE;
    }
  }
  if (!isset($NAVBAR_TITLE)) {
    $NAVBAR_TITLE = '';
    if (defined('NAVBAR_TITLE')) {
      $NAVBAR_TITLE = NAVBAR_TITLE;
    }
  }
  if (!isset($NAVBAR_TITLE_URL)) {
    $NAVBAR_TITLE_URL = '#';
    if (defined('NAVBAR_TITLE_URL')) {
      $NAVBAR_TITLE_URL = NAVBAR_TITLE_URL;
    }
  }

  #############################################################################
  # Build the NavBar (NavBar version 3 format)
  #############################################################################
  $NAVBAR = array();

  #############################################################################
  # Build the user menu options (Do they need to login - always first option)
  #############################################################################
  $USER_OPTIONS = array();
  $user = USER['user'];
  if (!isset(USER['user']) || USER['user'] == 'guest' || USER['user'] == 'no-one' || USER['user'] == '') {
    $user = '';
    $USER_OPTIONS[] = array('url'=>'?login=1', 'type'=>'url', 'title'=>'', 'text'=>'Log On');
  }

  #############################################################################
  # Modules based Menu Options (USER SECTION)
  #############################################################################
  if (defined('NAVBAR_MODULES') && isset(NAVBAR_MODULES['user'])) {
    foreach(NAVBAR_MODULES['user'] as $pos => $rows) {
      foreach ($rows as $irow => $row) {
        $USER_OPTIONS[] = array('url'=>$row['file'], 'type'=>'url', 'title'=>$row['display'], 'text'=>$row['name']);
      }
    }
  }


  #############################################################################
  # Show user debugging and logoff options - always last options
  #############################################################################
  if (!(!isset(USER['user']) || USER['user'] == 'guest' || USER['user'] == 'no-one' || USER['user'] == '')) {
    # Debugging Options
    if (ADMIN) {
      $USER_OPTIONS[] = array('type'=>'seperator');
      if (isset($_SESSION['debug'])) {
        $USER_OPTIONS[] = array('url'=>'?debug=off', 'type'=>'url', 'title'=>'', 'text'=>'<font color=#D1551F>Turn Debugging Off</font>');
      } else {
        $USER_OPTIONS[] = array('url'=>'?debug=on', 'type'=>'url', 'title'=>'', 'text'=>'Turn Debugging On');
      }
      $USER_OPTIONS[] = array('type'=>'seperator');
    }
    $USER_OPTIONS[] = array('url'=>'?logoff=1', 'type'=>'url', 'title'=>'', 'text'=>'Log Off');
  }
  $NAVBAR[] = array('type'=>'dropdown', 'title'=>'User Tools', 'icon'=>'glyphicon-user', 'rtext'=>" $user", 'options'=>$USER_OPTIONS, 'caret'=>true);



  #############################################################################
  # Modules based Menu Options (other sections)
  #############################################################################
  if (defined('MODULE_NAV') && defined('NAVBAR_MODULES')) {
    foreach(MODULE_NAV as $heading => $config) {
      if ($heading == 'seperator') {
        $NAVBAR[] = array('type'=>'seperator');
      } elseif ($heading != 'user' && isset(NAVBAR_MODULES[$heading])) {
        if (isset(NAVBAR_MODULES[$heading])) {
          $options = array();
          foreach(NAVBAR_MODULES[$heading] as $pos => $rows) {
            foreach ($rows as $irow => $row) {
              $options[] = array('url'=>$row['file'], 'type'=>'url', 'title'=>$row['display'], 'text'=>$row['name']);
            }
          }
          $config['options'] = $options;
          $NAVBAR[] = $config;
        }
      }
    }
  }

  #############################################################################
  # Manual NavBar functions
  #############################################################################

  # query db to see if they are in leader
  $query = "select * from Leader where username='";
  $query .= USER['user'];
  $query .="'";
  $results = query($db, $query, true);

  # if not in Leader, redirect to register.php
  if(empty($results) && basename($_SERVER['PHP_SELF']) != "register.php"){
    $url = "Location: register.php";
	  header($url);
    exit;
  }

  if(!empty($results) && basename($_SERVER['PHP_SELF']) == "register.php"){
    $url = "Location: home.php";
	  header($url);
    exit;
  }

  if(is_midshipman($db, USER['user']) && !in_midshipman_table($db, USER['user']) && basename($_SERVER['PHP_SELF']) != "profile_nasp.php"){
    $_SESSION['error'] = "You must complete your profile to use eChits.";
    $url = "Location: profile_nasp.php";
	  header($url);
    exit;
  }

  if(in_midshipman_table($db, USER['user']) && !coc_complete($db, USER['user']) && basename($_SERVER['PHP_SELF']) != "profile_nasp.php"){
    $_SESSION['error'] = "You have not designated your Chain of Command yet! Click the 'Edit Midshipman Information' button to proceed.";
    $url = "Location: profile_nasp.php";
	  header($url);
    die;
  }

  if(in_midshipman_table($db, USER['user']) && coc_complete($db, USER['user'])){
    $NAVBAR[] = array('type'=>'url', 'title'=>'Make Chit', 'ltext'=>" Make Chit", 'url'=>'makechit.php');
  }

  $query = "SELECT * FROM  auth_access where user=? AND access = 'level' AND value = 'MID'";
  $stmt = build_query($db, $query, array(USER['user']));
  $results = stmt_to_assoc_array($stmt);
  $stmt->close();

  if(empty($results)){
    if(preg_match('/m[0-9][0-9][0-9][0-9][0-9][0-9]/', USER['user'])){
      $query = "INSERT INTO auth_access values (?, 'level', 'MID')";
      $stmt = build_query($db, $query, array(USER['user']));
      $stmt->close();
    }
  }




  // echo "<pre>";
  // print_r($results);
  // echo "</pre>";

  #############################################################################
  # Load in the appropriate CSS and Navbar Display libraries.
  #############################################################################
  require_once('css.php');
  require_once('navbar_builder.php');

?>
