<?php require "config.php" ?>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email =  $_POST['emailaddress'];
    $password = sha1($_POST['password']);
    $stmt = $connection->prepare("SELECT * FROM `users` WHERE `email`=? AND `password`=? AND `rule_id`!= 2");
    $stmt->execute(array($email, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count == 1){
        $_SESSION['ID'] = $row['id'];
        $_SESSION['USER_NAME'] = $row['username'];
        $_SESSION['PASSWORD'] = $row['password'];
        $_SESSION['EMAIL'] = $row['email'];
        $_SESSION['ROLE'] = $row['rule_id'];
        $_SESSION['FULL_NAME'] = $row['fullname'];
        header('location:dashboard.php');
    }else{
        echo "this user doesnt exist";
    }
    // echo "<pre>";
    // print_r($row);
    // echo "</pre>";
}
?>
<?php 

    if(isset($_GET['lang']) && $_GET['lang']=='ar'){
         require "lang/ar.php";
        }else{
            require "lang/en.php";
        }
?>

<?php include_once "includes/header.php" ?>
<?php require "config.php" ?>

<body>
    <div class="container"> 
        <a href="?lang=en">en</a> | <a href="?lang=ar">اللغة العربيه</a>
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"><?= $lang['email']?></label>
                <input type="email" class="form-control" name="emailaddress">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label"><?= $lang['password']?></label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php include "includes/footer.php" ?>