<?php 
  session_start();
  echo "Hello " . $_SESSION['USER_NAME']."<br>";
  
 echo  $_SERVER['SERVER_NAME'] . "<br>";
 echo __FILE__ . "<br>";

?>

<a href="logout.php">logout</a>