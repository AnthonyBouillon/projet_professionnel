<?php

// Permet l'affichage des informations de l'utilisateur dans le menu
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
}

