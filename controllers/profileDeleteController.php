<?php

/*
 * On instancie l'objet users pour pouvoir supprimer un utilisateur
 * On assigne la session dans notre attribut de l'objet users
 * On vérifie que l'utilisateur est bien connecté, sinon page 404
 */
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}else{
    header('Location:404.php');
}
$readUsers = $users->readUsers();

/*
 * On vérifie que l'utilisateur à bien soumis le formulaire
 * On appelle la méthode qui supprime son compte
 * On détruit la session
 * Puis on le redigire sur la page d'inscription
 */
if (isset($_POST['submit'])) {
    if($users->deleteUsers()){
/*    unlink('../members/avatars/' . $readUsers->username . '/' . $readUsers->avatar);
    if (is_dir('../members/avatars/' . $readUsers->username)) {
        rmdir('../members/avatars/' . $readUsers->username . 'fake.jpg');
        rmdir('../members/avatars/' . $readUsers->username);
        var_dump('../members/avatars/' . $readUsers->username . 'fake.jpg');
    } */
    $deleteProfile = 'Votre compte à bien était supprimé !';
    header('refresh:5;url=registerView.php');
    session_destroy();
    }else{
        
        var_dump($users->id);
        var_dump('COMPTE NON SUPPR');
    } 
}else{
    var_dump('dddd');
}



