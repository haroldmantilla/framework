<?php
$MODULE_DEF = array('name' => 'Upload',
'version'    => 1.0,
'display'    => '',
'tab'        => 'tools',
'position'   => 2,
'student'    => true,
'instructor' => true,
'guest'      => false,
'access'     => array('admin'=>'db'));


# Load in Configuration Parameters
require_once("../etc/config.inc.php");

# Load in template, if not already loaded
require_once(LIBRARY_PATH.'template.php');

if (isset($_FILES['myfiles']) && !empty($_FILES['myfiles'])) {
	foreach ($_FILES['myfiles']['name'] as $key => $value) {
		if($_FILES['myfiles']['type'][$key] == "text/csv"){
			echo "<h4>$value</h4>";
			$data = read_csv($_FILES['myfiles']['tmp_name'][$key]);
			assoc_array_to_table($data, "results", true);
			echo "<br>";
		}
	}
	die;
}


# Load in The NavBar
require_once(WEB_PATH.'navbar.php');
?>
<style type="text/css">
[hidden] {
  display: none !important;
}
.progress
{
  position:relative;
  width:100%;
  border: 1px solid #ddd;
  padding: 1px;
  border-radius: 3px;
}
.bar
{
  background-color: #B4F5B4;
  width:0%;
  height:20px;
  border-radius: 3px;
}
.percent
{
  position:absolute;
  display:inline-block;
  top:3px;
  left:48%;
}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-2">
			<b>Please Select File(s)</b>
		</div>
		<div class="col-md-10">
			<form id="myform" method="post" enctype="multipart/form-data">
				<!-- <input type="file" id="myfiles" name="myfiles[]" multiple> -->
				<div class="input-group">
                   <label class="input-group-btn">
                       <span class="btn btn-primary">
                           Browse&hellip; <input type="file" id="myfiles" name="myfiles[]" style="display: none;" multiple>
                       </span>
                   </label>
                   <input type="text" class="form-control" readonly>
               </div>
			   <div class='progress' id="progress_div">
				   <div class='bar' id='bar'></div>
				   <div class='percent' id='percent'>0%</div>
			   </div>

				<input class="btn btn-default" style="float: right;" type="submit" value="Upload Files">
			</form>

		</div>
	</div>

	<div id="output"></div>

</div>

<script type="text/javascript">
$("#myform").submit(function(e){
	var formData = new FormData($(this)[0]);

	var bar = $('#bar');
	var percent = $('#percent');

	$.ajax({
		type: 'POST',
		data: formData,
		async: false,
		cache: false,
		contentType: false,
		enctype: 'multipart/form-data',
		processData: false,
		success: function (response) {
			$("#output").html(response);
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					//Do something with upload progress here
					// $("#progress").removeAttr("display");
					$("#percent").html(percentComplete);
					$("#bar").attr("width", percentComplete);
				}
			}, false);

			xhr.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					//Do something with download progress
				}
			}, false);

			return xhr;
		},
	});
	e.preventDefault();
});


$(function() {

	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	// We can watch for our custom `fileselect` event like this
	$(document).ready( function() {
		$(':file').on('fileselect', function(event, numFiles, label) {

			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
	});

});

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
