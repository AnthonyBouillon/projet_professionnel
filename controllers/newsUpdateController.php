<?php

$news = new news();
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();

