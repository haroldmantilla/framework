<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'My Profile',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => 'user',
                      'position'   => 0,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => false,
                      'access'     => array());
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

  # Load in The NavBar
  # Note: You too will have automated NavBar generation
  #       support in your future templates...
  require_once(WEB_PATH.'navbar.php');

?>
<script type="text/javascript">
function redirect(location){
	window.location = location;
}

</script>

<style type="text/css">
.btn-space {
	margin-top: 5px;
}
</style>

<div class="container">
	<div class="row">
		<div class="col-md-12">
      <?php
      if(isset($_SESSION['error'])) {
        echo "<div class=\"alert alert-danger\">".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
      }
      ?>

		</div>
	</div>

  <?php
  $debug = false;
  // $debug = true;

  //edit basic info
  if(isset($_POST['changes']) && $_POST['changes'] == "Submit Changes" && isset($_POST['rank']) && !empty($_POST['rank']) && isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['billet']) && !empty($_POST['billet'])){

    update_basic_leader_info($db, USER['user'], $_POST['rank'], $_POST['firstname'], $_POST['lastname'], $_POST['billet']);



  }

  $userinfo = get_user_information($db, USER['user']);

  // echo "<pre>";
  // print_r($userinfo);
  // echo "</pre>";

  if(isset($_POST['editbasic'])){
    echo "<div class=\"row\">";
    echo "<div class=\"col-sm-10\">";
    echo "<div class=\"well\">";
    echo "<form action=\"?\" method=\"post\">";

    if($userinfo['level'] == "MID"){
      echo "<select class='form-control' name='rank' id='rank' required>";
      echo "
      <option value='MIDN 4/C'"; if($userinfo['rank'] == "MIDN 4/C"){echo "selected";} echo ">MIDN 4/C</option>
      <option value='MIDN 3/C'"; if($userinfo['rank'] == "MIDN 3/C"){echo "selected";} echo ">MIDN 3/C</option>
      <option value='MIDN 2/C'"; if($userinfo['rank'] == "MIDN 2/C"){echo "selected";} echo ">MIDN 2/C</option>
      <option value='MIDN 1/C'"; if($userinfo['rank'] == "MIDN 1/C"){echo "selected";} echo ">MIDN 1/C</option>
      <option value='MIDN ENS'"; if($userinfo['rank'] == "MIDN ENS"){echo "selected";} echo ">MIDN ENS</option>
      <option value='MIDN LTJG'"; if($userinfo['rank'] == "MIDN LTJG"){echo "selected";} echo ">MIDN LTJG</option>
      <option value='MIDN LT'"; if($userinfo['rank'] == "MIDN LT"){echo "selected";} echo ">MIDN LT</option>
      <option value='MIDN LCDR'"; if($userinfo['rank'] == "MIDN LCDR"){echo "selected";} echo ">MIDN LCDR</option>
      <option value='MIDN CDR'"; if($userinfo['rank'] == "MIDN CDR"){echo "selected";} echo ">MIDN CDR</option>
      <option value='MIDN CAPT'"; if($userinfo['rank'] == "MIDN CAPT"){echo "selected";} echo ">MIDN CAPT</option>
      ";
      echo "</select>";
    }
    elseif($userinfo['level'] == "Officer" && $userinfo['service'] == "USN" ){
      echo "<select class='form-control' name='rank' id='rank' required>";
      echo "
      <option value='LT'"; if($userinfo['rank'] == "LT"){echo "selected";} echo ">LT</option>
      <option value='LCDR'"; if($userinfo['rank'] == "LCDR"){echo "selected";} echo ">LCDR</option>
      <option value='CDR'"; if($userinfo['rank'] == "CDR"){echo "selected";} echo ">CDR</option>
      <option value='CAPT'"; if($userinfo['rank'] == "CAPT"){echo "selected";} echo ">CAPT</option>
      ";
      echo "</select>";
    }
    elseif($userinfo['level'] == "Officer" && $userinfo['service'] == "USMC" ){
      echo "<select class='form-control' name='rank' id='rank' required>";
      echo "
      <option value='Capt'"; if($userinfo['rank'] == "Capt"){echo "selected";} echo ">Capt</option>
      <option value='Maj'"; if($userinfo['rank'] == "Maj"){echo "selected";} echo ">Maj</option>
      <option value='LtCol'"; if($userinfo['rank'] == "LtCol"){echo "selected";} echo ">LtCol</option>
      <option value='Col'"; if($userinfo['rank'] == "Col"){echo "selected";} echo ">Col</option>
      ";
      echo "</select>";
    }
    elseif($userinfo['level'] == "SEL" && $userinfo['service'] == "USN" ){
      echo "<select class='form-control' name='rank' id='rank' required>";

      $ranks = get_ranks($db);

      foreach ($ranks as $key => $rank) {
        echo "<option value='{$rank['rate']}'"; if($userinfo['rank'] == "{$rank['rate']}"){echo "selected";}
        echo ">{$rank['rate']}</option>";
      }


      echo "</select>";
    }
    elseif($userinfo['level'] == "SEL" && $userinfo['service'] == "USMC" ){
      echo "<select class='form-control' name='rank' id='rank' required>";
      echo "
      <option value='SSgt'"; if($userinfo['rank'] == "SSgt"){echo "selected";} echo ">SSgt</option>
      <option value='GySgt'"; if($userinfo['rank'] == "GySgt"){echo "selected";} echo ">GySgt</option>
      ";
      echo "</select>";
    }


    echo "<input type=\"text\" class=\"form-control\" name=\"firstname\" maxlength=\"20\" value=\"{$userinfo['firstName']}\" placeholder=\"First Name\"required>";

    echo "<input type=\"text\" class=\"form-control\" name=\"lastname\" maxlength=\"20\" value=\"{$userinfo['lastName']}\" placeholder=\"Last Name\"required>";

    echo "<input type=\"text\" class=\"form-control\" name=\"billet\" maxlength=\"40\" value=\"{$userinfo['billet']}\" placeholder=\"Billet\" required>";

    echo "</div>";
    echo "</div>";

    echo "<div class=\"col-sm-2 btn-toolbar text-center\">";

    echo "<input type=\"submit\" class=\"btn btn-default \" name=\"changes\" value=\"Submit Changes\">";
    echo "<button class=\"btn btn-danger btn-space\" onclick=\"redirect('./profile.php')\">Cancel</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";

  }
  else{
    echo "<div class=\"row\">";
    echo "<div class=\"col-sm-10\">";
    echo "<div class=\"well\">";
    echo "<h5>{$userinfo['rank']} {$userinfo['firstName']} {$userinfo['lastName']}, {$userinfo['service']}</h5>";
    echo "<h5>{$userinfo['billet']}</h5>";

    echo "</div>";
    echo "</div>";

    echo "<div class=\"col-sm-2\">";
    echo "<form action=\"?\" method=\"post\">";
    echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"editbasic\" value=\"Edit Basic Information\">";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    if(isset($_SESSION['success'])) {
      echo "<div class=\"alert alert-success\">".$_SESSION['success']."</div>";
      unset($_SESSION['success']);
    }


    if($userinfo['level'] != "MID"){
      $subordinates = get_subordinates($db, USER['user']);

      if(isset($subordinates) && !empty($subordinates)){
        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-10\">";
        echo "<div class=\"well\">";
        echo "<div style=\"text-align: center;\"><u>My Subordinates</u></div><br>";
        foreach($subordinates as $sub){
          if(!isset($sub['company']) || !isset($sub['rank']) || !isset($sub['firstName']) || !isset($sub['lastName']) || !isset($sub['room']) || !isset($sub['aptitudeGrade']) || !isset($sub['conductGrade']) || !isset($sub['SQPR']) || !isset($sub['CQPR']) || !isset($sub['phoneNumber']) ){
            continue;
          }
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-4\">";
          echo "<p>";
          echo "{$sub['rank']} {$sub['firstName']} {$sub['lastName']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-2\">";
          echo "<p>";
          echo "SQPR: {$sub['SQPR']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-2\">";
          echo "<p>";
          echo "CQPR: {$sub['CQPR']}";
          echo "</p>";
          echo "</div>";

          echo "<div class=\"col-sm-2\">";
          echo "<p>";
          echo "Aptitude: {$sub['aptitudeGrade']}";
          echo "</p>";
          echo "</div>";

          echo "<div class=\"col-sm-2\">";
          echo "<p>";
          echo "Conduct: {$sub['conductGrade']}";
          echo "</p>";
          echo "</div>";
          echo "</div>"; //closes row
        }
        echo "<br><p>*If your subordinate is not listed here, they have not yet registered.</p>";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"col-sm-2\">";
        echo "</div>";
        echo "</div>";
      }
      }
    }




    if($userinfo['level'] == "MID"){

      $is_midshipman = in_midshipman_table($db, USER['user']);

      $midshipmaninfo = get_midshipman_information($db, USER['user']);

      if(isset($_POST['changemidshipmaninfo']) && $_POST['changemidshipmaninfo'] == "Submit Changes" && isset($_POST['company']) &&  isset($_POST['year']) &&  isset($_POST['room']) &&  isset($_POST['phonenumber']) &&  isset($_POST['SQPR']) &&  isset($_POST['CQPR']) &&  isset($_POST['aptitudegrade']) &&  isset($_POST['conductgrade']) ){
//20AUG2018 MADE IT WORK WITHOUT DANT/DEPDANT
        if(!isset($_POST['coc_2'])){
          $_POST['coc_0'] = null;
          $_POST['coc_1'] = null;
          $_POST['coc_2'] = null;
          $_POST['coc_3'] = null;
          $_POST['coc_4'] = null;
          $_POST['coc_5'] = null;
          $_POST['coc_6'] = null;
          $_POST['coc_7'] = null;
          $_POST['coc_8'] = null;
        }

        if(in_array(USER['user'], array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))){
          $_SESSION['error'] = "You cannot be in your own Chain of Command!";
          $_POST['editmidshipmaninfo'] = "Submit Changes";
        }
        elseif(count(array_filter(array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))) !== count(array_unique(array_filter(array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))))){
          $_SESSION['error'] = "You cannot have duplicates in your Chain of Command!";
          $_POST['editmidshipmaninfo'] = "Submit Changes";
        }
        else{
          if($is_midshipman){
            update_midshipman($db, USER['user'],$_POST['company'], $_POST['year'], $_POST['room'], $_POST['SQPR'], $_POST['CQPR'], $_POST['phonenumber'], $_POST['aptitudegrade'], $_POST['conductgrade'], $_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6'], $_POST['coc_7'], $_POST['coc_8']);
            unset($_POST['changemidshipmaninfo']);
          }
          else{
            create_midshipman($db, USER['user'],$_POST['company'], $_POST['year'], $_POST['room'], $_POST['phonenumber'], $_POST['SQPR'], $_POST['CQPR'], $_POST['aptitudegrade'], $_POST['conductgrade'], $_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6'], $_POST['coc_7'], $_POST['coc_8']);
            unset($_POST['changemidshipmaninfo']);
          }
        }
      }

      if(isset($_POST['editmidshipmaninfo'])){



        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-10\">";
        echo "<div class=\"well\">";

        echo "<form action=\"?\" method=\"post\">";
        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-3\">";
        echo "<select class=\"form-control\" name=\"company\" required>";
        echo "<option value=\"1\""; if($midshipmaninfo['company'] == 1){echo "selected";} echo ">1</option>";
        echo "<option value=\"2\""; if($midshipmaninfo['company'] == 2){echo "selected";} echo ">2</option>";
        echo "<option value=\"3\""; if($midshipmaninfo['company'] == 3){echo "selected";} echo ">3</option>";
        echo "<option value=\"4\""; if($midshipmaninfo['company'] == 4){echo "selected";} echo ">4</option>";
        echo "<option value=\"5\""; if($midshipmaninfo['company'] == 5){echo "selected";} echo ">5</option>";
        echo "<option value=\"6\""; if($midshipmaninfo['company'] == 6){echo "selected";} echo ">6</option>";
        echo "<option value=\"7\""; if($midshipmaninfo['company'] == 7){echo "selected";} echo ">7</option>";
        echo "<option value=\"8\""; if($midshipmaninfo['company'] == 8){echo "selected";} echo ">8</option>";
        echo "<option value=\"9\""; if($midshipmaninfo['company'] == 9){echo "selected";} echo ">9</option>";
        echo "<option value=\"10\""; if($midshipmaninfo['company'] == 10){echo "selected";} echo ">10</option>";
        echo "<option value=\"11\""; if($midshipmaninfo['company'] == 11){echo "selected";} echo ">11</option>";
        echo "<option value=\"12\""; if($midshipmaninfo['company'] == 12){echo "selected";} echo ">12</option>";
        echo "<option value=\"13\""; if($midshipmaninfo['company'] == 13){echo "selected";} echo ">13</option>";
        echo "<option value=\"14\""; if($midshipmaninfo['company'] == 14){echo "selected";} echo ">14</option>";
        echo "<option value=\"15\""; if($midshipmaninfo['company'] == 15){echo "selected";} echo ">15</option>";
        echo "<option value=\"16\""; if($midshipmaninfo['company'] == 16){echo "selected";} echo ">16</option>";
        echo "<option value=\"17\""; if($midshipmaninfo['company'] == 17){echo "selected";} echo ">17</option>";
        echo "<option value=\"18\""; if($midshipmaninfo['company'] == 18){echo "selected";} echo ">18</option>";
        echo "<option value=\"19\""; if($midshipmaninfo['company'] == 19){echo "selected";} echo ">19</option>";
        echo "<option value=\"20\""; if($midshipmaninfo['company'] == 20){echo "selected";} echo ">20</option>";
        echo "<option value=\"21\""; if($midshipmaninfo['company'] == 21){echo "selected";} echo ">21</option>";
        echo "<option value=\"22\""; if($midshipmaninfo['company'] == 22){echo "selected";} echo ">22</option>";
        echo "<option value=\"23\""; if($midshipmaninfo['company'] == 23){echo "selected";} echo ">23</option>";
        echo "<option value=\"24\""; if($midshipmaninfo['company'] == 24){echo "selected";} echo ">24</option>";
        echo "<option value=\"25\""; if($midshipmaninfo['company'] == 25){echo "selected";} echo ">25</option>";
        echo "<option value=\"26\""; if($midshipmaninfo['company'] == 26){echo "selected";} echo ">26</option>";
        echo "<option value=\"27\""; if($midshipmaninfo['company'] == 27){echo "selected";} echo ">27</option>";
        echo "<option value=\"28\""; if($midshipmaninfo['company'] == 28){echo "selected";} echo ">28</option>";
        echo "<option value=\"29\""; if($midshipmaninfo['company'] == 29){echo "selected";} echo ">29</option>";
        echo "<option value=\"30\""; if($midshipmaninfo['company'] == 30){echo "selected";} echo ">30</option>";
        echo "</select>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<input type=\"text\" class=\"form-control\"maxlength=\"4\" name=\"year\" placeholder=\"Year\" value=\"{$midshipmaninfo['classYear']}\"  required>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<input type=\"text\" class=\"form-control\"maxlength=\"4\" name=\"room\" placeholder=\"Room\" value=\"{$midshipmaninfo['room']}\"  required>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<input type=\"text\" class=\"form-control\"maxlength=\"14\" name=\"phonenumber\" placeholder=\"Phone Number\" value=\"{$midshipmaninfo['phoneNumber']}\"  required>";
        echo "</div>";
        echo "</div>"; //closes row

        echo "<div class=\"row btn-space\">";
        echo "<div class=\"col-sm-3\">";
        echo "<input type=\"text\" class=\"form-control\" maxlength=\"4\" name=\"SQPR\" placeholder=\"SQPR\" value=\"{$midshipmaninfo['SQPR']}\" required>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<input type=\"text\" class=\"form-control\" maxlength=\"4\" name=\"CQPR\" placeholder=\"CQPR\" value=\"{$midshipmaninfo['CQPR']}\" required>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<select class=\"form-control\" name=\"aptitudegrade\" required>";
        echo "<option value=\"A\""; if($midshipmaninfo['aptitudeGrade'] == 'A'){echo "selected";} echo ">A</option>";
        echo "<option value=\"B\""; if($midshipmaninfo['aptitudeGrade'] == 'B'){echo "selected";} echo ">B</option>";
        echo "<option value=\"C\""; if($midshipmaninfo['aptitudeGrade'] == 'C'){echo "selected";} echo ">C</option>";
        echo "<option value=\"D\""; if($midshipmaninfo['aptitudeGrade'] == 'D'){echo "selected";} echo ">D</option>";
        echo "<option value=\"F\""; if($midshipmaninfo['aptitudeGrade'] == 'F'){echo "selected";} echo ">F</option>";
        echo "</select>";

        echo "</div>";
        echo "<div class=\"col-sm-3\">";

        echo "<select class=\"form-control\" name=\"conductgrade\" required>";
        echo "<option value=\"A\""; if($midshipmaninfo['conductGrade'] == 'A'){echo "selected";} echo ">A</option>";
        echo "<option value=\"B\""; if($midshipmaninfo['conductGrade'] == 'B'){echo "selected";} echo ">B</option>";
        echo "<option value=\"C\""; if($midshipmaninfo['conductGrade'] == 'C'){echo "selected";} echo ">C</option>";
        echo "<option value=\"D\""; if($midshipmaninfo['conductGrade'] == 'D'){echo "selected";} echo ">D</option>";
        echo "<option value=\"F\""; if($midshipmaninfo['conductGrade'] == 'F'){echo "selected";} echo ">F</option>";
        echo "</select>";

        echo "</div>";
        echo "</div>"; //closes row

        if(!isset($midshipmaninfo['company'])){
          echo "<br><br><br>";
          echo "<div class =\"row\">";


          echo "<div class =\"col-sm-12 text-center\">";
          echo "<div class=\"alert alert-warning\">You must submit your company selection to choose your Chain of Command!</div>";
          echo "</div>";

          echo "</div>";

        }
        else{

          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-12 text-center\">";
          echo "<br><br><br><p><u>Chain of Command</u></p>";
          echo "</div>";
          echo "</div>"; //closes row


          $coc_options_midn = get_potential_coc_midn($db, $midshipmaninfo['company']);

          $coc_options_officers = get_potential_coc_officers($db);
          $coc_options_SELs = get_potential_coc_SELs($db);

          // echo "<pre>";
          // print_r($coc_options_midn);
          // print_r($coc_options_officers);
          // echo "</pre>";
/////////////////////////////////////////////////////////////////////////////////////

///20AUG2018 -- HAROLD MANTILLA
// EDITED OUT COMMANDANT AND DEPT DANT OPTIONS

          // //coc_0
          // echo "<div class=\"row\">";
          // echo "<div class=\"col-sm-3 text-right\">";
          // echo "<p>Commandant:</p>";
          // echo "</div>";
          // echo "<div class=\"col-sm-6\">";
          // echo "<select class=\"form-control\" name=\"coc_0\">";
          // echo "<option value=\"\"></option>";
          // foreach($coc_options_officers as $user){
          //   echo "<option value=\"{$user['username']}\"";
          //
          //   if($midshipmaninfo['coc_0'] == $user['username']){
          //     echo "selected";
          //   }
          //
          //   echo ">{$user['rank']} {$user['lastName']}</option>";
          // }
          // echo "</select>";
          // echo "</div>";
          // echo "<div class=\"col-sm-3\">";
          // echo "</div>";
          // echo "</div>"; //closes row
          //
          // //coc_1
          // echo "<div class=\"row\">";
          // echo "<div class=\"col-sm-3 text-right\">";
          // echo "<p>Deputy Commandant:</p>";
          // echo "</div>";
          // echo "<div class=\"col-sm-6\">";
          // echo "<select class=\"form-control\" name=\"coc_1\">";
          // echo "<option value=\"\"></option>";
          // foreach($coc_options_officers as $user){
          //   echo "<option value=\"{$user['username']}\"";
          //
          //   if($midshipmaninfo['coc_1'] == $user['username']){
          //     echo "selected";
          //   }
          //
          //   echo ">{$user['rank']} {$user['lastName']}</option>";
          // }
          // echo "</select>";
          // echo "</div>";
          // echo "<div class=\"col-sm-3\">";
          // echo "</div>";
          // echo "</div>"; //closes row

////////////////////////////////////////////////////////////////////////////////

          //coc_2
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Battalion Officer:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_2\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_officers as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_2'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_3
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Company Officer:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_3\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_officers as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_3'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_4
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Senior Enlised:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_4\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_SELs as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_4'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_5
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Company Commander:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_5\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_5'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_6
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Company XO:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_6\">";
          echo "<option value=\"\"></option>";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_6'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>*If you are not a squad member, feel free to leave positions blank</p>";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_7
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Platoon Commander:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_7\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_7'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row

          //coc_8
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Squad Leader:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_8\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_8'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row

        }

          echo "</div>";
          echo "</div>";

          echo "<div class=\"col-sm-2\">";

          echo "<input type=\"submit\" class=\"btn btn-default \" name=\"changemidshipmaninfo\" value=\"Submit Changes\">";
          echo "<button class=\"btn btn-danger btn-space\" onclick=\"redirect('./profile.php')\">Cancel</button>";
          echo "</form>";
          echo "</div>";
          echo "</div>";

          if(isset($_SESSION['error'])) {
            echo "<div class=\"alert alert-danger\">".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
          }

      }
      //else profile filled out, display
      else{

          $midshipmaninfo = get_midshipman_information($db, USER['user']);

        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-10\">";
        echo "<div class=\"well\">";


        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Company: &nbsp {$midshipmaninfo['company']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Class Year: &nbsp {$midshipmaninfo['classYear']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Room: &nbsp {$midshipmaninfo['room']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Phone Number: {$midshipmaninfo['phoneNumber']}</p>";
        echo "</div>";
        echo "</div>"; //closes row

        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-3\">";
        echo "<p>SQPR: &nbsp {$midshipmaninfo['SQPR']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>CQPR: &nbsp {$midshipmaninfo['CQPR']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Aptitude Grade: &nbsp {$midshipmaninfo['aptitudeGrade']}</p>";
        echo "</div>";
        echo "<div class=\"col-sm-3\">";
        echo "<p>Conduct Grade: &nbsp {$midshipmaninfo['conductGrade']}</p>";
        echo "</div>";
        echo "</div>"; //closes row


        echo "<div class=\"row\">";
        echo "<div class=\"col-sm-12 text-center\">";
        echo "<br><br><br><p><u>Chain of Command</u></p>";
        echo "</div>";
        echo "</div>"; //closes row


        if(isset($midshipmaninfo['coc_0']) && !empty($midshipmaninfo['coc_0'])){
          $coc_0_info = get_user_information($db, $midshipmaninfo['coc_0']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_0_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_0_info['rank']} {$coc_0_info['firstName']} {$coc_0_info['lastName']}, {$coc_0_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }


        if(isset($midshipmaninfo['coc_1']) && !empty($midshipmaninfo['coc_1'])){
          $coc_1_info = get_user_information($db, $midshipmaninfo['coc_1']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_1_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_1_info['rank']} {$coc_1_info['firstName']} {$coc_1_info['lastName']}, {$coc_1_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }

        if(isset($midshipmaninfo['coc_2']) && !empty($midshipmaninfo['coc_2'])){
          $coc_2_info = get_user_information($db, $midshipmaninfo['coc_2']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_2_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_2_info['rank']} {$coc_2_info['firstName']} {$coc_2_info['lastName']}, {$coc_2_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }
        if(isset($midshipmaninfo['coc_3']) && !empty($midshipmaninfo['coc_3'])){
          $coc_3_info = get_user_information($db, $midshipmaninfo['coc_3']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_3_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_3_info['rank']} {$coc_3_info['firstName']} {$coc_3_info['lastName']}, {$coc_3_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }
        if(isset($midshipmaninfo['coc_4']) && !empty($midshipmaninfo['coc_4'])){
          $coc_4_info = get_user_information($db, $midshipmaninfo['coc_4']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_4_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_4_info['rank']} {$coc_4_info['firstName']} {$coc_4_info['lastName']}, {$coc_4_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }
        if(isset($midshipmaninfo['coc_5']) && !empty($midshipmaninfo['coc_5'])){
          $coc_5_info = get_user_information($db, $midshipmaninfo['coc_5']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_5_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_5_info['rank']} {$coc_5_info['firstName']} {$coc_5_info['lastName']}, {$coc_5_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }
        if(isset($midshipmaninfo['coc_6']) && !empty($midshipmaninfo['coc_6'])){
          $coc_6_info = get_user_information($db, $midshipmaninfo['coc_6']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_6_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_6_info['rank']} {$coc_6_info['firstName']} {$coc_6_info['lastName']}, {$coc_6_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }

        if(isset($midshipmaninfo['coc_7']) && !empty($midshipmaninfo['coc_7'])){
          $coc_7_info = get_user_information($db, $midshipmaninfo['coc_7']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_7_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_7_info['rank']} {$coc_7_info['firstName']} {$coc_7_info['lastName']}, {$coc_7_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }


        if(isset($midshipmaninfo['coc_8']) && !empty($midshipmaninfo['coc_8'])){
          $coc_8_info = get_user_information($db, $midshipmaninfo['coc_8']);
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p></p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_8_info['billet']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "<p>";
          echo "{$coc_8_info['rank']} {$coc_8_info['firstName']} {$coc_8_info['lastName']}, {$coc_8_info['service']}";
          echo "</p>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row
        }






        //
        // echo "<pre>";
        // print_r($midshipmaninfo);
        // echo "</pre>";
        //
        //

        echo "</div>";
        echo "</div>";

        echo "<div class=\"col-sm-2\">";
        echo "<form action=\"?\" method=\"post\">";
        echo "<input type=\"submit\" class=\"btn btn-secondary\" name=\"editmidshipmaninfo\" value=\"Edit Midshipman Information\">";
        echo "</form>";
        echo "</div>";
        echo "</div>";
        if(isset($_SESSION['success'])) {
          echo "<div class=\"alert alert-success\">".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }

        $subordinates = get_subordinates($db, USER['user']);

        if(isset($subordinates) && !empty($subordinates)){
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-10\">";
          echo "<div class=\"well\">";
          echo "<div style=\"text-align: center;\"><u>My Subordinates</u></div><br>";
          foreach($subordinates as $sub){
            if(!isset($sub['company']) || !isset($sub['rank']) || !isset($sub['firstName']) || !isset($sub['lastName']) || !isset($sub['room']) || !isset($sub['aptitudeGrade']) || !isset($sub['conductGrade']) || !isset($sub['SQPR']) || !isset($sub['CQPR']) || !isset($sub['phoneNumber']) ){
              continue;
            }
            echo "<div class=\"row\">";
            echo "<div class=\"col-sm-4\">";
            echo "<p>";
            echo "{$sub['rank']} {$sub['firstName']} {$sub['lastName']}";
            echo "</p>";
            echo "</div>";
            echo "<div class=\"col-sm-2\">";
            echo "<p>";
            echo "SQPR: {$sub['SQPR']}";
            echo "</p>";
            echo "</div>";
            echo "<div class=\"col-sm-2\">";
            echo "<p>";
            echo "CQPR: {$sub['CQPR']}";
            echo "</p>";
            echo "</div>";

            echo "<div class=\"col-sm-2\">";
            echo "<p>";
            echo "Aptitude: {$sub['aptitudeGrade']}";
            echo "</p>";
            echo "</div>";

            echo "<div class=\"col-sm-2\">";
            echo "<p>";
            echo "Conduct: {$sub['conductGrade']}";
            echo "</p>";
            echo "</div>";
            echo "</div>"; //closes row
          }
          echo "<br><p>*If your subordinate is not listed here, they have not yet registered.</p>";
          echo "</div>";
          echo "</div>";
          echo "<div class=\"col-sm-2\">";
          echo "</div>";
          echo "</div>";
        }

      }

    }



    // if($debug){
    //   echo "<pre>";
    //   echo "SESSION: ";
    //   print_r($_SESSION);
    //   echo "</pre>";
    // }

    ?>

  </div>
</body>

</html>
