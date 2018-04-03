<?php

/*
 * On instancie notre objet users
 * Si l'utilisateur est connecté,
 * on assigne ll'id de l'utilisateur dans notre attribut,
 * qui nous servira à afficher ses informations dans le menu grâce à notre méthode readUsers
 */
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
/*
 * Si l'utilisateur n'a pas les droits pour accéder à cette page,
 * l'erreur 403 apparait
 */
if ($readUsers->id_cuyn_admin != 5 && $readUsers->id_cuyn_admin != 2) {
    header('Location: ../views/403.php');
}
// On instancie notre objet news
$news = new news();
// On prépare nos regex pour nos champs 
$regexTitle = '#^[\w\W]{1,60}$#';
$regexPlateform = '#^[\w\W]{1,30}$#';
$regexResume = '#^[\w\W]{1,500}$#';
// On assigne un tableau vide dans un variable pour nos messages personnalisés
$formError = array();
$formSuccess = array();
/*
 * Si le formulaire et soumis et que tous les champs sont remplis
 * On assigne nos attribut par les saisies de l'utilisateur 
 * et on ajoute la fonction htmlspecialchars afin de convertir les entités en HTML
 */
if (isset($_POST['submitCreate'])) {
    if (!empty($_POST['title']) && !empty($_POST['plateform']) && !empty($_POST['resume']) && !empty($_POST['content']) && !empty($_FILES['picture'])) {
        $news->title = htmlspecialchars($_POST['title']);
        $news->plateform = htmlspecialchars($_POST['plateform']);
        $news->resume = htmlspecialchars($_POST['resume']);
        $news->content = htmlspecialchars($_POST['content']);
        /*
         * On vérifie si la saisie du champ correspond avec le format désiré grâce à nos regex déifni précédemment
         */
        if (!preg_match($regexTitle, $news->title)) {
            $formError['!regexTitle'] = 'Titre : Vous êtes limité à 60 caractères';
        }
        if (!preg_match($regexPlateform, $news->plateform)) {
            $formError['!regexPlateform'] = 'Plateforme : Vous êtes limité à 30 caractères';
        }
        if (!preg_match($regexResume, $news->resume)) {
            $formError['!regexResume'] = 'Résumer : Vous êtes limité à 500 caractères';
        }
        /*
         * On assigne dans une variable le poids maximul désiré pour une image
         * puis on assigne un tableau avec les extensions des images qu'on souhaite autoriser
         */
        $maxSize = 9000000;
        $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
        /*
         * Si l'image est inférieur ou égale au poids maximum autorisé
         * on récupère la chaîne de caractère qui ce trouve après le point,
         * en somme, on récupère l'extension de l'image
         */
        if (!empty($_FILES['picture'])) {
            if ($_FILES['picture']['size'] <= $maxSize) {
                $extension = strtolower(substr(strrchr($_FILES['picture']['name'], '.'), 1));
            } else {
                $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 80 mo';
            }
            /*
             * On vérifie si l'extension de l'image fait partie des extensions valides
             */
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
            } else {
                $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
            }
        } else {
            $formError['emptyPicture'] = 'Veuillez ajouter une image';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * on assigne l'id de l'utilisateur dans notre attribut demandé par la requête
     * puis on exécute la requête qui nous permet d'insérer les saisies de nos champs dans la base de données news
     */
    if (count($formError) == 0) {
        $news->id_user = $_SESSION['id'];
        if ($news->createNews()) {
            $formSuccess['createNews'] = 'Votre article est enregistré et affiché sur la page des actualités';
        } else {
            $formError['notCreateNews'] = 'Votre article n\'a pas pu être créer, réessayez ou contacté le responsable du site via le formulaire de contact';
        }
    }
}


    