<?php

  ///////////////////////////////////////////////////////////////////////////
  // Load in all  libraries for use within your project...

  // Load Configuration
  require_once('../etc/config.inc.php');

  // Load MySQL  (must provide $db object)
  require_once('lib_mysql.php');

  // Perform Client Authentication
  require_once("lib_auth.php");

  // Activate extensive (and viewable via the web) debugging support
  // Only if ADMIN and requested
  if (ADMIN) {
    if (isset($_REQUEST['debug'])) {
      if ($_REQUEST['debug'] == 'on') {
        $_SESSION['debug'] = true;
      } else {
        unset($_SESSION['debug']);
      }
    }
    if (isset($_SESSION['debug']) && $_SESSION['debug'] == true) {
      // Activate Verbose Error Reporting...
      require_once('lib_error.php');
    }
  }

  // Load in UUID Library
  require_once('lib_uuid.php');

  // Load in API Library
  require_once('lib_api.php');

  // Load in Semester Library
  require_once('lib_semester.php');

  // Load in CSV Library
  require_once('lib_csv.php');

  // Load in the Sessions Module
  require_once('lib_session.php');

  // Load in Modules Library
  require_once('lib_modules.php');

  // Plus whatever other libraries you may need.

?>
