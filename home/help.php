<?php


  ###############################################################
  #              Security and Navbar Configuration              #
  ###############################################################
  $MODULE_DEF = array('name'       => 'Help',
                      'version'    => 1.0,
                      'display'    => 'help',
                      'tab'        => 'user',
                      'position'   => 4,
                      'student'    => true,
                      'instructor' => true,
                      'guest'      => true,
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

<?php


if(isset($_POST['fullname']) &&
isset($_POST['email']) &&
isset($_POST['message'])){



  //
   $to = "m194020@usna.edu";
   $subject = "eChits Contact Email";
  // $txt = "test";
   $headers = "From: eChits@noreply.edu \r\n";

  $txt = "From: {$_POST["fullname"]}
  Email: {$_POST["email"]}
  Message: {$_POST["message"]}";

 $_POST['sent'] = mail($to,$subject,$txt,$headers);

}

//if(isset($_POST['sent']) && $_POST['sent']){

?>
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

<?php

  //echo "<div class='alert alert-success' data-dismiss='alert' aria-label='close'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a> <strong>Sent.</strong> Sent!</div> ";
//}
?>







<div class = "container">
<div class = "row">
<div class = "col-md-2">

</div>
<div class = "col-md-8">


  <!-- Contact -->
  <section id="contact">
    <div class = "well">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Contact Website Administrator</h2>
          <h6 class="section-subheading text-muted">Report bugs/feedback to Harold Mantilla</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form id="contactForm" method = "POST" name="sentMessage" novalidate>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input required="required" class="form-control" id="fullname" name="fullname" type="text" placeholder="Your Name *" required data-validation-required-message="Please enter your name.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input required="required" class="form-control" id="email" name="email" type="email" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <textarea required="required" class="form-control" id="message" name = "message" placeholder="Please explain your problem in depth so we can better address it. *" required data-validation-required-message="Please enter a message."></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-xl" data-toggle="modal" data-target="#whoModal" type="submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </section>




<br>

</div>
<div class = "col-md-2">

</div>

</div>
</div>

<!-- <script>
function sanitize(){                          //SANITIZE URL INPUT, IF QUERY DISPLAYED IN URL, GET RID OF IT
  if(window.location.href.indexOf('?') != -1){  //IS QUERY IN URL?
    var myarr = document.location.href.split("?");//EXPLODE  URL BY "?"
    document.location.href = myarr[0];            //SET URL TO URL BEFORE QUERY
  }
}

window.onload = sanitize;
</script> -->
