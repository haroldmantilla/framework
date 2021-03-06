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

  ################################################################
  #                  Commented on 29DEC18 by                     #
  #                       Harold Mantilla                        #
  ################################################################

  ################################################################
  #                     page to edit chits                       #
  ################################################################

  ################################################################
  #                       Repetitive Page                        #
  #              Could be streamlined using functions            #
  ################################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

// if chit doesn't exist send the user back home
  if(!isset($_SESSION['chit'])){
    header("Location: home.php");
    die;
  }

// chit has not been submitted
  $_SESSION['submitted']=0;

// make chit array from the chit stored in the database
  $chit = get_chit_information($db, $_SESSION['chit']);
// grab chit creator info from the db using the creator's alpha
  $midshipmaninfo = get_midshipman_information($db, $chit['creator']);
//grabs user's information from Leader table
  $ownerinfo = get_user_information($db, $chit['creator']);

// make sure that only the creator can edit their chit
  if(USER['user'] != $chit['creator']){
    header("Location: ./viewchit.php");
  }

//unquote strings and set variables
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

//if post is set, write to database, redirect to viewchit
if(
    isset($_POST['SHORT_DESCRIPTION']) && isset($_POST['TO_USERNAME']) && isset($_POST['REFERENCE']) && isset($_POST['REQUEST_TYPE']) && isset($_POST['ADDRESS_CITY']) && isset($_POST['ADDRESS_2']) && isset($_POST['ADDRESS_STATE']) && isset($_POST['ADDRESS_ZIP']) && isset($_POST['REMARKS']) && isset($_POST['BEGIN_DATE']) && isset($_POST['BEGIN_TIME']) && isset($_POST['END_DATE']) && isset($_POST['END_TIME'])){

      $_POST['SHORT_DESCRIPTION'] = addslashes($_POST['SHORT_DESCRIPTION']);
      $_POST['REFERENCE'] = addslashes($_POST['REFERENCE']);
      $_POST['ADDRESS_CITY'] = addslashes($_POST['ADDRESS_CITY']);
      $_POST['ADDRESS_2'] = addslashes($_POST['ADDRESS_2']);
      $_POST['ADDRESS_STATE'] = addslashes($_POST['ADDRESS_STATE']);
      $_POST['ADDRESS_ZIP'] = addslashes($_POST['ADDRESS_ZIP']);
      $_POST['REMARKS'] = addslashes($_POST['REMARKS']);
      $_POST['BEGIN_DATE'] = addslashes($_POST['BEGIN_DATE']);
      $_POST['BEGIN_TIME'] = addslashes($_POST['BEGIN_TIME']);
      $_POST['END_DATE'] = addslashes($_POST['END_DATE']);
      $_POST['END_TIME'] = addslashes($_POST['END_TIME']);

      $chitnumber = $chit['chitNumber'];

      $date = $chit['createdDate'];

      // fix this section with a function instead of copy/pasting
      if($_POST['TO_USERNAME'] == $midshipmaninfo['coc_0']){
        $coc_0 = $midshipmaninfo['coc_0'];
        $coc_1 = $midshipmaninfo['coc_1'];
        $coc_2 = $midshipmaninfo['coc_2'];
        $coc_3 = $midshipmaninfo['coc_3'];
        $coc_4 = $midshipmaninfo['coc_4'];
        $coc_5 = $midshipmaninfo['coc_5'];
        $coc_6 = $midshipmaninfo['coc_6'];
        $coc_7 = $midshipmaninfo['coc_7'];
        $coc_8 = $midshipmaninfo['coc_8'];
      }
      // fix this section with a function instead of copy/pasting
      elseif($_POST['TO_USERNAME'] == $midshipmaninfo['coc_1']){
        $coc_0 = null;
        $coc_1 = $midshipmaninfo['coc_1'];
        $coc_2 = $midshipmaninfo['coc_2'];
        $coc_3 = $midshipmaninfo['coc_3'];
        $coc_4 = $midshipmaninfo['coc_4'];
        $coc_5 = $midshipmaninfo['coc_5'];
        $coc_6 = $midshipmaninfo['coc_6'];
        $coc_7 = $midshipmaninfo['coc_7'];
        $coc_8 = $midshipmaninfo['coc_8'];
      }
      // fix this section with a function instead of copy/pasting
      elseif($_POST['TO_USERNAME'] == $midshipmaninfo['coc_2']){
        $coc_0 = null;
        $coc_1 = null;
        $coc_2 = $midshipmaninfo['coc_2'];
        $coc_3 = $midshipmaninfo['coc_3'];
        $coc_4 = $midshipmaninfo['coc_4'];
        $coc_5 = $midshipmaninfo['coc_5'];
        $coc_6 = $midshipmaninfo['coc_6'];
        $coc_7 = $midshipmaninfo['coc_7'];
        $coc_8 = $midshipmaninfo['coc_8'];
      }
      // fix this section with a function instead of copy/pasting
      elseif($_POST['TO_USERNAME'] == $midshipmaninfo['coc_3']){
        $coc_0 = null;
        $coc_1 = null;
        $coc_2 = null;
        $coc_3 = $midshipmaninfo['coc_3'];
        $coc_4 = $midshipmaninfo['coc_4'];
        $coc_5 = $midshipmaninfo['coc_5'];
        $coc_6 = $midshipmaninfo['coc_6'];
        $coc_7 = $midshipmaninfo['coc_7'];
        $coc_8 = $midshipmaninfo['coc_8'];
      }
      // fix this section with a function instead of copy/pasting
      elseif($_POST['TO_USERNAME'] == $midshipmaninfo['coc_4']){
        $coc_0 = null;
        $coc_1 = null;
        $coc_2 = null;
        $coc_3 = null;
        $coc_4 = $midshipmaninfo['coc_4'];
        $coc_5 = $midshipmaninfo['coc_5'];
        $coc_6 = $midshipmaninfo['coc_6'];
        $coc_7 = $midshipmaninfo['coc_7'];
        $coc_8 = $midshipmaninfo['coc_8'];
      }

      if(isset($_POST['REQUEST_OTHER'])){
        $requestOther = addslashes($_POST['REQUEST_OTHER']);
      }
      else{
        $requestOther = null;
      }

      if(isset($_POST['ADDRESS_1'])){
        $addr_1 = addslashes($_POST['ADDRESS_1']);
      }
      else{
        $addr_1 = null;
      }

      if(!empty($_POST['ORM'])){
        if(strpos($_POST['ORM'], "https://") === false){
          $_POST['ORM'] = "https://" . $_POST['ORM'];
        }
      }

      if(!empty($_POST['DOCS'])){
        if(strpos($_POST['DOCS'], "https://") === false){
          $_POST['DOCS'] = "https://" . $_POST['DOCS'];
        }
      }

      update_chit($db, $chitnumber, $chit['creator'], $_POST['SHORT_DESCRIPTION'], $_POST['REFERENCE'], $_POST['REQUEST_TYPE'], $requestOther, $addr_1, $_POST['ADDRESS_2'], $_POST['ADDRESS_CITY'], $_POST['ADDRESS_STATE'], $_POST['ADDRESS_ZIP'], $_POST['REMARKS'], $date, $_POST['BEGIN_DATE'], $_POST['BEGIN_TIME'], $_POST['END_DATE'], $_POST['END_TIME'], $_POST['ORM'], $_POST['DOCS'], $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8);

      header("Location: viewchit.php");

    }

    elseif(isset($_POST['SHORT_DESCRIPTION']) && isset($_POST['TO_USERNAME']) && isset($_POST['REFERENCE']) && isset($_POST['ADDRESS_CITY']) && isset($_POST['ADDRESS_2']) && isset($_POST['ADDRESS_STATE']) && isset($_POST['ADDRESS_ZIP']) && isset($_POST['REMARKS']) && isset($_POST['BEGIN_DATE']) && isset($_POST['BEGIN_TIME']) && isset($_POST['END_DATE']) && isset($_POST['END_TIME'])){
      $_SESSION['error'] = "Select a request type!";
    }


    if(isset($_SESSION['error'])){
      echo "<div class=\"alert alert-danger\">{$_SESSION['error']}</div>";
      unset($_SESSION['error']);
    }




    ?>

    <script type="text/javascript">
      function routeTo(){
        var to_username = document.getElementById("route_to").value;

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var coc = this.responseText.split(";")

            document.getElementById("pos_0").innerHTML = coc[0];
            document.getElementById("pos_1").innerHTML = coc[1];
            document.getElementById("pos_2").innerHTML = coc[2];
            document.getElementById("pos_3").innerHTML = coc[3];
            document.getElementById("pos_4").innerHTML = coc[4];
            document.getElementById("pos_5").innerHTML = coc[5];
            document.getElementById("pos_6").innerHTML = coc[6];
            document.getElementById("pos_7").innerHTML = coc[7];
            document.getElementById("pos_8").innerHTML = coc[8];

          }
        };

        xhttp.open("GET", "./makechit.php?to=" + to_username, true);
        xhttp.send();

      }
      </script>

      <style>
      .box {
        padding: 0;
        border: 1px solid #000000 !important;
        margin: 0;
      }

      .courier{
        font-family: "Courier New", Courier, monospace;
      }

      </style>
    </head>

    <div class="container">


      <div id="banner">

      </div>


<?php

# Load in The NavBar
require_once(WEB_PATH.'navbar.php');


?>

  <form  class="courier" role="form" action="?" method="post">


    <div class="row" style="border: 1px solid #000000">
      <div class="col-sm-12">



  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000;">
    <div class="col-sm-12">
      <strong>Special Request (Midshipman)</strong>
      <input required type="text" name="SHORT_DESCRIPTION" class="form-control-sm" placeholder="Briefly describe your request in one sentence." size="60" maxlength="100" value="<?php if(isset($chit['description'])){echo "{$chit['description']}";}?>"/>
    </div>
  </div>


  <div class="row" style="border-bottom:1px solid #000000;">

    <div class="col-sm-6" style="border-left: 1px solid #000000; border-top: 1px solid #000000; ">
      <div class="row">
        <div class="col-sm-1">
          To:
        </div>


        <div class="col-sm-11">
          <!-- submit information to ajax call -->
          <!-- This portion is just to update the "to" portion with the user's CoC -->

          <select id="route_to" onchange="routeTo();" class="form-control" name="TO_USERNAME" >
            <?php
            if(isset($midshipmaninfo['coc_3'])  && !is_midshipman($db, $midshipmaninfo['coc_4'])){
              $option_info = get_user_information($db, $midshipmaninfo['coc_4']);
              echo "<option value=\"{$midshipmaninfo['coc_4']}\" ";
              if(!isset($chit['coc_0_username']) && !isset($chit['coc_1_username'])  && !isset($chit['coc_2_username']) && !isset($chit['coc_3_username']) && isset($chit['coc_4_username']) && $chit['coc_4_username'] == $midshipmaninfo['coc_4']){
                echo "selected=\"selected\"";
              }
              echo ">{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
            }
            ?>

            <?php
            if(isset($midshipmaninfo['coc_4'])  && !is_midshipman($db, $midshipmaninfo['coc_3'])){
              $option_info = get_user_information($db, $midshipmaninfo['coc_3']);
              echo "<option value=\"{$midshipmaninfo['coc_3']}\" ";
              if(!isset($chit['coc_0_username']) && !isset($chit['coc_1_username'])  && !isset($chit['coc_2_username']) && isset($chit['coc_3_username']) && $chit['coc_3_username'] == $midshipmaninfo['coc_3']){
                echo "selected=\"selected\"";
              }
              echo ">{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
            }
            ?>

            <?php
            if(isset($midshipmaninfo['coc_2']) && !is_midshipman($db, $midshipmaninfo['coc_2'])){
              $option_info = get_user_information($db, $midshipmaninfo['coc_2']);
              echo "<option value=\"{$midshipmaninfo['coc_2']}\" ";
              if(!isset($chit['coc_0_username']) && !isset($chit['coc_1_username']) && isset($chit['coc_2_username']) && $chit['coc_2_username'] == $midshipmaninfo['coc_2']){
                echo "selected=\"selected\"";
              }
              echo ">{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
            }
            ?>

            <?php
            if(isset($midshipmaninfo['coc_1'])  && !is_midshipman($db, $midshipmaninfo['coc_1'])){
              $option_info = get_user_information($db, $midshipmaninfo['coc_1']);
              echo "<option value=\"{$midshipmaninfo['coc_1']}\" ";
              if(!isset($chit['coc_0_username']) && isset($chit['coc_1_username']) && $chit['coc_1_username'] == $midshipmaninfo['coc_1']){
                echo "selected=\"selected\"";
              }
              echo ">{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
            }
            ?>

            <?php
            if(isset($midshipmaninfo['coc_0']) && !is_midshipman($db, $midshipmaninfo['coc_0'])){
              $option_info = get_user_information($db, $midshipmaninfo['coc_0']);
              echo "<option value=\"{$midshipmaninfo['coc_0']}\" ";
              if(isset($chit['coc_0_username']) && $chit['coc_0_username'] == $midshipmaninfo['coc_0']){
                echo "selected=\"selected\"";
              }
              echo ">{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']} </option>";
            }
            ?>

          </select>
        </div>
        <div class="col-sm-2">
        </div>
      </div>

    </div>

    <script type="text/javascript">
    routeTo();
    </script>

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
                <select class="form-control" name="REFERENCE" >
                  <!-- all of the commandant instructions -->
                <?php
                echo "<option value=\"COMDTMIDNINST 5400.6T MIDREGS\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 5400.6T MIDREGS"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 5400.6T MIDREGS</option>";

                echo "<option value=\"COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS</option>";

                echo "<option value=\"COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY</option>";

                echo "<option value=\"COMDTMIDNINST 1531.1 TAILGATING SOP\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1531.1 TAILGATING SOP"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1531.1 TAILGATING SOP</option>";


                echo "<option value=\"COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION</option>";

                echo "<option value=\"COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS</option>";

                echo "<option value=\"COMDTMIDNINST 1610.2H CONDUCT MANUAL\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1610.2H CONDUCT MANUAL"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1610.2H CONDUCT MANUAL</option>";

                echo "<option value=\"COMDTMIDNINST 1600.2H APTITUDE FOR COMMISSION SYSTEM\" ";
                if(isset($chit['reference']) && $chit['reference'] == "COMDTMIDNINST 1600.2H APTITUDE FOR COMMISSION SYSTEM"){
                  echo "selected=\"selected\"";
                }
                echo ">COMDTMIDNINST 1600.2H APTITUDE FOR COMMISSION SYSTEM</option>";
                ?>
              </select>

              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 6px">
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
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 6px;">
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
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 6px;">
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
                  <div class="col-sm-3" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; padding-bottom: 6px;">
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


        <!-- place to put all of the request types for the request type of a chit (weekend liberty,dining out, leave, etc) -->

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
      Weekend Liberty:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="WEEKEND_LIBERTY" value="W" <?php if(isset($chit['requestType']) && $chit['requestType'] == "W"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Dining Out:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="DINING_OUT" value="D" <?php if(isset($chit['requestType']) && $chit['requestType'] == "D"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Leave:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="LEAVE" value="L" <?php if(isset($chit['requestType']) && $chit['requestType'] == "L"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-1">
      Other:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="OTHER" value="O" <?php if(isset($chit['requestType']) && $chit['requestType'] == "O"){echo "checked";}?>>
    </div>
    <div class="col-sm-2">
      <input type="text" name="REQUEST_OTHER" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($chit['requestOther'])){echo "{$chit['requestOther']}";}?>">
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
    <div class="col-sm-2 text-left">
      (City)
    </div>
    <div class="col-sm-1 text-left">
      (State)
    </div>
    <div class="col-sm-2">
      (Zip Code)
    </div>
    <div class="col-sm-1">
      (Phone)
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">
    <div class="col-sm-3">
      <input type="text" name="ADDRESS_1" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($chit['addr_careOf'])){echo "{$chit['addr_careOf']}";}?>">
    </div>
    <div class="col-sm-3">
      <input required type="text" name="ADDRESS_2" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($chit['addr_street'])){echo "{$chit['addr_street']}";}?>">
    </div>

    <div class="col-sm-3">
      <input required type="text" name="ADDRESS_CITY" class="form-control-sm" placeholder="" size="20" maxlength="30" value="<?php if(isset($chit['addr_city'])){echo "{$chit['addr_city']}";}?>">
      <input pattern=".{2}" title="i.e. MD" required type="text" name="ADDRESS_STATE" class="form-control-sm" placeholder="XX" size="2" maxlength="2" value="<?php if(isset($chit['addr_state'])){echo "{$chit['addr_state']}";}?>">
    </div>

    <div class="col-sm-1">
      <input pattern=".{5}" title="i.e. 21412" required type="text" name="ADDRESS_ZIP" class="form-control-sm" placeholder="XXXXX" size="5" maxlength="5" value="<?php if(isset($chit['addr_zip'])){echo "{$chit['addr_zip']}";}?>">

    </div>
    <div class="col-sm-2 text-right">
      <?php
      echo "{$midshipmaninfo['phoneNumber']}";
       ?>
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000;">
    <div class="col-md-12">
      <strong>Remarks or Reason</strong>
    </div>
  </div>
  <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000; border-bottom:1px solid #000000;">
    <div class="col-md-12">
      <textarea class="form-control" maxlength="1950" rows="10" name="REMARKS"><?php if(isset($chit['remarks'])){echo "{$chit['remarks']}";}?></textarea>
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
              <input type="submit" class="btn btn-primary" value="Submit Chit">
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000; padding-bottom: 15px;">
            <div class="col-sm-12">
              Date
            </div>
            <div class="col-sm-12">
              <?php
              echo "{$chit['createdDate']}";
               ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row" style="border-right:1px solid #000000; border-top: 1px solid #000000; padding-bottom: 6px;">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-12">
              Beginning (Time & Date)
              </div>
            <div class="col-sm-12">
              <input pattern=".{4}" title="i.e. 1800" required type="text" name="BEGIN_TIME" class="form-control-sm" placeholder="1745" size="4" value="<?php if(isset($chit['startTime'])){echo "{$chit['startTime']}";}?>">

              <input pattern=".{7}" title="i.e. 01JAN17" required type="text" name="BEGIN_DATE" class="form-control-sm" placeholder="01DEC17" size="7" value="<?php if(isset($chit['startDate'])){echo "{$chit['startDate']}";}?>">

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row" style="border-left: 1px solid #000000; ">
            <div class="col-sm-12">
              Ending (Time & Date)
            </div>
            <div class="col-sm-12">

                <input pattern=".{4}" title="i.e. 1800" required type="text" name="END_TIME" class="form-control-sm" placeholder="1745" size="4" value="<?php if(isset($chit['endTime'])){echo "{$chit['endTime']}";}?>">

                <input pattern=".{7}" title="i.e. 01JAN17" required type="text" name="END_DATE" class="form-control-sm" placeholder="01DEC17" size="8" value="<?php if(isset($chit['endDate'])){echo "{$chit['endDate']}";}?>">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4" style="padding-top: 10px; padding-bottom: 10px;">
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
        <div class="col-sm-2" style="border-left: 1px solid; padding-top: 10px; padding-bottom: 10px;">
          <div class="row" style="text-align: center; ">
            <div class="col-sm-12">
              <br />
            </div>
            <div class="col-sm-12">
              DATE
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3" >
          <div class="row" style="text-align: center; border-right: 1px solid #000000; border-left: 1px solid #000000;">
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
    <div class="col-sm-6" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;">
      <br>
      <br>
      <br>
      <strong>Chain of Command Comments:</strong>
    </div>

  </div>

  <div class="row">
    <div class="col-sm-6" style="border-right: 1px solid #000000;">
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_8">
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000">
            <div class="col-sm-12">
              <br><br><br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_7">

            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; ">
            <div class="col-sm-12">
              <br>
            </div>

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_6">
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; ">
            <div class="col-sm-12">
              <br>
            </div>

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row" >
            <div class="col-sm-12" id="pos_5">

            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>


      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12">
              <br />
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              Date
            </div>

          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              APPROVED
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              DISAPPROVED
            </div>
          </div>
        </div>
      </div>


      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row" >
            <div class="col-sm-12" id="pos_4">

            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row" >
            <div class="col-sm-12" id="pos_3">


            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>

              <div class="col-sm-12">
                <br>
              </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_2">


            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_1">


            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="border-left: 1px solid #000000; border-bottom:1px solid #000000;">
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-12" id="pos_0">


            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="row" style="text-align: center; border-left: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>

            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center; border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="row" style="text-align: center;">
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
            <div class="col-sm-12">
              <br>
            </div>
          </div>
        </div>
      </div>



    </div>
    <div class="col-sm-6">
      <div class="row" style="border-right:1px solid #000000; border-bottom:1px solid #000000; padding-bottom: 8px;">
        <div class="col-sm-12">
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>

          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </div>
      </div>



</div>

  <div class="form-group">
    <label for="ORM">ORM Link:</label>
    <input type="text" name="ORM" class="form-control" width="100%" placeholder="If required for your chit, paste a link to your ORM." maxlength="200" value="<?php if(isset($chit['ormURL'])){echo "{$chit['ormURL']}";}?>"/>
  </div>


  <div class="form-group">
    <label for="DOCS">Supporting Documents Link:</label>
    <input type="text" name="DOCS" class="form-control" width="100%" placeholder="If required for your chit, paste a link to your supporting documents, such as flight receipts." maxlength="200" value="<?php if(isset($chit['supportingDocsURL'])){echo "{$chit['supportingDocsURL']}";}?>"/>
  </div>


</form>

</body>
</html>
