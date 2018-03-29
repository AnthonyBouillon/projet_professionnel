<?php

$users = new users();

if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
if (isset($_GET['id'])) {
    $readProfile = $users->readProfile();
}
if (isset($_POST['delete'])) {
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
$readUser = $users->readStatus();
$rights = new admin();
$readStatus = $rights->readAllStatus();
if (isset($_POST['submitUpdate'])) {
    $users->id_admin = $_POST['updateRights'];
    // id utilisateur
    $users->id = $_POST[''];
    $users->updateRights();
}