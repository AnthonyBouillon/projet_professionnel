<?php

// Permet l'affichage des informations de l'utilisateur dans le menu
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
}
/*
 *  On instancie nos objet forumTopics et forumPosts
 * on assigne l'id du topic dans nos attributs
 * puis on appelle nos méthode qui nous permet d'afficher les réponses au topic et le titre du topic
 */
$forumTopics = new forumTopics();
$forumPosts = new forumPosts();
$forumPosts->id_topic = $_GET['id'];
$forumTopics->id_topic = $_GET['id'];
$readPosts = $forumPosts->readPosts();
$readNameByPost = $forumTopics->readNameByTopic();
/*
 * Si le formulaire est soumis
 * on assigne l'id de l'utilisateur et le message dans nos attributs
 * puis on apelle notre méthode qui nous permet de créer une réponse au sujet
 * et on affiche
 */
if (isset($_POST['submitCreate'])) {
    $forumPosts->id_user = $_SESSION['id'];
    $forumPosts->message = htmlspecialchars($_POST['message']);
    $forumPosts->createPosts();
    $readPosts = $forumPosts->readPosts();
}
