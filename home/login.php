
<?php
  session_start();
  $_SESSION['id'] = session_id();
  if(isset($_SESSION['username'])) { header("Location: ./index.php"); die(); }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="./imgs/icon.ico"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eChits</title>
    <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
      .btn-space {
        margin-top: 10px;
      }

    </style>

  </head>

  <body>
<?php
  require('./includes/nav.inc.php');
  nav(1);
?>
  <div class=center-div>
    <form method="post" action="./login/login-user.php" id="form1">
      <div class="well text-center">
        <h2>eChits Login</h2>
        <input type=text class=form-control name=username placeholder=Username required>
        <input type=password class=form-control name=password placeholder=Password required>

        <div class="col-xs-6 text-left">
          <div class="previous">
              <button type=submit class="btn btn-default btn-space" form=form1 value=Login>Login</button>
          </div>
        </div>
        <div class="col-xs-6 text-right">
          <div class="next">
            <button type=button class="btn btn-default btn-space" onclick="window.location.href='./register.php'">Register</button>

          </div>
        </div>
        <br />
        <br />
        <!-- <button type=button class="btn btn-default" onclick="window.location.href='./change.php'" >Change password</button> -->
      </div>
      <?php
        if(isset($_SESSION['error'])) {
          echo "<div class=\"alert alert-danger\">".$_SESSION['error']."</div>";
          unset($_SESSION['error']);
        } else if(isset($_SESSION['success'])) {
          echo "<div class=\"alert alert-success\">".$_SESSION['success']."</div>";
          unset($_SESSION['success']);
        }
       ?>
    </form>
    <div id="msg"></div>
  </div>

  </body>
</html>
