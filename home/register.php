<?php
   session_start();
   $_SESSION['id'] = session_id();
   if(isset($_SESSION['username'])) { header("Location: ./index.php");   die(); }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eChits</title>
    <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="./imgs/icon.ico"/>

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
    <!-- <link type="text/css" rel="stylesheet" href="style.css" /> -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <style>
      .center-div {
        position: absolute;
        margin: auto;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 331px;
        height: 300px;
      }
      h1, body {
        font-family: Raleway;
      }

      .zerodiv {
        padding-left: 0;
        padding-right: 0;
        padding-top: 0;
        padding-bottom: 0;
        margin-top: 0;
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 0;
      }
    </style>

    <script type="text/javascript">
    function restrict_to_navy(){
      var doc = document.getElementById("level");
      if(doc.vaue == "MID"){
        var html = "<select class='form-control' name='service' id='service' onkeypress='rankswitch();' onclick='rankswitch();' required> <option value='USN' selected>USN</option></select>";
      }
      else{
        var html = "<select class='form-control' name='service' id='service' onkeypress='rankswitch();' onclick='rankswitch();' required> <option value='USN' selected>USN</option> <option value='USMC'>USMC</option> </select>";
      }


      var out = document.getElementById("serviceout");
      out.innerHTML = html;
      return;


    }

    function rankswitch(){
      var serv = document.getElementById("service");
      var lev = document.getElementById("level");

      if(lev.value == "MID"){
        var html = "<select class='form-control' name='rank' id='rank' required><option value='MIDN 4/C' selected>MIDN 4/C</option><option value='MIDN 3/C'>MIDN 3/C</option><option value='MIDN 2/C'>MIDN 2/C</option><option value='MIDN 1/C'>MIDN 1/C</option><option value='MIDN ENS'>MIDN ENS</option><option value='MIDN LTJG'>MIDN LTJG</option><option value='MIDN LT'>MIDN LT</option><option value='MIDN LCDR'>MIDN LCDR</option><option value='MIDN CDR'>MIDN CDR</option><option value='MIDN CAPT'>MIDN CAPT</option></select>";

        restrict_to_navy();
      }
      else if(serv.value == "USN" && lev.value == "Officer"){
        var html = "<select class='form-control' name='rank' id='rank' required><option value='LT'>LT</option><option value='LCDR'>LCDR</option><option value='CDR'>CDR</option><option value='CAPT'>CAPT</option></select>";
      }
      else if (serv.value == "USMC" && lev.value == "Officer") {
        var html = "<select class='form-control' name='rank' id='rank' required><option value='Capt'>Capt</option><option value='Maj'>Maj</option><option value='LtCol'>LtCol</option><option value='Col'>Col</option></select>";
      }
      else if(serv.value == "USN" && lev.value == "SEL"){
        var html = "<select class='form-control' name='rank' id='rank' required><option value='ATCS'>ATCS</option><option value='FCCS'>FCCS</option><option value='YNCS'>YNCS</option></select>";
      }
      else if (serv.value == "USMC" && lev.value == "SEL") {
        var html = "<select class='form-control' name='rank' id='rank' required><option value='SSgt'>SSgt</option><option value='GySgt'>GySgt</option></select>";
      }


      var out = document.getElementById("ranks");
      out.innerHTML = html;
      return;
    }
    </script>
  </head>

  <body>
    <?php
       require('./includes/nav.inc.php');
       nav(1);
    ?>
  <div class="center-div">
    <form method=post action="login/register-user.php" id=reg-form onsubmit="return inputCheck(this)">
      <div class="well text-center">
        <h2>eChits Register</h2>

        <select class="form-control" name='level' id="level" onkeypress="rankswitch();" onclick="rankswitch();" required>
          <option value="MID" selected>MID</option>
          <option value="SEL">SEL</option>
          <option value="Officer">Officer</option>
        </select>

        <div id="serviceout" class="zerodiv">
          <select class="form-control" name='service' id="service" onkeypress="rankswitch();" onclick="rankswitch();" required>
            <option value="USN" selected>USN</option>
            <option value="USMC">USMC</option>
          </select>
        </div>

        <div id="ranks" class="zerodiv">
          <select class="form-control" name='rank' id="service" required>
          <option value="MIDN 4/C" selected>MIDN 4/C</option>
          <option value="MIDN 3/C">MIDN 3/C</option>
          <option value="MIDN 2/C">MIDN 2/C</option>
          <option value="MIDN 1/C">MIDN 1/C</option>
          <option value='MIDN ENS'>MIDN ENS</option>
          <option value='MIDN LTJG'>MIDN LTJG</option>
          <option value='MIDN LT'>MIDN LT</option>
          <option value='MIDN LCDR'>MIDN LCDR</option>
          <option value='MIDN CDR'>MIDN CDR</option>
          <option value='MIDN CAPT'>MIDN CAPT</option>
          </select>
        </div>

        </select>


        <input type="text" class="form-control" name="firstname" maxlength="20" placeholder="First name" required>
        <input type="text" class="form-control" name="lastname" maxlength="20" placeholder="Last name" required>
        <input type="text" class="form-control" name="billet" maxlength="40" placeholder="Billet" required>
        <input type="email" class="form-control" name="email" maxlength="20" placeholder="Email" required>
        <input type="text" class="form-control" name="username" maxlength="10" placeholder="Username" required>
        <input type="password" class="form-control" name="password1" maxlength="32" placeholder="Password" required>
        <input type="password" class="form-control" name="password2" maxlength="32" placeholder="Confirm Password" required>

        <!-- <a href=login.php><button type=button>Login</button></a> -->
        <!-- <button type=button class="btn btn-default" onclick="window.location.href='./login.php'">Login</button> -->
        <button type=submit class="btn btn-default" id=register-button form=reg-form value=Register>Register</button>
        <!-- <button type=button class="btn btn-default" onclick="window.location.href='./change.php'">Change password</button> -->
      </div>
      <?php
        if(isset($_SESSION['error'])) {
          echo "<div class=\"alert alert-danger\" id=error>" . $_SESSION['error'] . "</div>";
          unset($_SESSION['error']);
        } else if(isset($_SESSION['success'])) {
          echo "<div class=\"alert alert-success\">".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
       ?>
      <div class="alert alert-danger" id=error style="visibility:hidden;"></div>
    </form>

    <!-- Client-side check  -->
    <script type=text/javascript>
      function inputCheck($form) {
        if($form.elements['username'].value.indexOf(" ") != -1 || $form.elements['username'].value.indexOf("-") != -1) {
          // alert("Username should not contain \" \" or \"-\"!");
          document.getElementById("error").innerHTML = "Username should not contain \" \" or \"-\"!";
          document.getElementById("error").style.visibility = "visible";
          return false;
        } else if($form.elements['email'].value.indexOf("@usna.edu") == -1) { // email not in usna.edu domain
          document.getElementById("error").innerHTML = "Email not in USNA domain!";
          document.getElementById("error").style.visibility = "visible";
          return false;
        }
        return true;
      }

      // document.getElementById("register-button").focus();
    </script>
  </div>

  </body>
</html>
