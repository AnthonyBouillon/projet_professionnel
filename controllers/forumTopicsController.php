<?php

// Affichage des informations dans le menu
$users = new users();
$forumTopics = new forumTopics();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}
$readUsers = $users->readUsers();
/*
 * On assigne l'id récupéré dans l'url dans notre attribut
 * puis on affiche les topics
 */
$forumTopics->id_subCategory = $_GET['id'];
$readTopics = $forumTopics->readTopics();
/*
 * Si le formulaire est soumis
 * on assigne l'id du topic, l'id de l'utilisateur et le nom du topic
 * ensuite on apelle notre méthode afin de créer un topic
 * puis on affiche
 */
if (isset($_POST['submitCreate'])) {
    $forumTopics->id_subCategory = $_GET['id'];
    $forumTopics->id_user = $_SESSION['id'];
    $forumTopics->name = htmlspecialchars($_POST['name']);
    $forumTopics->createTopics();
    $readTopics = $forumTopics->readTopics();
}


