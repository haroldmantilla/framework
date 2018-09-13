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

// $to = "m194020@usna.edu";
// $subject = "A chit is ready for your approval!";
// $txt = "Log in at midn.cs.usna.edu/project-echits to review the chit.
// I am the better CS/IT major and platoon sam can eat my dust";
// $headers = "From: eChits@noreply.edu" . "\r\n" .
// "CC: m194020@usna.edu";
//
// sendemail($to,$subject,$txt,$headers);

<div class = "container">
<div class = "row">
<div class = "col-md-2">

</div>
<div class = "col-md-8">


  <!-- Contact -->
  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Contact Us</h2>
          <h3 class="section-subheading text-muted">We may or may not get to you.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form id="contactForm" name="sentMessage" novalidate>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" id="name" type="text" placeholder="Your Name *" required data-validation-required-message="Please enter your name.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="email" type="email" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="phone" type="tel" placeholder="Your Phone *" required data-validation-required-message="Please enter your phone number.">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <textarea class="form-control" id="message" placeholder="Your Message *" required data-validation-required-message="Please enter a message."></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-xl" type="submit">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

Website Administrator is Harold Mantilla. If you run into any issues please contact me at:
<br>
m194020@usna.edu
</div>
<div class = "col-md-2">

</div>

</div>
</div>
