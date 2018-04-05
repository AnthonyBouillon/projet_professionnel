<?php
/*
 * J'instancie mon objet users()
 * puis j'assigne ma méthode readStatus() qui me permet d'afficher les statuts des utilisateurs
 */
$admin = new users();
$readStatus = $admin->readStatusByUsers();

