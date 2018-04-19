<?php

$MODULE_DEF = array('name' => 'Board',
'version'    => 1.0,
'display'    => '',
'tab'        => 'tools',
'position'   => 4,
'student'    => true,
'instructor' => true,
'guest'      => false,
'access'     => array('admin'=>'db'));


# Load in Configuration Parameters
require_once("../etc/config.inc.php");

# Load in template, if not already loaded
require_once(LIBRARY_PATH.'template.php');

if (isset($_REQUEST['myinfo'])) {
	$query = "INSERT INTO Board (username, post) VALUES (?, ?) ";
	$stmt = build_query($db, $query, array(USER['user'], $_REQUEST['myinfo']));
	$stmt->close();
	session_destroy();
	die;
}

if (isset($_REQUEST['retreive'])) {
	$results = query($db, "select * from Board;");
	print_r($results);
	die;
}

# Load in The NavBar
require_once(WEB_PATH.'navbar.php');


?>

<h5 class="text-center">Message Board</h5>
<p>
  <form id='myform'>
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon3">What's on your mind?</span>
      <input type="text" class="form-control" name="myinfo" aria-describedby="basic-addon3">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Post!</button>
      </span>
    </div>
  </form>
</p>

<p id="addhere"></p>

<script>
  $(document).ready(function(){
    $('#addhere').load('board.php', { retreive: "true" } );

    setInterval(
      function(){
        $('#addhere').load('board.php', { retreive: "true" } );
		// console.log("now");
      },
      10000);

    $('#myform').submit(function(e){
      $.ajax({
        url: "board.php",
        data: $("#myform").serialize(),
        success: function(result) {
          $("#addhere").html(result);
		  console.log(result);
        }
      });
      e.preventDefault();
  });

});

$(document).ajaxComplete(function(){
	$('#addhere').load('board.php', { retreive: "true" } );
});
</script>
