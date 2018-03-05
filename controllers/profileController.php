<?php

/*
 * On instancie l'objet users
 * On assigne notre session à notre attribut dans objet users
 * On vérifie que l'utilisateur est connecté
 * On affiche sont profile
 */
$users = new users();
$users->id = $_SESSION['id'];
$readUsers = $users->readUsers();
if (!empty($_SESSION['id'])) {
    $users->readUsers();
}
if (!isset($_SESSION['id'])) {
    header('Location:404.php');
}
