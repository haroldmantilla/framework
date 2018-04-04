<?php
$MODULE_DEF = array('name'       => 'Query',
'version'    => 1.0,
'display'    => '',
'tab'        => 'tools',
'position'   => 0,
'student'    => true,
'instructor' => true,
'guest'      => false,
'access'     => array('admin'=>'db', 'admin'=>'developer'));


	# Load in Configuration Parameters
	require_once("../etc/config.inc.php");

	# Load in template, if not already loaded
	require_once(LIBRARY_PATH.'template.php');


	if (isset($_REQUEST['query']) && !empty($_REQUEST['query'])) {
		$results = query($db, $_REQUEST['query']);

	 ?>

	 <table class="table table-bordered" id="results">
		 <?php
		 foreach ($results as $key => $row) {
			 if($key == 0){
				 echo "<thead>";
				 echo "<tr>";
				 foreach ($row as $key2 => $row2) {
					 echo "<th>" . $key2 . "</th>";
				 }
				 echo "</tr>";
				 echo "</thead>";
				 echo "<tbody>";
			 }
			 echo "<tr>";
			 foreach ($row as $key2 => $row2) {
				 echo "<td>" . $row2 . "</td>";
			 }
			 echo "</tr>";
		 }

		 ?>
	 </tbody>
	</table>
	<?php
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
		 <button type="submit" class="btn btn-primary" onclick="return do_query();">RUN QUERY</button>
	 </div>
	 </form>

 </div>
 <div class="row">
	 <div class="col-sm-12" id="out">

	 </div>
 </div>

 <script type="text/javascript">
 function do_query(){
	  $.ajax({
 		 url: "query.php",
 		 data: $("#form").serialize(),
 		 success: function(result) {
 			 $("#out").html(result);
 			 // console.log(result);
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

</script>


</body>
</html>
