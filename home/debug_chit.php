<?php
################################################################
#                  Commented on 17DEC18 by                     #
#                       Harold Mantilla                        #
################################################################

################################################################
#                     Admin only page                          #
#                         Debugs                               #
################################################################

################################################################
#                       Defunct page.                          #
#                  Keeping in case one day I will use it       #
################################################################
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>INSERT TITLE HERE</title>

    <!-- Bootstrap -->
    <link href="/~m190108/IT350/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/~m190108/IT350/css/bootstrap/js/bootstrap.min.js"></script>

    <!-- Local Styles-->
    <link href="/~m190108/IT350/css/bootstrapped_main.css" rel="stylesheet">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Douglas Alpuche">

    <link href="https://fonts.googleapis.com/css?family=Wendy+One" rel="stylesheet">
</head>
<body>

<?php
  $filename = "./chits/m183990_chit1.txt";

  if(is_file($filename)){
    $raw_data = file_get_contents($filename);
    $data = unserialize($raw_data);


    echo "<pre>";
    print_r($data);
    echo "</pre>";

  }
?>

</body>
</html>
