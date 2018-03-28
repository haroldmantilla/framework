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

  #############################################################################
  # Load in the appropriate CSS and Navbar Display libraries.
  #############################################################################
  require_once('css.php');
  require_once('navbar_builder.php');

?>
