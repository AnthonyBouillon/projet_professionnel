<?php
$forumPosts = new forumPosts();
$forumPosts->id_topic = $_GET['id'];
$readPosts = $forumPosts->readPosts();

$readNameByPost = $forumPosts->readName();

if (isset($_POST['submitCreate'])) {
    $forumPosts->id_topic = $_GET['id'];
    $forumPosts->id_user = $_SESSION['id'];
    $forumPosts->message = $_POST['message'];
    var_dump($forumPosts->message,  $forumPosts->id_user, $forumPosts->id_topic);
    $forumPosts->createPosts();
    $readPosts = $forumPosts->readPosts();
}
