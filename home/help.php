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

if(isset($_POST['sent']) && $_POST['sent']){
  echo "<h1>sent<h1>";
}
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
                  <input class="form-control" id="fullname" name="fullname" type="text" placeholder="Your Name *" required data-validation-required-message="Please enter your name.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="email" name="email" type="email" placeholder="Your Email *" required data-validation-required-message="Please enter your email address.">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <textarea class="form-control" id="message" name = "message" placeholder="Please explain your problem in depth so we can better address it. *" required data-validation-required-message="Please enter a message."></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-xl" type="submit">Submit</button>
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

<script>
function sanitize(){                          //SANITIZE URL INPUT, IF QUERY DISPLAYED IN URL, GET RID OF IT
  if(window.location.href.indexOf('?') != -1){  //IS QUERY IN URL?
    var myarr = document.location.href.split("?");//EXPLODE  URL BY "?"
    document.location.href = myarr[0];            //SET URL TO URL BEFORE QUERY
  }
}

window.onload = sanitize;
</script>
