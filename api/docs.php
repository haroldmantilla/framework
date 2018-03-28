<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'API Documentation',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'user',
                      'position'   => 11,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  # Load in Template information
  require_once(WEB_PATH.'navbar.php');

  # Generate or Retrieve API key
  $api_data = retrieve_apikey($db, $user);
  if (count($api_data) < 1) {
    generate_apikey($db, $user);
    $api_data = retrieve_apikey($db, $user);
  }

  if (isset($api_data['apikey'])) {
    $api_key = $api_data['apikey'];
  } else {
    $api_key = "your_api_key_here";
  }

  $path_parts = pathinfo($_SERVER['REQUEST_URI']);
  $path_server = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];

?>
<div class="container">
 <div class="row">

<h4>General API Format</h4>
<pre><code>api/&lt;api_key&gt;/function/option/option/..</code></pre>

<h4>Basic Notes</h4>
<ol>
  <li>All api functions require an authorized api key.</li>
  <li>Your api key has been automatically inserted in all of the following examples.</li>
  <li>Data responses are returned via JSON, non-data responses via text or via binary download.</li>
</ol>

<br><br><br><br>

</div>
</div>
