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
    $checkElement = $users->checkElements();
} else {
    header('Location:404.php');
}
if ($_GET['key'] != $checkElement->keyMail) {
    header('Location:404.php');
}
if ($checkElement->actif != 0) {
    $error['confirmed'] = 'Votre compte a déjà était validé, vous pouvez vous connecter sur le site en cliquant sur connexion dans le menu en haut à droite';
}
/*
 * On vérifie qu'il n'y a aucune erreur 
 * Puis on active son compte
 */
if (count($error) == 0) {
    $users->updateCountActif();
}

