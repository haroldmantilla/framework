<?php

// session_start();

$MODULE_DEF = array('name'       => 'Generate PDF',
                    'version'    => 1.0,
                    'display'    => '',
                    'tab'        => '',
                    'position'   => 0,
                    'student'    => true,
                    'instructor' => true,
                    'guest'      => false,
                    'access'     => array());

        ################################################################
        #                  Commented on 29DEC18 by                     #
        #                       Harold Mantilla                        #
        ################################################################

        ################################################################
        #                  generate pdf of complete chit
        #                       very straightforward                   #
        ################################################################


# Load in Configuration Parameters

require_once("../etc/config.inc.php");

# Load in template, if not already loaded
require_once(LIBRARY_PATH.'template.php');

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

$req1 = WEB_PATH . "fpdf181/fpdf.php";
$req2 = WEB_PATH . "fpdi/src/autoload.php";

require_once($req1);
require_once($req2);

// if chit is set grab all of the information
if(isset($_SESSION['chit'])){

  $chit = get_chit_information($db, $_SESSION['chit']);
  $midshipmaninfo = get_midshipman_information($db, $chit['creator']);
  $ownerinfo = get_user_information($db, $chit['creator']);

  $chit['description'] = stripslashes($chit['description']);
  $chit['reference'] = stripslashes($chit['reference']);
  $chit['addr_city'] = stripslashes($chit['addr_city']);
  $chit['addr_street'] = stripslashes($chit['addr_street']);
  $chit['addr_state'] = stripslashes($chit['addr_state']);
  $chit['addr_zip'] = stripslashes($chit['addr_zip']);
  $chit['remarks'] = stripslashes($chit['remarks']);
  $chit['startDate'] = stripslashes($chit['startDate']);
  $chit['startTime'] = stripslashes($chit['startTime']);
  $chit['endDate'] = stripslashes($chit['endDate']);
  $chit['endTime'] = stripslashes($chit['endTime']);

}
else{
  //filename is not set
  echo "<pre>";
  print_r($_SESSION);
  echo "<pre>";
  die;
}

$printpending = false;

$filename='./blank_chit_custom.pdf';

$template_pdf=new Fpdi();
$template_pdf->AddPage();
$template_pdf->setSourceFile($filename);
$template_index=$template_pdf->importPage(1);
$template_pdf->useTemplate($template_index,-4);
$template_pdf->SetMargins(0,0,0);
$template_pdf->SetFont('Courier');
$template_pdf->SetFontSize(8);
$template_pdf->SetTextColor(0,0,0);

$template_pdf->SetXY(8, 32);

if(isset($chit['coc_0_username'])){ //dant
  $coc_0 = get_user_information($db, $chit['coc_0_username']);
  $to = "{$coc_0['rank']} {$coc_0['firstName']} {$coc_0['lastName']}, {$coc_0['service']}   {$coc_0['billet']}";

}
elseif(isset($chit['coc_1_username'])){ //depdant
  $coc_1 = get_user_information($db, $chit['coc_1_username']);
  $to = "{$coc_1['rank']} {$coc_1['firstName']} {$coc_1['lastName']}, {$coc_1['service']}   {$coc_1['billet']}";
}
elseif(isset($chit['coc_2_username'])){ // batt o
  $coc_2 = get_user_information($db, $chit['coc_2_username']);
  $to = "{$coc_2['rank']} {$coc_2['firstName']} {$coc_2['lastName']}, {$coc_2['service']}   {$coc_2['billet']}";

}
elseif(isset($chit['coc_3_username'])){ //co
  $coc_3 = get_user_information($db, $chit['coc_3_username']);
  $to = "{$coc_3['rank']} {$coc_3['firstName']} {$coc_3['lastName']}, {$coc_3['service']}   {$coc_3['billet']}";

}
elseif(isset($chit['coc_4_username'])){ //sel
  $coc_4 = get_user_information($db, $chit['coc_4_username']);
  $to = "{$coc_4['rank']} {$coc_4['firstName']} {$coc_4['lastName']}, {$coc_4['service']}   {$coc_4['billet']}";

}
$template_pdf->Write(0, "".$to);

// set location of text that will be grabbed from chit array and printed on the page
$template_pdf->SetXY(105, 32);
$from =  "{$ownerinfo['rank']} {$ownerinfo['firstName']} {$ownerinfo['lastName']}, {$ownerinfo['service']}";
$template_pdf->Write(0, "".$from);

$template_pdf->SetXY(180, 32);
$template_pdf->Write(0, "".$midshipmaninfo['alpha']);

$template_pdf->SetXY(8, 47);
$template_pdf->Write(0, "".$chit['reference']);

$template_pdf->SetXY(110, 40);
$template_pdf->Write(0, "".$midshipmaninfo['classYear']);

$template_pdf->SetXY(135, 40);
$template_pdf->Write(0, "".$midshipmaninfo['company']);

$template_pdf->SetXY(160, 40);
$template_pdf->Write(0, "".$midshipmaninfo['room']);

$template_pdf->SetXY(180, 40);
$template_pdf->Write(0, "".$ownerinfo['rank']);

$template_pdf->SetXY(110, 47);
$template_pdf->Write(0, "".$midshipmaninfo['SQPR']);

$template_pdf->SetXY(135, 47);
$template_pdf->Write(0, "".$midshipmaninfo['CQPR']);

$template_pdf->SetXY(160, 47);
$template_pdf->Write(0, "".$midshipmaninfo['aptitudeGrade']);

$template_pdf->SetXY(184, 47);
$template_pdf->Write(0, "".$midshipmaninfo['conductGrade']);

$template_pdf->SetXY(8, 60);
$template_pdf->Write(0, "".$chit['addr_careOf']);

$template_pdf->SetXY(43, 60);
$template_pdf->Write(0, "".$chit['addr_street']);

$template_pdf->SetXY(120, 60);
$template_pdf->Write(0, "".$chit['addr_city']);

$template_pdf->SetXY(152, 60);
$template_pdf->Write(0, "".$chit['addr_state']);

$template_pdf->SetXY(160, 60);
$template_pdf->Write(0, "".$chit['addr_zip']);

$template_pdf->SetXY(175, 60);
$template_pdf->Write(0, "".$midshipmaninfo['phoneNumber']);

$reference = preg_split('/\h+/', $chit['remarks']);

$x = 8;
$y = 66;
$count = 0;
$line = "";

foreach ($reference as $word) {
  if(strstr($word, "\n")){
    $arr = preg_split('/\s+/', $word);
    $line .= $arr[0] . " ";

    $template_pdf->SetXY($x, $y);
    $template_pdf->Write(0, "".$line);

    $out = explode(PHP_EOL, $word);

    if(isset($out[0]) && strlen(trim($out[0])) == 0 && isset($out[1]) && strlen(trim($out[1])) == 0){
      $y += 3;
    }

    $line = $arr[1] . " ";
    $count = strlen($arr[1]) + 1;
    $y += 3;

  }
  elseif($count + strlen($word) < 111){
    $line .= $word . " ";
    $count += strlen($word);
    $count += 1;
  }
  else{
    $template_pdf->SetXY($x, $y);
    $template_pdf->Write(0, "".$line);
    $y += 3;
    $line = $word . " ";
    $count = strlen($word);
  }
}
if(!empty($line)){
  $template_pdf->SetXY($x, $y);
  $template_pdf->Write(0, "".$line);
  $y += 3;
}



if($chit['requestType'] == 'W'){
$template_pdf->SetXY(35, 53);
$template_pdf->Write(0, "X");
}else if($chit['requestType'] == 'D'){
  //TODO Test this
$template_pdf->SetXY(65, 53);
$template_pdf->Write(0, "X");
}else if($chit['requestType'] == 'L'){
  //TODO Test this
$template_pdf->SetXY(90, 53);
$template_pdf->Write(0, "X");
}else if($chit['requestType'] == 'O'){
$template_pdf->SetXY(135, 53);
$template_pdf->Write(0, "".$chit['requestOther']);
}


#ADDRESS
$template_pdf->SetXY(85, 152);
$template_pdf->Write(0, "".$chit['createdDate']);

$template_pdf->SetXY(115, 152);
$template_pdf->Write(0, "".$chit['startTime']);

$template_pdf->SetXY(125, 152);
$template_pdf->Write(0, "".$chit['startDate']);

$template_pdf->SetXY(160, 152);
$template_pdf->Write(0, "".$chit['endTime']);


$template_pdf->SetXY(170, 152);
$template_pdf->Write(0, "".$chit['endDate']);


//formats the coc positions
$coc_0 = array("username"=>$chit['coc_0_username'], "status"=>$chit['coc_0_status'], "comments"=> $chit['coc_0_comments'], "date"=> $chit['coc_0_date'], "time"=> $chit['coc_0_time']);

$coc_1 = array("username"=>$chit['coc_1_username'], "status"=>$chit['coc_1_status'], "comments"=> $chit['coc_1_comments'], "date"=> $chit['coc_1_date'], "time"=> $chit['coc_1_time']);

$coc_2 = array("username"=>$chit['coc_2_username'], "status"=>$chit['coc_2_status'], "comments"=> $chit['coc_2_comments'], "date"=> $chit['coc_2_date'], "time"=> $chit['coc_2_time']);

$coc_3 = array("username"=>$chit['coc_3_username'], "status"=>$chit['coc_3_status'], "comments"=> $chit['coc_3_comments'], "date"=> $chit['coc_3_date'], "time"=> $chit['coc_3_time']);

$coc_4 = array("username"=>$chit['coc_4_username'], "status"=>$chit['coc_4_status'], "comments"=> $chit['coc_4_comments'], "date"=> $chit['coc_4_date'], "time"=> $chit['coc_4_time']);

$coc_5 = array("username"=>$chit['coc_5_username'], "status"=>$chit['coc_5_status'], "comments"=> $chit['coc_5_comments'], "date"=> $chit['coc_5_date'], "time"=> $chit['coc_5_time']);

$coc_6 = array("username"=>$chit['coc_6_username'], "status"=>$chit['coc_6_status'], "comments"=> $chit['coc_6_comments'], "date"=> $chit['coc_6_date'], "time"=> $chit['coc_6_time']);

$coc_7 = array("username"=>$chit['coc_7_username'], "status"=>$chit['coc_7_status'], "comments"=> $chit['coc_7_comments'], "date"=> $chit['coc_7_date'], "time"=> $chit['coc_7_time']);

$coc_8 = array("username"=>$chit['coc_8_username'], "status"=>$chit['coc_8_status'], "comments"=> $chit['coc_8_comments'], "date"=> $chit['coc_8_date'], "time"=> $chit['coc_8_time']);

$pos_8 = null;
$pos_7 = null;
$pos_6 = null;
$pos_5 = null;
$pos_4 = null;
$pos_3 = null;
$pos_2 = null;
$pos_1 = null;
$pos_0 = null;

if(isset($chit['coc_8_username'])){
  $pos_8 = $coc_8;
  $pos_7 = $coc_7;
  $pos_6 = $coc_6;
  $pos_5 = $coc_5;
}
elseif(isset($chit['coc_7_username'])){
  $pos_8 = $coc_7;
  $pos_7 = $coc_6;
  $pos_6 = $coc_5;
}
elseif(isset($chit['coc_6_username'])){
  $pos_8 = $coc_6;
  $pos_7 = $coc_5;
}
elseif(isset($chit['coc_5_username'])){
  $pos_8 = $coc_5;
}

if(isset($chit['coc_0_username'])){
  $pos_0 = $coc_0;
  $pos_1 = $coc_1;
  $pos_2 = $coc_2;
  $pos_3 = $coc_3;
  $pos_4 = $coc_4;
}
elseif(isset($chit['coc_1_username'])){
  $pos_1 = $coc_1;
  $pos_2 = $coc_2;
  $pos_3 = $coc_3;
  $pos_4 = $coc_4;
}
elseif(isset($chit['coc_2_username'])){
  $pos_2 = $coc_2;
  $pos_3 = $coc_3;
  $pos_4 = $coc_4;
}
elseif(isset($chit['coc_3_username'])){
  $pos_3 = $coc_3;
  $pos_4 = $coc_4;
}
elseif(isset($chit['coc_4_username'])){
  $pos_4 = $coc_4;
}

if(isset($pos_0['comments']) && !empty($pos_0['comments'])){
  $pos_0['comments'] = stripslashes($pos_0['comments']);
}
if(isset($pos_1['comments']) && !empty($pos_1['comments'])){
  $pos_1['comments'] = stripslashes($pos_1['comments']);
}
if(isset($pos_2['comments']) && !empty($pos_2['comments'])){
  $pos_2['comments'] = stripslashes($pos_2['comments']);
}
if(isset($pos_3['comments']) && !empty($pos_3['comments'])){
  $pos_3['comments'] = stripslashes($pos_3['comments']);
}
if(isset($pos_4['comments']) && !empty($pos_4['comments'])){
  $pos_4['comments'] = stripslashes($pos_4['comments']);
}
if(isset($pos_5['comments']) && !empty($pos_5['comments'])){
  $pos_5['comments'] = stripslashes($pos_5['comments']);
}
if(isset($pos_6['comments']) && !empty($pos_6['comments'])){
  $pos_6['comments'] = stripslashes($pos_6['comments']);
}


$template_pdf->SetFontSize(6);


// ctrl + f "//[a number]" from 8 to 1 in order to see each CoC's chunk of this code
// it repeats 9 times for every member in the CoC and prints their information on the chit
// (comments, rank, name, approval, etc)
//8
if(isset($pos_8['username'])){
  $y = 165;

  $info = get_user_information($db, $pos_8['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_8['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_8['status']);
  }
  else{
    if($pos_8['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_8['status']);
    }
    elseif($pos_8['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_8['status']);

    }

    $time = $pos_8['time'];
    $date = $pos_8['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_8['comments'])){

    $comments = preg_split('/\h+/', $pos_8['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {

      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}

//7

if(isset($pos_7['username'])){
  $y = 174;

  $info = get_user_information($db, $pos_7['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_7['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_7['status']);
  }
  else{
    if($pos_7['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_7['status']);
    }
    elseif($pos_7['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_7['status']);

    }

    $time = $pos_7['time'];
    $date = $pos_7['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_7['comments'])){

    $comments = preg_split('/\h+/', $pos_7['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}


//6

if(isset($pos_6['username'])){
  $y = 182;

  $info = get_user_information($db, $pos_6['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_6['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_6['status']);
  }
  else{
    if($pos_6['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_6['status']);
    }
    elseif($pos_6['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_6['status']);

    }

    $time = $pos_6['time'];
    $date = $pos_6['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_6['comments'])){

    $comments = preg_split('/\h+/', $pos_6['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}


//5
if(isset($pos_5['username'])){
  $y = 189;

  $info = get_user_information($db, $pos_5['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_5['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_5['status']);
  }
  else{
    if($pos_5['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_5['status']);
    }
    elseif($pos_5['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_5['status']);

    }

    $time = $pos_5['time'];
    $date = $pos_5['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_5['comments'])){

    $comments = preg_split('/\h+/', $pos_5['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}


//4
if(isset($pos_4['username'])){
  $y = 201;

  $info = get_user_information($db, $pos_4['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_4['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_4['status']);
  }
  else{
    if($pos_4['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_4['status']);
    }
    elseif($pos_4['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_4['status']);

    }

    $time = $pos_4['time'];
    $date = $pos_4['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_4['comments'])){

    $comments = preg_split('/\h+/', $pos_4['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}


//3
if(isset($pos_3['username'])){
  $y = 209;

  $info = get_user_information($db, $pos_3['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_3['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_3['status']);
  }
  else{
    if($pos_3['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_3['status']);
    }
    elseif($pos_3['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_3['status']);

    }

    $time = $pos_3['time'];
    $date = $pos_3['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_3['comments'])){

    $comments = preg_split('/\h+/', $pos_3['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}


//2
if(isset($pos_2['username'])){
  $y = 217;

  $info = get_user_information($db, $pos_2['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_2['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_2['status']);
  }
  else{
    if($pos_2['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_2['status']);
    }
    elseif($pos_2['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_2['status']);

    }

    $time = $pos_2['time'];
    $date = $pos_2['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_2['comments'])){

    $comments = preg_split('/\h+/', $pos_2['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}

//1
if(isset($pos_1['username'])){
  $y = 223;

  $info = get_user_information($db, $pos_1['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_1['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_1['status']);
  }
  else{
    if($pos_1['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_1['status']);
    }
    elseif($pos_1['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_1['status']);

    }

    $time = $pos_1['time'];
    $date = $pos_1['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_1['comments'])){

    $comments = preg_split('/\h+/', $pos_1['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}

//1
if(isset($pos_0['username'])){
  $y = 230;

  $info = get_user_information($db, $pos_0['username']);
  $name = "{$info['rank']} {$info['lastName']}";
  $billet = "{$info['billet']}";

  $template_pdf->SetXY(8,$y);
  $template_pdf->Write(0, "".$name);
  $template_pdf->SetXY(8,$y+3);
  $template_pdf->Write(0, "".$billet);

  if($pos_0['status'] == "PENDING" && $printpending == true){
    $template_pdf->SetXY(44,$y+3);
    $template_pdf->Write(0, "".$pos_0['status']);
  }
  else{
    if($pos_0['status'] == "APPROVED"){
      $template_pdf->SetXY(63,$y+3);
      $template_pdf->Write(0, "".$pos_0['status']);
    }
    elseif($pos_0['status'] == "DENIED"){
      $template_pdf->SetXY(89,$y+3);
      $template_pdf->Write(0, "".$pos_0['status']);

    }

    $time = $pos_0['time'];
    $date = $pos_0['date'];

    $template_pdf->SetXY(44,$y);
    $template_pdf->Write(0, "".$time);

    $template_pdf->SetXY(42,$y+3);
    $template_pdf->Write(0, "".$date);

  }

  if(isset($pos_0['comments'])){

    $comments = preg_split('/\h+/', $pos_0['comments']);
    $x = 105;
    $count = 0;
    $line = "";
    foreach ($comments as $word) {
      if($count + strlen($word) < 70){
        $line .= $word . " ";
        $count += strlen($word);
        $count += 1;
      }
      else{
        $template_pdf->SetXY($x, $y);
        $template_pdf->Write(0, "".$line);
        $y += 2;
        $line = $word . " ";
        $count = strlen($word);
      }
    }

    if(!empty($line)){
      $template_pdf->SetXY($x, $y);
      $template_pdf->Write(0, "".$line);
      $y += 2;
    }

  }

}



$template_pdf->Output("D","Chit.pdf");

?>
