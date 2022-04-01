<?php
  $text="";
  if($_SERVER['REQUEST_METHOD']=="POST"){
    $myfile=fopen('mytext.txt','r');
    $text=fread($myfile,filesize('mytext.txt'));
    fclose($myfile);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <label>File Content</label>
        <textarea  name="txtfile">
        <?php echo $text; ?>
        </textarea>
        <button>Submit</button>
    </form>
    
</body>
</html>