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

  $stmt->bind_result($results['company']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

// TESTME
function register_leader($db, $username, $first, $last, $billet, $rank, $service, $level, $accesslevel="user"){

  $query = "call createLeader(?,?,?,?,?,?,?,?,?,?)";

  $stmt = build_query($db, $query, array($username, $first, $last, $billet, $rank, $service, $level, $accesslevel));

  $stmt->close();
}

function get_user_information($db, $username){

  $query = "call viewLeader(?)";
  $stmt = build_query($db, $query, array($username));

  $stmt->bind_result($results['username'], $results['firstName'], $results['lastName'], $results['billet'], $results['accesslevel'], $results['rank'], $results['service'], $results['level']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0];
}

// TESTME
function update_basic_leader_info($db, $username, $rank, $first, $last, $billet){

  $query = "call updateLeader(?,?,?,?,?)";
  $stmt = build_query($db, $query, array($username, $first, $last, $billet, $rank));

  $stmt->close();

}

function get_midshipman_information($db, $username){
  $query = "call viewMidshipman(?)";
  $stmt = build_query($db, $query, array($username));

  $stmt->bind_result($results['alpha'], $results['company'], $results['classYear'], $results['room'], $results['SQPR'], $results['CQPR'], $results['phoneNumber'], $results['aptitudeGrade'], $results['conductGrade'], $results['coc_0'], $results['coc_1'], $results['coc_2'], $results['coc_3'], $results['coc_4'], $results['coc_5'], $results['coc_6']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results[0];
}

function get_chit_information($db, $number){
  $query = "call viewChit(?)";
  $stmt = build_query($db, $query, array($number));

  $stmt->bind_result($results['chitNumber'], $results['creator'], $results['description'], $results['reference'], $results['requestType'], $results['requestOther'], $results['addr_careOf'], $results['addr_street'], $results['addr_city'], $results['addr_state'], $results['addr_zip'], $results['archiveactive'], $results['remarks'], $results['createdDate'], $results['startDate'], $results['startTime'], $results['endDate'], $results['endTime'], $results['ormURL'], $results['supportingDocsURL'], $results['coc_0_username'], $results['coc_0_status'], $results['coc_0_comments'], $results['coc_0_date'], $results['coc_0_time'], $results['coc_1_username'], $results['coc_1_status'], $results['coc_1_comments'], $results['coc_1_date'], $results['coc_1_time'], $results['coc_2_username'], $results['coc_2_status'], $results['coc_2_comments'], $results['coc_2_date'], $results['coc_2_time'], $results['coc_3_username'], $results['coc_3_status'], $results['coc_3_comments'], $results['coc_3_date'], $results['coc_3_time'], $results['coc_4_username'], $results['coc_4_status'], $results['coc_4_comments'], $results['coc_4_date'], $results['coc_4_time'], $results['coc_5_username'], $results['coc_5_status'], $results['coc_5_comments'], $results['coc_5_date'], $results['coc_5_time'], $results['coc_6_username'], $results['coc_6_status'], $results['coc_6_comments'], $results['coc_6_date'], $results['coc_6_time']);

  $results = stmt_to_assoc_array($stmt);

  $stmt->close();
  return $results;
}

function is_midshipman($db, $username){
  $query = "call getMidshipmen()";
  $stmt = build_query($db, $query, array());
  $stmt->bind_result($results['username'], $results['firstName'], $results['lastName'], $results['billet'], $results['accesslevel'], $results['rank'], $results['service'], $results['level']);

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
function update_midshipman($db, $username, $company, $year, $room, $SQPR, $CQPR, $phone, $aptitude, $conduct, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6){
  
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
  $coc_6 . ")";
  
  $stmt = build_query($db, $query, array());


  $stmt->close();
}

// TESTME
function create_midshipman($db, $username, $company, $year, $room, $phone, $SQPR, $CQPR, $aptitude, $conduct, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6){
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
  $coc_6 . ")";
  
  $stmt = build_query($db, $query, array());


  $stmt->close();
}

function create_chit($db, $chitnumber, $creator, $shortdescription, $reference, $requestType, $requestOther, $addr_careOf, $addr_street, $addr_city, $addr_state, $addr_zip, $remarks, $createDate, $startDate, $startTime, $endDate, $endTime, $orm, $supportingdocs, $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6){

  if(empty($coc_0)){
    $coc_0 = 'NULL';
    $coc_0_status = 'NULL';
    $coc_0_comments = 'NULL';
    $coc_0_date = 'NULL';
    $coc_0_time = 'NULL';
  }
  else{
    $coc_0_status = "PENDING";
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
    $coc_1_status = "PENDING";
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
    $coc_2_status = "PENDING";
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
    $coc_3_status = "PENDING";
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
    $coc_4_status = "PENDING";
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
    $coc_5_status = "PENDING";
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
    $coc_6_status = "PENDING";
    $coc_6_comments = 'NULL';
    $coc_6_date = 'NULL';
    $coc_6_time = 'NULL';
  }

  $query = "call createChit(?,?,?,?,?,?,?,?,?,?,?,0,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

  $stmt = build_query($db, $query, array($chitnumber, $creator, $shortdescription, $reference, $requestType, $requestOther, $addr_careOf, $addr_street, $addr_city, $addr_state, $addr_zip, $remarks, $createDate, $startDate, $startTime, $endDate, $endTime, $orm, $supportingdocs, $coc_0, $coc_0_status, $coc_0_comments, $coc_0_date, $coc_0_time, $coc_1, $coc_1_status, $coc_1_comments, $coc_1_date, $coc_1_time, $coc_2, $coc_2_status, $coc_2_comments, $coc_2_date, $coc_2_time, $coc_3, $coc_3_status, $coc_3_comments, $coc_3_date, $coc_3_time, $coc_4, $coc_4_status, $coc_4_comments, $coc_4_date, $coc_4_time, $coc_5, $coc_5_status, $coc_5_comments, $coc_5_date, $coc_5_time, $coc_6, $coc_6_status, $coc_6_comments, $coc_6_date, $coc_6_time));


  $stmt->close();
}

function action($db, $chit, $who, $what, $today, $now){
  $query = "call ";

  if($who == "coc_0"){
    $query .="action_coc0(";
  }
  elseif($who == "coc_1"){
    $query .="action_coc1(";
  }
  elseif($who == "coc_2"){
    $query .="action_coc2(";
  }
  elseif($who == "coc_3"){
    $query .="action_coc3(";
  }
  elseif($who == "coc_4"){
    $query .="action_coc4(";
  }
  elseif($who == "coc_5"){
    $query .="action_coc5(";
  }
  elseif($who == "coc_6"){
    $query .="action_coc6(";
  }

  if($what == "PENDING"){
    $today = 'NULL';
    $now = 'NULL';
  }

  $query .= "?,?,?,?)";

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

  $query .= "?,?)";

  $stmt = build_query($db, $query, array($chit, $comment));

  $stmt->close();
}

function get_user_chits($db, $username){
	$query = "call getUserChits(?)";
	$stmt = build_query($db, $query, array($username));

	$stmt->bind_result($results['chitNumber'], $results['creator'], $results['description'], $results['reference'], $results['requestType'], $results['requestOther'], $results['addr_careOf'], $results['addr_street'], $results['addr_city'], $results['addr_state'], $results['addr_zip'], $results['archiveactive'], $results['remarks'], $results['createdDate'], $results['startDate'], $results['startTime'], $results['endDate'], $results['endTime'], $results['ormURL'], $results['supportingDocsURL'], $results['coc_0_username'], $results['coc_0_status'], $results['coc_0_comments'], $results['coc_0_date'], $results['coc_0_time'], $results['coc_1_username'], $results['coc_1_status'], $results['coc_1_comments'], $results['coc_1_date'], $results['coc_1_time'], $results['coc_2_username'], $results['coc_2_status'], $results['coc_2_comments'], $results['coc_2_date'], $results['coc_2_time'], $results['coc_3_username'], $results['coc_3_status'], $results['coc_3_comments'], $results['coc_3_date'], $results['coc_3_time'], $results['coc_4_username'], $results['coc_4_status'], $results['coc_4_comments'], $results['coc_4_date'], $results['coc_4_time'], $results['coc_5_username'], $results['coc_5_status'], $results['coc_5_comments'], $results['coc_5_date'], $results['coc_5_time'], $results['coc_6_username'], $results['coc_6_status'], $results['coc_6_comments'], $results['coc_6_date'], $results['coc_6_time']);



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


function get_active_chits($db){
  $query="call getActiveChits()";
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


function get_archived_chits($db)
{
  
    $query="call getArchivedChits()";
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
