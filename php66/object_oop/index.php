<?php
require_once "vendor/autoload.php";

use APP\controller\membersex;

$user1 = new membersex;
echo $user1->index() ."<br>";
echo $user1->edit() ."<br>";
echo $user1->store() ."<br>";



?>