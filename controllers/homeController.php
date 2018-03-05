<?php

/*
 * On instancie l'objet chat
 * On assigne notre tableau qui contient toute les informations de la table users dans une variable
 * On assigne une regex dans une variable qui servira pour nos champs
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs
 */
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
}

$checkElement = $users->checkElements();
$chat = new chat();
$showMessages = $chat->checkMessage();
$regexMessage = '#^[\w\W]{1,500}$#';
$formError = array();
/*
 * On vérifie que l'utilisateur est bien connecté
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que notre superglobale $_POST n'est pas vide et existe
 * On assigne la valeur du $_POST dans l'attribut de l'objet chat
 * On utilise les fonctions trim et htmlspecialchars afin de convertir les balises HTML et PHP et de supprimer les espaces avant et après
 * On vérifie que le format désiré est bien respecté
 */
if (isset($_SESSION['id'])) {
    $chat->sessionID = $_SESSION['id'];
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['message'])) {
        $chat->message = trim(htmlspecialchars($_POST['message']));
        if (!preg_match($regexMessage, $chat->message)) {
            $formError['errorRegex'] = 'Votre message n\'a pas pu être envoyé';
        }
    } else {
        $formError['errorRegex'] = 'Veuillez écrire un message avant de l\'envoyez';
    }
    /*
     * On vérifie que le formulaire ne comporte aucune erreur
     * On insert le message dans la base de donnée
     * Puis on affiche
     */
    if (count($formError) == 0) {
        $chat->insertMessage();
        $showMessages = $chat->checkMessage();
    }
}
