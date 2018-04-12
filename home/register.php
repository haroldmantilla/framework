<?php

  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Register',
                      'version'    => 1.0,
                      'display'    => '',
                      'tab'        => '',
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
  
  if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['level']) && isset($_POST['billet']) && isset($_POST['service']) && isset($_POST['rank'])){
    
    if(strlen($_POST['firstname']) > 20){
      $_SESSION['error'] = "Firstname too long!";
    }
    
    if(strlen($_POST['lastname']) > 20){
      $_SESSION['error'] = "Lastname too long!";
    }
    
    if(strlen($_POST['billet']) > 40){
      $_SESSION['error'] = "Billet too long!";
    }
    
    
    $level = $_POST['level'];
    $first = $_POST['firstname'];
    $last = $_POST['lastname'];
    $billet = $_POST['billet'];
    $service = $_POST['service'];
    $rank = $_POST['rank'];
    
    register_leader($db, USER['user'], $first, $last, $billet, $rank, $service, $level);
    
    $successful_write = is_user($db, USER['user']);
    
    


    if(!$successful_write) {
      $_SESSION['error'] = "Unsuccessful write to database! Contact the website administrator if the error persists.";
    }
    else{
      header("Location: index.php");
    }
    
  }
  
  
    # Load in The NavBar
    require_once(WEB_PATH.'navbar.php');
  


?>
   <style>
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
    

  <div class="row">
    <div class="col-xs-4">
    </div>
    <div class="col-xs-4">
      <?php 
      if(isset($_SESSION['error'])){
        echo "<div class=\"alert alert-danger text-center\">";
        echo $_SESSION['error'];
        echo "</div>";
      }
      else{
        echo "<div class=\"alert alert-danger text-center\">Your profile is <strong>incomplete!</strong> Please register to continue.</div>";
      }
      ?>
      
    <form method=post action="?" id=reg-form onsubmit="return inputCheck(this)">
      <div class="well text-center">
      
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

        <!-- <a href=login.php><button type=button>Login</button></a> -->
        <button type=submit class="btn btn-default" id=register-button form=reg-form value=Register>Register</button>
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
    
  </div>
  <div class="col-xs-4">
  </div>
</div>

  </body>
</html>
