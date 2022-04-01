<?php session_start() ?>
<?php require "config.php" ?>
<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>

<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "index";
}
?>

<?php if ($action == 'index') : ?>
    <?php

    $hidden = $_SESSION['ROLE'] == 1 ? "" : "AND `hidden` = 0";
    $rule = isset($_GET['owners']) && $_GET['owners'] == 'admin' ? "rule_id !=2"  : "rule_id = 2";

    $stmt = $connection->prepare("SELECT * FROM `users` WHERE $rule $hidden");
    $stmt->execute();
    $users = $stmt->fetchAll();
    ?>
    <div class="row text-center">
        <div class="col">
            <h1>All members</h1>
        </div>
        <div class="col">
            <a href="members.php?action=create" class="btn btn-primary">
                <i class="fas fa-user-plus" title="add-user"></i>
            </a>
        </div>
    </div>
    <section class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">image</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Control</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <th scope="row">1</th>
                        <td> <img style="height: 10vh;" src="asset/images/<?= $user['image']?>" alt=""></td>
                        <td>
                            <?= $user['email'] ?>
                            <?php if ($user['hidden'] == 1) : ?>
                                <span class="badge bg-danger">Deleted</span>
                            <?php endif ?>
                        </td>
                        <td><?= $user['fullname'] ?></td>
                        <td><?= $user['created_at'] ?></td>
                        <td>
                            <?php if ($user['hidden'] == 1) : ?>
                                <a class="btn btn-info" href="members.php?action=restore&selection=<?= $user['id'] ?>"><i class="fas fa-trash-restore" title="restore"></i></a>
                            <?php endif ?>
                            <a class="btn btn-info" href="members.php?action=show&selection=<?= $user['id'] ?>"> <i class="fas fa-info" title="show"></i></a>
                            <?php if ($_SESSION['ROLE'] == 1) : ?>
                                <a class="btn btn-warning" href="members.php?action=edit&selection=<?= $user['id'] ?>"><i class="fas fa-user-edit" title="edit"></i></a>
                                <a class="btn btn-danger" href="members.php?action=destroy&selection=<?= $user['id'] ?>"><i class="fas fa-user-minus" title="delete"></i></a>
                            <?php else : ?>
                                <a class="btn btn-danger" href="members.php?action=soft&selection=<?= $user['id'] ?>"><i class="fas fa-trash" title="delete"></i></a>
                            <?php endif ?>

                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
<?php elseif ($action == 'create') : ?>
    <section class="container">
        <h1 class="text-center">Create Member</h1>
        <form method="post" action="?action=store" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Fullname</label>
                <input type="text" class="form-control" name="fullname">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Phone</label>
                <input type="phone" class="form-control" name="phone">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">image</label>
                <input type="file" class="form-control" name="avatar">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </section>
<?php elseif ($action == 'store') : ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $imageName = $_FILES['avatar']['name'];
        $newName = rand(0, 1000) .  $imageName;
        $imageType = $_FILES['avatar']['type'];
        $imageTempName = $_FILES['avatar']['tmp_name'];
        $imageAllowExtension = array("image/png", "image/jpeg", "image/jpg");
        if (in_array($imageType, $imageAllowExtension)) {
            $destination = "asset\images\\" .  $newName;
            move_uploaded_file($imageTempName, $destination);
            $username =  $_POST['username'];
            $email =  $_POST['email'];
            $password =  sha1($_POST['password']);
            $phone =  $_POST['phone'];
            $fullname =  $_POST['fullname'];
            $stmt = $connection->prepare(
                "INSERT INTO `users` (username , password , email, fullname ,phone , created_at , rule_id , `image`) 
                     VALUES ( ?, ? , ? ,  ? ,? , now() , 2 , ? );
                    "
            );
            $stmt->execute(array($username, $password, $email, $fullname, $phone ,$newName ));
        }
    }
    ?>
    <script>
        window.history.back()
    </script>
<?php elseif ($action == 'edit') : ?>
    <?php
    $userid =  $_GET['selection'];
    $inDb = 1;
    //check id is integer
    if (intval($userid)) {
        $stmt = $connection->prepare("SELECT * FROM `users` WHERE id=?");
        $stmt->execute(array($userid));
        $user = $stmt->fetch();
        $count = $stmt->rowCount();
        //check id if exsist
        if ($count == $inDb) { ?>
            <section class="container">
                <h1 class="text-center">Edit Member</h1>
                <form method="post" action="?action=update">
                    <input type="hidden" class="form-control" value="<?= $user['id'] ?>" name="userid">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= $user['username'] ?>" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" value="<?= $user['email'] ?>" name="email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"> new Password</label>
                        <input type="hidden" class="form-control" value="<?= $user['password'] ?>" name="oldpassword">
                        <input type="text" class="form-control" name="newpassword" placeholder="Insert new password if you want  ,  if label empty still old password">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Fullname</label>
                        <input type="text" class="form-control" value="<?= $user['fullname'] ?>" name="fullname">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone</label>
                        <input type="phone" class="form-control" value="<?= $user['phone'] ?>" name="phone">
                    </div>
                    <button type="submit" class="btn btn-dark">update</button>
                </form>

            </section>
    <?php
        } else {
            echo '<script>history.back()</script>';
        }
    } else {
        echo '<script>history.back()</script>';
    }

    ?>
<?php elseif ($action == 'update') : ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_POST['userid'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $password = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

        $stmt = $connection->prepare('UPDATE `users` SET  `username`=? , `password`= ?,`email`= ? ,`fullname`= ?  , `phone` = ? WHERE `id` = ?  ');
        $stmt->execute(array($username, $password, $email, $fullname, $phone, $userid));
    }

    ?>
<?php elseif ($action == 'show') : ?>
    <?php
    $userid =  $_GET['selection'];
    $inDb = 1;
    //check id is integer
    if (intval($userid)) {
        $stmt = $connection->prepare("SELECT * FROM `users` WHERE id=?");
        $stmt->execute(array($userid));
        $user = $stmt->fetch();
        $count = $stmt->rowCount();
        //check id if exsist
        if ($count == $inDb) { ?>
            <section class="container">
                <h1 class="text-center">Show Member</h1>
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" value="<?= $user['email'] ?>" readonly>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Fullname</label>
                        <input type="text" class="form-control" value="<?= $user['fullname'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone</label>
                        <input type="phone" class="form-control" value="<?= $user['phone'] ?>" readonly>
                    </div>
                    <button type="button" class="btn btn-dark">back</button>
                </form>

            </section>
    <?php
        } else {
            echo '<script>history.back()</script>';
        }
    } else {
        echo '<script>history.back()</script>';
    }

    ?>
<?php elseif ($action == 'destroy') : ?>
    <?php
    $userid =  $_GET['selection'];
    $inDb = 1;
    //check id is integer
    if (intval($userid)) {
        $stmt = $connection->prepare("DELETE FROM `users` WHERE `id`= ?");
        $stmt->execute(array($userid));
        $count = $stmt->rowCount();
        //check id if exsist
        if ($count == $inDb) {
            echo '<script>history.back()</script>';
        } else {
            echo "Error";
        }
    } else {
        echo '<script>history.back()</script>';
    }
    ?>
<?php elseif ($action == "soft") : ?>
    <?php
    $userid =  $_GET['selection'];
    $inDb = 1;
    //check id is integer
    if (intval($userid)) {
        $stmt = $connection->prepare('UPDATE `users` SET  `hidden`= 1 WHERE `id` = ?  ');
        $stmt->execute(array($userid));
        header('location:members.php');
    } else {
        echo '<script>history.back()</script>';
    }
    ?>
<?php elseif ($action == "restore") : ?>
    <?php
    $userid =  $_GET['selection'];
    $inDb = 1;
    //check id is integer
    if (intval($userid)) {
        $stmt = $connection->prepare('UPDATE `users` SET  `hidden`= 0 WHERE `id` = ?  ');
        $stmt->execute(array($userid));
        header('location:members.php');
    } else {
        echo '<script>history.back()</script>';
    }
    ?>
<?php endif ?>

<?php include "includes/footer.php" ?>