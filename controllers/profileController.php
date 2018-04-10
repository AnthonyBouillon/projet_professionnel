<?php

/*
 * On instancie l'objet users
 * On assigne notre session à notre attribut dans objet users
 * On vérifie que l'utilisateur est connecté
 * Puis on affiche ses informations
 */
$users = new users();
$users->id = $_SESSION['id'];
$readUsers = $users->readUsers();
// Si l'utilisateur n'est pas connecté, on le redirige vers la page d'accueil
if (!isset($_SESSION['id'])) {
    header('Location: ../Accueil');
}
