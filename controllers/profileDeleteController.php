<?php

/*
 * On instancie l'objet users pour pouvoir supprimer un utilisateur
 * On assigne la session dans notre attribut de l'objet users
 * On vérifie que l'utilisateur est bien connecté, sinon page 404
 */
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
} else {
    header('Location:404.php');
}
$readUsers = $users->readUsers();
/*
 * On vérifie que l'utilisateur à bien soumis le formulaire
 * On appelle la méthode qui supprime son compte
 * Si la méthode pour supprimer ses informations est executé
 * Et que son dossier ainsi que ses fichiers existent, on les supprimes
 * On détruit la session
 * Puis on le redigire sur la page d'inscription
 */
if (isset($_POST['submit'])) {
    if ($users->deleteUsers()) {
        $fileName = '../members/avatars/' . $readUsers->username . '/' . $readUsers->avatar;
        $fileFakeImg = '../members/avatars/' . $readUsers->username . '/fake.jpg';
        $docName = '../members/avatars/' . $readUsers->username;
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        if (file_exists($fileFakeImg)) {
            unlink($fileFakeImg);
        }
        if (file_exists($docName)) {
            rmdir($docName);
        }
        $success = 'Votre compte à bien était supprimé !';
        header('refresh:5;url=Inscription');
        session_destroy();
    } else {
        $error = 'Malheureusement un problème est survenue et votre compte n\'a pas pu être supprimer, veuillez réessayez ulterieurement ou contactez nous.';
    }
}




