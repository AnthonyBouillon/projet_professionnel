<?php

$users = new users();
$admin = new admin();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readStatus = $users->readStatus();
$readAllStatus = $admin->readAllStatus();

if (isset($_POST['submitUpdate'])) {
    $users->id_admin = $_POST['updateRights'];
    var_dump($users->id_admin);
    // id utilisateur
    $users->id = $_POST['id_user'];
    var_dump($users->id);
    $users->updateRights();
    $readStatus = $users->readStatus();
}