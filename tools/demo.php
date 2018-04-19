<?php

$MODULE_DEF = array('name' => 'Revealable',
'version'    => 1.0,
'display'    => '',
'tab'        => 'tools',
'position'   => 3,
'student'    => true,
'instructor' => true,
'guest'      => false,
'access'     => array('admin'=>'db'));


# Load in Configuration Parameters
require_once("../etc/config.inc.php");

# Load in template, if not already loaded
require_once(LIBRARY_PATH.'template.php');

# Load in The NavBar
require_once(WEB_PATH.'navbar.php');


?>

<style type="text/css">
.glyphicon-arrow-up, .glyphicon-arrow-down {
  font-size: 30px;
}

.blue {
    color: #2E3A65;
}

.gold {
    color: #FED01A;
}
</style>

<div class="container">
  <h3 class="text-center">Revealable Content</h3>
  <div style="width:50%; display:flex; justify-content:space-between; align-items:baseline;" class="text-center">
    <h5 id="label">Click to show --></h5><span class="glyphicon glyphicon-arrow-down blue" id="clickme"></span>
  </div>
  <div class="revealable text-center">
    <img src="<?php echo WEB_PATH; ?>images/usna.jpg">
  </div>
    
  </div>
<script type="text/javascript">
$(document).ready(function(){
  $(".revealable").hide();
});

$("#clickme").click(function() {
  $(".revealable").slideToggle( 500 );
  

  if ( $("#clickme").hasClass("glyphicon-arrow-up") ) {
    $("#clickme").attr("class", "glyphicon glyphicon-arrow-down blue");
    
    $("#label").html("Click to show -->");
  }
  else {
    $("#clickme").attr("class", "glyphicon glyphicon-arrow-up gold");
    
    $("#label").html("Click to hide -->");
  }
});

</script>

</body>
</html>
