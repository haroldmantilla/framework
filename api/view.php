<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'View / Reset API Key',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'user',
                      'position'   => 10.0,
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

?>
<div class="container">
 <div class="row">
<?php

  # Generate or Retrieve API key
  if (isset($_REQUEST['reset'])) {
    generate_apikey($db, USER['user']);
  }
  $api_data = retrieve_apikey($db, USER['user']);
  if (count($api_data) < 1) {
    generate_apikey($db, USER['user']);
    $api_data = retrieve_apikey($db, USER['user']);
  }
  if (count($api_data) < 1) {
    echo '<h4>API Key generation failed, please contact your administrator</h4>';
    die;
  }

  echo '<h4>Below is your <em>personal</em> API key that can be used throughout this system</h4>';
  echo "<pre><code class=text>";
  echo $api_data['apikey'];
  echo "</code></pre>";
?>

  <b>Do not share your api key</b>,
  for information on how to use the API please review the <a href="../api/docs.php">documentation</a>.
  Changing your API key can not be undone, all scripts that utilize your key will have to be updated.

  <br><br>
  <form method=POST>
    <input type=hidden name=reset value=yes>
    <button type="submit" class="btn btn-warning">Reset API key</button>
  </form>
 </div>
</div>

<?php

   if (isset($_SESSION['debug'])) {
     echo '<div class="container"><div class="jumbotron">';
     echo '<h3>Debugging Information</h3>';
     echo "<pre><code class=text>"; print_r($api_data); echo "</code></pre>";
   }

?>
