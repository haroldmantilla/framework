<?php

  // Academy Logon Library for PHP.
  // Updates to this library may be available on
  // github at https://github.com/jskenney/academy-credentials

  // Please define the following variables within the script that calls this library:

  // define('AUTH_SERVER',     'https://www.usna.edu/xxxxxxx/server/');
  // define('AUTH_MESSAGE',    'Please log into the Authentication Server');
  // define('AUTH_TITLE',      'Example Title');
  // define('AUTH_TOKEN_TIME', 100);
  // define('AUTH_IDENTIFIER', '91f3cdf0-cfca-40e9-85b3-47f0596f9855');
  // define('AUTH_SECRET',     '00e91c2b-4ffb-4a03-b36b-1928d8ade526');

  // Redirect to the authentication server,
  function login_redirect($LOGIN_ADDRESS,
                          $LOGIN_MESSAGE='Please Log On',
                          $LOGIN_TITLE='Academy Log On',
                          $TOKEN_IDENTIFIER='default') {

      // Determine what page we started from
      $LOGIN_URI = $_SERVER['REQUEST_URI'];
      $LOGIN_URI = explode("?", $LOGIN_URI);
      $LOGIN_URI = $LOGIN_URI[0];

      // Build the Redirect
      $location = "Location: $LOGIN_ADDRESS" .
                  "?identifier=" . urlencode($TOKEN_IDENTIFIER) .
                  "&source="     . urlencode($LOGIN_URI) .
                  "&server="     . urlencode($_SERVER['SERVER_NAME']) .
                  "&display="    . urlencode($LOGIN_MESSAGE) .
                  "&title="      . urlencode($LOGIN_TITLE);

      // Add the query string if available
      if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
          if (strpos(urlencode($_SERVER['QUERY_STRING']), 'token=') === FALSE) {
            $location .= "&qstring=" . urlencode($_SERVER['QUERY_STRING']);
          }
      }

      // Did we come from a https capable web site?
      if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
          $location .= "&https=on";
      }

      // Redirect to the login page!
      header($location);
      die;
  }

  // Validate returned login token
  // Process returned fields from the server
  function login_validate($TOKEN_SECRET, $TOKEN_VALID_FOR=100) {
      if (isset($_REQUEST['token'])
       && isset($_REQUEST['user'])
       && isset($_REQUEST['date'])) {

          // Build Expected Tokens and Calculate Time Delta
          $correct_token = sha1($_REQUEST['user'] . $TOKEN_SECRET . $_REQUEST['date']);
          $timediff = abs(intval($_REQUEST['date'])-time());

          // Validate Token
          if ($correct_token == $_REQUEST['token'] && $timediff < $TOKEN_VALID_FOR) {

              /////////////////////////////////////////////////////////////
              // Retrieve submitted username and password combination (from web form)
              $user            = $_REQUEST['user'];
              $user_fullname   = urldecode($_REQUEST['fullname']);
              $user_firstname  = urldecode($_REQUEST['first']);
              $user_lastname   = urldecode($_REQUEST['last']);
              $user_department = urldecode($_REQUEST['dept']);

              /////////////////////////////////////////////////////////////
              // Return the results
              return array('user'          => $user,
                           'fullname'      => $user_fullname,
                           'first'         => $user_firstname,
                           'last'          => $user_lastname,
                           'department'    => $user_department,
                           'time'          => intval($_REQUEST['date']));
          }
      }
      return array();
  }

  /////////////////////////////////////////////////////////////////////////
  // Has this library been minimally configured
  if (!defined('AUTH_SECRET')
       || !defined('AUTH_SERVER')
       || !defined('AUTH_IDENTIFIER')
       || !defined('AUTH_TOKEN_TIME')
       || !defined('AUTH_MESSAGE')
       || !defined('AUTH_TITLE')
     ) {
    echo "Authentication variables have not been defined, contact the administrator.";
    die;
  }

  /////////////////////////////////////////////////////////////////////////
  // Has data been received from the server side authenticator?
  $USER_CREDENTIALS = array();
  if (isset($_REQUEST['token']) && isset($_REQUEST['user']) && isset($_REQUEST['date'])) {
      $USER_CREDENTIALS = login_validate(AUTH_SECRET, AUTH_TOKEN_TIME);
  }

  // Should we redirect to the server for authentication?
  if (empty($USER_CREDENTIALS)) {
      login_redirect(AUTH_SERVER, AUTH_MESSAGE, AUTH_TITLE, AUTH_IDENTIFIER);
      die;
  }
?>
