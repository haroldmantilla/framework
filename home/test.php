<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Show Variables',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'tools',
                      'position'   => 6,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array('admin'=>'admin'));
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  require_once(WEB_PATH.'navbar.php');

$to = "m194020@usna.edu";
$subject = "A chit is ready for your approval!";
$txt = "Log in at midn.cs.usna.edu/project-echits to review the chit.
I am the better CS/IT major and platoon sam can eat my dust";
$headers = "From: eChits@noreply.edu" . "\r\n" .
"CC: m194020@usna.edu";

sendemail($to,$subject,$txt,$headers);

  echo "<pre>";
  echo "USER:";
  print_r(USER);
  echo "</pre>";

  echo "<pre>";
  echo "\$_SESSION:";
  print_r($_SESSION);
  echo "</pre>";


  echo "<pre>";
  echo "\$_REQUEST:";
  print_r($_REQUEST);
  echo "</pre>";

  $query = "show tables;";
  $data = query($db, $query);
  echo "<pre>";
  echo "CUSTOM: ";
  print_r($data);
  echo "</pre>";

  $results = coc_complete($db, "m194020");
  echo "$results";

  $to = "m193978@usna.edu";
$subject = "A chit is ready for your approval!";
$txt = "Log in at midn.cs.usna.edu/project-echits to review the chit.
I am the better CS/IT major and platoon sam can eat my dust";
$headers = "From: eChits@noreply.edu" . "\r\n" .
"CC: m194020@usna.edu";

sendmail($to,$subject,$txt,$headers);

?>
