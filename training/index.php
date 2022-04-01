<script>
//  alert("done");
window.onload=function(){
  console.log("index");
        <?php
        echo "";
    // $hi="";
    // $post="";
   // Header('Location: '.$_SERVER['PHP_SELF']);
     ?>

    }
function check1(){
  
  var email=document.forms["form1"]["email"].value;
  var password=document.forms["form1"]["password"].value;
  //var email_v=document.getElementById("email_v");
  var pass_v=document.getElementById("pass_v");
  console.log(email);
  console.log(password);
  if(email==""||password==""){
   // alert("done");
    //console.log('done');
    pass_v.innerHTML="please enter missing data";
    return false;
  }
  else{
    return true;
  }
  

}
</script>

<?php
  
  if ( $_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['email']) && isset($_POST['password']) ){
   
    echo $_SERVER['PHP_SELF']."<br>";
    //echo $_SERVER['REQUEST_METHOD']."<br>";
    $email=strip_tags($_POST['email']) ;
    // if(!preg_match("/^[A-Z][a-z]+$/",$email)){
    //     $email="<span>Error Email</span>";
    // }
    $passwordd=strip_tags($_POST['password']) ;
    $gender= $_POST['gender'];
    echo $email."<br>";
    echo $passwordd."<br>";
    echo $_POST['gender']."<hr>";
    //data base connection
    //$dsn="mysql:host=localhost;dbname=training";
    $username="root";
    $password="";
    $conn=new mysqli('localhost',$username,$password,'training');
    if($conn->connect_error){
      die('connection failed : '.$conn->connect_error);

    }else{
      $stmt=$conn->prepare('insert into registeration(email,password,gender)
      values (?,?,?)');
      $stmt->bind_param("sss",$email,$passwordd,$gender);
      $stmt->execute();
      echo "data saved";
      $stmt->close();
      $conn->close();
    }

  }
  
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
  <?php include "login.php"?>
<form method="POST"  onsubmit="return check1()" name="form1">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    <p id="email_v"></p>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
    <p id="pass_v"></p>
  </div>
  <div>
    <select  name="gender">
      <option value="male" >male</option>
      <option  value="female">female</option>
    </select>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    
  </body>
</html>