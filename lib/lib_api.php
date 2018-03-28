<?php

  # Load in UUID functions
  require_once('lib_uuid.php');

  # Determine courses that a students is currently taking
  function authenticate_api($db, $apikey) {
    $query = "SELECT user, expires FROM auth_api WHERE apikey=? AND expires > NOW()";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('s', $apikey);
    $result = $stmt->execute();
    if (!$result || $db->affected_rows == 0) { echo '<h1>ERROR: '. $db->error . " for query *$query*</h1><hr>"; }
    $results = stmt_to_assoc_array($stmt);
    $stmt->close();
    $return_results = array();
    if (count($results) > 0) {
      foreach ($results as $row) {
        foreach ($row as $key => $value) {
          $return_results[$key] = $value;
        }
      }
    }
    return $return_results;
  }

  # Retrieve Users Info and Access Information
  function retrieve_user_information($db, $user) {
    $query = "SELECT user, session, fullname, department, first, last FROM auth_user WHERE user=?";
    $stmt = build_query($db, $query, array($user));
    $stmt->store_result();
    $USER_CREDENTIALS = array('user'          => 'guest',
                              'fullname'      => 'Guest',
                              'first'         => 'Guest',
                              'last'          => 'Guest',
                              'department'    => 'Guest',
                              'time'          => 0,
                              'privileges'    => array());
    if ($stmt->num_rows > 0) {
      $USER_CREDENTIALS = array_2d_to_1d(stmt_to_assoc_array($stmt));
    }
    $stmt->close();

    $query = "SELECT access, value FROM auth_access WHERE user=?";
    $stmt = build_query($db, $query, array($USER_CREDENTIALS['user']));
    $stmt->bind_result($returned_access, $returned_value);
    $USER_CREDENTIALS['privileges'] = array();
    while($stmt->fetch()) {
      $USER_CREDENTIALS['privileges'][$returned_access][] = $returned_value;
    }
    $stmt->close();

    /////////////////////////////////////////////////////////////
    // Determine Admin Status
    if (isset($USER_CREDENTIALS['privileges']['admin']['site'])) {
      define('ADMIN', True);
    } else {
      define('ADMIN', False);
    }

    /////////////////////////////////////////////////////////////
    // Are they an instructor/staff member?
    // Search for m123456 <- and do not promote to instructor
    if ($USER_CREDENTIALS['user'] == 'guest') {
      define('GUEST', True);
      define('STUDENT', False);
      define('INSTRUCTOR', False);
    } elseif (preg_match("/^M[0-9]{6}/", $USER_CREDENTIALS['user']) == 0
           && preg_match("/^m[0-9]{6}/", $USER_CREDENTIALS['user']) == 0) {
      define('GUEST', False);
      define('STUDENT', False);
      define('INSTRUCTOR', True);
    } else {
      define('GUEST', False);
      define('STUDENT', True);
      define('INSTRUCTOR', False);
    }

    /////////////////////////////////////////////////////////////
    // Are they an Officer? USMC? USN? USAF? USA? Midn? Civilian?
    // Set $user_type appropriately;
    foreach (array(' USMC '=>'MARINE OFFICER', ' USN ' =>'NAVY OFFICER',
                   ' USA ' =>'ARMY OFFICER',   ' USAF '=>'AIR FORCE OFFICER',
                   ' CIV ' =>'CIVILIAN',
                   ' Midn '=>'MIDN',           ' MIDN '=>'MIDN')
             as $search => $report) {
        if (strpos($USER_CREDENTIALS['fullname'], $search) !== false && !defined('TYPE')) {
          define('TYPE', $report);
        }
    }
    if (!defined('TYPE')) {
      define('TYPE', 'UNKNOWN');
    }

    /////////////////////////////////////////////////////////////
    // Provide back the USER constant to any calling pages.
    define('USER', $USER_CREDENTIALS);
  }

  # Determine if the user has a specific database access level
  function retrieve_api_db_level($db, $user) {
    $query = "SELECT value FROM auth_access WHERE user=? AND access='dblevel'";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('s', $user);
    $result = $stmt->execute();
    $value = '';
    $stmt->bind_result($value);
    while ($stmt->fetch()) { }
    $stmt->close();
    return $value;
  }

  # Retrieve api_key
  # Determine courses that a students is currently taking
  function retrieve_apikey($db, $user) {
    $query = "SELECT user, expires, apikey FROM auth_api WHERE user=? AND expires > NOW()";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('s', $user);
    $result = $stmt->execute();
    if (!$result || $db->affected_rows == 0) { echo '<h1>ERROR: '. $db->error . " for query *$query*</h1><hr>"; }
    $results = stmt_to_assoc_array($stmt);
    $stmt->close();
    $return_results = array();
    if (count($results) > 0) {
      foreach ($results as $row) {
        foreach ($row as $key => $value) {
          $return_results[$key] = $value;
        }
      }
    }
    return $return_results;
  }

  # Generate api_key
  function generate_apikey($db, $user) {
    if ($user != 'no-one') {
      $new_key = generate_uuid();
      $query = "INSERT INTO auth_api (user, apikey) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE apikey=?";
      $stmt = $db->stmt_init();
      $stmt->prepare($query);
      $stmt->bind_param('sss', $user, $new_key, $new_key);
      $result = $stmt->execute();
      $stmt->close();
    }
  }

?>
