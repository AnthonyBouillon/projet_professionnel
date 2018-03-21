<?php

$news = new news();
$users = new users();
if (isset($readUsers->id_cuyn_admin) && $readUsers->id_cuyn_admin == 1 || 2) {
    $users->id = $_SESSION['id'];
} else {
    header('Location: ../404.php');
}
$readUsers = $users->readUsers();
$news->id_new = $_GET['id'];
if (isset($_POST['submit'])) {
    /*  MODIFICATION D'UNE IMAGE DE PROFIL
     * On vérifie que le formulaire à bien était soumis
     * On vérifie que l'image à bien était choisi
     * On vérifie que la taille de l'image est bien respecté
     * Puis on récupère la chaine de caractère après le point
     */
    if (empty($_FILES['picture'])) {
        $formError['emptyAvatar'] = 'Veuillez ajouter une image pour valider';
    }
    $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $maxSize = 9000000;
    if ($_FILES['picture']['size'] <= $maxSize) {
        $news->extension = substr(strrchr($_FILES['picture']['name'], '.'), 1);
    } else {
        $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 8 mo';
    }
    /*
     * On vérifie que les extensions font partie des extensions valide
     * On créer un dossier qui portera le pseudo de l'utilisateur grâce à la commande mkdir
     * On assigne le chemin de l'image dans le dossier en mettant son id comme nom + le nom de l'extension
     * On utilise la fonction move_uploaded_file afin de déplacer un fichier
     */
    $news->id_user = $_SESSION['id'];
    $news->title = $_POST['title'];
    $news->plateform = $_POST['plateform'];
    $news->resume = $_POST['resume'];
    $news->content = $_POST['content'];
    $news->picture = $_FILES['picture'];

    if (!empty($news->title)) {
        $news->updateTitle();
    }
    if (!empty($news->plateform)) {
        $news->updatePlateform();
    }
    if (!empty($news->resume)) {
        $news->updateResume();
    }
    if (!empty($news->content)) {
        $news->updateContent();
    }
    if (!empty($news->picture)) {
        if (in_array($news->extension, $validsExtensions)) {
            $path = '../news/images/' . $readUsers->username . '/' . $users->id . '.' . $news->extension;
            var_dump($news->id_user . '.' . $news->extension);
            $movement = move_uploaded_file($_FILES['picture']['tmp_name'], $path);
            if ($movement) {
                $news->updatePicture();
                var_dump('ddfdddqsdsdsd');
            }
        } else {
            $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
        }
    }
}