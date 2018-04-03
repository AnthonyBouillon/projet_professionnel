
<?php
// On instancie l'objet users
$users = new users();
/*
 * On vérifie si l'utilisateur est connecté
 * puis on assige son id dans notre attribut
 * et on affiche ses informations dans le menu comme (l'image et le pseudo de l'utilisateur
 */
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
/*
 * On vérifie que l'id dans l'url existe
 * puis on assigne notre méthode qui nous permet de lire un profil utilisateur
 */
if (!empty($_GET['id'])) {
    $users->id = $_GET['id'];
    $readProfile = $users->readUsers();
}
