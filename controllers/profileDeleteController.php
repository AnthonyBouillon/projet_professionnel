<?php

// On instancie l'objet users()
$users = new users();
// Affichage des informations (pseudo + image du menu)
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->id_topic = $_SESSION['id_topic'];
} else {
    header('Location:Accueil');
}
$readUsers = $users->readUsers();
/*
 * Si l'utilisateur clique sur supprimer le compte
 * On appelle la méthode deleteUsers afin de supprimer toutes les informations de l'utilisateur
 */
if (isset($_POST['submit'])) {
    if ($users->deleteUsers()) {
        // On assigne les chemins des différent format des images que peut avoir l'utilisateur et du dossier qui est lié à l'utilisateur
        $filePicturePNG = '../members/avatars/' . $readUsers->username . '/' . $readUsers->id . '.png';
        $filePictureJPG = '../members/avatars/' . $readUsers->username . '/' . $readUsers->id . '.jpg';
        $filePictureJEPG = '../members/avatars/' . $readUsers->username . '/' . $readUsers->id . '.jepg';
        $filePictureGIF = '../members/avatars/' . $readUsers->username . '/' . $readUsers->id . '.gif';
        $fileFakeImg = '../members/avatars/' . $readUsers->username . '/fake.jpg';
        $docName = '../members/avatars/' . $readUsers->username;
        /*
         *  Si le ou les fichiers et que le dossier existent
         * on supprime
         */
        if (file_exists($filePicturePNG)) {
            unlink($filePicturePNG);
        }
        if (file_exists($filePictureJPG)) {
            unlink($filePictureJPG);
        }
        if (file_exists($filePictureJEPG)) {
            unlink($filePictureJEPG);
        }
        if (file_exists($filePictureGIF)) {
            unlink($filePictureGIF);
        }
        if (file_exists($fileFakeImg)) {
            unlink($fileFakeImg);
        }
        if (file_exists($docName)) {
            rmdir($docName);
        }
        $success = 'Votre compte à bien était supprimé !';
        /*
         * La session de l'utilisateur est détruite
         * puis l'utilisateur est redirigé vers la page d'inscription
         */
        session_destroy();
        header('refresh:5;url=Inscription');   
    }
} else {
    $error = 'Malheureusement un problème est survenue et votre compte n\'a pas pu être supprimé, veuillez réessayez ulterieurement ou contactez nous.';
}
