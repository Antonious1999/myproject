
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    echo "done";
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
    <form method="POST" enctype="multipart/form-data">
        <label>upload file</label>
        <input type="file" name="up">
        <button>Submit</button>
    </form>
    
</body>
</html>