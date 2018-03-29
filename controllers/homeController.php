<?php

/*
 * Si notre script en ajax fonctionne
 * on démarre la session et on inclut nos fichiers dont on a besoin
 */
if (isset($_POST['message'])) {
    session_start();
    include_once '../configuration.php';
    include_once '../models/database.php';
    include_once '../models/users.php';
    include_once '../models/chat.php';
    // On instancie nos objets users et chat
    $chat = new chat();
    $users = new users();
    /*
     * Si l'utilisateur est connecté
     * on assigne les attributs id et le pseudo dans nos attributs de la classe  users pour le menu
     * puis on assigne l'attribut id de l'utilisateur de la classe chat pour le tchat
     */
    if (isset($_SESSION['id'])) {
        $users->id = $_SESSION['id'];
        $users->username = $_SESSION['username'];
        $chat->id_user = $_SESSION['id'];
    }
    /*
     * On vérifie que le message n'est pas vide
     * puis insert le message dans la base de données
     */
    if (!empty($_POST['message'])) {
        $chat->message = trim(htmlspecialchars($_POST['message']));
        $chat->createMessage();
    }
    // On appelle la méthode readUsers pour l'affichage du pseudo et de l'image de l'utilisateur pour le menu
    $readUsers = $users->readUsers();
    // On génère notre JSON qui est un tableau
    echo json_encode($readMessages);
} else {
    // On instancie nos objets users et chat
    $users = new users();
    $chat = new chat();
    /*
     * Si l'utilisateur est connecté
     * on assigne les attributs id et le pseudo dans nos attributs de la classe  users pour le menu
     * puis on assigne l'attribut id de l'utilisateur de la classe chat pour le tchat
     */
    if (isset($_SESSION['id'])) {
        $users->id = $_SESSION['id'];
        $users->username = $_SESSION['username'];
        $chat->id_user = $_SESSION['id'];
    }
    // On appelle la méthode readUsers pour l'affichage du pseudo et de l'image de l'utilisateur pour le menu
    $readUsers = $users->readUsers();
    // On appelle la méthode readMessage afin d'afficher les messages du tchat
    $readMessages = $chat->readMessage();
    // On prépare notre regex pour le tchat
    $regexMessage = '#^[\w\W]{1,500}$#';
    // On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs
    $formError = array();
    /*
     * On vérifie que le formulaire à bien était soumis
     * On vérifie que notre superglobale $_POST n'est pas vide et existe
     * On assigne la valeur du message de l'utilisateur dans l'attribut de l'objet chat
     * On utilise les fonctions trim et htmlspecialchars afin de convertir les balises HTML et PHP et de supprimer les espaces avant et après
     * On vérifie que le format désiré est bien respecté
     */
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
         * On insert le message dans la base de données
         * Puis on affiche
         */
        if (count($formError) == 0) {
            $chat->createMessage();
            $readMessages = $chat->readMessage();
        }
    }
}