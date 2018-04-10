<?php
/*
 *  Affichage des informations dans le menu
 * Si l'utilisateur est connecté
 * on assigne notre objet users dans une variable
 * puis on assigne l'id + le pseudo dans nos attribut
 * et on affiche ces informations
 */
if (isset($_SESSION['id'])) {
    $users = new users();
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
} else {
    header('Location:Accueil');
}
