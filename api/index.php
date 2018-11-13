<?php

  # This script relies on .htaccess settings
  #RewriteEngine On
  #RewriteCond %{REQUEST_FILENAME} !-f
  #RewriteCond %{REQUEST_FILENAME} !-d
  #RewriteRule ^(.*)$ /~user/api/api.php?path=$1 [QSA,L]

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in Template information
  require_once(LIBRARY_PATH.'lib_mysql.php');

  # Load in API Authentication Libraries
  require_once(LIBRARY_PATH.'lib_api.php');

  // Verify that the connection was successful to the database
  if (mysqli_connect_errno()) {
    echo "API DB ERROR: ". mysqli_connect_errno() . ": " . mysqli_connect_error();
    die;
  }

  // If no information was provided by the .htaccess redirect then fail
  // immediately before any new work is done!
  if (!isset($_GET['path'])) {
    echo "API Format: api/&lt;apikey&gt;/mode/options/../";
    die;
  }

  // Retrieve the API key
  $API_KEY = explode("/", $_GET['path'])[0];

  // Are we going to use the session for api authentication?
  if (strtoupper($API_KEY) == 'SESSION') {
    if (!isset($_SESSION)) {
      session_start();
    }
    if (!defined('AUTH_SESSION_ID')) {
      define('AUTH_SESSION_ID', session_id());
    }
    $query = "SELECT apikey
                FROM auth_user
                     LEFT JOIN auth_session USING(user)
                     LEFT JOIN auth_api USING(user)
               WHERE (NOW() < (DATE_ADD(lastvisit, INTERVAL ".AUTH_MAX_TIME_IDLE_SESSION.")))
                 AND (NOW() < (DATE_ADD(lastlogin, INTERVAL ".AUTH_MAX_TIME_SINCE_LAST_LOGIN.")))
                 AND auth_session.id=?";
    $stmt = build_query($db, $query, array(AUTH_SESSION_ID));
    $stmt->bind_result($API_KEY);
    while ($stmt->fetch()) {}
    $stmt->close();
  }

  // API key validation
  // Results like: Array ([user] => 'username', [expires] => '2099-01-01', [access] => '')
  $API_AUTH = authenticate_api($db, $API_KEY);
  if (empty($API_AUTH)) {
    echo "API Authentication ERROR: Invalid API Key";
    die;
  } else {
    $user = $API_AUTH['user'];
  }

  // Create USER, STUDENT, INSRUCTOR, and ADMIN constants
  retrieve_user_information($db, $user);

  // Determine What Functional Module to Run
  $API_FUNC = explode("/", $_GET['path'])[1];
  $API_FUNC = str_replace('/','',stripslashes($API_FUNC));  // Remove slashes for security!
  $API_FUNC = 'scripts/'. $API_FUNC;

  // Determine the rest of the path for the api call
  $API_PATH = array_slice(explode("/", $_GET['path']),2);

  // Check to see if the FUNC file exists
  if (!file_exists($API_FUNC.'.php') || $API_FUNC == 'api') {
    echo "API ERROR: Invalid Path";
    die;
  }

  // retrieve specific database level information (if available)
  $API_ROLE = retrieve_api_db_level($db, $user);

  // Lower the db access level if possible, otherwise change to
  // the level specified in auth_access[user][dblevel]
  if (defined('ADMIN') && ADMIN && isset(DATABASE_MYSQL['admin'])) {
    $API_ROLE = 'admin';
    $db_info = DATABASE_MYSQL[$API_ROLE];
    $db = connect_db($db_info['host'], $db_info['user'], $db_info['password'], $db_info['name']);
  } elseif ((!defined('ADMIN') || !ADMIN) && $API_ROLE == '' && isset(DATABASE_MYSQL['low'])) {
    $API_ROLE = 'low';
    $db_info = DATABASE_MYSQL[$API_ROLE];
    $db = connect_db($db_info['host'], $db_info['user'], $db_info['password'], $db_info['name']);
  } elseif ($API_ROLE != '' && isset(DATABASE_MYSQL[$API_ROLE])) {
    $db_info = DATABASE_MYSQL[$API_ROLE];
    $db = connect_db($db_info['host'], $db_info['user'], $db_info['password'], $db_info['name']);
  } else {
    $API_ROLE = 'default';
  }

  // Throw an error if we can't connect...
  if (mysqli_connect_errno()) {
    echo "API DB ERROR (Lowering): ". mysqli_connect_errno() . ": " . mysqli_connect_error();
    die;
  }

  // load in the correct FUNCtional module
  $API_FUNC = $API_FUNC . '.php';
  require_once $API_FUNC;

?>
