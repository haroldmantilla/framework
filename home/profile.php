<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <link rel="icon" href="./imgs/icon.ico"/>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>eChits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="includes/bootstrap/js/bootstrap.min.js"></script>
  <!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
  <!-- Bootstrap Js CDN -->
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

  <script type="text/javascript">
  function redirect(location){
    window.location = location;
  }
  //
  // function editinfo(){
  //   var editdiv = document.getElementById("edit");
  //   html = "<div class=\"row\"><div class=\"col-sm-10 well\"></div><div class=\"col-sm-2\"></div></div>";
  //
  //
  //
  //   editdiv.innerHTML = html;
  // }

  </script>

  <style type="text/css">
  .btn-space {
    margin-top: 5px;
  }
  </style>



</head>
<body>
  <?php
  session_start();
  require_once('./includes/nav.inc.php');
  require_once("./includes/nimitz.inc.php");
  require_once("./includes/error.inc.php");
  require_once("./includes/func.inc.php");
  nav();
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
      </div>
    </div>

    <?php
    // session_destroy();
    // $_POST = array();
    // $_REQUEST = array();
    // die;
    $debug = false;
    // $debug = true;

    unset($_SESSION['error']);
    unset($_SESSION['success']);


    if (!isset($_SESSION['username'])) {
      header("Location: ./login.php");

    }

    if($debug){
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
    }

    if($debug){
      echo "<pre>";
      print_r($_POST);
      echo "</pre>";
    }


    //edit basic info
    if(isset($_POST['changes']) && $_POST['changes'] == "Submit Changes" && isset($_POST['rank']) && !empty($_POST['rank']) && isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname']) && isset($_POST['billet']) && !empty($_POST['billet'])){

      update_basic_leader_info($_SESSION['username'], $_POST['rank'], $_POST['firstname'], $_POST['lastname'], $_POST['billet']);



    }

    if(isset($_POST['changepass']) && isset($_POST['oldpassword']) && isset($_POST['password1']) && isset($_POST['password2'])){

      //check if valid oldpasssword
      $login = get_login_info($_SESSION['username']);
      $pass = $_POST['oldpassword'];
      $salt = $login[0];
      $hash = $login[1];
      $concat = $pass . $salt;
      $md5 = md5($pass . $salt);

      if(md5($concat) != $hash){
        $_SESSION['error'] = "Old password is not valid!";
        $_POST['changepassword'] = "Change Password";
      }

      //check if passwords match
      if(empty($_SESSION['error']) && $_POST['password1'] != $_POST['password2']){
        $_SESSION['error'] = "New passwords do not match!";
        $_POST['changepassword'] = "Change Password";
      }

      //check if old password is new password
      if(empty($_SESSION['error']) && $_POST['oldpassword'] == $_POST['password1']){
        $_SESSION['error'] = "New password cannot be match oldpassword!";
        $_POST['changepassword'] = "Change Password";
      }

      //check if new password is at least 4 characters
      if(empty($_SESSION['error']) && strlen($_POST['password1']) < 4){
        $_SESSION['error'] = "New password is too short!";
        $_POST['changepassword'] = "Change Password";
      }

      unset($_POST['oldpassword']);
      unset($_POST['password2']);
      unset($pass);

      if(!isset($_SESSION['error'])){

        //make change
        $salt = generateRandomString();
        $hash = md5($_POST['password1'] . $salt );
        change_password($_SESSION['username'], $salt, $hash);

        //verify change
        $login = get_login_info($_SESSION['username']);
        $pass = $_POST['password1'];
        $salt = $login[0];
        $hash = $login[1];
        $concat = $pass . $salt;
        $md5 = md5($pass . $salt);

        if(md5($concat) != $hash){
          $_SESSION['error'] = "Error writing to database!";
          $_POST['changepassword'] = "Change Password";
        }
        else{
          $_SESSION['success'] = "Password changed!";
        }


      }
    }

    $userinfo = get_user_information($_SESSION['username']);


    //
    // if($debug){
    //   echo "<pre>";
    //   print_r($userinfo);
    //   echo "</pre>";
    // }
    if(isset($_POST['changepassword'])){
      echo "<div class=\"row\">";
      echo "<div class=\"col-sm-10\">";
      echo "<div class=\"well\">";
      echo "<form action=\"?\" method=\"post\">";
      echo "<input type=\"password\" class=\"form-control\" name=\"oldpassword\" maxlength=\"32\" placeholder=\"Old Password\" required>";
      echo "<input type=\"password\" class=\"form-control\" name=\"password1\" maxlength=\"32\" placeholder=\"New Password\" required>";
      echo "<input type=\"password\" class=\"form-control\" name=\"password2\" maxlength=\"32\" placeholder=\"Confirm New Password\" required>";
      echo "</div>";
      echo "</div>";

      echo "<div class=\"col-sm-2 btn-toolbar text-center\">";
      echo "<input type=\"submit\" class=\"btn btn-default \" name=\"changepass\" value=\"Change Password\">";
      echo "<button class=\"btn btn-danger btn-space\" onclick=\"redirect('./profile.php')\">Cancel</button>";
      echo "</form>";
      echo "</div>";
      echo "</div>";

      if(isset($_SESSION['error'])) {
        echo "<div class=\"alert alert-danger\">".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
      }


    }
    elseif(isset($_POST['editbasic'])){
      echo "<div class=\"row\">";
      echo "<div class=\"col-sm-10\">";
      echo "<div class=\"well\">";
      echo "<form action=\"?\" method=\"post\">";

      if($_SESSION['level'] == "MID"){
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
      elseif($_SESSION['level'] == "Officer" && $userinfo['service'] == "USN" ){
        echo "<select class='form-control' name='rank' id='rank' required>";
        echo "
        <option value='LT'"; if($userinfo['rank'] == "LT"){echo "selected";} echo ">LT</option>
        <option value='LCDR'"; if($userinfo['rank'] == "LCDR"){echo "selected";} echo ">LCDR</option>
        <option value='CDR'"; if($userinfo['rank'] == "CDR"){echo "selected";} echo ">CDR</option>
        <option value='CAPT'"; if($userinfo['rank'] == "CAPT"){echo "selected";} echo ">CAPT</option>
        ";
        echo "</select>";
      }
      elseif($_SESSION['level'] == "Officer" && $userinfo['service'] == "USMC" ){
        echo "<select class='form-control' name='rank' id='rank' required>";
        echo "
        <option value='Capt'"; if($userinfo['rank'] == "Capt"){echo "selected";} echo ">Capt</option>
        <option value='Maj'"; if($userinfo['rank'] == "Maj"){echo "selected";} echo ">Maj</option>
        <option value='LtCol'"; if($userinfo['rank'] == "LtCol"){echo "selected";} echo ">LtCol</option>
        <option value='Col'"; if($userinfo['rank'] == "Col"){echo "selected";} echo ">Col</option>
        ";
        echo "</select>";
      }
      elseif($_SESSION['level'] == "SEL" && $userinfo['service'] == "USN" ){
        echo "<select class='form-control' name='rank' id='rank' required>";
        echo "<option value='ATCS'"; if($userinfo['rank'] == "ATCS"){echo "selected";} echo ">ATCS</option><option value='FCCS'"; if($userinfo['rank'] == "FCCS"){echo "selected";} echo ">FCCS</option><option value='YNCS'"; if($userinfo['rank'] == "YNCS"){echo "selected";} echo ">YNCS</option>";
        echo "</select>";
      }
      elseif($_SESSION['level'] == "SEL" && $userinfo['service'] == "USMC" ){
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
      echo "<input type=\"submit\" class=\"btn btn-secondary btn-space \" name=\"changepassword\" value=\"Change Password\">";
      echo "</form>";
      echo "</div>";
      echo "</div>";
      if(isset($_SESSION['success'])) {
        echo "<div class=\"alert alert-success\">".$_SESSION['success']."</div>";
        unset($_SESSION['success']);
      }

      if($_SESSION['level'] != "MID"){


      $subordinates = get_subordinates($_SESSION['username']);

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




    if($_SESSION['level'] == "MID"){

      $is_midshipman = in_midshipman_table($_SESSION['username']);

      $midshipmaninfo = get_midshipman_information($_SESSION['username']);

      if(isset($_POST['changemidshipmaninfo']) && $_POST['changemidshipmaninfo'] == "Submit Changes" && isset($_POST['company']) &&  isset($_POST['year']) &&  isset($_POST['room']) &&  isset($_POST['phonenumber']) &&  isset($_POST['SQPR']) &&  isset($_POST['CQPR']) &&  isset($_POST['aptitudegrade']) &&  isset($_POST['conductgrade']) ){

        if($_SESSION['accesslevel'] == "safety" || $_SESSION['accesslevel'] == "MISLO"){
          $_POST['company'] = $midshipmaninfo['company'];
        }

        if(!isset($_POST['coc_0'])){
          $_POST['coc_0'] = null;
          $_POST['coc_1'] = null;
          $_POST['coc_2'] = null;
          $_POST['coc_3'] = null;
          $_POST['coc_4'] = null;
          $_POST['coc_5'] = null;
          $_POST['coc_6'] = null;
        }

        if(in_array($_SESSION['username'], array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))){
          $_SESSION['error'] = "You cannot be in your own Chain of Command!";
          $_POST['editmidshipmaninfo'] = "Submit Changes";
        }
        elseif(count(array_filter(array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))) !== count(array_unique(array_filter(array($_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']))))){
          $_SESSION['error'] = "You cannot have duplicates in your Chain of Command!";
          $_POST['editmidshipmaninfo'] = "Submit Changes";
        }
        else{
          if($is_midshipman){
            update_midshipman($_SESSION['username'],$_POST['company'], $_POST['year'], $_POST['room'], $_POST['phonenumber'], $_POST['SQPR'], $_POST['CQPR'], $_POST['aptitudegrade'], $_POST['conductgrade'], $_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']);
            unset($_POST['changemidshipmaninfo']);
          }
          else{
            create_midshipman($_SESSION['username'],$_POST['company'], $_POST['year'], $_POST['room'], $_POST['phonenumber'], $_POST['SQPR'], $_POST['CQPR'], $_POST['aptitudegrade'], $_POST['conductgrade'], $_POST['coc_0'], $_POST['coc_1'], $_POST['coc_2'], $_POST['coc_3'], $_POST['coc_4'], $_POST['coc_5'], $_POST['coc_6']);
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



          $coc_options_midn = get_potential_coc_midn($midshipmaninfo['company']);

          $coc_options_officers = get_potential_coc_officers();
          $coc_options_SELs = get_potential_coc_SELs();

          // echo "<pre>";
          // print_r($coc_options_midn);
          // print_r($coc_options_officers);
          // echo "</pre>";


          //coc_0
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Battalion Officer:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_0\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_officers as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_0'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row

          //coc_1
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Company Officer:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_1\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_officers as $user){
            echo "<option value=\"{$user['username']}\"";

            if($midshipmaninfo['coc_1'] == $user['username']){
              echo "selected";
            }

            echo ">{$user['rank']} {$user['lastName']}</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class=\"col-sm-3\">";
          echo "</div>";
          echo "</div>"; //closes row


          //coc_2
          echo "<div class=\"row\">";
          echo "<div class=\"col-sm-3 text-right\">";
          echo "<p>Senior Enlisted:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_2\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_SELs as $user){
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
          echo "<p>Highest MIDN CoC:</p>";
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_3\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
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
          echo "</div>";
          echo "<div class=\"col-sm-6\">";
          echo "<select class=\"form-control\" name=\"coc_4\">";
          echo "<option value=\"\"></option>";
          foreach($coc_options_midn as $user){
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

          $midshipmaninfo = get_midshipman_information($_SESSION['username']);

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

        if(isset($midshipmaninfo['company']) && empty($midshipmaninfo['coc_0']) && empty($midshipmaninfo['coc_1']) && empty($midshipmaninfo['coc_2']) && empty($midshipmaninfo['coc_3']) && empty($midshipmaninfo['coc_4']) && empty($midshipmaninfo['coc_5']) && empty($midshipmaninfo['coc_6'])){
            echo "<div class=\"alert alert-warning text-center\">You have not designated your Chain of Command yet! Click the \"Edit Midshipman Information\" button to proceed.</div>";
        }

        if(isset($midshipmaninfo['coc_0']) && !empty($midshipmaninfo['coc_0'])){
          $coc_0_info = get_user_information($midshipmaninfo['coc_0']);
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
          $coc_1_info = get_user_information($midshipmaninfo['coc_1']);
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
          $coc_2_info = get_user_information($midshipmaninfo['coc_2']);
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
          $coc_3_info = get_user_information($midshipmaninfo['coc_3']);
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
          $coc_4_info = get_user_information($midshipmaninfo['coc_4']);
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
          $coc_5_info = get_user_information($midshipmaninfo['coc_5']);
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
          $coc_6_info = get_user_information($midshipmaninfo['coc_6']);
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

        $subordinates = get_subordinates($_SESSION['username']);

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
