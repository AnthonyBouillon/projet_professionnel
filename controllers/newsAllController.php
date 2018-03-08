<?php

$news = new news();
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
$count = $news->countNews();
$news->limitArticles = 3;
$numberOfPages = ceil($count->numbersArticles / $news->limitArticles);
if (isset($_GET['id'])) {
    $news->id = $_GET['id'];
    $currentPage = $news->id;
} else {
    $currentPage = 1;
}
if ($currentPage > $numberOfPages) {
    $currentPage = $numberOfPages;
}
$news->firstEntry = ($currentPage - 1) * $news->limitArticles;
if (isset($_POST['submit']) && !empty($_POST['search'])) {
    $news->search = $_POST['search'];
}

/* delete news */
if(isset($_POST['delete'])){
    $news->id_new = $_POST['id'];

    $news->deleteNews();
}

$checkArticle = $news->readNews();