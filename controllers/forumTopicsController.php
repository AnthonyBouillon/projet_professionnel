<?php
$users = new users();

if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
}

$readUsers = $users->readUsers();
$forumTopics = new forumTopics();
$forumTopics->id_subCategory = $_GET['id'];
$readTopics = $forumTopics->readTopics();
