<?php
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
}

$readUsers = $users->readUsers();
$topics = new forumTopics();
$getTopics = $topics->readTopics();