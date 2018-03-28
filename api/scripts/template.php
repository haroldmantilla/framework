<?php

  echo "API Template - Test Script".PHP_EOL;

  echo "<pre>";
  echo "API Method:    {$_SERVER['REQUEST_METHOD']}".PHP_EOL;
  echo "API FUNC:      $API_FUNC ".PHP_EOL;
  echo "API KEY:       $API_KEY ".PHP_EOL;
  echo "API DB ROLE:   $API_ROLE".PHP_EOL;
  echo "is Student?    ".STUDENT.PHP_EOL;
  echo "is Instructor? ".INSTRUCTOR.PHP_EOL;
  echo "is Admin?      ".ADMIN.PHP_EOL;
  echo "User Type?     ".TYPE.PHP_EOL;
  echo "API PATH: ";
  print_r($API_PATH);
  echo "API AUTH: ";
  print_r($API_AUTH);
  echo "WEB GET DATA: ";
  print_r($_GET);
  echo "WEB POST DATA = ";
  print_r($_POST);
  echo "USER DATA = ";
  print_r(USER);
  echo "</pre>";

?>
