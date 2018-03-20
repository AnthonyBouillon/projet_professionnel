<?php

if (isset($_SESSION['id'])) {
    $users = new users();
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
} else {
    header('Location:404.php');
}
