<?php

$news = new news();
$news->id_new = $_GET['id'];
$users = new users();
$comments = new comments();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $comments->id_user = $_SESSION['id'];
}
$readUsers = $users->readUsers();
$comments->id_new = $_GET['id'];
$readArticles = $news->readNewsById();
$readComments = $comments->readComments();
$countComments = $comments->countComments();
$error = array();
$success = array();
$regexComment = '#[\w\W]#';



if (isset($_POST['submitAdd'])) {
    if (!isset($_SESSION['id'])) {
        $error['logout'] = 'Vous devez être connecté afin de pouvoir commenter';
    }
    if (!empty($_POST['comment'])) {
        $comments->comments = htmlspecialchars($_POST['comment']);
    } else {
        $error['empty'] = 'Vous devez remplir le champ pour commenter';
    }
    if (!preg_match($regexComment, $comments->comments)) {
        $error['commentBadRegex'] = 'Eviter ';
    }
    if (count($error) == 0) {
        $comments->id_new = $_GET['id'];
        $comments->id_user = $_SESSION['id'];
        if ($comments->createComments()) {
            $success['insertComment'] = 'Votre commentaire a était ajouté';
            $readComments = $comments->readComments();
            $countComments = $comments->countComments();
        } else {
            $error['notInsertComment'] = 'Votre commentaire n\'a pas était enregistré, veuillez réessayez plus tard ou contactez-nous';
        }
    }
}
if (isset($_POST['edit'])) {
    $comments->id_comment = $_POST['idComment'];
    if (!empty($_POST['commentUpdate'])) {
        $comments->comment = htmlspecialchars($_POST['commentUpdate']);
    } else {
        $error['emptyComment'] = 'Veuillez remplir le champ pour modifier votre commentaire';
    }
    if (!preg_match($regexComment, $comments->comment)) {
        $error['!regexUpdate'] = 'Votre commentaire n\'est pas conforme au format demandé';
    }
    if (count($error) == 0) {
        $comments->updateComments();
        $success['updateComment'] = 'Votre commentaire a était modifié';
        $readComments = $comments->readComments();
    }
}
if (!empty($_SESSION['id']) && isset($_POST['deleteBtn'])) {
    $comments->id_comment = $_POST['idComment'];
    if ($comments->deleteComments()) {
        $readComments = $comments->readComments();
        $countComments = $comments->countComments();
        $success['deleteComment'] = 'Votre commentaire a était supprimé';
    }
}
$readArticles = $news->readNewsById();
