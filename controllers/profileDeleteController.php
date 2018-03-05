<?php

/*
 * On instancie l'objet users
 * On assigne la session dans notre attribut de l'objet users
 * On vérifie que l'utilisateur est bien connecté, sinon page 404
 */
$users = new users();
$users->id = $_SESSION['id'];
$checkElement = $users->checkElements();
if (!isset($users->id)) {
    header('Location:404.php');
}
/*
 * On vérifie que l'utilisateur à bien soumis le formulaire
 * On appelle la méthode qui supprime son compte
 * On détruit la session
 * Puis on le redigire sur la page d'inscription
 */
if (isset($_POST['submit'])) {
    $users->deleteProfile();
    $deleteProfile = 'Votre compte à bien était supprimé !';
    session_destroy();
    header('refresh:5;url=registerView.php');
}



