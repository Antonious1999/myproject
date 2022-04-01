<?php
session_start();
?>
<?php require "config.php" ?>
<?php include_once "includes/header.php" ?>
<?php include "includes/navbar.php" ?>
<style>
    li{
        display: inline-block;
    }
    </style>

<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "index";
}
?>
<?php if ($action == 'index') : ?>
    <?php
    $hidden= $_SESSION['role']==1 ? "":"AND 'hidden' = 0";
    $role = isset ($_GET ['owners'])&& $_GET['owners']=='admin' ? "rule_id !=2" : "rule_id =2";
    $stml = $connection->prepare("SELECT * FROM `users` WHERE $rule $hidden");
    $stml->execute();
    $users = $stml->fetchAll();
   
    ?>

    <h1>All members</h1>
    <div   >
    <ul >
    <li >  <a class="nav-link" href="dashbord">
    <i class="fa-solid fa-backward-step fa-2x"></i>
    </a> </li>
      <li > <a  class="nav-link " href="members?action=create">
      <i class="fa-solid fa-user-plus fa-2x"></i>
        </a> </li>
    </ul>
    </div>
  
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Control</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['fullname'] ?></td>
                        <td><?= $user['created_at'] ?></td>
                        <td> <a class="btn btn-info" href="members?action=show&selection=<?= $user['id'] ?>">
                        <?php  $_SESSION['showflag']=1; ?> 
                        <i class="fa-solid fa-info"  title="info"></i> 
                    </a>
                          <?php if( $_SESSION['role']==1) : ?>
                             <a class="btn btn-warning"  href="members?action=edit&selection=<?= $user['id'] ?>" > 
                             <?php  $_SESSION['editflag']=1; ?>
                             <i class="fas fa-user-edit" title="edit"></i>   
                            </a>
                             <a class="btn btn-danger"  href="members?action=destroy&selection=<?= $user['id'] ?>"> 
                             <?php  $_SESSION['destroy']=1; ?>
                             <i class="fas fa-user-minus" title="delete"></i> 
                            </a>   
                            <?php endif?>
                            <a class="btn btn-danger"  href="members?action=soft&selection=<?= $user['id'] ?>"> 
                             <?php  $_SESSION['soft']=1; ?>
                             <i class="fas fa-trash" title="trash"></i> 
                            </a>
                             
                    </td>
                                   

                    <?php endforeach ?>
                    </tr>

            </tbody>
        </table>
    </section>

<?php elseif ($action == 'create') : ?>
    <h1>Add User</h1>

    <div>
    <ul >
    <li >  <a class="nav-link" href="dashbord">
    <i class="fa-solid fa-backward-step fa-2x"></i>
    </a> </li>
      <li > <a  class="nav-link " href="members?action=index">index</a> </li>
    </ul>
    </div>
    <section>

        <form method="POST" action="?action=store">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">User name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">

            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">fullname</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="fullname">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Phone</label>
                <input type="number" class="form-control" id="exampleInputPassword1" name="phone">
            </div>

            <button type="submit" class="btn btn-primary"  onclick="add()">Add</button>
        </form>
        <script>
            function add(){
                alert('added successfully');
            }
        </script>
    </section>

<?php elseif ($action == 'store') : ?>
    <h1>store</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        $phone = $_POST['phone'];
        $fullname = $_POST['fullname'];
        $stml = $connection->prepare("INSERT INTO `users` (username,password,email,fullname,phone,created_at ,rule_id)VALUES (?,?,?,?,?,now(),2)  ");
        $stml->execute(array($username, $password, $email, $fullname, $phone));
    }
    ?>
    <script>
        history.back();
        </script>

<?php elseif ($action == 'edit') : ?>
    <h1>edit</h1>
    <?php
     $userid=$_GET['selection'];
     $flag=$_SESSION['editflag'];
    $inDp=1;
    if(intval($userid) &&$flag==1){
        $_SESSION['editflag']=0;
        $stml=$connection->prepare("SELECT * FROM `users` WHERE id=? ");
        $stml->execute(array($userid));
        $user=$stml->fetch();
        $count=$stml->rowCount();
        if($count==$inDp){ ?>
    <div class="container">
<form method="POST" action="?action=update" >

<div class="mb-3">

    <input type="hidden"  value="<?= $user['id'] ?>"   name="id">

<label for="exampleInputEmail1" class="form-label">user name</label>

<input type="text" class="form-control"  value="<?= $user['username'] ?> " name="username"  >

<div class="mb-3">
<label for="exampleInputPassword1" class="form-label">password</label>

<input type="hideen" class="form-control"  value="<?= $user['password'] ?>"  name="password" >
</div>

</div>
<div class="mb-3">
<label for="exampleInputEmail" class="form-label">Email</label>

<input type="text" class="form-control"  value="<?= $user['email'] ?>"  name="email" >

</div>
<div class="mb-3">
<label for="exampleInputFullName" class="form-label">full name</label>

<input type="text" class="form-control"  value="<?= $user['fullname'] ?>"  name="fullname" >
</div>
<div class="mb-3">
<label for="exampleInputPhone" class="form-label">phone</label>

<input type="text" class="form-control"  value="<?= $user['phone'] ?>"  name="phone" >

</div>
<button type="submit" class="btn btn-primary">update</button>
<button type="button" class="btn btn-primary"  onclick="back()">back</button>
</form>
<script>
        function back(){  history.back()}
    </script>

</div>  <?php }else{
            echo '<script>history.back()</script>';
        }
    }
    else{
        echo '<script>history.back()</script>';
    }
     ?>
         
<?php elseif ($action == 'update') : ?>
    <h1>update</h1>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
       
         $id=$_POST['id'];
         $username=$_POST['username'];
         $email= $_POST['email'];
         $fullname=$_POST['fullname'];
         $phone=$_POST['phone'];
         $password = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

        $stml=$connection->prepare(" UPDATE `users` 
        SET `username`=?,  `password`=?, `email`=?, `fullname`=? ,`phone`=?
        WHERE `id`=?
        ");
        $stml->execute(array($username,$password,$email,$fullname,$phone,$id));
        echo '<script>history.back()</script>'; 
       }
    
    ?>
   
   
<?php elseif ($action == 'show') : ?>
    <h1>show</h1>
    <?php
    $userid=$_GET['selection'];
    $flag= $_SESSION['showflag'];
    $inDp=1;
    if(intval($userid) &&$flag==1){
        $_SESSION['showflag']=0;
        $stml=$connection->prepare("SELECT * FROM `users` WHERE id=? ");
        $stml->execute(array($userid));
        $user=$stml->fetch();
        $count=$stml->rowCount();
        if($count==$inDp){ ?>
        <div class="container">
    <form  >
    
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">user name</label>

    <input type="email" class="form-control"  value="<?= $user['username'] ?>"  readonly>

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Email</label>

    <input type="text" class="form-control"  value="<?= $user['email'] ?>"  readonly >

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">full name</label>

    <input type="text" class="form-control"  value="<?= $user['fullname'] ?>"  readonly >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">phone</label>

    <input type="text" class="form-control"  value="<?= $user['phone'] ?>"  readonly >

  </div>
  <button type="button" class="btn btn-primary"  onclick="back()">back</button>
</form>

    </div>
    <script>
        function back(){ history.back()}
    </script>
          

        <?php }else{
            echo '<script>history.back()</script>';
        }
    }
    else{
        echo '<script>history.back()</script>';
    }
     ?>

<?php elseif ($action == 'show') : ?>
    <h1>show</h1>
    <?php
    $userid=$_GET['selection'];
    $flag= $_SESSION['showflag'];
    $inDp=1;
    if(intval($userid) &&$flag==1){
        $_SESSION['showflag']=0;
        $stml=$connection->prepare("SELECT * FROM `users` WHERE id=? ");
        $stml->execute(array($userid));
        $user=$stml->fetch();
        $count=$stml->rowCount();
        if($count==$inDp){ ?>
        <div class="container">
    <form  >
    
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">user name</label>

    <input type="email" class="form-control"  value="<?= $user['username'] ?>"  readonly>

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Email</label>

    <input type="text" class="form-control"  value="<?= $user['email'] ?>"  readonly >

  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">full name</label>

    <input type="text" class="form-control"  value="<?= $user['fullname'] ?>"  readonly >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">phone</label>

    <input type="text" class="form-control"  value="<?= $user['phone'] ?>"  readonly >

  </div>
  <button type="button" class="btn btn-primary"  onclick="back()">back</button>
</form>

    </div>
    <script>
        function back(){ history.back()}
    </script>
          

        <?php }else{
            echo '<script>history.back()</script>';
        }
    }
    else{
        echo '<script>history.back()</script>';
    }
     ?>
   






















<?php elseif ($action == 'destroy') : ?>

        <h1>destroy</h1>

    <?php
    $id=$_GET['selection'];
    $inDp=1;
    if(intval($id)){
        $stml=$connection->prepare("  DELETE FROM `users` WHERE `id`=?
        ");
        $stml->execute(array($id));
        $count=$stml->rowCount();
        if($count==$inDp){
            echo 'user deleted';

         }else{ echo '<script>history.back()</script>'; }

    }else{ echo '<script>history.back()</script>'; }

    ?>
    
    <section>
    <?php elseif ($action == 'soft') : ?>

<?php
$id=$_GET['selection'];
$inDp=1;
if(intval($id)){
    $stml=$connection->prepare("  UPDATE `users` SET `hidden`=1 WHERE `id`=?
    ");
    $stml->execute(array($id));
    header('location:members.php');
}else{ 
    echo '<script>history.back()</script>'; }

?>
    
     <?php elseif ($action == 'confirm') : ?>
    <?php
        $id= $_GET['selection'];
    ?>


<?php elseif ($action == 'restore') : ?>

<?php
$id=$_GET['selection'];
$inDp=1;
if(intval($id)){
    $stml=$connection->prepare("  UPDATE `users` SET `hidden`=0 WHERE `id`=?
    ");
    $stml->execute(array($id));
    header('location:members.php');
}else{ 
    echo '<script>history.back()</script>'; }

?>
    
<?php else :   header('location:index');?>




<?php endif ?>


<?php include_once 'includes/footer.php' ?>