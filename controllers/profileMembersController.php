<?php

$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}
$readUsers = $users->readUsers();
if (isset($_GET['id'])) {
    $readProfile = $users->readProfile();
}
$readStatus = $users->readStatus();
