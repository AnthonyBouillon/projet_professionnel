<?php

$users = new users();
$forumTopics = new forumTopics();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}
$readUsers = $users->readUsers();
$forumTopics->id_subCategory = $_GET['id'];
$readTopics = $forumTopics->readTopics();


if (isset($_POST['submitCreate'])) {
    $forumTopics->id_subCategory = $_GET['id'];
    $forumTopics->id_user = $_SESSION['id'];
    $forumTopics->name = $_POST['name'];
    var_dump($forumTopics->name,  $forumTopics->id_user, $forumTopics->id_subCategory);
    $forumTopics->createTopics();
    $readTopics = $forumTopics->readTopics();
}


