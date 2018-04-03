<?php

/*
 * On instancie l'objet users qui contient les informations de tous les utilisateurs
 * et on instancie l'objet admin qui contient les droits pour les utilisateur
 */
$users = new users();
$admin = new admin();
//Si l'utilisateur est connecté, on assigne son id dans notre attribut qui servira pour nos requêtes
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
/*
 * On assigne nos méthodes qui nous permet de lire les informations des utilisateurs, 
 * de lire le status de chaque membres
 * et la 3 ème méthode qui nous permet d'afficher tous les status
 */
$readUsers = $users->readUsers();
$readStatus = $users->readStatusByUsers();
$readAllStatus = $admin->readAllStatus();
/*
 * Si le formulaire est soumis
 * on assigne l'id des droits administrateur et l'id de l'utilisateur
 * on appelle notre méthode afin de modifier le status de l'utilisateur
 * et on appelle notre méthode afin d'afficher après actualisation le nouveau status qui a était modifier
 */
if (isset($_POST['submitUpdate'])) {
    if (!empty($_POST['id_user']) && !empty($_POST['updateRights'])) {
        $users->id_admin = $_POST['updateRights'];

        $users->id = $_POST['id_user'];
        if ($users->updateRights()) {
            $success = 'Le status de l\'utilisateur a était modifié avec succès';
        }
    }else{
        $error = 'Veuillez sélectionner un status pour le modifier';
    }
    $readStatus = $users->readStatusByUsers();
}