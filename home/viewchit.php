<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Make Chit',
                      'version'    => 1.0,
                      'display'    => 'Make Chit',
                      'tab'        => '',
                      'position'   => 1,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');


  if(isset($_REQUEST['chit'])){
    $_SESSION['chit'] = $_REQUEST['chit'];
  }

  if(!isset($_SESSION['chit'])){
    // sleep(5);
    header("Location: home.php");
    die;
  }


//print_r($chit);
//print_r($comments);




  if(isset($_REQUEST['approve'])){

    $chit = get_chit_information($db, $_SESSION['chit']);
    $who = USER['user'];

    if($chit['coc_0_username'] == USER['user']){ //dant
      $who = "coc_0";
    }
    elseif($chit['coc_1_username'] == USER['user']){ //depdant
      $who = "coc_1";
    }
    elseif($chit['coc_2_username'] == USER['user']){ //batt o
      $who = "coc_2";
    }
    elseif($chit['coc_3_username'] == USER['user']){ //co
      $who = "coc_3";
    }
    elseif($chit['coc_4_username'] == USER['user']){ //sel
      $who = "coc_4";
    }
    elseif($chit['coc_5_username'] == USER['user']){
      $who = "coc_5";
    }
    elseif($chit['coc_6_username'] == USER['user']){
      $who = "coc_6";
    }
    elseif($chit['coc_7_username'] == USER['user']){
      $who = "coc_7";
    }
    elseif($chit['coc_8_username'] == USER['user']){
      $who = "coc_8";
    }

    // echo "$who";

    $today = date("dMy");
    $today = strtoupper($today);
    $now = date("Hi");
    $chit = $_SESSION['chit'];

    action($db, $chit, $who, "APPROVED", $today, $now);


    //redirect
    header("Location: ./viewchit.php");
    die;
  }
  elseif (isset($_REQUEST['disapprove'])) {

    $chit = get_chit_information($db, $_SESSION['chit']);
    $who = USER['user'];

    if($chit['coc_0_username'] == USER['user']){
      $who = "coc_0";
    }
    elseif($chit['coc_1_username'] == USER['user']){
      $who = "coc_1";
    }
    elseif($chit['coc_2_username'] == USER['user']){ // batt o
      $who = "coc_2";
    }
    elseif($chit['coc_3_username'] == USER['user']){ // co
      $who = "coc_3";
    }
    elseif($chit['coc_4_username'] == USER['user']){ // sel
      $who = "coc_4";
    }
    elseif($chit['coc_5_username'] == USER['user']){
      $who = "coc_5";
    }
    elseif($chit['coc_6_username'] == USER['user']){
      $who = "coc_6";
    }
    elseif($chit['coc_7_username'] == USER['user']){
      $who = "coc_7";
    }
    elseif($chit['coc_8_username'] == USER['user']){
      $who = "coc_8";
    }

    $aggregate = "'".$who."_username'";
    $coc_email = get_user_information($db, $chit[$aggregate]);
    $to = "m194020@usna.edu";                     // CREATOR OF THE CHIT, WILL SEND EMAIL TO THEM
     //{$chit['creator']} this is who it should send to eventually
    $subject = "Your chit has been disapproved."; // SUBJECT OF THE EMAIL

    $txt = "Disapproved by {$coc_email['rank']} {$coc_email['firstName']} {$coc_email['lastName']}, {$coc_email['service']}
          \nLog in at midn.cs.usna.edu/project-echits to review the chit. \n";

    $headers = "From: eChits@noreply.edu" . "\r\n"; // IT WILL SEND FROM THIS ADDRESS

    //  $headers = "From: eChits@noreply.edu" . "\r\n" . // IT WILL SEND FROM THIS ADDRESS
    //  "CC: m194020@usna.edu"; // THIS IS FOR FUTURE USE

    sendemail($to,$subject,$txt,$headers); // ACTUALLY SENDS EMAIL


    $today = date("dMy");
    $today = strtoupper($today);
    $now = date("Hi");
    $chit = $_SESSION['chit'];

    action($db, $chit, $who, "DISAPPROVED", $today, $now);

    //redirect
    header("Location: ./viewchit.php");
    die;
  }
  elseif (isset($_REQUEST['pending'])) {

    $chit = get_chit_information($db, $_SESSION['chit']);
    $who = USER['user'];

    if($chit['coc_0_username'] == USER['user']){
      $who = "coc_0";
    }
    elseif($chit['coc_1_username'] == USER['user']){
      $who = "coc_1";
    }
    elseif($chit['coc_2_username'] == USER['user']){
      $who = "coc_2";
    }
    elseif($chit['coc_3_username'] == USER['user']){
      $who = "coc_3";
    }
    elseif($chit['coc_4_username'] == USER['user']){
      $who = "coc_4";
    }
    elseif($chit['coc_5_username'] == USER['user']){
      $who = "coc_5";
    }
    elseif($chit['coc_6_username'] == USER['user']){
      $who = "coc_6";
    }
    elseif($chit['coc_7_username'] == USER['user']){
      $who = "coc_7";
    }
    elseif($chit['coc_8_username'] == USER['user']){
      $who = "coc_8";
    }


    $today = date("dMy");
    $today = strtoupper($today);
    $now = date("Hi");
    $chit = $_SESSION['chit'];

    action($db, $chit, $who, "PENDING", $today, $now);

    //redirect
    header("Location: ./viewchit.php");
    die;
  }
  elseif (isset($_REQUEST['comments'])) {

    $chit = get_chit_information($db, $_SESSION['chit']);
    $who = USER['user'];

    if($chit['coc_0_username'] == USER['user']){
      $who = "coc_0";
    }
    elseif($chit['coc_1_username'] == USER['user']){
      $who = "coc_1";
    }
    elseif($chit['coc_2_username'] == USER['user']){
      $who = "coc_2";
    }
    elseif($chit['coc_3_username'] == USER['user']){
      $who = "coc_3";
    }
    elseif($chit['coc_4_username'] == USER['user']){
      $who = "coc_4";
    }
    elseif($chit['coc_5_username'] == USER['user']){
      $who = "coc_5";
    }
    elseif($chit['coc_6_username'] == USER['user']){
      $who = "coc_6";
    }
    elseif($chit['coc_7_username'] == USER['user']){
      $who = "coc_7";
    }
    elseif($chit['coc_8_username'] == USER['user']){
      $who = "coc_8";
    }

    $chit = $_SESSION['chit'];
    $comments = addslashes($_POST['comments']);

    //error_log("test error");

    comment($db, $chit, $who, $comments);
    //redirect
    header("Location: ./viewchit.php");
    die;
  }
  elseif (isset($_REQUEST['print'])) {

    header("Location: generate_pdf.php");
    die;
  }
  elseif (isset($_REQUEST['archive'])) {

    $chit = $_REQUEST['archive'];

    archive_chit($db, $chit);

    unset($_SESSION['chit']);

    //redirect
    if(isset($_SERVER['HTTP_REFERER'])){
      if(strpos($_SERVER['HTTP_REFERER'], "viewchit.php")){
        header("Location: ./index.php");
      }
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");

    die;
  }
  elseif (isset($_REQUEST['restore'])) {

    $chit = $_REQUEST['chit'];

    restore_chit($db, $chit);

    //redirect
    $_SESSION['success'] = "Chit successfully restored!";
    header("Location: {$_SERVER['HTTP_REFERER']}");


    die;
  }


  # Load in The NavBar
  require_once(WEB_PATH.'navbar.php');


  $_SESSION['submitted']=0;
  ?>

    <script type="text/javascript">
    function redirect(location){
      window.location = location;
    }
    </script>


    <style>
    .box {
      padding: 0;
      border: 1px solid #000000 !important;
      margin: 0;
    }

    #courier {
      font-family: "Courier New", Courier, monospace;
    }

    </style>

<div class="container" id="courier">


  <div id="banner">

  </div>

<?php

if(isset($_SESSION['error'])) {
  echo "<div class=\"alert alert-danger\">".$_SESSION['error']."</div>";
  unset($_SESSION['error']);
}

// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";

if(isset($_REQUEST['chit'])){
	$_SESSION['chit'] = $_REQUEST['chit'];
	$chit = get_chit_information($db, $_REQUEST['chit']);
}
else{
	$chit = get_chit_information($db, $_SESSION['chit']);
}

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


$is_archived = is_archived($db, $_SESSION['chit']);
$is_midshipman = is_midshipman($db, USER['user']);

if($is_archived){
  echo "<div class=\"alert alert-warning\">This chit is archived! In order for this chit to be acted upon, it must be restored.</div>";
}
elseif(isset($_SESSION['success'])){
  echo "<div class=\"alert alert-success\">{$_SESSION['success']}</div>";
  unset($_SESSION['success']);
}


?>
<div class="row" style="border: 1px solid #000000">
  <div class="col-sm-12">



    <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000;">
      <div class="col-sm-12">
        <strong>Special Request (Midshipman)</strong>
        <?php if(isset($chit['description'])){echo "&nbsp&nbsp{$chit['description']}";}?>
    </div>
  </div>


  <div class="row" style="border-bottom:1px solid #000000;">

    <div class="col-sm-6" style="border-left: 1px solid #000000; border-top: 1px solid #000000; ">
      <div class="row">
        <div class="col-sm-1">
          To:
        </div>


        <div class="col-sm-11">
          <?php
          if(isset($chit['coc_0_username'])){
            $coc_0 = get_user_information($db, $chit['coc_0_username']);
            echo "{$coc_0['rank']} {$coc_0['firstName']} {$coc_0['lastName']}, {$coc_0['service']}";
          }
          elseif(isset($chit['coc_1_username'])){
            $coc_1 = get_user_information($db, $chit['coc_1_username']);
            echo "{$coc_1['rank']} {$coc_1['firstName']} {$coc_1['lastName']}, {$coc_1['service']}";
          }
          elseif(isset($chit['coc_2_username'])){
            $coc_2 = get_user_information($db, $chit['coc_2_username']);
            echo "{$coc_2['rank']} {$coc_2['firstName']} {$coc_2['lastName']}, {$coc_2['service']}";
          }
          elseif(isset($chit['coc_3_username'])){
            $coc_3 = get_user_information($db, $chit['coc_3_username']);
            echo "{$coc_3['rank']} {$coc_3['firstName']} {$coc_3['lastName']}, {$coc_3['service']}";
          }
          elseif(isset($chit['coc_4_username'])){
            $coc_4 = get_user_information($db, $chit['coc_4_username']);
            echo "{$coc_4['rank']} {$coc_4['firstName']} {$coc_4['lastName']}, {$coc_4['service']}";
          }
           ?>
        </div>
        <div class="col-sm-2">
        </div>
      </div>

    </div>

    <div class="col-sm-6" style="border-right: 1px solid #000000; border-top: 1px solid #000000; ">
      <div class="row" style="border-left: 1px solid #000000;">
        <div class="col-sm-9" >
          <div class="row">
            <div class="col-sm-2">
              From:
            </div>
            <div class="col-sm-10">
              <?php
              echo "{$ownerinfo['rank']} {$ownerinfo['firstName']} {$ownerinfo['lastName']}, {$ownerinfo['service']}";
              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-3" style="border-left: 1px solid #000000; ">
          <div class="row">
            <div class="col-sm-12">
              Alpha Number
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <?php
              echo "{$midshipmaninfo['alpha']}";
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
      <div class="col-sm-6" style="border-left: 1px solid #000000;">
        <div class="row"  >
          <div class="col-sm-12">
            VIA:
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            Chain-of-Command
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            <div class="row">

              <div class="col-sm-3" style="border-left: 1px solid #000000;">
                <div class="row">
                  <div class="col-sm-12">
                    Class Year
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?php
                    echo "{$midshipmaninfo['classYear']}";
                     ?>

                   </div>
                 </div>
               </div>
               <div class="col-sm-3" style="border-left: 1px solid #000000;  ">
                <div class="row">
                  <div class="col-sm-12">
                    Company
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?php
                    echo "{$midshipmaninfo['company']}";
                     ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-3" style="border-left: 1px solid #000000; ">
                <div class="row">
                  <div class="col-sm-12">
                    Room Number
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?php
                    echo "{$midshipmaninfo['room']}";
                     ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-3" style="border-left: 1px solid #000000; border-right:1px solid #000000;">
                <div class="row">
                  <div class="col-sm-12">
                    Rank
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?php
                    echo "{$ownerinfo['rank']}";
                     ?>
                  </div>
                </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>


        <div class="row">
          <div class="col-sm-6" style="border-left: 1px solid #000000; border-top:1px solid #000000;">
            <div class="row"  >
              <div class="col-sm-12">
                REF:
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <?php if(isset($chit['reference'])){echo "{$chit['reference']}";}?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">

                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000;">
                    <div class="row">
                      <div class="col-sm-12">
                        SQPR
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <?php
                        echo "{$midshipmaninfo['SQPR']}";
                         ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; ">
                    <div class="row">
                      <div class="col-sm-12">
                        CQPR
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <?php
                        echo "{$midshipmaninfo['CQPR']}";
                         ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000;">
                    <div class="row">
                      <div class="col-sm-12">
                        Perf. Grade
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <?php
                        echo "{$midshipmaninfo['aptitudeGrade']}";
                         ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000;">
                    <div class="row">
                      <div class="col-sm-12">
                        Conduct Grade
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <?php
                        echo "{$midshipmaninfo['conductGrade']}";
                         ?>
                      </div>
                    </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>

<div class="form-check">
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000;">
    <div class="col-sm-6">
      I Respectfully Request (Type):
    </div>
    <div class="col-sm-3">

    </div>
    <div class="col-sm-3">
      (Specify)
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">
    <div class="col-sm-2">
      Weekend Liberty: <?php if(isset($chit['requestType']) && $chit['requestType'] == "W"){echo "&nbsp X";}?>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Dining Out: <?php if(isset($chit['requestType']) && $chit['requestType'] == "D"){echo "&nbsp X";}?>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Leave:  <?php if(isset($chit['requestType']) && $chit['requestType'] == "L"){echo "&nbsp X";}?>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-1">
      Other:  <?php if(isset($chit['requestType']) && $chit['requestType'] == "O"){echo "&nbsp X";}?>
    </div>
    <div class="col-sm-2">
      <?php if(isset($chit['requestOther'])){echo "{$chit['requestOther']}";}?>
    </div>
  </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000;">
    <div class="col-sm-3">
      Address (Care of:)
    </div>
    <div class="col-sm-3">
      (Street, P.O. Box, RFD)
    </div>
    <div class="col-sm-2 text-right">
      (City) (State)
    </div>
    <div class="col-sm-2">
      (Zip Code)
    </div>
    <div class="col-sm-2">
      (Phone)
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">
    <div class="col-sm-3">
      <?php if(isset($chit['addr_careOf'])){echo "{$chit['addr_careOf']}";}?>
    </div>
    <div class="col-sm-3">
      <?php if(isset($chit['addr_street'])){echo "{$chit['addr_street']}";}?>
    </div>


    <div class="col-sm-2 text-right">
      <?php if(isset($chit['addr_city'])){echo "{$chit['addr_city']}, ";}?>
      <?php if(isset($chit['addr_state'])){echo "{$chit['addr_state']}";}?>
    </div>
    <div class="col-sm-2">
      <?php if(isset($chit['addr_zip'])){echo "{$chit['addr_zip']} &nbsp";}?>
    </div>
    <div class="col-sm-2">
      <?php echo "{$midshipmaninfo['phoneNumber']}";?>
    </div>


  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000;">
    <div class="col-md-12">
      <strong>Remarks or Reason</strong>
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000; border-bottom:1px solid #000000;">
    <div class="col-md-12">
      <?php
      // if(isset($chit['remarks'])){
      //   $out = str_split($chit['remarks'], 145);
      //   foreach ($out as $line) {
      //     echo "{$line}<br>";
      //   }
      // }


      if(isset($chit['remarks'])){
        $out = nl2br($chit['remarks']);
        $out = stripcslashes($out);
        echo "$out";
      }

      $len = strlen($chit['remarks']);
      $len = $len / 145;
      $stop = 10 - $len;
      for ($i=0; $i < $stop; $i++) {
        echo "<br>";
      }

      ?>

    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000;">
    <div class="col-md-12">
      <strong>I am not in a duty status on the dates requested.</strong>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="row" style="border-left: 1px solid #000000;">
        <div class="col-sm-9" style="border-top: 1px solid #000000;">
          <div class="row" >
            <div class="col-sm-12">
              Signature (Midshipman)
            </div>
            <div class="col-sm-12">
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000;">
            <div class="col-sm-12">
              Date
            </div>
            <div class="col-sm-12">
              <?php
              if(isset($chit['createdDate'])){
                echo "{$chit['createdDate']}";
              }
               ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row" style="border-right:1px solid #000000; border-top: 1px solid #000000;">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-12">
              Beginning (Time & Date)
              </div>
            <div class="col-sm-12">
              <?php if(isset($chit['startTime'])){echo "{$chit['startTime']}  ";}?>
              <?php if(isset($chit['startDate'])){echo "&nbsp{$chit['startDate']}";}?>

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row" style="border-left: 1px solid #000000;">
            <div class="col-sm-12">
              Ending (Time & Date)
            </div>
            <div class="col-sm-12">

              <?php if(isset($chit['endTime'])){echo "{$chit['endTime']}  ";}?>
              <?php if(isset($chit['endDate'])){echo "&nbsp{$chit['endDate']}";}?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4" style="border-right: 1px solid #000000;">
          <div class="row">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              CHAIN-OF-COMMAND
            </div>
            <div class="col-sm-12">
              <br />
            </div>
          </div>
        </div>
        <div class="col-sm-2" style="border-right: 1px solid #000000;">
          <div class="row" style="text-align: center; ">
            <div class="col-sm-12">
              <br />
            </div>
            <div class="col-sm-12">
              DATE/TIME
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3" >
          <div class="row" style="text-align: center; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <em>CoC's Initials</em>
            </div>
            <div class="col-sm-12">
              RECOMMEND
            </div>
            <div class="col-sm-12">
              YES
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <em>CoC's Initials</em>
            </div>
            <div class="col-sm-12">
              RECOMMEND
            </div>
            <div class="col-sm-12">
              NO
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000;">
      <br>
      <br>
      <strong>Chain of Command Comments:</strong>
    </div>
  </div>

  <?php

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
  if(isset($pos_7['comments']) && !empty($pos_7['comments'])){
    $pos_7['comments'] = stripslashes($pos_7['comments']);
  }
  if(isset($pos_8['comments']) && !empty($pos_8['comments'])){
    $pos_8['comments'] = stripslashes($pos_8['comments']);
  }
  ?>

  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

  <!--  pos_8 -->
  <div class="row" style="border-bottom:1px solid #000000;">
    <div class="col-sm-6">
      <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
        <div class="col-sm-4" style="border-right: 1px solid #000000;">
          <div class="row">
            <div class="col-sm-12" id="pos_8">
              <?php
              if(isset($pos_8['username'])){
                $info = get_user_information($db, $pos_8['username']);

                echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                if(strlen($info['billet']) < 20){
                  echo "<br><br>";
                }
              }
              else {
                echo "<br><br><br>";
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-2" style="border-right: 1px solid #000000;">
          <div class="row" style="text-align: center; ">
            <div class="col-sm-12" id="pos_8_date">
              <?php
              if(isset($pos_8['username'])){
                if($pos_8['status'] == "PENDING"){
                  echo "<br>";
                  echo "<strong>{$pos_8['status']}</strong>";
                  echo "<br>";
                  echo "<br>";
                }
                else{
                  echo "{$pos_8['time']} {$pos_8['date']}<br><br>";
                }
              }
              else {
                echo "<br><br><br>";
              }

              ?>
            </div>

          </div>
        </div>
        <div class="col-sm-3" >
          <div class="row" style="text-align: center; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <?php
              if(isset($pos_8['username'])){
                if(USER['user'] == $pos_8['username']){
                  if($pos_8['status'] == "APPROVED"){
                    echo "<br><strong>{$pos_8['status']}</strong><br><br>";
                  }
                  else{
                    if(!$is_archived){
                      echo "<div class=\"input-group\">";
                      echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                      echo "</div>";
                      echo "<br>";
                    }
                    else{
                      echo "<br><br><br>";
                    }
                  }
                }
                else{
                  if($pos_8['status'] == "APPROVED"){
                    echo "<br><strong>{$pos_8['status']}</strong><br><br>";
                  }
                  else{
                    echo "<br><br><br>";
                  }
                }
              }
              else {
                echo "<br><br><br>";
              }


              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <?php
              if(isset($pos_8['username'])){
                if(USER['user'] == $pos_8['username']){
                  if($pos_8['status'] == "DISAPPROVED"){
                    echo "<br><strong>{$pos_8['status']}</strong><br><br>";
                  }
                  else{
                    if(!$is_archived){
                      echo "<div class=\"input-group\">";
                      echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                      echo "</div>";
                      echo "<br>";
                    }
                    else{
                      echo "<br><br><br>";
                    }
                  }


                }
                else{
                  if($pos_8['status'] == "DISAPPROVED"){
                    echo "<br><strong>{$pos_8['status']}</strong><br><br>";
                  }
                  else{

                  }
                }
              }
              else {
                echo "<br><br><br>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6" style="border-right: 1px solid #000000; ">
      <?php
      if(isset($pos_8)){
        if(USER['user'] == $pos_8['username'] && !$is_archived){
          echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
          echo "<div class=\"input-group\">";


          echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_8['comments']}\">";

          echo "<span class=\"input-group-btn\">";

          echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";
          echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
          echo "</form>";


          echo "</span>";
          echo "</div>";
          echo "<br>";
        }
        else{
          if(isset($pos_8['comments']) && !empty($pos_8['comments'])){
            $out = stripslashes($pos_8['comments']);

            $comments = preg_split('/\s+/', $out);
            $count = 0;
            $line = "";
            $lines = 0;
            foreach($comments as $word){
              if($count + strlen($word) < 70){
                $line .= $word . " ";
                $count += strlen($word);
                $count += 1;
              }
              else{
                echo "$line<br>";
                $line = $word . " ";
                $lines += 1;
                $count = strlen($word) + 1;
              }
            }

            if(!empty($line)){
              echo "$line<br>";
              $lines += 1;
            }

            $stop = 3 - $lines;
            for ($i = 0; $i < $stop ; $i++) {
              echo "<br>";
            }
          }
        }
      }

      ?>
    </div>
  </div>



  <div class="row" style="border-bottom:1px solid #000000;">
    <div class="col-sm-6">

      <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
      <!--  pos_7 -->
      <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
             <div class="col-sm-4" style="border-right: 1px solid #000000;">
               <div class="row">
                 <div class="col-sm-12" id="pos_5">
                   <?php
                   if(isset($pos_7['username'])){
                     $info = get_user_information($db, $pos_7['username']);

                     echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                     if(strlen($info['billet']) < 20){
                       echo "<br><br>";
                     }
                   }
                   else {
                     echo "<br><br><br>";
                   }
                    ?>
                 </div>
               </div>
             </div>
             <div class="col-sm-2" style="border-right: 1px solid #000000;">
               <div class="row" style="text-align: center; ">
                 <div class="col-sm-12" id="pos_5_date">
                   <?php
                   if(isset($pos_7['username'])){
                     if($pos_7['status'] == "PENDING"){
                       echo "<br>";
                       echo "<strong>{$pos_7['status']}</strong>";
                       echo "<br>";
                       echo "<br>";
                     }
                     else{
                       echo "{$pos_7['time']} {$pos_7['date']}<br><br>";
                     }
                   }
                   else {
                     echo "<br><br><br>";
                   }

                    ?>
                 </div>

               </div>
             </div>
             <div class="col-sm-3" >
               <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                 <div class="col-sm-12">
                   <?php
                   if(isset($pos_7['username'])){
                     if(USER['user'] == $pos_7['username']){
                       if($pos_7['status'] == "APPROVED"){
                         echo "<br><strong>{$pos_7['status']}</strong><br><br>";
                       }
                       else{
                         if(!$is_archived){

                         echo "<div class=\"input-group\">";
                         echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                         echo "</div>";
                         echo "<br>";
                       }
                       else{
                         echo "<br><br><br>";
                       }
                       }
                     }
                     else{
                       if($pos_7['status'] == "APPROVED"){
                         echo "<br><strong>{$pos_7['status']}</strong><br><br>";
                       }
                       else{
                         echo "<br><br><br>";
                       }
                     }
                   }
                   else {
                     echo "<br><br><br>";
                   }


                    ?>
                 </div>
               </div>
             </div>
             <div class="col-sm-3">
               <div class="row" style="text-align: center;">
                 <div class="col-sm-12">
                   <?php
                   if(isset($pos_7['username'])){
                     if(USER['user'] == $pos_7['username']){
                       if($pos_7['status'] == "DISAPPROVED"){
                         echo "<br><strong>{$pos_7['status']}</strong><br><br>";
                       }
                       else{
                         if(!$is_archived){
                         echo "<div class=\"input-group\">";
                       echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                         echo "</div>";
                         echo "<br>";
                       }
                       else{
                         echo "<br><br><br>";
                       }
                     }


                     }
                     else{
                       if($pos_7['status'] == "DISAPPROVED"){
                         echo "<br><strong>{$pos_7['status']}</strong><br><br>";
                       }
                       else{

                       }
                     }
                   }
                   else {
                     echo "<br><br><br>";
                   }
                   ?>
                 </div>
               </div>
             </div>
           </div>
         </div>
         <div class="col-sm-6" style="border-right: 1px solid #000000; ">
           <?php
           if(isset($pos_7['username'])){
             if(USER['user'] == $pos_7['username'] && !$is_archived){
               echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
               echo "<div class=\"input-group\">";


               echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_7['comments']}\">";

               echo "<span class=\"input-group-btn\">";

               echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

               echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
               echo "</form>";

               echo "</span>";
               echo "</div>";
               echo "<br>";
             }
             else{
               if(isset($pos_7['comments']) && !empty($pos_7['comments'])){
                 $out = stripslashes($pos_7['comments']);

                 $comments = preg_split('/\s+/', $out);
                 $count = 0;
                 $line = "";
                 $lines = 0;
                 foreach($comments as $word){
                   if($count + strlen($word) < 70){
                     $line .= $word . " ";
                     $count += strlen($word);
                     $count += 1;
                   }
                   else{
                     echo "$line<br>";
                     $line = $word . " ";
                     $lines += 1;
                     $count = strlen($word) + 1;
                   }
                 }

                 if(!empty($line)){
                   echo "$line<br>";
                   $lines += 1;
                 }

                 $stop = 3 - $lines;
                 for ($i = 0; $i < $stop ; $i++) {
                   echo "<br>";
                 }
               }
             }
           }

            ?>
         </div>
       </div>



       <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

       <!--  pos_6 -->
       <div class="row" style="border-bottom:1px solid #000000;">
        <div class="col-sm-6">
          <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
            <div class="col-sm-4" style="border-right: 1px solid #000000;">
              <div class="row">
                <div class="col-sm-12" id="pos_4">
                  <?php
                  if(isset($pos_6['username'])){
                    $info = get_user_information($db, $pos_6['username']);

                    echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                    if(strlen($info['billet']) < 20){
                      echo "<br><br>";
                    }
                  }
                  else {
                    echo "<br><br><br>";
                  }
                   ?>
                </div>
              </div>
            </div>
            <div class="col-sm-2" style="border-right: 1px solid #000000;">
              <div class="row" style="text-align: center; ">
                <div class="col-sm-12" id="pos_4_date">
                  <?php
                  if(isset($pos_6['username'])){
                    if($pos_6['status'] == "PENDING"){
                      echo "<br>";
                      echo "<strong>{$pos_6['status']}</strong>";
                      echo "<br>";
                      echo "<br>";
                    }
                    else{
                      echo "{$pos_6['time']} {$pos_6['date']}<br><br>";
                    }
                  }
                  else {
                    echo "<br><br><br>";
                  }

                   ?>
                </div>

              </div>
            </div>
            <div class="col-sm-3" >
              <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                <div class="col-sm-12">
                  <?php
                  if(isset($pos_6['username'])){
                    if(USER['user'] == $pos_6['username']){
                      if($pos_6['status'] == "APPROVED"){
                        echo "<br><strong>{$pos_6['status']}</strong><br><br>";
                      }
                      else{
                        if(!$is_archived){

                        echo "<div class=\"input-group\">";
                        echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                        echo "</div>";
                        echo "<br>";
                      }
                      else{
                        echo "<br><br><br>";
                      }
                      }
                    }
                    else{
                      if($pos_6['status'] == "APPROVED"){
                        echo "<br><strong>{$pos_6['status']}</strong><br><br>";
                      }
                      else{
                        echo "<br><br><br>";
                      }
                    }
                  }
                  else {
                    echo "<br><br><br>";
                  }


                   ?>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="row" style="text-align: center;">
                <div class="col-sm-12">
                  <?php
                  if(isset($pos_6['username'])){
                    if(USER['user'] == $pos_6['username']){
                      if($pos_6['status'] == "DISAPPROVED"){
                        echo "<br><strong>{$pos_6['status']}</strong><br><br>";
                      }
                      else{
                        if(!$is_archived){

                        echo "<div class=\"input-group\">";
                      echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                        echo "</div>";
                        echo "<br>";
                      }
                      else{
                        echo "<br><br><br>";
                      }
                    }

                    }
                    else{
                      if($pos_6['status'] == "DISAPPROVED"){
                        echo "<br><strong>{$pos_6['status']}</strong><br><br>";
                      }
                      else{

                      }
                    }
                  }
                  else {
                    echo "<br><br><br>";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6" style="border-right: 1px solid #000000; ">
          <?php
          if(isset($pos_6['username'])){
            if(USER['user'] == $pos_6['username'] && !$is_archived){
              echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
              echo "<div class=\"input-group\">";


              echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_6['comments']}\">";

              echo "<span class=\"input-group-btn\">";

              echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

              echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
              echo "</form>";

              echo "</span>";
              echo "</div>";
              echo "<br>";
            }
            else{
              if(isset($pos_6['comments']) && !empty($pos_6['comments'])){
                $out = stripslashes($pos_6['comments']);
                $comments = preg_split('/\s+/', $out);
                $count = 0;
                $line = "";
                $lines = 0;
                foreach($comments as $word){
                  if($count + strlen($word) < 70){
                    $line .= $word . " ";
                    $count += strlen($word);
                    $count += 1;
                  }
                  else{
                    echo "$line<br>";
                    $line = $word . " ";
                    $lines += 1;
                    $count = strlen($word) + 1;
                  }
                }

                if(!empty($line)){
                  echo "$line<br>";
                  $lines += 1;
                }

                $stop = 3 - $lines;
                for ($i = 0; $i < $stop ; $i++) {
                  echo "<br>";
                }
              }
            }
          }

           ?>
        </div></div>

        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!--  pos_5 -->
        <div class="row" style="border-bottom:1px solid #000000;">
          <div class="col-sm-6">
            <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
              <div class="col-sm-4" style="border-right: 1px solid #000000;">
                <div class="row">
                  <div class="col-sm-12" id="pos_5">
                    <?php
                    if(isset($pos_5['username'])){
                      $info = get_user_information($db, $pos_5['username']);

                      echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                      if(strlen($info['billet']) < 20){
                        echo "<br><br>";
                      }
                    }
                    else {
                      echo "<br><br><br>";
                    }
                     ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2" style="border-right: 1px solid #000000;">
                <div class="row" style="text-align: center; ">
                  <div class="col-sm-12" id="pos_5_date">
                    <?php
                    if(isset($pos_5['username'])){
                      if($pos_5['status'] == "PENDING"){
                        echo "<br>";
                        echo "<strong>{$pos_5['status']}</strong>";
                        echo "<br>";
                        echo "<br>";
                      }
                      else{
                        echo "{$pos_5['time']} {$pos_5['date']}<br><br>";
                      }
                    }
                    else {
                      echo "<br><br><br>";
                    }

                     ?>
                  </div>

                </div>
              </div>
              <div class="col-sm-3" >
                <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                  <div class="col-sm-12">
                    <?php
                    if(isset($pos_5['username'])){
                      if(USER['user'] == $pos_5['username']){
                        if($pos_5['status'] == "APPROVED"){
                          echo "<br><strong>{$pos_5['status']}</strong><br><br>";
                        }
                        else{
                          if(!$is_archived){

                          echo "<div class=\"input-group\">";
                          echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                          echo "</div>";
                          echo "<br>";
                        }
                        else{
                          echo "<br><br><br>";
                        }
                        }
                      }
                      else{
                        if($pos_5['status'] == "APPROVED"){
                          echo "<br><strong>{$pos_5['status']}</strong><br><br>";
                        }
                        else{
                          echo "<br><br><br>";
                        }
                      }
                    }
                    else {
                      echo "<br><br><br>";
                    }


                     ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="row" style="text-align: center;">
                  <div class="col-sm-12">
                    <?php
                    if(isset($pos_5['username'])){
                      if(USER['user'] == $pos_5['username']){
                        if($pos_5['status'] == "DISAPPROVED"){
                          echo "<br><strong>{$pos_5['status']}</strong><br><br>";
                        }
                        else{
                          if(!$is_archived){

                            echo "<div class=\"input-group\">";
                          echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                            echo "</div>";
                            echo "<br>";
                          }
                          else{
                            echo "<br><br><br>";
                          }
                        }

                      }
                      else{
                        if($pos_5['status'] == "DISAPPROVED"){
                          echo "<br><strong>{$pos_5['status']}</strong><br><br>";
                        }
                        else{

                        }
                      }
                    }
                    else {
                      echo "<br><br><br>";
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6" style="border-right: 1px solid #000000; ">
            <?php
            if(isset($pos_5['username'])){
              if(USER['user'] == $pos_5['username'] && !$is_archived){
                echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                echo "<div class=\"input-group\">";


                echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_5['comments']}\">";

                echo "<span class=\"input-group-btn\">";

                echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                echo "</form>";

                echo "</span>";
                echo "</div>";
                echo "<br>";
              }
              else{
                if(isset($pos_5['comments']) && !empty($pos_5['comments'])){
                  $out = stripslashes($pos_5['comments']);
                  $comments = preg_split('/\s+/', $out);
                  $count = 0;
                  $line = "";
                  $lines = 0;
                  foreach($comments as $word){
                    if($count + strlen($word) < 70){
                      $line .= $word . " ";
                      $count += strlen($word);
                      $count += 1;
                    }
                    else{
                      echo "$line<br>";
                      $line = $word . " ";
                      $lines += 1;
                      $count = strlen($word) + 1;
                    }
                  }

                  if(!empty($line)){
                    echo "$line<br>";
                    $lines += 1;
                  }

                  $stop = 3 - $lines;
                  for ($i = 0; $i < $stop ; $i++) {
                    echo "<br>";
                  }
                }
              }
            }

             ?>
          </div>
        </div>
      </div>

      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-4" >
                <div class="row" style="border-right: 1px solid #000000;">
                  <div class="col-sm-12">
                    <br />
                  </div>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                  <div class="col-sm-12">
                    DATE/TIME
                  </div>

                </div>
              </div>
              <div class="col-sm-3">
                <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                  <div class="col-sm-12">
                    APPROVED
                  </div>
                </div>
              </div>
              <div class="col-sm-3" style="text-align: center; border-right: 1px solid #000000; ">
                <div class="row" >
                  <div class="col-sm-12" >
                    DISAPPROVED
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
          </div>
        </div>


        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

        <!--  pos_4 -->
        <div class="row" style="border-bottom:1px solid #000000;">
            <div class="col-sm-6">
              <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
                <div class="col-sm-4" style="border-right: 1px solid #000000;">
                  <div class="row">
                    <div class="col-sm-12" id="pos_4">
                      <?php
                      if(isset($pos_4['username'])){
                        $info = get_user_information($db, $pos_4['username']);

                        echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                        if(strlen($info['billet']) < 20){
                          echo "<br><br>";
                        }
                      }
                      else {
                        echo "<br><br><br>";
                      }
                       ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2" style="border-right: 1px solid #000000;">
                  <div class="row" style="text-align: center; ">
                    <div class="col-sm-12" id="pos_4_date">
                      <?php
                      if(isset($pos_4['username'])){
                        if($pos_4['status'] == "PENDING"){
                          echo "<br>";
                          echo "<strong>{$pos_4['status']}</strong>";
                          echo "<br>";
                          echo "<br>";
                        }
                        else{
                          echo "{$pos_4['time']} {$pos_4['date']}<br><br>";
                        }
                      }
                      else {
                        echo "<br><br><br>";
                      }

                       ?>
                    </div>

                  </div>
                </div>
                <div class="col-sm-3" >
                  <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                    <div class="col-sm-12">
                      <?php
                      if(isset($pos_4['username'])){
                        if(USER['user'] == $pos_4['username']){
                          if($pos_4['status'] == "APPROVED"){
                            echo "<br><strong>{$pos_4['status']}</strong><br><br>";
                          }
                          else{
                            if(!$is_archived){

                            echo "<div class=\"input-group\">";
                            echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                            echo "</div>";
                            echo "<br>";
                          }
                          else{
                            echo "<br><br><br>";
                          }
                          }
                        }
                        else{
                          if($pos_4['status'] == "APPROVED"){
                            echo "<br><strong>{$pos_4['status']}</strong><br><br>";
                          }
                          else{
                            echo "<br><br><br>";
                          }
                        }
                      }
                      else {
                        echo "<br><br><br>";
                      }


                       ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="row" style="text-align: center;">
                    <div class="col-sm-12">
                      <?php
                      if(isset($pos_4['username'])){
                        if(USER['user'] == $pos_4['username']){
                          if($pos_4['status'] == "DISAPPROVED"){
                            echo "<br><strong>{$pos_4['status']}</strong><br><br>";
                          }
                          else{
                            if(!$is_archived){

                            echo "<div class=\"input-group\">";
                          echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                            echo "</div>";
                            echo "<br>";
                          }
                          else{
                            echo "<br><br><br>";
                          }
                          }


                        }
                        else{
                          if($pos_4['status'] == "DISAPPROVED"){
                            echo "<br><strong>{$pos_4['status']}</strong><br><br>";
                          }
                          else{

                          }
                        }
                      }
                      else {
                        echo "<br><br><br>";
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6" style="border-right: 1px solid #000000; ">
              <?php
              if(isset($pos_4['username'])){
                if(USER['user'] == $pos_4['username'] && !$is_archived){
                  echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                  echo "<div class=\"input-group\">";


                  echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_4['comments']}\">";

                  echo "<span class=\"input-group-btn\">";

                  echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                  echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                  echo "</form>";

                  echo "</span>";
                  echo "</div>";
                  echo "<br>";
                }
                else{
                  if(isset($pos_4['comments']) && !empty($pos_4['comments'])){
                    $out = stripslashes($pos_4['comments']);
                    $comments = preg_split('/\s+/', $out);
                    $count = 0;
                    $line = "";
                    $lines = 0;
                    foreach($comments as $word){
                      if($count + strlen($word) < 70){
                        $line .= $word . " ";
                        $count += strlen($word);
                        $count += 1;
                      }
                      else{
                        echo "$line<br>";
                        $line = $word . " ";
                        $lines += 1;
                        $count = strlen($word) + 1;
                      }
                    }

                    if(!empty($line)){
                      echo "$line<br>";
                      $lines += 1;
                    }

                    $stop = 3 - $lines;
                    for ($i = 0; $i < $stop ; $i++) {
                      echo "<br>";
                    }
                  }
                }
              }

               ?>
            </div>
          </div>


          <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

          <!--  pos_3 -->
          <div class="row" style="border-bottom:1px solid #000000;">
              <div class="col-sm-6">
                <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
                  <div class="col-sm-4" style="border-right: 1px solid #000000;">
                    <div class="row">
                      <div class="col-sm-12" id="pos_3">
                        <?php
                        if(isset($pos_3['username'])){
                          $info = get_user_information($db, $pos_3['username']);

                          echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                          if(strlen($info['billet']) < 20){
                            echo "<br><br>";
                          }
                        }
                        else {
                          echo "<br><br><br>";
                        }
                         ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2" style="border-right: 1px solid #000000;">
                    <div class="row" style="text-align: center; ">
                      <div class="col-sm-12" id="pos_3_date">
                        <?php
                        if(isset($pos_3['username'])){
                          if($pos_3['status'] == "PENDING"){
                            echo "<br>";
                            echo "<strong>{$pos_3['status']}</strong>";
                            echo "<br>";
                            echo "<br>";
                          }
                          else{
                            echo "{$pos_3['time']} {$pos_3['date']}<br><br>";
                          }
                        }
                        else {
                          echo "<br><br><br>";
                        }

                         ?>
                      </div>

                    </div>
                  </div>
                  <div class="col-sm-3" >
                    <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                      <div class="col-sm-12">
                        <?php
                        if(isset($pos_3['username'])){
                          if(USER['user'] == $pos_3['username']){
                            if($pos_3['status'] == "APPROVED"){
                              echo "<br><strong>{$pos_3['status']}</strong><br><br>";
                            }
                            else{
                              if(!$is_archived){

                              echo "<div class=\"input-group\">";
                              echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                              echo "</div>";
                              echo "<br>";
                            }
                            else{
                              echo "<br><br><br>";
                            }
                          }
                          }
                          else{
                            if($pos_3['status'] == "APPROVED"){
                              echo "<br><strong>{$pos_3['status']}</strong><br><br>";
                            }
                            else{
                              echo "<br><br><br>";
                            }
                          }
                        }
                        else {
                          echo "<br><br><br>";
                        }


                         ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="row" style="text-align: center;">
                      <div class="col-sm-12">
                        <?php
                        if(isset($pos_3['username'])){
                          if(USER['user'] == $pos_3['username']){
                            if($pos_3['status'] == "DISAPPROVED"){
                              echo "<br><strong>{$pos_3['status']}</strong><br><br>";
                            }
                            else{
                              if(!$is_archived){

                              echo "<div class=\"input-group\">";
                            echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                              echo "</div>";
                              echo "<br>";
                            }
                            else{
                              echo "<br><br><br>";
                            }
                          }

                          }
                          else{
                            if($pos_3['status'] == "DISAPPROVED"){
                              echo "<br><strong>{$pos_3['status']}</strong><br><br>";
                            }
                            else{

                            }
                          }
                        }
                        else {
                          echo "<br><br><br>";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6" style="border-right: 1px solid #000000; ">
                <?php
                if(isset($pos_3['username'])){
                  if(USER['user'] == $pos_3['username'] && !$is_archived){
                    echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                    echo "<div class=\"input-group\">";


                    echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_3['comments']}\">";

                    echo "<span class=\"input-group-btn\">";

                    echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                    echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                    echo "</form>";

                    echo "</span>";
                    echo "</div>";
                    echo "<br>";
                  }
                  else{
                    if(isset($pos_3['comments']) && !empty($pos_3['comments'])){
                      $out = stripslashes($pos_3['comments']);
                      $comments = preg_split('/\s+/', $out);
                      $count = 0;
                      $line = "";
                      $lines = 0;
                      foreach($comments as $word){
                        if($count + strlen($word) < 70){
                          $line .= $word . " ";
                          $count += strlen($word);
                          $count += 1;
                        }
                        else{
                          echo "$line<br>";
                          $line = $word . " ";
                          $lines += 1;
                          $count = strlen($word) + 1;
                        }
                      }

                      if(!empty($line)){
                        echo "$line<br>";
                        $lines += 1;
                      }

                      $stop = 3 - $lines;
                      for ($i = 0; $i < $stop ; $i++) {
                        echo "<br>";
                      }
                    }
                  }
                }

                 ?>
              </div>
            </div>


            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

            <!--  pos_2 -->
            <div class="row" style="border-bottom:1px solid #000000;">
                <div class="col-sm-6">
                  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
                    <div class="col-sm-4" style="border-right: 1px solid #000000;">
                      <div class="row">
                        <div class="col-sm-12" id="pos_2">
                          <?php
                          if(isset($pos_2['username'])){
                            $info = get_user_information($db, $pos_2['username']);

                            echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                            if(strlen($info['billet']) < 22){
                              echo "<br><br>";
                            }
                          }
                          else {
                            echo "<br><br><br>";
                          }
                           ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2" style="border-right: 1px solid #000000;">
                      <div class="row" style="text-align: center; ">
                        <div class="col-sm-12" id="pos_2_date">
                          <?php
                          if(isset($pos_2['username'])){
                            if($pos_2['status'] == "PENDING"){
                              echo "<br>";
                              echo "<strong>{$pos_2['status']}</strong>";
                              echo "<br>";
                              echo "<br>";
                            }
                            else{
                              echo "{$pos_2['time']} {$pos_2['date']}<br><br>";
                            }
                          }
                          else {
                            echo "<br><br><br>";
                          }

                           ?>
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-3" >
                      <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                        <div class="col-sm-12">
                          <?php
                          if(isset($pos_2['username'])){
                            if(USER['user'] == $pos_2['username']){
                              if($pos_2['status'] == "APPROVED"){
                                echo "<br><strong>{$pos_2['status']}</strong><br><br>";
                              }
                              else{
                                if(!$is_archived){

                                echo "<div class=\"input-group\">";
                                echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                                echo "</div>";
                                echo "<br>";
                              }

                              else{
                                echo "<br><br><br>";
                              }
                              }
                            }
                            else{
                              if($pos_2['status'] == "APPROVED"){
                                echo "<br><strong>{$pos_2['status']}</strong><br><br>";
                              }
                              else{
                                echo "<br><br><br>";
                              }
                            }
                          }
                          else {
                            echo "<br><br><br>";
                          }


                           ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="row" style="text-align: center;">
                        <div class="col-sm-12">
                          <?php
                          if(isset($pos_2['username'])){
                            if(USER['user'] == $pos_2['username']){
                              if($pos_2['status'] == "DISAPPROVED"){
                                echo "<br><strong>{$pos_2['status']}</strong><br><br>";
                              }
                              else{
                                if(!$is_archived){

                                echo "<div class=\"input-group\">";
                              echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                                echo "</div>";
                                echo "<br>";
                              }
                              else{
                                echo "<br><br><br>";
                              }
                            }

                            }
                            else{
                              if($pos_2['status'] == "DISAPPROVED"){
                                echo "<br><strong>{$pos_2['status']}</strong><br><br>";
                              }
                              else{

                              }
                            }
                          }
                          else {
                            echo "<br><br><br>";
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6" style="border-right: 1px solid #000000; ">
                  <?php
                  if(isset($pos_2['username'])){
                    if(USER['user'] == $pos_2['username'] && !$is_archived){
                      echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                      echo "<div class=\"input-group\">";


                      echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_2['comments']}\">";

                      echo "<span class=\"input-group-btn\">";

                      echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                      echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                      echo "</form>";

                      echo "</span>";
                      echo "</div>";
                      echo "<br>";
                    }
                    else{
                      if(isset($pos_2['comments']) && !empty($pos_2['comments'])){
                        $out = stripslashes($pos_2['comments']);
                        $comments = preg_split('/\s+/', $out);
                        $count = 0;
                        $line = "";
                        $lines = 0;
                        foreach($comments as $word){
                          if($count + strlen($word) < 70){
                            $line .= $word . " ";
                            $count += strlen($word);
                            $count += 1;
                          }
                          else{
                            echo "$line<br>";
                            $line = $word . " ";
                            $lines += 1;
                            $count = strlen($word) + 1;
                          }
                        }

                        if(!empty($line)){
                          echo "$line<br>";
                          $lines += 1;
                        }

                        $stop = 3 - $lines;
                        for ($i = 0; $i < $stop ; $i++) {
                          echo "<br>";
                        }
                      }
                    }
                  }

                   ?>
                </div>
              </div>

              <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                <!--  pos_1 -->
                <div class="row" style="border-bottom:1px solid #000000;">
                    <div class="col-sm-6">
                      <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
                        <div class="col-sm-4" style="border-right: 1px solid #000000;">
                          <div class="row">
                            <div class="col-sm-12" id="pos_1">
                              <?php
                              if(isset($pos_1['username'])){
                                $info = get_user_information($db, $pos_1['username']);

                                echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                                if(strlen($info['billet']) < 22){
                                  echo "<br><br>";
                                }
                              }
                              else {
                                echo "<br><br><br>";
                              }
                               ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-2" style="border-right: 1px solid #000000;">
                          <div class="row" style="text-align: center; ">
                            <div class="col-sm-12" id="pos_1_date">
                              <?php
                              if(isset($pos_1['username'])){
                                if($pos_1['status'] == "PENDING"){
                                  echo "<br>";
                                  echo "<strong>{$pos_1['status']}</strong>";
                                  echo "<br>";
                                  echo "<br>";
                                }
                                else{
                                  echo "{$pos_1['time']} {$pos_1['date']}<br><br>";
                                }
                              }
                              else {
                                echo "<br><br><br>";
                              }

                               ?>
                            </div>

                          </div>
                        </div>
                        <div class="col-sm-3" >
                          <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                            <div class="col-sm-12">
                              <?php
                              if(isset($pos_1['username'])){
                                if(USER['user'] == $pos_1['username']){
                                  if($pos_1['status'] == "APPROVED"){
                                    echo "<br><strong>{$pos_1['status']}</strong><br><br>";
                                  }
                                  else{
                                    if(!$is_archived){

                                    echo "<div class=\"input-group\">";
                                    echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                                    echo "</div>";
                                    echo "<br>";
                                  }

                                  else{
                                    echo "<br><br><br>";
                                  }
                                  }
                                }
                                else{
                                  if($pos_1['status'] == "APPROVED"){
                                    echo "<br><strong>{$pos_1['status']}</strong><br><br>";
                                  }
                                  else{
                                    echo "<br><br><br>";
                                  }
                                }
                              }
                              else {
                                echo "<br><br><br>";
                              }


                               ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="row" style="text-align: center;">
                            <div class="col-sm-12">
                              <?php
                              if(isset($pos_1['username'])){
                                if(USER['user'] == $pos_1['username']){
                                  if($pos_1['status'] == "DISAPPROVED"){
                                    echo "<br><strong>{$pos_1['status']}</strong><br><br>";
                                  }
                                  else{
                                    if(!$is_archived){

                                    echo "<div class=\"input-group\">";
                                  echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                                    echo "</div>";
                                    echo "<br>";
                                  }
                                  else{
                                    echo "<br><br><br>";
                                  }
                                }

                                }
                                else{
                                  if($pos_1['status'] == "DISAPPROVED"){
                                    echo "<br><strong>{$pos_1['status']}</strong><br><br>";
                                  }
                                  else{

                                  }
                                }
                              }
                              else {
                                echo "<br><br><br>";
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6" style="border-right: 1px solid #000000; ">
                      <?php
                      if(isset($pos_1['username'])){
                        if(USER['user'] == $pos_1['username'] && !$is_archived){
                          echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                          echo "<div class=\"input-group\">";


                          echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_1['comments']}\">";

                          echo "<span class=\"input-group-btn\">";

                          echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                          echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                          echo "</form>";

                          echo "</span>";
                          echo "</div>";
                          echo "<br>";
                        }
                        else{
                          if(isset($pos_1['comments']) && !empty($pos_1['comments'])){
                            $out = stripslashes($pos_1['comments']);
                            $comments = preg_split('/\s+/', $out);
                            $count = 0;
                            $line = "";
                            $lines = 0;
                            foreach($comments as $word){
                              if($count + strlen($word) < 70){
                                $line .= $word . " ";
                                $count += strlen($word);
                                $count += 1;
                              }
                              else{
                                echo "$line<br>";
                                $line = $word . " ";
                                $lines += 1;
                                $count = strlen($word) + 1;
                              }
                            }

                            if(!empty($line)){
                              echo "$line<br>";
                              $lines += 1;
                            }

                            $stop = 3 - $lines;
                            for ($i = 0; $i < $stop ; $i++) {
                              echo "<br>";
                            }
                          }
                        }
                      }

                       ?>
                    </div>
                  </div>

                  <!--  pos_0 -->
                  <div class="row" style="border-bottom:1px solid #000000;">
                      <div class="col-sm-6">
                        <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; ">
                          <div class="col-sm-4" style="border-right: 1px solid #000000;">
                            <div class="row">
                              <div class="col-sm-12" id="pos_0">
                                <?php
                                if(isset($pos_0['username'])){
                                  $info = get_user_information($db, $pos_0['username']);

                                  echo "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";

                                  if(strlen($info['billet']) < 20){
                                    echo "<br><br>";
                                  }
                                }
                                else {
                                  echo "<br><br><br>";
                                }
                                 ?>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2" style="border-right: 1px solid #000000;">
                            <div class="row" style="text-align: center; ">
                              <div class="col-sm-12" id="pos_0_date">
                                <?php
                                if(isset($pos_0['username'])){
                                  if($pos_0['status'] == "PENDING"){
                                    echo "<br>";
                                    echo "<strong>{$pos_0['status']}</strong>";
                                    echo "<br>";
                                    echo "<br>";
                                  }
                                  else{
                                    echo "{$pos_0['time']} {$pos_0['date']}<br><br>";
                                  }
                                }
                                else {
                                  echo "<br><br><br>";
                                }

                                 ?>
                              </div>

                            </div>
                          </div>
                          <div class="col-sm-3" >
                            <div class="row" style="text-align: center; border-right: 1px solid #000000;">
                              <div class="col-sm-12">
                                <?php
                                if(isset($pos_0['username'])){
                                  if(USER['user'] == $pos_0['username']){
                                    if($pos_0['status'] == "APPROVED"){
                                      echo "<br><strong>{$pos_0['status']}</strong><br><br>";
                                    }
                                    else{
                                      if(!$is_archived){

                                      echo "<div class=\"input-group\">";
                                      echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-success\" type=\"submit\" name=\"approve\" type=\"button\" style=\"margin-top: 6px\" >Approve</button></form></span>";
                                      echo "</div>";
                                      echo "<br>";
                                    }
                                    else{
                                      echo "<br><br><br>";
                                    }
                                  }
                                  }
                                  else{
                                    if($pos_0['status'] == "APPROVED"){
                                      echo "<br><strong>{$pos_0['status']}</strong><br><br>";
                                    }
                                    else{
                                      echo "<br><br><br>";
                                    }
                                  }
                                }
                                else {
                                  echo "<br><br><br>";
                                }


                                 ?>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="row" style="text-align: center;">
                              <div class="col-sm-12">
                                <?php
                                if(isset($pos_0['username'])){
                                  if(USER['user'] == $pos_0['username']){
                                    if($pos_0['status'] == "DISAPPROVED"){
                                      echo "<br><strong>{$pos_0['status']}</strong><br><br>";
                                    }
                                    else{
                                      if(!$is_archived){

                                      echo "<div class=\"input-group\">";
                                    echo "<span class=\"input-group-btn\"><form method=\"post\" action=\"?\"><button class=\"btn btn-danger\" name=\"disapprove\" type=\"submit\" style=\"margin-top: 6px\">Deny</button></form></span>";
                                      echo "</div>";
                                      echo "<br>";
                                    }
                                    else{
                                      echo "<br><br><br>";
                                    }
                                  }

                                  }
                                  else{
                                    if($pos_0['status'] == "DISAPPROVED"){
                                      echo "<br><strong>{$pos_0['status']}</strong><br><br>";
                                    }
                                    else{

                                    }
                                  }
                                }
                                else {
                                  echo "<br><br><br>";
                                }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6" style="border-right: 1px solid #000000; ">
                        <?php
                        if(isset($pos_0['username'])){
                          if(USER['user'] == $pos_0['username'] && !$is_archived){
                            echo "<form action=\"viewchit.php\" method=\"post\" style=\"padding-bottom: 6px;\">";
                            echo "<div class=\"input-group\">";


                            echo "<input name=\"comments\" maxlength=\"200\" class=\"form-control\" type=\"text\" value=\"{$pos_0['comments']}\">";

                            echo "<span class=\"input-group-btn\">";

                            echo "<button class=\"btn btn-primary\" type=\"submit\" >Save Comments</button>";

                            echo "<button class=\"btn btn-default\" type=\"submit\" name=\"pending\">Revert to Pending</button>";
                            echo "</form>";

                            echo "</span>";
                            echo "</div>";
                            echo "<br>";
                          }
                          else{
                            if(isset($pos_0['comments']) && !empty($pos_0['comments'])){
                              $out = stripslashes($pos_0['comments']);
                              $comments = preg_split('/\s+/', $out);
                              $count = 0;
                              $line = "";
                              $lines = 0;
                              foreach($comments as $word){
                                if($count + strlen($word) < 70){
                                  $line .= $word . " ";
                                  $count += strlen($word);
                                  $count += 1;
                                }
                                else{
                                  echo "$line<br>";
                                  $line = $word . " ";
                                  $lines += 1;
                                  $count = strlen($word) + 1;
                                }
                              }

                              if(!empty($line)){
                                echo "$line<br>";
                                $lines += 1;
                              }

                              $stop = 3 - $lines;
                              for ($i = 0; $i < $stop ; $i++) {
                                echo "<br>";
                              }
                            }
                          }
                        }

                         ?>
                      </div>
                    </div>





              <div class="row" style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;">

      <div class="col-sm-12">
        <strong>NDW-USNA-BBA-1050/09 (Rev. 4-92)</strong>
      </div>
    </div>

  </form>

</div>

<div class="row">
  <div class="col-sm-4">
    <?php
    if(isset($chit['ormURL'])){
      echo "<a class=\"btn btn-success\" style=\"margin-right: 15px\" target=\"_blank\"  href=\"{$chit['ormURL']}\">View ORM</a>";
    }

    if(isset($chit['supportingDocsURL'])){
      echo "<a class=\"btn btn-success\" target=\"_blank\" href=\"{$chit['supportingDocsURL']}\">View Supporting Docs</a>";
    }
    ?>
  </div>
  <div class="col-sm-4 text-center">


    <div class="col-xs-4 text-left">
      <div class="previous">

        <?php
        if(!$is_archived && $chit['creator'] == USER['user']){
          echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#editModal\">Edit Chit</button>";
        }

         ?>

      </div>
    </div>
    <div class="col-xs-4 text-center">
      <form action="viewchit.php" method="post">
        <input type="hidden" name="chit" value="<?php echo "{$_SESSION['chit']}"; ?>"/>
        <input type="submit" class="btn btn-default" name="print" value="Print Chit">
      </form>
    </div>
    <div class="col-xs-4 text-right">
      <div class="next">

        <?php
        if($is_archived){
          echo "<form action=\"?\" method=\"post\"><input type=\"hidden\" name=\"chit\" value=\"{$chit['chitNumber']}\" /><input type=\"submit\" class=\"btn btn-primary\" name=\"restore\" value=\"Restore Chit\"></form>";
        }
        else{
          echo "<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal\">Archive Chit</button>";

        }
        ?>

      </div>
    </div>




    <!-- Modal -->
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Are you sure you want to edit this chit?</h4>
            <h5 class="modal-title">Editing will revert all approvals to PENDING</h5>
          </div>
          <div class="modal-footer">

            <div class="col-xs-6 text-left">
              <div class="previous">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
            </div>
            <div class="col-xs-6 text-right">
              <div class="next">

                <form action="editchit.php" method="post">
                  <input type="hidden" value="<?php echo "{$_SESSION['chit']}"; ?>" name="archive">
                  <input type="submit" class="btn btn-primary" value="Edit Chit" />
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



		<!-- Delete Modal -->
		<div id="deleteModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Are you sure you want to archive this chit?</h4>
            <h5 class="modal-title">This action affects all users.</h5>
					</div>
					<div class="modal-footer">

						<div class="col-xs-6 text-left">
							<div class="previous">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<div class="next">
                <form action="?" method="post">
                <input type="hidden" name="archive" value="<?php echo "{$chit['chitNumber']}"; ?>"/>
                <input type="submit" class="btn btn-danger" value="Archive">
              </form>
							</div>
						</div>


					</div>
				</div>

			</div>
		</div>

  </div>
  <div class="col-sm-4">
  </div>

</div>

</body>
</html>
