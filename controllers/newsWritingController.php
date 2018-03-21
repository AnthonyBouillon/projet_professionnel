<?php

/*
 * On instancie l'objet news
 * On instancie l'objet users
 * On vérifie que l'utilisateur est connecté et on assigne l'id de la session dans un attribut
 */
$news = new news();
$users = new users();

if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
/*
 * On assigne notre méthode qui nous permet de lire ou d'afficher des informations dans un nouvel objet
 * On assigne nos regex
 * On assigne un tableau vide qui servira pour nos erreurs
 */
$readUsers = $users->readUsers();
$regexTitle = '#^[\w\W]{1,60}$#';
$regexPlateform = '#^[\w\W]{1,30}$#';
$regexResume = '#^[\w\W]{1,500}$#';
$formError = array();
$formSuccess = array();
/*
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que les champs ne sont pas vide
 * On assigne nos $_POST dans nos attributs (Ajout de htmlspecialchars pour convertir nos entitiés en HTML)
 * On vérifie si les valeurs de nos $_POST respecte le format désiré
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['title']) && !empty($_POST['plateform']) && !empty($_POST['resume']) && !empty($_POST['content']) && !empty($_FILES['picture'])) {
        $news->title = htmlspecialchars($_POST['title']);
        $news->plateform = htmlspecialchars($_POST['plateform']);
        $news->resume = htmlspecialchars($_POST['resume']);
        $news->content = htmlspecialchars($_POST['content']);
        if (!preg_match($regexTitle, $news->title)) {
            $formError['!regexTitle'] = 'Vous êtes limité à 60 caractères';
        }
        if (!preg_match($regexPlateform, $news->plateform)) {
            $formError['!regexPlateform'] = 'Vous êtes limité à 30 caractères';
        }
        if (!preg_match($regexResume, $news->resume)) {
            $formError['!regexResume'] = 'Vous êtes limité à 500 caractères';
        }
        /*
         * 
         */
        $maxSize = 9000000;
        $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if ($_FILES['picture']['size'] <= $maxSize) {
            $extension = strtolower(substr(strrchr($_FILES['picture']['name'], '.'), 1));
        } else {
            $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 80 mo';
        }
        if (in_array($extension, $validsExtensions)) {
            if (!is_dir('../news/images/' . $readUsers->username)) {
                mkdir('../news/images/' . $readUsers->username, 0777, true);
            }
            $nbRandom = mt_rand();
            $path = '../news/images/' . $readUsers->username . '/' . $nbRandom . '.' . $extension;
            $news->picture = $nbRandom . '.' . $extension;
            $movement = move_uploaded_file($_FILES['picture']['tmp_name'], $path);
        } else {
            $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * Si le formulaire ne contient aucune erreur
     * On appelle la méthode qui nous permet d'insérer un article
     */
    if (count($formError) == 0) {
        $news->id_user = $_SESSION['id'];
        if ($news->createNews()) {
            $formSuccess['createNews'] = 'Votre article est enregistré et affiché sur la page des actualités';
        } else {
            $formError['notCreateNews'] = 'Votre article n\'a pas pu être créer, réessayez ou contacté le technicien du site via le formulaire de contact';
        }
    }
}


    