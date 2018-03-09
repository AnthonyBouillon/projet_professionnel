<?php

// On instancie l'objet users
$users = new users();
$error = array();
/*
 * On vérifie que nos $_GET ne sont pas vide et existent
 * On assigne la valeur de $_GET dans l'attribut de l'objet users 
 * On assigne notre tableau qui contient toute les informations de la table users dans une variable
 * On vérifie que la clé dans l'url correspond à la clé de l'utilisateur
 * On vérifie si son compte n'est pas déja activé
 */
if (!empty($_GET['id']) && !empty($_GET['key'])) {
    $users->id = $_GET['id'];
    $readUsers = $users->readUsers();
} else {
    header('Location:404.php');
}
if ($_GET['key'] != $readUsers->keyMail) {
    header('Location:404.php');
}
if ($readUsers->actif != 0) {
    $error['confirmed'] = 'Votre compte a déjà était validé';
    header('refresh:5;url=../views/loginView.php');
}
/*
 * On vérifie qu'il n'y a aucune erreur 
 * Puis on active son compte
 * Puis on créer un dossier qui porte son pseudo
 * Puis on donne tout les droits sur le dossier
 * Puis on déplace une image de profil par défaut dans le dossier de l'utilisateur
 */
if (count($error) == 0) {
    $users->updateCountActif();
    if (!is_dir('../members/avatars/' . $readUsers->username)) {
        mkdir('../members/avatars/' . $readUsers->username, 0777, true);
        chmod('../members/avatars/' . $readUsers->username, 0777);
        copy('../members/avatars/fake.jpg', '../members/avatars/' . $readUsers->username . '/fake.jpg');
    }
}

