<?php

function get_users($db){
  $query = "call getUsers()";
  $stmt = build_query($db, $query, array());

  $stmt->bind_result($results);
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function get_potential_coc_midn($db, $company){
  $query = "call getPotentialCoC(?)";
  $stmt = build_query($db, $query, array($company));

  $stmt->bind_result($results['username'], $results['lastName'], $results['firstName'], $results['rank'], $results['alpha'], $results['company']);
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function get_potential_coc_officers($db){
  $query = "call getPotentialCoCOfficers()";
  $stmt = build_query($db, $query, array());

  $stmt->bind_result($results['username'], $results['lastName'], $results['firstName'], $results['rank']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function get_potential_coc_SELs($db){
  $query = "call getPotentialCoCSELs()";
  $stmt = build_query($db, $query, array());

  $stmt->bind_result($results['username'], $results['lastName'], $results['firstName'], $results['rank']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

// FIXME
// Is this function used? If so, have db return true instead of php
// function is_user($db, $username){
//   $query = "call getUsers()";
//   $stmt = build_query($db, $query, array());
//   $stmt->bind_result($results['username']);
//   $results = stmt_to_assoc_array($stmt);
//
//   $valid = false;
//   foreach ($results as $key => $row) {
//     if($username == $row['username']){
//       $valid = true;
//       break;
//     }
//   }
//   return $valid;
// }

function get_company_number($db, $username){

  $query = "call getCompanyNumber(?)";

  $stmt = build_query($db, $query, array($username));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['company'];
}

function register_leader($db, $username, $first, $last, $billet, $rank, $service, $level){

  $query = "call createLeader(?,?,?,?,?,?,?)";
  $stmt = build_query($db, $query, array($username, $first, $last, $billet, $rank, $service, $level));
  $stmt->close();

  if($level == "MID"){
    $query = "call designateMID(?)";
    $stmt = build_query($db, $query, array($username));
    $stmt->close();
  }


}

function designate_MISLO($db, $username){
  $query = "insert into auth_access values (?,'admin','MISLO')";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();
  return true;
}

function designate_safety($db, $username){
  $query = "insert into auth_access values (?,'admin','safety')";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();
  return true;
}

function designate_admin($db, $username){
  $query = "insert into auth_access values (?,'admin','admin')";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();
  return true;
}

function remove_MISLO($db, $username){
  $query = "DELETE FROM auth_access WHERE user=? AND access=? AND value=?";
  $stmt = build_query($db, $query, array($username, "admin", "MISLO"));
  $stmt->close();
  return true;
}

function remove_safety($db, $username){
  $query = "DELETE FROM auth_access WHERE user=? AND access=? AND value=?";
  $stmt = build_query($db, $query, array($username, "admin", "safety"));
  $stmt->close();
  return true;
}

function remove_admin($db, $username){
  $query = "DELETE FROM auth_access WHERE user=? AND access=? AND value=?";
  $stmt = build_query($db, $query, array($username, "admin", "admin"));
  $stmt->close();
  return true;
}

function get_user_information($db, $username){

  $query = "call viewLeader(?)";
  $stmt = build_query($db, $query, array($username));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();

  if(!empty($results)){
    return $results[0];
  }
  else {
    return null;
  }
}

// TESTME
function update_basic_leader_info($db, $username, $rank, $first, $last, $billet){

  $query = "call updateLeader(?,?,?,?,?)";
  $stmt = build_query($db, $query, array($username, $first, $last, $billet, $rank));

  $stmt->close();

}

function is_user($db, $username){

  $query = "call viewLeader(?)";
  $stmt = build_query($db, $query, array($username));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  if(!empty($results)){
    return true;
  }
  else {
    return false;
  }

}

function get_next_chit_number($db){
  $query = "call lastChitNumber()";
  $stmt = build_query($db, $query, array());

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();

  // echo "<pre>";
  // print_r($results);
  // echo "<pre>";
  //
  if(!empty($results)){
    return $results[0]['chitNumber'] + 1;
  }
  else{
    return 1;
  }
}

function get_midshipman_information($db, $username){
  $query = "call viewMidshipman(?)";
  $stmt = build_query($db, $query, array($username));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  if(!empty($results)){
    return $results[0];
  }
  else{
    return false;
  }
}

function coc_complete($db, $username){
  $query = "call cocComplete(?)";
  $stmt = build_query($db, $query, array($username));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  if(empty($results)){
    return false;
  }

  if(empty($results[0]['coc_0']) && empty($results[0]['coc_1']) && empty($results[0]['coc_2']) && empty($results[0]['coc_3']) && empty($results[0]['coc_4']) && empty($results[0]['coc_5']) && empty($results[0]['coc_6']) && empty($results[0]['coc_7']) && empty($results[0]['coc_8'])){
    return false;
  }
  else{
    return true;
  }

}



function get_chit_information($db, $number){
  $query = "call viewChit(?)";
  $stmt = build_query($db, $query, array($number));

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0];
}

function is_midshipman($db, $username){
  $query = "call getMidshipmen()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $valid = false;
  foreach ($results as $key => $row) {
    if($row['username'] == $username ){
      $valid = true;
    }
  }

  $stmt->close();
  return $valid;

}

function is_archived($db, $chitNumber){
  $query = "call getArchivedChits()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $archived = false;
  foreach ($results as $key => $row) {
    if($row['chitNumber'] == $chitNumber ){
      $archived = true;
    }
  }

  $stmt->close();
  return $archived;

}

function in_midshipman_table($db, $username){
  $query = "call getMidshipmanTable()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results['alpha']);

  $results = stmt_to_assoc_array($stmt);

  $valid = false;
  foreach ($results as $key => $row) {
    if($row['alpha'] == $username ){
      $valid = true;
    }
  }

  $stmt->close();
  return $valid;

}

// TESTME
function update_midshipman($db, $username, $company, $year, $room, $SQPR, $CQPR, $phone, $aptitude, $conduct, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8){

  $username = "'".$username."'";
  $company = "'".$company."'";
  $year = "'".$year."'";
  $room = "'".$room."'";
  $phone = "'".$phone."'";
  $SQPR = "'".$SQPR."'";
  $CQPR = "'".$CQPR."'";
  $aptitude = "'".$aptitude."'";
  $conduct = "'".$conduct."'";


  if(empty($coc_0)){
    $coc_0 = "NULL";
  }
  else{
    $coc_0 = "'".$coc_0."'";
  }

  if(empty($coc_1)){
    $coc_1 = "NULL";
  }
  else{
    $coc_1 = "'".$coc_1."'";
  }

  if(empty($coc_2)){
    $coc_2 = "NULL";
  }
  else{
    $coc_2 = "'".$coc_2."'";
  }

  if(empty($coc_3)){
    $coc_3 = "NULL";
  }
  else{
    $coc_3 = "'".$coc_3."'";
  }

  if(empty($coc_4)){
    $coc_4 = "NULL";
  }
  else{
    $coc_4 = "'".$coc_4."'";
  }

  if(empty($coc_5)){
    $coc_5 = "NULL";
  }
  else{
    $coc_5 = "'".$coc_5."'";
  }

  if(empty($coc_6)){
    $coc_6 = "NULL";
  }
  else{
    $coc_6 = "'".$coc_6."'";
  }

  if(empty($coc_7)){
    $coc_7 = "NULL";
  }
  else{
    $coc_7 = "'".$coc_7."'";
  }

  if(empty($coc_8)){
    $coc_8 = "NULL";
  }
  else{
    $coc_8 = "'".$coc_8."'";
  }


  $query = "call updateMidshipman(" .
  $username . "," .
  $company . "," .
  $year . "," .
  $room . "," .
  $SQPR . "," .
  $CQPR . "," .
  $phone . "," .
  $aptitude . "," .
  $conduct . "," .
  $coc_0 . "," .
  $coc_1 . "," .
  $coc_2 . "," .
  $coc_3 . "," .
  $coc_4 . "," .
  $coc_5 . "," .
  $coc_6 . "," .
  $coc_7 . "," .
  $coc_8 . ")";

  $stmt = build_query($db, $query, array());


  $stmt->close();
}

// TESTME
function create_midshipman($db, $username, $company, $year, $room, $phone, $SQPR, $CQPR, $aptitude, $conduct, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8){
  $username = "'".$username."'";
  $company = "'".$company."'";
  $year = "'".$year."'";
  $room = "'".$room."'";
  $phone = "'".$phone."'";
  $SQPR = "'".$SQPR."'";
  $CQPR = "'".$CQPR."'";
  $aptitude = "'".$aptitude."'";
  $conduct = "'".$conduct."'";


  if(empty($coc_0)){
    $coc_0 = "NULL";
  }
  else{
    $coc_0 = "'".$coc_0."'";
  }

  if(empty($coc_1)){
    $coc_1 = "NULL";
  }
  else{
    $coc_1 = "'".$coc_1."'";
  }

  if(empty($coc_2)){
    $coc_2 = "NULL";
  }
  else{
    $coc_2 = "'".$coc_2."'";
  }

  if(empty($coc_3)){
    $coc_3 = "NULL";
  }
  else{
    $coc_3 = "'".$coc_3."'";
  }

  if(empty($coc_4)){
    $coc_4 = "NULL";
  }
  else{
    $coc_4 = "'".$coc_4."'";
  }

  if(empty($coc_5)){
    $coc_5 = "NULL";
  }
  else{
    $coc_5 = "'".$coc_5."'";
  }

  if(empty($coc_6)){
    $coc_6 = "NULL";
  }
  else{
    $coc_6 = "'".$coc_6."'";
  }


  if(empty($coc_7)){
    $coc_7 = "NULL";
  }
  else{
    $coc_7 = "'".$coc_7."'";
  }

  if(empty($coc_8)){
    $coc_8 = "NULL";
  }
  else{
    $coc_8 = "'".$coc_8."'";
  }


  $query = "call createMidshipman(" .
  $username . "," .
  $company . "," .
  $year . "," .
  $room . "," .
  $SQPR . "," .
  $CQPR . "," .
  $phone . "," .
  $aptitude . "," .
  $conduct . "," .
  $coc_0 . "," .
  $coc_1 . "," .
  $coc_2 . "," .
  $coc_3 . "," .
  $coc_4 . "," .
  $coc_5 . "," .
  $coc_6 . "," .
  $coc_7 . "," .
  $coc_8 . ")";

  $stmt = build_query($db, $query, array());


  $stmt->close();
}

function create_chit($db, $chitnumber, $creator, $shortdescription, $reference, $requestType, $requestOther, $addr_careOf, $addr_street, $addr_city, $addr_state, $addr_zip, $remarks, $createdDate, $startDate, $startTime, $endDate, $endTime, $orm, $supportingdocs, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8){


  $creator = "'".$creator."'";
  $shortdescription = "'".$shortdescription."'";
  $reference = "'".$reference."'";
  $requestType = "'".$requestType."'";


  if(!empty($requestOther)){
    $requestOther = "'".$requestOther."'";
  }
  else{
    $requestOther = 'NULL';
  }

  if(!empty($addr_careOf)){
    $addr_careOf = "'".$addr_careOf."'";
  }
  else{
    $addr_careOf = 'NULL';
  }


  if(!empty($orm)){
    $orm = "'".$orm."'";
  }
  else{
    $orm = 'NULL';
  }


  if(!empty($supportingdocs)){
    $supportingdocs = "'".$supportingdocs."'";
  }
  else{
    $supportingdocs = 'NULL';
  }

  $addr_street = "'".$addr_street."'";
  $addr_city = "'".$addr_city."'";
  $addr_state = "'".$addr_state."'";
  $addr_zip = "'".$addr_zip."'";
  $remarks = "'".$remarks."'";
  $createdDate = "'".$createdDate."'";
  $startDate = "'".$startDate."'";
  $startTime = "'".$startTime."'";
  $endDate = "'".$endDate."'";
  $endTime = "'".$endTime."'";

  if(empty($coc_0)){
    $coc_0 = 'NULL';
    $coc_0_status = 'NULL';
    $coc_0_comments = 'NULL';
    $coc_0_date = 'NULL';
    $coc_0_time = 'NULL';
  }
  else{
    $coc_0 = "'".$coc_0."'";
    $coc_0_status = "'PENDING'";
    $coc_0_comments = 'NULL';
    $coc_0_date = 'NULL';
    $coc_0_time = 'NULL';
  }


  if(empty($coc_1)){
    $coc_1 = 'NULL';
    $coc_1_status = 'NULL';
    $coc_1_comments = 'NULL';
    $coc_1_date = 'NULL';
    $coc_1_time = 'NULL';
  }
  else{
    $coc_1 = "'".$coc_1."'";
    $coc_1_status = "'PENDING'";
    $coc_1_comments = 'NULL';
    $coc_1_date = 'NULL';
    $coc_1_time = 'NULL';
  }


  if(empty($coc_2)){
    $coc_2 = 'NULL';
    $coc_2_status = 'NULL';
    $coc_2_comments = 'NULL';
    $coc_2_date = 'NULL';
    $coc_2_time = 'NULL';
  }
  else{
    $coc_2 = "'".$coc_2."'";
    $coc_2_status = "'PENDING'";
    $coc_2_comments = 'NULL';
    $coc_2_date = 'NULL';
    $coc_2_time = 'NULL';
  }

  if(empty($coc_3)){
    $coc_3 = 'NULL';
    $coc_3_status = 'NULL';
    $coc_3_comments = 'NULL';
    $coc_3_date = 'NULL';
    $coc_3_time = 'NULL';
  }
  else{
    $coc_3 = "'".$coc_3."'";
    $coc_3_status = "'PENDING'";
    $coc_3_comments = 'NULL';
    $coc_3_date = 'NULL';
    $coc_3_time = 'NULL';
  }

  if(empty($coc_4)){
    $coc_4 = 'NULL';
    $coc_4_status = 'NULL';
    $coc_4_comments = 'NULL';
    $coc_4_date = 'NULL';
    $coc_4_time = 'NULL';
  }
  else{
    $coc_4 = "'".$coc_4."'";
    $coc_4_status = "'PENDING'";
    $coc_4_comments = 'NULL';
    $coc_4_date = 'NULL';
    $coc_4_time = 'NULL';
  }

  if(empty($coc_5)){
    $coc_5 = 'NULL';
    $coc_5_status = 'NULL';
    $coc_5_comments = 'NULL';
    $coc_5_date = 'NULL';
    $coc_5_time = 'NULL';
  }
  else{
    $coc_5 = "'".$coc_5."'";
    $coc_5_status = "'PENDING'";
    $coc_5_comments = 'NULL';
    $coc_5_date = 'NULL';
    $coc_5_time = 'NULL';
  }

  if(empty($coc_6)){
    $coc_6 = 'NULL';
    $coc_6_status = 'NULL';
    $coc_6_comments = 'NULL';
    $coc_6_date = 'NULL';
    $coc_6_time = 'NULL';
  }
  else{
    $coc_6 = "'".$coc_6."'";
    $coc_6_status = "'PENDING'";
    $coc_6_comments = 'NULL';
    $coc_6_date = 'NULL';
    $coc_6_time = 'NULL';
  }


  if(empty($coc_7)){
    $coc_7 = 'NULL';
    $coc_7_status = 'NULL';
    $coc_7_comments = 'NULL';
    $coc_7_date = 'NULL';
    $coc_7_time = 'NULL';
  }
  else{
    $coc_7 = "'".$coc_7."'";
    $coc_7_status = "'PENDING'";
    $coc_7_comments = 'NULL';
    $coc_7_date = 'NULL';
    $coc_7_time = 'NULL';
  }


  if(empty($coc_8)){
    $coc_8 = 'NULL';
    $coc_8_status = 'NULL';
    $coc_8_comments = 'NULL';
    $coc_8_date = 'NULL';
    $coc_8_time = 'NULL';
  }
  else{
    $coc_8 = "'".$coc_8."'";
    $coc_8_status = "'PENDING'";
    $coc_8_comments = 'NULL';
    $coc_8_date = 'NULL';
    $coc_8_time = 'NULL';
  }




  $query = "call createChit(" .
  $chitnumber . "," .
  $creator . "," .
  $shortdescription . "," .
  $reference . "," .
  $requestType . "," .
  $requestOther . "," .
  $addr_careOf . "," .
  $addr_street . "," .
  $addr_city . "," .
  $addr_state . "," .
  $addr_zip . "," .
  "0" . "," .
  $remarks . "," .
  $createdDate . "," .
  $startDate . "," .
  $startTime . "," .
  $endDate . "," .
  $endTime . "," .

  $orm . "," .
  $supportingdocs . "," .

  $coc_0 . "," .
  $coc_0_status . "," .
  $coc_0_comments . "," .
  $coc_0_date . "," .
  $coc_0_time . "," .

  $coc_1 . "," .
  $coc_1_status . "," .
  $coc_1_comments . "," .
  $coc_1_date . "," .
  $coc_1_time . "," .

  $coc_2 . "," .
  $coc_2_status . "," .
  $coc_2_comments . "," .
  $coc_2_date . "," .
  $coc_2_time . "," .

  $coc_3 . "," .
  $coc_3_status . "," .
  $coc_3_comments . "," .
  $coc_3_date . "," .
  $coc_3_time . "," .

  $coc_4 . "," .
  $coc_4_status . "," .
  $coc_4_comments . "," .
  $coc_4_date . "," .
  $coc_4_time . "," .

  $coc_5 . "," .
  $coc_5_status . "," .
  $coc_5_comments . "," .
  $coc_5_date . "," .
  $coc_5_time . "," .

  $coc_6 . "," .
  $coc_6_status . "," .
  $coc_6_comments . "," .
  $coc_6_date . "," .
  $coc_6_time . "," .

  $coc_7 . "," .
  $coc_7_status . "," .
  $coc_7_comments . "," .
  $coc_7_date . "," .
  $coc_7_time . "," .


  $coc_8 . "," .
  $coc_8_status . "," .
  $coc_8_comments . "," .
  $coc_8_date . "," .
  $coc_8_time  . ")";


   // echo "$query";

   $stmt = build_query($db, $query, array());
   $stmt->close();

   return true;
}


function update_chit($db, $chitnumber, $creator, $shortdescription, $reference, $requestType, $requestOther, $addr_careOf, $addr_street, $addr_city, $addr_state, $addr_zip, $remarks, $createdDate, $startDate, $startTime, $endDate, $endTime, $orm, $supportingdocs, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8){


  $creator = "'".$creator."'";
  $shortdescription = "'".$shortdescription."'";
  $reference = "'".$reference."'";
  $requestType = "'".$requestType."'";


  if(!empty($requestOther)){
    $requestOther = "'".$requestOther."'";
  }
  else{
    $requestOther = 'NULL';
  }

  if(!empty($addr_careOf)){
    $addr_careOf = "'".$addr_careOf."'";
  }
  else{
    $addr_careOf = 'NULL';
  }


  if(!empty($orm)){
    $orm = "'".$orm."'";
  }
  else{
    $orm = 'NULL';
  }


  if(!empty($supportingdocs)){
    $supportingdocs = "'".$supportingdocs."'";
  }
  else{
    $supportingdocs = 'NULL';
  }

  $addr_street = "'".$addr_street."'";
  $addr_city = "'".$addr_city."'";
  $addr_state = "'".$addr_state."'";
  $addr_zip = "'".$addr_zip."'";
  $remarks = "'".$remarks."'";
  $createdDate = "'".$createdDate."'";
  $startDate = "'".$startDate."'";
  $startTime = "'".$startTime."'";
  $endDate = "'".$endDate."'";
  $endTime = "'".$endTime."'";

  if(empty($coc_0)){
    $coc_0 = 'NULL';
    $coc_0_status = 'NULL';
    $coc_0_comments = 'NULL';
    $coc_0_date = 'NULL';
    $coc_0_time = 'NULL';
  }
  else{
    $coc_0 = "'".$coc_0."'";
    $coc_0_status = "'PENDING'";
    $coc_0_comments = 'NULL';
    $coc_0_date = 'NULL';
    $coc_0_time = 'NULL';
  }


  if(empty($coc_1)){
    $coc_1 = 'NULL';
    $coc_1_status = 'NULL';
    $coc_1_comments = 'NULL';
    $coc_1_date = 'NULL';
    $coc_1_time = 'NULL';
  }
  else{
    $coc_1 = "'".$coc_1."'";
    $coc_1_status = "'PENDING'";
    $coc_1_comments = 'NULL';
    $coc_1_date = 'NULL';
    $coc_1_time = 'NULL';
  }


  if(empty($coc_2)){
    $coc_2 = 'NULL';
    $coc_2_status = 'NULL';
    $coc_2_comments = 'NULL';
    $coc_2_date = 'NULL';
    $coc_2_time = 'NULL';
  }
  else{
    $coc_2 = "'".$coc_2."'";
    $coc_2_status = "'PENDING'";
    $coc_2_comments = 'NULL';
    $coc_2_date = 'NULL';
    $coc_2_time = 'NULL';
  }

  if(empty($coc_3)){
    $coc_3 = 'NULL';
    $coc_3_status = 'NULL';
    $coc_3_comments = 'NULL';
    $coc_3_date = 'NULL';
    $coc_3_time = 'NULL';
  }
  else{
    $coc_3 = "'".$coc_3."'";
    $coc_3_status = "'PENDING'";
    $coc_3_comments = 'NULL';
    $coc_3_date = 'NULL';
    $coc_3_time = 'NULL';
  }

  if(empty($coc_4)){
    $coc_4 = 'NULL';
    $coc_4_status = 'NULL';
    $coc_4_comments = 'NULL';
    $coc_4_date = 'NULL';
    $coc_4_time = 'NULL';
  }
  else{
    $coc_4 = "'".$coc_4."'";
    $coc_4_status = "'PENDING'";
    $coc_4_comments = 'NULL';
    $coc_4_date = 'NULL';
    $coc_4_time = 'NULL';
  }

  if(empty($coc_5)){
    $coc_5 = 'NULL';
    $coc_5_status = 'NULL';
    $coc_5_comments = 'NULL';
    $coc_5_date = 'NULL';
    $coc_5_time = 'NULL';
  }
  else{
    $coc_5 = "'".$coc_5."'";
    $coc_5_status = "'PENDING'";
    $coc_5_comments = 'NULL';
    $coc_5_date = 'NULL';
    $coc_5_time = 'NULL';
  }

  if(empty($coc_6)){
    $coc_6 = 'NULL';
    $coc_6_status = 'NULL';
    $coc_6_comments = 'NULL';
    $coc_6_date = 'NULL';
    $coc_6_time = 'NULL';
  }
  else{
    $coc_6 = "'".$coc_6."'";
    $coc_6_status = "'PENDING'";
    $coc_6_comments = 'NULL';
    $coc_6_date = 'NULL';
    $coc_6_time = 'NULL';
  }


  if(empty($coc_7)){
    $coc_7 = 'NULL';
    $coc_7_status = 'NULL';
    $coc_7_comments = 'NULL';
    $coc_7_date = 'NULL';
    $coc_7_time = 'NULL';
  }
  else{
    $coc_7 = "'".$coc_7."'";
    $coc_7_status = "'PENDING'";
    $coc_7_comments = 'NULL';
    $coc_7_date = 'NULL';
    $coc_7_time = 'NULL';
  }


  if(empty($coc_8)){
    $coc_8 = 'NULL';
    $coc_8_status = 'NULL';
    $coc_8_comments = 'NULL';
    $coc_8_date = 'NULL';
    $coc_8_time = 'NULL';
  }
  else{
    $coc_8 = "'".$coc_8."'";
    $coc_8_status = "'PENDING'";
    $coc_8_comments = 'NULL';
    $coc_8_date = 'NULL';
    $coc_8_time = 'NULL';
  }




  $query = "call updateChit(" .
  $chitnumber . "," .
  $creator . "," .
  $shortdescription . "," .
  $reference . "," .
  $requestType . "," .
  $requestOther . "," .
  $addr_careOf . "," .
  $addr_street . "," .
  $addr_city . "," .
  $addr_state . "," .
  $addr_zip . "," .
  "0" . "," .
  $remarks . "," .
  $createdDate . "," .
  $startDate . "," .
  $startTime . "," .
  $endDate . "," .
  $endTime . "," .

  $orm . "," .
  $supportingdocs . "," .

  $coc_0 . "," .
  $coc_0_status . "," .
  $coc_0_comments . "," .
  $coc_0_date . "," .
  $coc_0_time . "," .

  $coc_1 . "," .
  $coc_1_status . "," .
  $coc_1_comments . "," .
  $coc_1_date . "," .
  $coc_1_time . "," .

  $coc_2 . "," .
  $coc_2_status . "," .
  $coc_2_comments . "," .
  $coc_2_date . "," .
  $coc_2_time . "," .

  $coc_3 . "," .
  $coc_3_status . "," .
  $coc_3_comments . "," .
  $coc_3_date . "," .
  $coc_3_time . "," .

  $coc_4 . "," .
  $coc_4_status . "," .
  $coc_4_comments . "," .
  $coc_4_date . "," .
  $coc_4_time . "," .

  $coc_5 . "," .
  $coc_5_status . "," .
  $coc_5_comments . "," .
  $coc_5_date . "," .
  $coc_5_time . "," .

  $coc_6 . "," .
  $coc_6_status . "," .
  $coc_6_comments . "," .
  $coc_6_date . "," .
  $coc_6_time . "," .

  $coc_7 . "," .
  $coc_7_status . "," .
  $coc_7_comments . "," .
  $coc_7_date . "," .
  $coc_7_time . "," .


  $coc_8 . "," .
  $coc_8_status . "," .
  $coc_8_comments . "," .
  $coc_8_date . "," .
  $coc_8_time  . ")";


   // echo "$query";

   $stmt = build_query($db, $query, array());


   $stmt->close();

   return true;
}




function action($db, $chit, $who, $what, $today, $now){
  $query = "call ";

  if($who == "coc_0"){
    $query .= "action_coc0(";
  }
  elseif($who == "coc_1"){
    $query .= "action_coc1(";
  }
  elseif($who == "coc_2"){
    $query .= "action_coc2(";
  }
  elseif($who == "coc_3"){
    $query .= "action_coc3(";
  }
  elseif($who == "coc_4"){
    $query .= "action_coc4(";
  }
  elseif($who == "coc_5"){
    $query .= "action_coc5(";
  }
  elseif($who == "coc_6"){
    $query .= "action_coc6(";
  }
  elseif($who == "coc_7"){
    $query .= "action_coc7(";
  }
  elseif($who == "coc_8"){
    $query .= "action_coc8(";
  }

  if($what == "PENDING"){
    $today = 'NULL';
    $now = 'NULL';
  }

  $query .= "?,?,?,?)";

  echo "$query";


  $stmt = build_query($db, $query, array($chit, $what, $today, $now));

  $stmt->close();

}

function comment($db, $chit, $who, $comment){
  $query = "call ";

  if($who == "coc_0"){
    $query .="comment_coc0(";
  }
  elseif($who == "coc_1"){
    $query .="comment_coc1(";
  }
  elseif($who == "coc_2"){
    $query .="comment_coc2(";
  }
  elseif($who == "coc_3"){
    $query .="comment_coc3(";
  }
  elseif($who == "coc_4"){
    $query .="comment_coc4(";
  }
  elseif($who == "coc_5"){
    $query .="comment_coc5(";
  }
  elseif($who == "coc_6"){
    $query .="comment_coc6(";
  }
  elseif($who == "coc_7"){
    $query .="action_coc7(";
  }
  elseif($who == "coc_8"){
    $query .="action_coc8(";
  }

  $query .= "?,?)";
  $comment = "test comment";
  $fixer = array($chit, $comment);
  ?>
  <script>
  alert(<?php
  print_r($comment);
  print_r($fixer);
  ?>)
  </script>
  <?php
//  $stmt = build_query($db, $query, array($chit, $comment));
  $stmt = build_query($db, $query, $fixer);

  $stmt->close();
}

function get_user_chits($db, $username){
	$query = "call getUserChits(?)";
	$stmt = build_query($db, $query, array($username));
	$results = stmt_to_assoc_array($stmt);

	$stmt->close();
	return $results;

}

function get_user_archived_chits($db, $username){
	$query = "call getUserArchivedChits(?)";
	$stmt = build_query($db, $query, array($username));
	$results = stmt_to_assoc_array($stmt);

	$stmt->close();
	return $results;
}

function get_subordinate_archived_chits($db, $username){
	$query = "call getSubordinateArchivedChits(?)";
	$stmt = build_query($db, $query, array($username));
	$results = stmt_to_assoc_array($stmt);

	$stmt->close();
	return $results;

}




function get_num_users($db){
  $query = "call getNumUsers()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_mids($db){
  $query = "call getNumMids()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}


function get_num_companies($db){
  $query = "call getNumCompanies()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_total_chits($db){
  $query = "call getNumTotalChits()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_active_chits($db){
  $query = "call getNumActiveChits()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_bigOs($db){
  $query = "call getNumBigOs()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_officers($db){
  $query = "call getNumOfficers()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_num_SELs($db){
  $query = "call getNumSELs()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0]['count'];

}

function get_subordinates($db, $username){
  $query = "call getSubordinates(?)";
  $stmt = build_query($db, $query, array($username));
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;

}


function get_active_chits($db){
  $query="call getActiveChits()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;

}

function archive_chit($db, $chit){
  $query="call deleteChit(?)";
  $stmt = build_query($db, $query, array($chit));
  $stmt->close();
  return true;
}

function delete_chit($db, $chit){
  $query="call permanentlyDeleteChit(?)";
  $stmt = build_query($db, $query, array($chit));
  $stmt->close();
  return true;
}


function get_ranks($db){
  $query="select * from Rates";
  $stmt = build_query($db, $query, array());

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();

  return $results;
}

function restore_chit($db, $chit){
  $query="call restoreChit(?)";
  $stmt = build_query($db, $query, array($chit));
  $stmt->close();
  return true;
}


function get_archived_chits($db)
{

    $query="call getArchivedChits()";
    $stmt = build_query($db, $query, array());

    $results = stmt_to_assoc_array($stmt);

    $stmt->close();
    return $results;

}

function get_active_orm_chits_company($db, $company){
  $query="call getActiveORMChitsCompany(?)";
  $stmt = build_query($db, $query, array($company));
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;

}

function get_archived_orm_chits_company($db, $company){
  $query="call getArchivedORMChitsCompany(?)";
  $stmt = build_query($db, $query, array($company));
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;

}

function get_admins($db){
  $query = "call getAdmins()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();



  return $results;
}

function get_company($db, $company){
  $query = "call getCompany(?)";
  $stmt = build_query($db, $query, array($company));
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function get_staff($db){
  $query = "call getStaff()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}



function get_safeties($db){
  $query = "call getSafeties()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function delete_user($db, $username){
  $query = "call removeAdmin(?)";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();

  $query = "call removeMISLO(?)";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();

  $query = "call removeSafety(?)";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();

  $query = "call deleteUser(?)";
  $stmt = build_query($db, $query, array($username));
  $stmt->close();






  return true;
}



function get_MISLOs($db){
  $query = "call getMISLOs()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}


function get_complete_mids($db){
  $query = "call getCompleteMids()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function get_incomplete_mids($db){
  $query = "call getInCompleteMids()";
  $stmt = build_query($db, $query, array());
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function blast_chits_company($db, $company){
  $query = "call gblastChitsCompany(?)";
  $stmt = build_query($db, $query, array($company));

  $stmt->close();
  return true;
}

function blast_chits($db){
  $query = "call blastChits";
  $stmt = build_query($db, $query, array());

  $stmt->close();
  return true;
}


function get_subordinate_chits($db, $coc){
  $query = "call getSubordinateChits(?)";
  $stmt = build_query($db, $query, array($coc));
  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}








 ?>
