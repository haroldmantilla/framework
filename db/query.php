<?php
$MODULE_DEF = array('name'       => 'Query',
					'version'    => 1.0,
					'display'    => '',
					'tab'        => 'Tools',
					'position'   => 0,
					'student'    => true,
					'instructor' => true,
					'guest'      => false,
					'access'     => array());


# Load in Configuration Parameters
require_once("../etc/config.inc.php");

# Load in template, if not already loaded
require_once(LIBRARY_PATH.'template.php');

# Load in The NavBar
require_once(WEB_PATH.'navbar.php');

?>
