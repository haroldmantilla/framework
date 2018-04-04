<!DOCTYPE html>
<?php
  session_start();
  if(!isset($_SESSION['username'])){
    //if username isn't set send them to a login page
    header("Location: ./login.php");
}
 ?>
<script type="text/javascript">
  function redirect(location){
    window.location = location;
  }
</script>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="./imgs/icon.ico"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Chits</title>
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



  </head>
  <body>
    <?php
      require('nav.inc.php');
      nav();
    ?>

    <?php
       /****** approve and deny should only edit ./chit/directory.txt *******
        *  Description: when approving/denying a chit,
        *
        *  find the name of the chit in column [1].
        *  then find the user's username in $line[2].
        *  - change # in "MXXXXXX-#" (# is the number following the user's username in $line[2])
        *    - if the user has denied the chit
        *      - change # in user's "MXXXXXX-#" in $line[2] to 2
        *      - change # in $line[3] to 2
        *    - else
        *      - change # in user's "MXXXXXX-#" in $line[2] to 1
        *      - if every # in "MXXXXXX-#" is 1 (every user has approved)
        *        - change $line[3] to 1 (chit is approved)
        */

      $chitname = $_POST['filename'];
      $action = $_POST['update'];


      // IGNORE FOLLOWING DEBUGGING {
        // echo $SESSION['username'] . ' ' . $_POST['filename'];
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
      // }

      $fp = fopen("./chits/directory.txt", "r");
      $data_to_write_back = [];
      if($fp){
        while(($line = fgets($fp)) !== false){
          $split = explode(",", $line);

          if($split[1] == $chitname){

            $coc_all = $split[2];
            $coc = explode(" ", $coc_all);

            $updated_coc = "";

            // echo "$newcoc";

            foreach ($coc as $member) {
              $member = explode("-", $member);
              if($member[0] == $_SESSION['username']){
                if($action == "Approve") {

                  $updated_coc = $updated_coc . $member[0] . "-1 ";

                }
                elseif($action == "Deny") {
                  $updated_coc = $updated_coc . $member[0] . "-2 ";
                  $split[3] = 2;
                  // echo "here";
                }
              }
              else{
                if(!empty($member[0])){
                  $updated_coc = $updated_coc . $member[0] . "-" . $member[1] . " ";
                }
              }

            }

            $count = 1;
            $updated_coc_array = explode(" ", $updated_coc);

            foreach ($updated_coc_array as $member){
              $member = explode("-", $member);
              // echo "$member[1]";
              if($member[1] == 1){
                // echo "here";
                $count = $count + 1;
              }
            }

            if($count == count($updated_coc_array) && $action == "Approve"){
              $split[3] = 1;
            }
            elseif($count != count($updated_coc_array) && $action == "Approve"){
              $split[3] = 0;
            }

            // print_r($updated_coc_array);
            end($updated_coc_array);
            $last = prev($updated_coc_array);

            $last = explode("-", $last);

            // print_r($last);

            if($last[1] == 1){
              // echo "here";
              $split[3] = 1;
            }


            //
            // echo "<pre>";
            // print_r($coc);
            // echo "</pre>";

            $line = $split[0] . ',' . $split[1] . ',' . $updated_coc . ',' . $split[3] . ',' . $split[4];
            array_push($data_to_write_back, $line);
            // echo "Updated: $line";
          }
          else{
            array_push($data_to_write_back, $line);
            // echo "Not alterned: $line";
          }
        }
        fclose($fp);
      }

      $fp = fopen("./chits/directory.txt", "w");
      if($fp){
        foreach($data_to_write_back as $line){

          fwrite($fp, $line);
        }
      }


      header("Location: ./index.php");
      die();
    ?>
  </body>
</html>
