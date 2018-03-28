<?php

  // This library returns authentication information if the user
  // is using a development server. Be careful using these features.

  // To disable, simply make no reference to this library
  // in your configuration file.

  if (isset($_REQUEST['login']) && $_REQUEST['login'] != '1') {
    $query = "SELECT user, session, fullname, department, first, last
                FROM auth_user
               WHERE USER=?";
    $stmt = build_query($db, $query, array($_REQUEST['login']));
    $stmt->store_result();
    $USER_CREDENTIALS = array(
          'user'          => 'dev',
          'fullname'      => 'dev',
          'first'         => 'dev',
          'last'          => 'dev',
          'department'    => 'dev',
          'time'          => 0
    );
    if ($stmt->num_rows > 0) {
      $USER_CREDENTIALS = array_2d_to_1d(stmt_to_assoc_array($stmt));
    }
    $stmt->close();
    $USER_CREDENTIALS['user'] = $_REQUEST['login'];
  } else {
    ?>
      <form method=POST>
        <input type="hidden" name="become" value="1">
        Username: <input type="text" name="login">
        <input type="submit" value="login">
      </form>
    <?php
    die;
  }

?>
