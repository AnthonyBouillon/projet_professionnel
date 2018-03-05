<?php

// On instancie nos objets
$news = new news();
$news->id = $_GET['id'];
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$checkElement = $users->checkElements();

$comments = new comments();


$readArticles = $news->getArticleById();
$readComments = $comments->getComments();
// Assigne un tableau vide dans une variable (désignera les erreurs et les succès)
$error = array();
$success = array();
$regexComment = '#[\w\W]#';

// Si il n'y a pas d'article : page 404
if (empty($readArticles)) {
    header('Location: 404.php');
}
/* * * * CREATION D'UN COMMENTAIRE * * * *
 * On vérifie que le formulaire à bien était soumis
 * Si il n'est pas connecté : message d'erreur
 * On vérifie que le champ n'est pas vide : Sinon message d'erreur
 * On assigne la valeur du champ dans notre attribut
 * On ajoute la fonction htmlspecialchars afin de convertir les entités HTML
 * On assigne une regex dans une variable
 * Si l'attribut qui contient la saisie de l'utilisateur n'est pas vide, on vérifie si la regex est respecté : Sinon message d'erreur
 * Si le formulaire ne comporte aucune erreur, on insert le commentaire
 */
if (isset($_POST['submit'])) {
    if (!isset($_SESSION['id'])) {
        $error['logout'] = 'Vous devez être connecté afin de pouvoir commenter';
    }
    if (!empty($_POST['comment'])) {
        $comments->comments = htmlspecialchars($_POST['comment']);
        var_dump($_POST['comment']);
    } else {
        $error['empty'] = 'Vous devez remplir le champ pour commenter';
    }
    if (!preg_match($regexComment, $comments->comments)) {
        $error['commentBadRegex'] = 'Eviter ';
    }
    if (count($error) == 0) {
        $comments->getID = $_GET['id'];
        $comments->sessionID = $_SESSION['id'];
        if ($comments->InsertComment()) {
            $success['insertComment'] = 'Votre commentaire a était ajouté';
            $readComments = $comments->getComments();
        } else {
            $error['notInsertComment'] = 'Votre commentaire n\'a pas était enregistré, veuillez réessayez plus tard ou contactez-nous';
        }
    }
}
/* * * * MODIFICATION D'UN COMMENTAIRE * * * *
 *
 */
if (isset($_POST['edit'])) {
    $comments->idComment = $_POST['idComment'];
    if (!empty($_POST['commentUpdate'])) {
        $comments->commentUpdate = htmlspecialchars($_POST['commentUpdate']);
    } else {
        $error['emptyComment'] = 'Veuillez remplir le champ pour modifier votre commentaire';
    }
    if (!preg_match($regexComment, $comments->commentUpdate)) {
        $error['!regexUpdate'] = 'Votre commentaire n\'est pas conforme au format demandé';
    }
    if (count($error) == 0) {
        $comments->updateComments();
        $success['updateComment'] = 'Votre commentaire a était modifié';
        $readComments = $comments->getComments();
    }
}

/* * * * SUPPRESSION D'UN COMMENTAIRE * * * *
 * On vérifie qu'il soit connecté et que le formulaire a bien était soumis
 * On vérifie que l'id du commentaire correspond
 * Et on supprime
 */
if (!empty($_SESSION['id']) && isset($_POST['deleteBtn'])) {
    $comments->idComment = $_POST['idComment'];
    if ($comments->deleteComments()) {
        $success['deleteComment'] = 'Votre commentaire a était supprimé';
    }
}