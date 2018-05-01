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

function init()
{
    canvas = document.getElementById("myCanvas");
    canvas.width = document.body.clientWidth; //document.width is obsolete
    canvas.height = document.body.clientHeight; //document.height is obsolete
    canvasW = canvas.width;
    canvasH = canvas.height;
}


$(document).ready(function(){

	init();

	myCanvas.drawPolygon({
		draggable: true,
		fillStyle: '#000',
		x: document.body.clientWidth / 2, y: document.body.clientHeight / 3,
		radius: 20, sides: 3
	});

});
</script>



</body>
</html>
