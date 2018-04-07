<?php



// Generic Query Function (works perfectly 100% of the time)
function query($db, $query) {
  $stmt = build_query($db, $query, array());

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;

}

 ?>
