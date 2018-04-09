<?php
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
