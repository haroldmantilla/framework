<?php



/*
 * Utility function to automatically bind columns from selects in prepared statements to 
 * an array
 */
function bind_result_array($stmt)
{
    $meta = $stmt->result_metadata();
    $result = array();
    while ($field = $meta->fetch_field())
    {
        $result[$field->name] = NULL;
        $params[] = &$result[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $params);
    return $result;
}

/**
 * Returns a copy of an array of references
 */
function getCopy($row)
{
    return array_map(create_function('$a', 'return $a;'), $row);
}


// Generic Query Function (works perfectly 100% of the time)
function query($db, $query) {
  $stmt = build_query($db, $query, array());
  $row = bind_result_array($stmt);
  $results = array();
  $count = 0;
  if(!$stmt->error)
  {
    while($stmt->fetch()){
      $results[$count] = getCopy($row);
      $count=$count+1;
    }
  }
  return $results;
  
}

 ?>


 
