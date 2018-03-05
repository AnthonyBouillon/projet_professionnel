<?php

/*
 * On instancie l'objet users
 * On assigne nos sessions dans les attributs de l'objet users
 * On assigne une regex dans nos variables qui servira pour nos champs
 * On assigne notre méthode qui provient de l'objet users
 * On assigne une limite de taille dans une variable
 * On assigne dans une variable un tableau qui contient les extensions autorisés
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs et de réussites
 */
$users = new users();
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
$regexMail = '#^[a-zAZ0-9._-]+@[a-zAZ0-9._-]{2,}\.[a-z]{2,4}$#';
$regexPassword = '#[\w\W]{11,255}#';
$checkElement = $users->checkElements();
$maxSize = 9000000;
$validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
$formError = array();
$formSuccess = array();
// On vérifie que l'utilisateur est bien connecté
if (!isset($users->id)) {
    header('Location:404.php');
}
/*  MODIFICATION D'UNE IMAGE DE PROFIL
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que l'image à bien était choisi
 * On vérifie que la taille de l'image est bien respecté
 * Puis on récupère la chaine de caractère après le point
 */
if (isset($_POST['submitAvatar'])) {
    if (empty($_FILES['avatar'])) {
        $formError['emptyAvatar'] = 'Veuillez ajouter une image pour valider';
    }
    if ($_FILES['avatar']['size'] <= $maxSize) {
        $users->extension = substr(strrchr($_FILES['avatar']['name'], '.'), 1);
    } else {
        $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 8 mo';
    }
    /*
     * On vérifie que les extensions font partie des extensions valide
     * On créer un dossier qui portera le pseudo de l'utilisateur grâce à la commande mkdir
     * On assigne le chemin de l'image dans le dossier en mettant son id comme nom + le nom de l'extension
     * On utilise la fonction move_uploaded_file afin de déplacer un fichier
     */
    if (in_array($users->extension, $validsExtensions)) {
        if(is_dir('..members/avatars/' . $users->username)){
            mkdir('../members/avatars/' . $users->username, 0777);
        }
            $path = '../members/avatars/' . $users->username . '/' . $users->id . '.' . $users->extension;
            $movement = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
    } else {
        $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
    }
    /*
     * On vérifie
     */
    if (count($formError) == 0) {
        $users->updateAvatar();
        $formSuccess['avatarUpdate'] = 'Votre image de profil à était modifié';
    }
}
/*  MOFICATION DE L'ADRESSE E-MAIL
 *
 */
if (isset($_POST['submitMail'])) {
    if (!empty($_POST['mail']) && !empty($_POST['confirmMail'])) {
        $users->mail = strip_tags($_POST['mail']);
        if ($users->mail == $checkElement->mail) {
            $formError['mailSimilar'] = 'Vous essayez de modifier votre adresse e-mail qui est déja enregistrée XD';
        }
        if ($users->mail != $_POST['confirmMail']) {
            $formError['mailDiff'] = 'Les deux adresses e-mail doit-être identiques';
        }
        if (!preg_match($regexMail, $users->mail) && !preg_match($regexMail, $_POST['confirmMail'])) {
            $formError['wrongFormat'] = 'L\'adresse e-mail doit-être de ce format : exemple@email.com';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    if (count($formError) == 0) {
        if ($users->updateMail()) {
            $to = $checkElement->mail;
            $subject = 'APT : Confirmation de la modification de votre adresse e-mail';
            $headers = 'Bonjour ' . $users->username . ',';
            $message = 'La modification de votre adresse e-mail à bien était prise en compte' . "\r\n";
            $message .= 'La nouvelle adresse e-mail enregistrée est : ' . $checkElement->mail . '' . "\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
        } else {
            $formError['mailNotExist'] = 'l\'e-mail saisie existe déja';
        }
        if (mail($to, $subject, $message, $headers)) {
            $formSuccess['sendMail'] = 'Votre adresse e-mail à bien était enregistrée, un e-mail vous à était envoyé afin que vous ayez la confirmation';
        } else {
            $formError['sendMailError'] = 'Un problème est survenu lors de la modification de votre adresse e-mail, veuillez réessayez ultérieurement';
        }
    }
}
/*  MOFICATION DU MOT DE PASSE
 *
 */
if (isset($_POST['submitPassword'])) {
    if (!empty($_POST['password']) && !empty($_POST['newPassword'])) {
        $users->password = htmlspecialchars($_POST['password']);
        $users->newPassword = htmlspecialchars($_POST['newPassword']);
        if ($users->newPassword != $_POST['confirmPassword']) {
            $formError['passwordDiff'] = 'Vos deux mots de passe ne sont pas identiques';
        }
        if (!preg_match($regexPassword, $users->newPassword)) {
            $formError['wrongFormatPassword'] = 'Minimum 11 caractères maximum 255 caractères';
        }
        if (!preg_match($regexPassword, $_POST['confirmPassword'])) {
            $formError['wrongFormatPassword'] = 'Minimum 11 caractères maximum 255 caractères';
        }
        if (password_verify($users->password, $checkElement->password)) {
            $users->passwordHash = password_hash($users->newPassword, PASSWORD_BCRYPT);
        } else {
            $formError['badPassword'] = 'Mauvais mot de passe';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    if (count($formError) == 0) {
        if ($users->updatePassword()) {
            $to = $checkElement->mail;
            $subject = 'APT : Confirmation de la modification de votre mot de passe';
            $headers = 'Bonjour ' . $checkElement->username . ',';
            $message = 'Votre nouveau mot de passe est : ' . $_POST['newPassword'] . "\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
        }
        if (mail($to, $subject, $message, $headers)) {
            $formSuccess['sendPassword'] = 'Votre mot de passe a était changé, un e-mail vous à était envoyé avec votre nouveau mot de passe';
        } else {
            $formError['sendPasswordError'] = 'Un problème est survenu lors de la modification de votre mot de passe, veuillez réessayez ultérieurement';
        }
    }
}
