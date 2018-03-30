<?php

$users = new users();
$admin = new admin();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
$readStatus = $users->readStatus();
$readAllStatus = $admin->readAllStatus();

if (isset($_POST['submitUpdate'])) {
    $users->id_admin = $_POST['updateRights'];
    // id utilisateur
    $users->id = $_POST['id_user'];
    $users->updateRights();
    $readStatus = $users->readStatus();
}