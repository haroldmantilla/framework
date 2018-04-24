<?php

$MODULE_DEF = array('name' => 'Triangle',
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
<script src="<?php echo WEB_PATH; ?>jcanvas.min.js"></script>

<center>
	<canvas id="myCanvas" width="640" height="480">
		<p>Apparently your browser doesn't support this... oh well, go upgrade...</p>
	</canvas>
</center>

<script type="text/javascript">
var myCanvas = $('#myCanvas');



$(document).ready(function(){
	myCanvas.drawRect({
		fillStyle: 'white',
		strokeStyle: 'red',
		strokeWidth: 4,
		x: 0, y: 0,
		fromCenter: false,
		width: 640,
		height: 480
	});

	myCanvas.drawLine({
		strokeStyle: '#000',
		strokeWidth: 1,
		x1: 100, y1: 100,
		x2: 200, y2: 100,
		x3: 150, y3: 150,
		x4: 100, y4: 100
	});

	myCanvas.drawLine({
		strokeStyle: '#000',
		strokeWidth: 5,
		x1: 500, y1: 100,
		x2: 600, y2: 100,
		x3: 550, y3: 150,
		x4: 500, y4: 100
	});


});
</script>



</body>
</html>
