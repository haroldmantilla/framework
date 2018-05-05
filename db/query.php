<?php
$MODULE_DEF = array('name'       => 'Query',
'version'    => 1.0,
'display'    => '',
'tab'        => 'tools',
'position'   => 0,
'student'    => true,
'instructor' => true,
'guest'      => false,
'access'     => array('admin'=>'db'));


	# Load in Configuration Parameters
	require_once("../etc/config.inc.php");

	# Load in template, if not already loaded
	require_once(LIBRARY_PATH.'template.php');


	if (isset($_REQUEST['query']) && !empty($_REQUEST['query'])) {
			$results = query($db, $_REQUEST['query']);
			assoc_array_to_table($results, "results", true);
			die;
		}



# Load in The NavBar
require_once(WEB_PATH.'navbar.php');
?>


<div class="container">
	<div class="row">
		<div class="col-sm-10">
			<form method="post" action="?" id="form">
				<div class="input-group">
					<textarea class="form-control" rows="5" cols="200" style="width: 100%; resize:vertical;" name="query" id="query"><?php if(isset($_REQUEST['query'])){echo $_REQUEST['query'];} ?></textarea>
				</div>
			</div>

			<div class="col-sm-2">
				<button type="submit" class="btn btn-primary" id="submit" onclick="return do_query();">RUN QUERY</button>
			</div>
		</form>

	</div>
	<div class="row">
		<div class="col-sm-12" id="success">

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" id="error">

		</div>
	</div>

	<script type="text/javascript">
	function do_query(){
		$.ajax({
			url: "query.php",
			data: $("#form").serialize(),
			success: function(result) {

				$("#error").html("");
				$("#success").html(result);
				// console.log(result);
			},
			error: function(result) {
				$("#success").html("");
				$("#error").html(result.responseText);
			}

		} );

		return false;
	}
	</script>

	<script type="text/javascript">
	$( document ).ajaxComplete(function() {

		$('#results').DataTable( {
			"lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
			"pageLength": 10,
			"dom": 'Bfrtip',
			"buttons": [
				'pageLength', 'csv', 'excel'
			]
		} );
	});


	$(function () {
    $("#query").keypress(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        // alert(code);
        if (code == 13) {
            $("#submit").trigger('click');
            return false;
        }
    });
	});


</script>


</body>
</html>
