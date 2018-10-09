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
                      'access'     => array('level'=>'MID'));
  ###############################################################

  # Load in Configuration Parameters
  require_once("../etc/config.inc.php");

  # Load in template, if not already loaded
  require_once(LIBRARY_PATH.'template.php');

header("Location: profile_acyear.php");

/******************************************************************************
*******************************************************************************
*******       COMMENTED BY HAROLD MANTILLA 31AUG2018               ************
*******************************************************************************
*******************************************************************************/


//Setting options for dropdown menu to choose who to route the chit to
  if(isset($_REQUEST['to'])){
    //grab midshipman info from the DB using the username
    $midshipmaninfo = get_midshipman_information($db, USER['user']);

    $response = "";
    $pos_0 = null; // dant
    $pos_1 = null; //depdant
    $pos_2 = null; //batt-o
    $pos_3 = null; //CO
    $pos_4 = null; //SEL

    //grab CoC iformation from DB and set user info using result (so seeing who the chit is being routed to)
    $user_info = get_user_information($db, $_REQUEST['to']);

//**************************IF ROUTING TO DANT***************************************************************//
    if($_REQUEST['to'] == $midshipmaninfo['coc_0']){                            //if the chit is being routed to the dant

      if(!empty($midshipmaninfo['coc_0'])){                                     // if this position in the CoC is set (always dant)
        $info = get_user_information($db, $midshipmaninfo['coc_0']);            // grab dant from DB
        $pos_0 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // variable set pos_0 to dant (or whoever was grabbed from DB in pos_0)
      }

      if(!empty($midshipmaninfo['coc_1'])){                                     // if this posiiton in CoC is set (always depdant)
        $info = get_user_information($db, $midshipmaninfo['coc_1']);            // grab depdant from DB
        $pos_1 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos 1 to depdant (or whoever was theoretically grabbed from DB in pos_1)
      }

      if(!empty($midshipmaninfo['coc_2'])){                                     // if this position is set (a batt-o)
        $info = get_user_information($db, $midshipmaninfo['coc_2']);            // grab batt-o from DB
        $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_2 to batt-o
      }

      if(!empty($midshipmaninfo['coc_3'])){                                     // if this position is set (a CO)
        $info = get_user_information($db, $midshipmaninfo['coc_3']);            // grab CO from DB
        $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_3 to user's DB CO
      }

      if(!empty($midshipmaninfo['coc_4'])){                                     // if this position isset (SEL)
        $info = get_user_information($db, $midshipmaninfo['coc_4']);            // grab SEL from DB
        $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_4 to SEL
      }
    }                                                                           //end if dant
//**************************END ROUTING TO DANT***************************************************************//



//**************************IF ROUTING TO DEPDANT***************************************************************//
    elseif($_REQUEST['to'] == $midshipmaninfo['coc_1']){                        //if request is to depdant
      $pos_0 = "<br><br><br>";                                                  //make dant space on chit empty

      if(!empty($midshipmaninfo['coc_1'])){                                     // if coc_1 isset
        $info = get_user_information($db, $midshipmaninfo['coc_1']);            // grab user's coc_1 (depdant) from DB
        $pos_1 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_1 to depdant
      }

      if(!empty($midshipmaninfo['coc_2'])){                                     // if coc_2 isset
        $info = get_user_information($db, $midshipmaninfo['coc_2']);            // grab user's coc_2 from DB
        $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_2 to user's batt-o
      }

      if(!empty($midshipmaninfo['coc_3'])){                                     // if coc_3 isset
        $info = get_user_information($db, $midshipmaninfo['coc_3']);            // grab user's coc_3 from DB
        $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_3 to user's DB coc_3 (usually CO)
      }

      if(!empty($midshipmaninfo['coc_4'])){                                     // if coc_4 isset
        $info = get_user_information($db, $midshipmaninfo['coc_4']);            // grab user's coc_4 from DB
        $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_4 to user's DB CoC_4 (SEL)
      }
    }
//**************************END ROUTING TO DEPDANT***************************************************************//


//**************************IF ROUTING TO BATT-O***************************************************************//
    elseif($_REQUEST['to'] == $midshipmaninfo['coc_2']){

      $pos_0 = "<br><br><br>";                                                  // make dant space on chit empty
      $pos_1 = "<br><br><br>";                                                  // make depdant space on chit empty

      if(!empty($midshipmaninfo['coc_2'])){                                     // if coc_2 isset
        $info = get_user_information($db, $midshipmaninfo['coc_2']);            // grab user's coc_2 from DB (batt-0)
        $pos_2 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_2 to user's DB coc_2 (batt-o)
      }

      if(!empty($midshipmaninfo['coc_3'])){                                     // if coc_3 isset
        $info = get_user_information($db, $midshipmaninfo['coc_3']);            // grab user's coc_3 from DB
        $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_3 to user's DB coc_3 (usually CO)
      }

      if(!empty($midshipmaninfo['coc_4'])){                                     // if coc_4 isset
        $info = get_user_information($db, $midshipmaninfo['coc_4']);            // grab user's coc_4 from DB
        $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_4 to user's DB CoC_4 (SEL)
      }
    }
//**************************END ROUTING TO BATT-O***************************************************************//


//**************************IF ROUTING TO CO***************************************************************//
    elseif($_REQUEST['to'] == $midshipmaninfo['coc_3']){                        // if being sent to CO

      $pos_0 = "<br><br><br>";                                                  // set dant space on chit to empty
      $pos_1 = "<br><br><br>";                                                  // set depdant space on chit to empty
      $pos_2 = "<br><br><br>";                                                  // set batt-o space on chit to empty


      if(!empty($midshipmaninfo['coc_3'])){                                     // if coc_3 isset
        $info = get_user_information($db, $midshipmaninfo['coc_3']);            // grab user's coc_3 from DB
        $pos_3 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_3 to user's DB coc_3 (usually CO)
      }

      if(!empty($midshipmaninfo['coc_4'])){                                     // if coc_4 isset
        $info = get_user_information($db, $midshipmaninfo['coc_4']);            // grab user's coc_4 from DB
        $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pso_4 to user's DB CoC_4 (SEL)
      }
    }
//**************************END ROUTING TO CO***************************************************************//



//**************************IF ROUTING TO SEL***************************************************************//
    elseif($_REQUEST['to'] == $midshipmaninfo['coc_4']){

      $pos_0 = "<br><br><br>";                                                  // set dant space in chit empty
      $pos_1 = "<br><br><br>";                                                  // set depdant space in chit empty
      $pos_2 = "<br><br><br>";                                                  // set BATT-O space in chit empty
      $pos_3 = "<br><br><br>";                                                  // set CO dant space in chit empty

      if(!empty($midshipmaninfo['coc_4'])){                                     // if coc_4 isset
        $info = get_user_information($db, $midshipmaninfo['coc_4']);            // grab user's coc_4 from DB
        $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";    // set variable pos_4 to user's DB coc 4
      }
    }
//**************************END ROUTING TO SEL***************************************************************//

// at this point, you assume that the chit will not route to anyone lower than SEL, which is fair
// Now, you are setting the rest of the CoC in the chit

    if(!empty($midshipmaninfo['coc_5'])){                                       // if CC is not empty
      $info = get_user_information($db, $midshipmaninfo['coc_5']);              // grab CC from DB
      $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";      // set pos_5 to CC
    }                                                                           // end if
    else{                                                                       // else if CC is empty
      $pos_5 = "<br><br><br>";                                                  // fill in CC spot with a blank
    }

    if(!empty($midshipmaninfo['coc_6'])){                                       // if XO is not empty
      $info = get_user_information($db, $midshipmaninfo['coc_6']);              // grab XO from DB
      $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";      // set pos_6 to XC
    }                                                                           // end if not empty
    else{                                                                       // else if XO is empty
      $pos_6 = "<br><br><br>";                                                  // fill in XO spot as blank
    }

    if(!empty($midshipmaninfo['coc_7'])){                                       // if PC is not empty
      $info = get_user_information($db, $midshipmaninfo['coc_7']);              // grab PC from DB
      $pos_7 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";      // set pos_7 to PC
    }                                                                           // end if not empty
    else{                                                                       // else if PC empty
      $pos_7 = "<br><br><br>";                                                  // fill in PC spot as blank
    }

    if(!empty($midshipmaninfo['coc_8'])){                                       // if SL is not empty
      $info = get_user_information($db, $midshipmaninfo['coc_8']);              // grab SL from DB
      $pos_8 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";      // set pos_8 to SL
    }                                                                           // end if not empty
    else{                                                                       // else if SL empty
      $pos_8 = "<br><br><br>";                                                  // fill in SL spot as blank
    }

// ************* Not sure what this old code is, commented out by Scott Mayer previous to v1.2  ******//

    // elseif(!empty($midshipmaninfo['coc_5'])){
    //   $pos_3 = "<br><br><br>";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_5']);
    //   $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_4']);
    //   $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_3']);
    //   $pos_4 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    //
    // }
    // elseif(!empty($midshipmaninfo['coc_4'])){
    //   $pos_3 = "<br><br><br>";
    //   $pos_4 = "<br><br><br>";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_4']);
    //   $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_3']);
    //   $pos_5 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    //
    // }
    //
    // elseif(!empty($midshipmaninfo['coc_3'])){
    //   $pos_3 = "<br><br><br>";
    //   $pos_4 = "<br><br><br>";
    //   $pos_5 = "<br><br><br>";
    //
    //   $info = get_user_information($db, $midshipmaninfo['coc_3']);
    //   $pos_6 = "{$info['rank']} {$info['lastName']}<br>{$info['billet']}";
    // }
    // else{
    //   $pos_3 = "<br><br><br>";
    //   $pos_4 = "<br><br><br>";
    //   $pos_5 = "<br><br><br>";
    //   $pos_6 = "<br><br><br>";
    // }

// ************* Not sure what this old code is, commented out by Scott Mayer previous to v1.2  ******//


    echo $pos_0 . ";" . $pos_1 . ";" . $pos_2 . ";" . $pos_3 . ";" . $pos_4 . ";". $pos_5 . ";". $pos_6 . ";" . $pos_7 . ";" . $pos_8 ;
    // header("location: makechit.php");
    die;
    //kill if statement
  }

//*****************************************************************************************//
//************** this is where you start filling in the chit itself **********************//
//*****************************************************************************************//

//if post is set, write to database, redirect to viewchit
  if(isset($_POST['SHORT_DESCRIPTION']) && isset($_POST['TO_USERNAME']) && isset($_POST['REFERENCE']) && isset($_POST['REQUEST_TYPE']) && isset($_POST['ADDRESS_CITY']) && isset($_POST['ADDRESS_2']) && isset($_POST['ADDRESS_STATE']) && isset($_POST['ADDRESS_ZIP']) && isset($_POST['REMARKS']) && isset($_POST['BEGIN_DATE']) && isset($_POST['BEGIN_TIME']) && isset($_POST['END_DATE']) && isset($_POST['END_TIME'])){


        $midshipmaninfo = get_midshipman_information($db, USER['user']);

        $userinfo = get_user_information($db, USER['user']);


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

        $chitnumber = get_next_chit_number($db);
        // $_SESSION['error'] = $chitnumber;

        if(empty($chitnumber)){
          $chitnumber = 1;
        }


        $today = date("dMy");
        $today = strtoupper($today);

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

        create_chit($db, $chitnumber, USER['user'], $_POST['SHORT_DESCRIPTION'], $_POST['REFERENCE'], $_POST['REQUEST_TYPE'], $requestOther, $addr_1, $_POST['ADDRESS_2'], $_POST['ADDRESS_CITY'], $_POST['ADDRESS_STATE'], $_POST['ADDRESS_ZIP'], $_POST['REMARKS'], $today, $_POST['BEGIN_DATE'], $_POST['BEGIN_TIME'], $_POST['END_DATE'], $_POST['END_TIME'], $_POST['ORM'], $_POST['DOCS'], $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8);

        $afterchitnumber = get_next_chit_number($db);
        if($afterchitnumber > $chitnumber){
          $_SESSION['success'] = "Chit has been submitted!";
          $_SESSION['chit'] = $chitnumber;
          //WOULD NOT SAVE PC OR SQL FOR SOME REASON UNTIL I ADDED THIS BOTTOM LINE
          update_chit($db, $chitnumber, USER['user'], $_POST['SHORT_DESCRIPTION'], $_POST['REFERENCE'], $_POST['REQUEST_TYPE'], $requestOther, $addr_1, $_POST['ADDRESS_2'], $_POST['ADDRESS_CITY'], $_POST['ADDRESS_STATE'], $_POST['ADDRESS_ZIP'], $_POST['REMARKS'], $today, $_POST['BEGIN_DATE'], $_POST['BEGIN_TIME'], $_POST['END_DATE'], $_POST['END_TIME'], $_POST['ORM'], $_POST['DOCS'], $coc_0, $coc_1, $coc_2, $coc_3, $coc_4, $coc_5, $coc_6, $coc_7, $coc_8);
          // echo "<script type='text/javascript'>redirect('viewchit.php')</script>";
          header("Location: viewchit.php");
//---------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------
          //$aggregate = $aboveCoC."_username";  // grab whatever coc it is
          if($coc_8!=null){
            $upperCoC = $coc_8;
          } elseif($coc_7!=null){
            $upperCoC = $coc_7;
          }elseif($coc_6!=null){
            $upperCoC = $coc_6;
          }elseif($coc_5!=null){
            $upperCoC = $coc_5;
          }elseif($coc_4!=null){
            $upperCoC = $coc_4;
          }elseif($coc_3!=null){
            $upperCoC = $coc_3;
          }elseif($coc_2!=null){
            $upperCoC = $coc_2;
          }elseif($coc_1!=null){
            $upperCoC = $coc_1;
          }elseif($coc_0!=null){
            $upperCoC = $coc_0;
          }

          //$to = "m194020@usna.edu";

          $to = "$upperCoC@usna.edu";                                     // who to send email to
          //{$chit['creator']} this is who it should send to eventually
          $subject = "A chit has been created.";
                                        // SUBJECT OF THE EMAIL
          $midshipmaninfo = get_user_information($db, USER['user']);
          // THIS IS FOR FUTURE USE

          $txt = "
          Creator: {$midshipmaninfo['rank']} {$midshipmaninfo['firstName']} {$midshipmaninfo['lastName']}, {$midshipmaninfo['service']}
          Description:\"{$_POST['SHORT_DESCRIPTION']}\"\n";

//          $txt = "Chit by {$coc_email['firstName']} {$coc_email['lastName']}, {$coc_email['service']}
  //        \nLog in at midn.cs.usna.edu/project-echits to review the chit. \n";

          $headers = "From: eChits@noreply.edu" . "\r\n"; // IT WILL SEND FROM THIS ADDRESS


          sendemail($to,$subject,$txt,$headers); // ACTUALLY SENDS EMAIL


//---------------------------------------------------------------------------------

//----------------------------------------------------------------------------------

        }
        else{
          $_SESSION['error'] = "Error creating chit! Contact the web administrator.";
        }


    }
    elseif(isset($_POST['SHORT_DESCRIPTION']) && isset($_POST['TO_USERNAME']) && isset($_POST['REFERENCE']) && isset($_POST['ADDRESS_CITY']) && isset($_POST['ADDRESS_2']) && isset($_POST['ADDRESS_STATE']) && isset($_POST['ADDRESS_ZIP']) && isset($_POST['REMARKS']) && isset($_POST['BEGIN_DATE']) && isset($_POST['BEGIN_TIME']) && isset($_POST['END_DATE']) && isset($_POST['END_TIME'])){
      $_SESSION['error'] = "Select a request type!";
    }




  # Load in The NavBar
  require_once(WEB_PATH.'navbar.php');


  $midshipmaninfo = get_midshipman_information($db, USER['user']);
  $userinfo = get_user_information($db, USER['user']);


?>


<script type="text/javascript">
function redirect(location){
  window.location = location;
}
</script>

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
      // console.log(coc);
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

#courier {
  font-family: "Courier New", Courier, monospace;
}

</style>

<?php


if(!isset($_SESSION['visit'])){
  $_SESSION['visit'] = true;
}
else{
  $_SESSION['visit'] = false;
}


$_SESSION['submitted']=0;


?>
<div class="container" id="courier">


  <div id="banner">

  </div>


    <form  role="form" action="?" method="post">


      <div class="row" style="border: 1px solid #000000">
        <div class="col-sm-12">



    <div class="row" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top: 1px solid #000000;">
      <div class="col-sm-12">
        <strong>Special Request (Midshipman)</strong>
        <input required type="text" name="SHORT_DESCRIPTION" class="form-control-sm" placeholder="Briefly describe your request in one sentence." size="60" maxlength="100" value="<?php if(isset($_POST['SHORT_DESCRIPTION'])){echo "{$_POST['SHORT_DESCRIPTION']}";}?>"/>
        <button style="float: right;" type="button" class="btn btn-default" data-toggle="modal" data-target="#whoModal">Who should I route my chit to?</button>

      </div>
    </div>


    <div class="row" style="border-bottom:1px solid #000000;">

      <div class="col-sm-6" style="border-left: 1px solid #000000; border-top: 1px solid #000000; ">
        <div class="row">
          <div class="col-sm-1">
            To:
          </div>


          <div class="col-sm-11">
            <select id="route_to" onchange="routeTo();" class="form-control" name="TO_USERNAME" >
              <?php if(isset($midshipmaninfo['coc_4'])  && !is_midshipman($db, $midshipmaninfo['coc_4'])){
                $option_info = get_user_information($db, $midshipmaninfo['coc_4']);
                echo "<option value=\"{$midshipmaninfo['coc_4']}\">";
                echo "{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
              }?>

              <?php if(isset($midshipmaninfo['coc_3'])  && !is_midshipman($db, $midshipmaninfo['coc_3'])){
                $option_info = get_user_information($db, $midshipmaninfo['coc_3']);
                echo "<option value=\"{$midshipmaninfo['coc_3']}\">";
                echo "{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
              }?>

              <?php if(isset($midshipmaninfo['coc_2']) && !is_midshipman($db, $midshipmaninfo['coc_2'])){
                $option_info = get_user_information($db, $midshipmaninfo['coc_2']);
                echo "<option value=\"{$midshipmaninfo['coc_2']}\">";
                echo "{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
              }?>

              <?php if(isset($midshipmaninfo['coc_1'])  && !is_midshipman($db, $midshipmaninfo['coc_1'])){
                $option_info = get_user_information($db, $midshipmaninfo['coc_1']);
                echo "<option value=\"{$midshipmaninfo['coc_1']}\">";
                echo "{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']}</option>";
              }?>

              <?php
              if(isset($midshipmaninfo['coc_0']) && !is_midshipman($db, $midshipmaninfo['coc_0'])){
                $option_info = get_user_information($db, $midshipmaninfo['coc_0']);
                echo "<option value=\"{$midshipmaninfo['coc_0']}\">";
                echo "{$option_info['rank']} {$option_info['firstName']} {$option_info['lastName']}, {$option_info['service']} </option>";
              }?>





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
                echo "{$userinfo['rank']} {$userinfo['firstName']} {$userinfo['lastName']}, {$userinfo['service']}";
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
                      echo "{$userinfo['rank']}";
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
                    <?php

                    echo "<option value=\"COMDTMIDNINST 5400.6T MIDREGS\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 5400.6T MIDREGS"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 5400.6T MIDREGS</option>";


                    echo "<option value=\"COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 1020.3B MIDSHIPMEN UNIFORM REGULATIONS</option>";

                    echo "<option value=\"COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 1050.2 OVERSEAS LEAVE/LIBERTY POLICY</option>";

                    echo "<option value=\"COMDTMIDNINST 1531.1 TAILGATING SOP\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1531.1 TAILGATING SOP"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 1531.1 TAILGATING SOP</option>";


                    echo "<option value=\"COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 1601.10L BANCROFT HALL WATCH INSTRUCTION</option>";

                    echo "<option value=\"COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 3500.1 DINING-INS AND DINING OUTS</option>";

                    echo "<option value=\"COMDTMIDNINST 1610.2H CONDUCT MANUAL\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1610.2H CONDUCT MANUAL"){
                      echo "selected=\"selected\"";
                    }
                    echo ">COMDTMIDNINST 1610.2H CONDUCT MANUAL</option>";

                    echo "<option value=\"COMDTMIDNINST 1600.2H APTITUDE FOR COMMISSION SYSTEM\" ";
                    if(isset($_POST['REFERENCE']) && $_POST['REFERENCE'] == "COMDTMIDNINST 1600.2H APTITUDE FOR COMMISSION SYSTEM"){
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

                    <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 15px">
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
                    <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 15px;">
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
                    <div class="col-sm-3" style="border-left: 1px solid #000000; border-top: 1px solid #000000; padding-bottom: 15px;">
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
                    <div class="col-sm-3" style="border-left: 1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; padding-bottom: 15px;">
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
      Weekend Liberty:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="WEEKEND_LIBERTY" value="W" <?php if(isset($_POST['REQUEST_TYPE']) && $_POST['REQUEST_TYPE'] == "W"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Dining Out:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="DINING_OUT" value="D" <?php if(isset($_POST['REQUEST_TYPE']) && $_POST['REQUEST_TYPE'] == "D"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-2">
      Leave:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="LEAVE" value="L" <?php if(isset($_POST['REQUEST_TYPE']) && $_POST['REQUEST_TYPE'] == "L"){echo "checked";}?>>
    </div>
    <div class="col-sm-1">

    </div>
    <div class="col-sm-1">
      Other:
      <input class="form-check-input" name="REQUEST_TYPE" type="radio" name="OTHER" value="O" <?php if(isset($_POST['REQUEST_TYPE']) && $_POST['REQUEST_TYPE'] == "O"){echo "checked";}?>>
    </div>
    <div class="col-sm-2">
      <input type="text" name="REQUEST_OTHER" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($_POST['REQUEST_OTHER'])){echo "{$_POST['REQUEST_OTHER']}";}?>">
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
      <input type="text" name="ADDRESS_1" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($_POST['ADDRESS_1'])){echo "{$_POST['ADDRESS_1']}";}?>">
    </div>
    <div class="col-sm-3">
      <input required type="text" name="ADDRESS_2" class="form-control-sm" placeholder="" size="10" maxlength="30" value="<?php if(isset($_POST['ADDRESS_2'])){echo "{$_POST['ADDRESS_2']}";}?>">
    </div>

    <div class="col-sm-3">
      <input required type="text" name="ADDRESS_CITY" class="form-control-sm" placeholder="" size="20" maxlength="30" value="<?php if(isset($_POST['ADDRESS_CITY'])){echo "{$_POST['ADDRESS_CITY']}";}?>">
      <input pattern=".{2}" title="i.e. MD" required type="text" name="ADDRESS_STATE" class="form-control-sm" placeholder="XX" size="2" maxlength="2" value="<?php if(isset($_POST['ADDRESS_STATE'])){echo "{$_POST['ADDRESS_STATE']}";}?>">
    </div>

    <div class="col-sm-1">
      <input pattern=".{5}" title="i.e. 21412" required type="text" name="ADDRESS_ZIP" class="form-control-sm" placeholder="XXXXX" size="5" maxlength="5" value="<?php if(isset($_POST['ADDRESS_ZIP'])){echo "{$_POST['ADDRESS_ZIP']}";}?>">

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
      <textarea class="form-control" maxlength="1950" rows="10" name="REMARKS"><?php
      // echo "<pre>";
      // print_r($midshipmaninfo);
      // echo "</pre>";
      if(isset($_POST['REMARKS'])){echo "{$_POST['REMARKS']}";}?></textarea>
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
              $today = date("dMy");
              $today = strtoupper($today);
              echo "$today";
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
              <input pattern=".{4}" title="i.e. 1800" required type="text" name="BEGIN_TIME" class="form-control-sm" placeholder="1745" size="4" value="<?php if(isset($_POST['BEGIN_TIME'])){echo "{$_POST['BEGIN_TIME']}";}?>">

              <input pattern=".{7}" title="i.e. 01JAN17" required type="text" name="BEGIN_DATE" class="form-control-sm" placeholder="01DEC17" size="7" value="<?php if(isset($_POST['BEGIN_DATE'])){echo "{$_POST['BEGIN_DATE']}";}?>">

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="row" style="border-left: 1px solid #000000; ">
            <div class="col-sm-12">
              Ending (Time & Date)
            </div>
            <div class="col-sm-12">

                <input pattern=".{4}" title="i.e. 1800" required type="text" name="END_TIME" class="form-control-sm" placeholder="1745" size="4" value="<?php if(isset($_POST['END_TIME'])){echo "{$_POST['END_TIME']}";}?>">

                <input pattern=".{7}" title="i.e. 01JAN17" required type="text" name="END_DATE" class="form-control-sm" placeholder="01DEC17" size="8" value="<?php if(isset($_POST['END_DATE'])){echo "{$_POST['END_DATE']}";}?>">

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
          <div class="row">
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
  <input type="text" name="ORM" class="form-control" width="100%" placeholder="If required for your chit, paste a link to your ORM." maxlength="200" value="<?php if(isset($_POST['ORM'])){echo "{$_POST['ORM']}";}?>"/>
</div>


<div class="form-group">
  <label for="ORM">Supporting Documents Link:</label>
  <input type="text" name="DOCS" class="form-control" width="100%" placeholder="If required for your chit, paste a link to your supporting documents, such as flight receipts." maxlength="200" value="<?php if(isset($_POST['DOCS'])){echo "{$_POST['DOCS']}";}?>"/>
</div>

<!-- Who Modal -->
<div id="whoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title text-center">Who should I route my chit to?</h2>
      </div>
      <div class="modal-body">
        <h3>2.2 Special Requests</h3>
        <ol>
          <li>The right of any midshipman to make a special request of their organizational superiors may not be denied or restricted. If a midshipman feels that special circumstances warrant an exception to any regulation or directive, that midshipman may submit a special request to an approval authority to obtain relaxation or modification of the regulation.
            <ol style="list-style-type: lower-alpha; padding-bottom: 0;">

              <li>Requests will be forwarded promptly through the chain of command to the appropriate level for decision. When appropriate, the reason should be stated when a request is not approved or recommended.</li>

              <li>No person will, through intent or neglect, fail to act on or forward promptly any request or appeal which is his/her duty to act on or forward.</li>

              <li>Requests for exchange of duty will be made only between midshipmen fully qualified to stand each other’s watches. Exchanges of duty will be made for at least one full day.</li>

              <li>A special request chit must be submitted at least three working days prior to the request. If the request requires Battalion Officer approval, it should be submitted at least five working days in advance. If the request requires Commandant or Deputy Commandant approval, the request should be submitted at least seven working days in advance.</li>

              <li>Midshipmen shall not act on a special request until they have approval as required below.</li>
            </ol>
          </li>
          <li>Approval Authority
            <ol style="list-style-type: lower-alpha; padding-bottom: 0;">
              <li><strong>**Commandant:</strong>
                <ol>
                  <li>Use of alcohol at any Naval Academy sponsored event except where delegated to the Battalion Officer by the Commandant. Requestors must complete the alcohol and drug education officer's special request chit before submitting requests to be included with request package.</li>
                  <li>Any outside employment.</li>
                </ol>
              </li>
              <li><strong>**Deputy Commandant:</strong>
                <ol>
                  <li>Change of company for a midshipman. Company changes shall be in effect through graduation, to include the graduation processions.</li>
                </ol>
              </li>
              <li><strong>Battalion Officer:</strong>
                <ol>
                  <li>Emergency leave requests.</li>
                  <li>Special leave requests up to 96 hours.</li>
                  <li>Regular OCONUS leave requests.</li>
                  <li>Convalescent leave outside Bancroft Hall.</li>
                  <li>Excusals from any mandatory Brigade or Battalion level event, to include but not limited to football games, Distinguished Artist Series, Forrestal Lectures, and Battalion Spirit Nights.</li>
                  <li>Participation in inherently hazardous activities (refer to Chapter 5.5, paragraph 2e).</li>
                  <li>Replacement of a lost/stolen ID card (second offense).</li>
                  <li>Alcohol chits for Battalion and Company level events such as football tailgates, dining in/outs, company picnics, and movement orders.</li>
                  <li>Replacement of a lost/stolen ID card (second offense).</li>
                </ol>
              </li>
              <li><strong>**Commandant Operations Officer:</strong>
                <ol>
                  <li>ORM Memorandums from High Risk ECAs identified by the Commandant of Midshipmen.</li>
                </ol>
              </li>
              <li><strong>**Officer of the Watch:</strong>
                <ol>
                  <li>Emergency leave request chits during non-working hours.</li>
                  <li>Cutting locks in seventh and eighth wing locker spaces.</li>
                </ol>
              </li>
              <li><strong>Company Officer and Senior Enlisted Leader</strong>
                <ol>
                  <li>Missing class.</li>
                  <li>Endorsement to Academic Dean to miss a regularly scheduled examination during end of semester or academic reserve periods.</li>
                  <li>Missing taps and liberty extensions up to 12 hours for ORM purposes.</li>
                  <li>Special town liberty, including liberty for 4/C to attend religious services at a house of worship located within the 35 mile radius.</li>
                  <li>Excusal from military evolutions, including swimming and PE remedials, parades, restriction musters, intramurals, and formations.</li>
                  <li>Assess weekend eligibility requirements.</li>
                  <li>Guests of individual midshipmen to dine in King Hall (O-5 and below).</li>
                  <li>Authorization to reside in Bancroft Hall during leave periods.</li>
                  <li>Regular INCONUS leave requests.</li>
                  <li>Attendance at sporting events that are not on the Yard or not at the BSC during non-liberty hours (SAT 1/C, 2/C, and 3/C only).</li>
                  <li>Replacement of a lost/stolen ID card (first offense).</li>
                  <li>Conduct of “spirit missions.”</li>
                  <li>Wearing Navy/USMC related technical PT gear for endurance sports when working out off the Yard.</li>
                  <li>Grant one weekend per semester to eligible members of a Color Squad.</li>
                </ol>
              </li>
              <li><strong>**Company Commander:</strong>
                <ol>
                  <li>Workout times earlier than 0545 for company personnel on an individual basis.</li>
                  <li>Sign-in formations for weekday noon meal and weekday evening meal formations if meals are rolling tray.</li>
                  <li>Reservation of the company wardroom for events or meetings.</li>
                </ol>
              </li>
              <li><strong>**Squad Leader:</strong>
                <ol>
                  <li>Late lights for 4/C in squad.</li>
                  <li>Early lights before 2200 for 4/C in squad.</li>
                  <li>Carry-on for squad at meals.</li>
                </ol>
              </li>

<ol>
      </div>
      <div class="modal-footer">

        <div class="col-xs-8 text-left">
          <div class="previous">
            ** Not currently supported by eChits
          </div>
        </div>
        <div class="col-xs-4 text-right">
          <div class="next">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>


      </div>
    </div>

  </div>
</div>

</form>

</body>
</html>
