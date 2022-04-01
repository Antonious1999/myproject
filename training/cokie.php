<?php
  if(isset($_POST['btnset'])){
    setcookie("user","ahmed");
  }
  if(isset($_POST['btnget'])){
    echo @$_COOKIE['user'];
  }
  if(isset($_POST['index'])){
      header("location:index.php");
  }
  if(isset($_POST['test'])){
      $user=@$_SESSION['user'] or die("No session");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        label{
            display: block;
            margin: 57px;
        }
        button{
            display: block;
            margin: 57px;
        }
        </style>
</head>
<body>
    <form  method="post"  action="<?php $_SERVER['PHP_SELF'] ?>">
        <label>Cookie Form</label>
        <button name="btnset">Set Cookie</button>
        <button name="btnget">Get Cookie</button>
        <button name="index">Go to index</button>
        <button name="test">test</button>
    </form>
    
</body>
</html>