<?php

/*
 * On instancie l'objet user
 * si la l'utilisateur est connecté,
 * on assigne la session dans notre attribut
 * puis on affiche les informations de l'utilisateur
 * (pseudo, image de profil, etc)
 */
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
/*
 * On instancie l'objet news
 * on assigne l'id de l'article dans notre attribut
 */
$news = new news();
if (!empty($_GET['id'])) {
    $news->id_new = $_GET['id'];
}
$error = array();
$success = array();
/*
 * 
 */
if (isset($_POST['submitUpdate'])) {
    $news->id_user = $_SESSION['id'];
    $news->title = htmlspecialchars($_POST['title']);
    $news->plateform = htmlspecialchars($_POST['plateform']);
    $news->resume = htmlspecialchars($_POST['resume']);
    $news->content = htmlspecialchars($_POST['content']);
    $news->picture = $_FILES['picture'];
    /*
     * 
     */
    if (!empty($news->title)) {
        if ($news->updateTitle()) {
            $success['updateTitle'] = 'Le titre de l\'article a était modifié';
        } else {
            $error['!updateTitle'] = 'Le titre de l\'article n\'a pas pu être modifié, si cela se reproduit, veuillez me contacter via le formulaire de contact';
        }
    }
    if (!empty($news->plateform)) {
        if ($news->updatePlateform()) {
            $success['updatePlatform'] = 'Le nom de la plateforme de l\'article a était modifié';
        } else {
            $error['!updatePlatform'] = 'Le nom de la plateforme de l\'article n\'a pas pu être modifié, si cela se reproduit, veuillez me contacter via le formulaire de contact';
        }
    }
    if (!empty($news->resume)) {
        if ($news->updateResume()) {
            $success['updateResume'] = 'Le résumé de l\'article a était modifié';
        } else {
            $error['!updateResume'] = 'Le résumé de l\'article n\'a pas pu être modifié, si cela se reproduit, veuillez me contacter via le formulaire de contact';
        }
    }
    if (!empty($news->content)) {
        if ($news->updateContent()) {
            $success['updateContent'] = 'Le contenu de l\'article a était modifié';
        } else {
            $error['!updateContent'] = 'Le contenu de l\'article n\'a pas pu être modifié, si cela se reproduit, veuillez me contacter via le formulaire de contact';
        }
    }
    /*
     * 
     */
    $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $maxSize = 9000000;
    if ($_FILES['picture']['size'] <= $maxSize) {
        $extension = substr(strrchr($_FILES['picture']['name'], '.'), 1);
    } else {
        $error['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 8 mo';
    }
    if (in_array($extension, $validsExtensions)) {
        /*
         * On assigne dans une variable une fonction qui génère une valeur aléatoire
         * puis on indique le chemin en donnant comme nom : la valeur aléatoire + . + l'extension de l'image récupéré précédemment
         * et on déplace l'image dans le chemin indiqué grâce à la fonction move_uploaed_file
         */
        $nbRandom = mt_rand();
        $path = '../news/images/' . $nbRandom . '.' . $extension;
        $news->picture = $nbRandom . '.' . $extension;
        $movement = move_uploaded_file($_FILES['picture']['tmp_name'], $path);
        if ($movement) {
            if ($news->updatePicture()) {
                $success['updatePicture'] = 'L\'image de l\'article a était modifié';
            } else {
                $error['!updatePicture'] = 'L\'image de l\'article n\'a pas pu être modifié, peut-être que l\'image n\'est pas de ce format :  jpg, jpeg, png ou gif, si cela se reproduit, veuillez me contacter via le formulaire de contact';
            }
        }
    }
}