<?php

/*
 * Permet l'affichage des informations de l'utilisateur dans le menu
 */
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();

// On instancie notre objet news
$news = new news();
// On assigne notre méthode qui nous retourne le nombre total d'article
$count = $news->countNews();
// On assigne un tableau vide pour nos messages personnalisés.
$error = array();
$success = array();

// On assigne dans notre attribut le nombre d'article que nous voulons sur une page
$news->limitArticles = 3;
/*
 * La fonction ceil permet d'arrondir au nombre supérieur pour tomber sur un nombre entier
 * On divise le nombre total d'article par 3 (la limite d'article par page)
 * Le résultat sera le nombre de page
 */
$numberOfPages = ceil($count / $news->limitArticles);
/*
 * Si l'id de l'article existe,
 * on assigne l'id de l'article,
 * et on assigne l'id dans une variable qui correspond à page sélectionné
 * Si l'id n'existe pas, on défini notre variable à 1 qui correspond à la première page
 */
if (!empty($_GET['id'])) {
    $news->id = $_GET['id'];
    $currentPage = $news->id;
} else {
    $currentPage = 1;
}
/*
 * Si pour x raisons l'utilisateur atteri sur une page où les articles n'existe pas
 * donc si l'id récupéré n'existe pas dans la table news
 * dans ce cas la page actuel deviendra la dernière page qui contient des articles
 */
if ($currentPage > $numberOfPages) {
    $currentPage = $numberOfPages;
}
/*
 * On assigne notre attribut par l'id récupéré -1 X la limite des articles par page (3),
 * afin de stipuler dans notre requete quel résultat récupéré il affiche en premier
 */
$news->firstEntry = ($currentPage - 1) * $news->limitArticles;
/*
 * Si le formulaire de suppresion est soumis,
 * on assigne notre attribut par l'id de l'article afin de le supprimer
 * Si la requête est exécuté, on affiche un message personnalisé
 */
if(isset($_POST['submitDelete'])){
    $news->id_new = $_POST['id_new'];
    if($news->deleteNews()){
        $success['deleteNew'] = 'L\'article a bien était supprimé';
    }else{
        $error['!deleteNew'] = 'L\'article n\'a pas pu être supprimé';
    }
}
// On assigne notre méthode qui nous retourne tous les articles contenu dans la table news afin de les afficher dans notre vue
$readArticle = $news->readNews();
