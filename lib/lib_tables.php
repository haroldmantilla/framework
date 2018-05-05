<?php
function assoc_array_to_table($data, $id="", $headers=false){
	echo "<table class=\"table table-bordered\" ";
	if(!empty($id)){
		echo "id=\"$id\"";
	}
	echo ">";
	if (!$headers) {
		echo "<tbody>";
	}
	else{
		echo "<thead>";
		echo "<tr>";
		foreach ($data as $key => $row) {
			foreach ($row as $key2 => $row2) {
				echo "<th>" . $key2 . "</th>";
			}
			break;
		}
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$headers=false;
	}

	foreach ($data as $key => $row) {

		echo "<tr>";

		if(is_array($row)){
			foreach ($row as $key2 => $row2) {
				echo "<td>" . $row2 . "</td>";
			}
		}
		else{
			echo "<td>" . $row . "</td>";
		}
		echo "</tr>";
	}

	echo "</tbody></table>";
}


 ?>
