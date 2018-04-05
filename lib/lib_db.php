<?php

function query($db, $query) {
  $stmt = build_query($db, $query, array());

  $stmt->bind_result($results);
  
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
  
}

 ?>
