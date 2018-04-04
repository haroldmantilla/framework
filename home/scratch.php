<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Test</title>
  </head>
  <body>
    

<?php 

if(isset($_REQUEST['alpha'])){
  echo "{$_REQUST['alpha']}";
  
}

 ?>


<form class="form" action="scratch.php" method="post">
  <input type="hidden" name="alpha" value="m183990">
  <input type="submit" name="submit" value="button">  
</form>


</body>
</html>
