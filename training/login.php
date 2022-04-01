<script>
//     window.onload=function(){
//       //  console.log("login");
//         <?php
//         echo " ";
//         $_POST['name']="";
//     // $hi="";
//     // $post="";
//    // Header('Location: '.$_SERVER['PHP_SELF']);
//      ?>

//     }
<?php
  //      echo " ";
       // $_POST['name']="";
//       $post="";
     ?>
  
    function check(){
        console.log('done');
      var name=document.forms["myform"]["name"].value;
      var validate=document.getElementById('validate');
      var color=document.getElementById('name');
     if(name==''){
       // alert('please enter name');
       validate.innerHTML="please enter name";
       color.style.border="solid red 2px";
       return false;
     }else{
         return true;
     }

}
 

</script>

   
<?php
  //echo "hi";
  //echo isset($_POST['name']);
  echo $_SERVER['REQUEST_METHOD'];
  $post=" ";
  echo $post;
  if ( $_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['name'])){
      $hi="Hi ";
      $post=$_POST['name'];
      //echo $hi;
      echo $post;
    //  $_SERVER['REQUEST_METHOD']=="GET";
      
  }

  class person{
    public $phone; public $address;
    function getData(){
      return $this->phone."<br>".$this->address."<br>";
    }
  }
  class employee  extends person{
    function __construct($emp_no,$emp_name){
       $this->emp_no=$emp_no;
       $this->emp_name=$emp_name;
    }
    private $emp_no;
    private $emp_name;
    function printData(){
      $no=$this->emp_no;
      $name=$this->emp_name;
      $phoneaddress=$this->getData();
      echo "<h3>$no</h3><h3>$name</h3> <h3>$phoneaddress</h3>";
    }  
  }
  if(isset($_POST['test'])){
    $emp1=new employee(1,"ayman");
    $emp1->phone="12345";
    $emp1->address="cairo";
    $emp1->printData();
    $emp1=new employee(2,"mido");
    $emp1->printData();

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
    <form  method="POST" onsubmit="return check()" name="myform">
        <label>Name</label>
        <input type="text" id="name" name="name">
        <button type="submit" >submit</button>
      
        <p id="validate"></p>
    </form>
    <Form method="post">
    <button name="test">test</button>
    </Form>
    
</body>
</html>