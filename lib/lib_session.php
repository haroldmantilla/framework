<?php

  ////////////////////////////////////////////////////////////////////////////
  // Save Session information to database
  function session_save($db, $user) {
    $query = "UPDATE auth_user SET session=? WHERE user=?";
    $session_data = session_encode();
    $stmt = build_query_quiet($db, $query, array($user, $session_data));
    $stmt->close();
  }

  ////////////////////////////////////////////////////////////////////////////
  // Restore Session information from database
  function session_load($db, $user) {
    $query = "SELECT session FROM auth_user WHERE user=?";
    $stmt = build_query($db, $query, array($user));
    $stmt->bind_result($session_data);
    while($stmt->fetch()) {
      session_decode($session_data);
    }
    $stmt->close();
  }

?>
