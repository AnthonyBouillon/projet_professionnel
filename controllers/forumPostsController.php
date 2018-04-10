<?php
// Permet l'affichage des informations de l'utilisateur dans le menu
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
}
$forumTopics = new forumTopics();   
$forumPosts = new forumPosts();
$forumPosts->id_topic = $_GET['id'];
$forumTopics->id_topic = $_GET['id'];
$readPosts = $forumPosts->readPosts();

$readNameByPost = $forumTopics->readNameByTopic();

if (isset($_POST['submitCreate'])) {
    $forumPosts->id_topic = $_GET['id'];
    $forumPosts->id_user = $_SESSION['id'];
    $forumPosts->message = $_POST['message'];
    $forumPosts->createPosts();
    $readPosts = $forumPosts->readPosts();
}
