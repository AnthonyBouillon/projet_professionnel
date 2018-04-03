<?php

/*
 * On instancie nos objet users, news et comments
 * users pour les informations de l'utilisation
 * news pour les articles
 * et comments pour les informations du commentaire
 */
$users = new users();
$news = new news();
$comments = new comments();
/*
 * Si l'utilisateur est connecté,
 * on assigne l'id pour identifié l'utilisateur 
 * et pour identifié le propriétaire du commentaire
 */
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $comments->id_user = $_SESSION['id'];
}
/*
 * Si l'id dans l'url existe,
 * on assigne l'id récupéré dans l'url dans nos attribut qui servira pour nos requête
 */
if (isset($_GET['id'])) {
    $news->id_new = $_GET['id'];
    $comments->id_new = $_GET['id'];
}
/*
 * Si le l'id du commentaire existe
 * on assigne l'id du commentaire dans notre attribut
 */
if (!empty($_POST['idComment'])) {
    $comments->id_comment = $_POST['idComment'];
}
/*
 *  On prépare notre regex pour les commentaires
 * et on assigne un tableau d'erreur dans nos variable afin de personnalisé nos erreurs
 */
$regexComment = '#[\w\W]#';
$error = array();
$success = array();
/*
 * Si le formulaire a était soumis
 * et que l'utilisateur est connecté
 */
if (isset($_POST['submitAdd'])) {
    if (!isset($_SESSION['id'])) {
        $error['logout'] = 'Vous devez être connecté afin de pouvoir commenter';
    }
    /*
     * On assigne le $_POST du commentaire en le sécurisant avec la fonction htmlspecialchars
     * puis on vérifie si le format désiré pour le commentaire soit bien respecté
     */
    if (!empty($_POST['comment'])) {
        $comments->comments = htmlspecialchars($_POST['comment']);
    } else {
        $error['empty'] = 'Vous devez remplir le champ pour commenter';
    }
    if (!preg_match($regexComment, $comments->comments)) {
        $error['commentBadRegex'] = 'Seul les minuscules, majuscules, chiffre et caractère spéciaux sont autorisés';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * on appelle notre méthode qui nous permet de créer un commentaire
     * on appelle nos méthode afin le commentaire ajouté ainsi que le nombre de commentaire soit mis à jour après l'actualisation
     */
    if (count($error) == 0) {
        if ($comments->createComments()) {
            $success['insertComment'] = 'Votre commentaire a était ajouté';
            $readComments = $comments->readComments();
            $countComments = $comments->countComments();
        } else {
            $error['notInsertComment'] = 'Votre commentaire n\'a pas était enregistré, veuillez réessayez plus tard ou contactez-nous';
        }
    }
}
/*
 * Si l'utilisateur clique sur le bouton édité
 * et que le champ du commentaire n'est pas vide
 * on assigne la saisie dans l'attribut en le sécurisant avec htmlspecialchars
 * puis on vérifie si le format désiré pour le commentaire est bien respecté
 * Et enfin, si le formulaire ne comporte aucune erreur, on appelle notre méthode pour modifier le commentaire
 * puis on l'affiche de nouveau
 */
if (isset($_POST['edit'])) {
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
// Si l'utilisateur est connecté et qu'il clique sur le bouton supprimer
if (isset($_POST['deleteBtn'])) {
    /*
     *  On appelle notre méthode afin de supprimer le commentaire
     *  on affiche les commentaires et le nombre de commentaire afin qu'après actualisation, l'affichage se mette à jour
     */
    if ($comments->deleteComments()) {
        $readComments = $comments->readComments();
        $countComments = $comments->countComments();
        $success['deleteComment'] = 'Votre commentaire a était supprimé';
    }
}
/*
 * On assigne nos méthodes qui nous servira à : 
 * lire les informations de l'utilisateur
 * lire l'article en rapport avec son id
 * lire les commentaires lié à l'article
 * et compter le nombre de commentaire total d'un article
 */
$readUsers = $users->readUsers();
$readArticles = $news->readNewsById();
$readComments = $comments->readComments();
$countComments = $comments->countComments();
