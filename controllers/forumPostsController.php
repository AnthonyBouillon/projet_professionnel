<?php
$forumPosts = new forumPosts();
$forumPosts->id_topic = $_GET['id'];
$readPosts = $forumPosts->readPosts();