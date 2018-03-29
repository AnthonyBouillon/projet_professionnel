<?php

/*
 * On instancie l'objet users afin de pouvoir modifier les données de l'utilisateur
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
$readUsers = $users->readUsers();
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
        if (is_dir('..members/avatars/' . $users->username)) {
            mkdir('../members/avatars/' . $users->username, 777);
        }
        $path = '../members/avatars/' . $users->username . '/' . $users->id . '.' . $users->extension;
        $movement = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
    } else {
        $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
    }
    /*
     * On vérifie qu'il n'y a aucune erreur
     * On appelle la méthode qui nous permet de modifier le champ avatar de la base de données
     * On l'affiche
     */
    if (count($formError) == 0) {
        $users->updateAvatar();
        $readUsers = $users->readUsers();
        $formSuccess['avatarUpdate'] = 'Votre image de profil à était modifié avec succès';
    }
}
/*  MOFICATION DE L'ADRESSE E-MAIL
 * Si le formulaire à était soumis et que nos champs ne sont pas vide,
 * on assigne le $_POST dans notre attribut qui ce trouve dans la classe users
 */
if (isset($_POST['submitMail'])) {
    if (!empty($_POST['mail']) && !empty($_POST['confirmMail'])) {
        $users->mail = htmlspecialchars($_POST['mail']);
        $readMail = $users->readMail();
        // Si l'adresse e-mail existe déja et que l'id de l'utilisateur et le mail enregistré et différent du mail saisie
        if (!empty($readMail->mail) && $users->mail != $readUsers->mail) {
            $formError['mailExist'] = 'L\'adresse e-mail existe déja';
            // Si l'id de l'utilisateur et l'adresse e-mail saisie et le meme que celui qui est enregistré
        } elseif ($users->mail == $readUsers->mail) {
            $formError['mailSimilar'] = 'Vous essayez de modifier votre propre adresse e-mail qui est déjà enregistrée XD';
        }
        /*
         * Si l'adresse e-mail saisie est différent du champ de confirmation,
         * on affichage un message d'erreur
         */
        if ($users->mail != $_POST['confirmMail']) {
            $formError['mailDiff'] = 'Les deux adresses e-mail doit-être identiques';
        }
        /*
         * Si le format désiré n'est pas respecté,
         * on affichage un message d'erreur
         */
        if (!preg_match($regexMail, $users->mail) && !preg_match($regexMail, $_POST['confirmMail'])) {
            $formError['wrongFormat'] = 'L\'adresse e-mail doit-être de ce format : exemple@email.com';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * et que l'adresse e-mail à bien était modifier
     * on envoie un e-mail à l'utilisateur confirmant que son adresse e-mail a bien était modifier
     */
    if (count($formError) == 0) {
        if ($users->updateMail()) {
            $to = $_POST['mail'];
            $subject = 'APT : Confirmation de la modification de votre adresse e-mail';
            $headers = 'Bonjour ' . $users->username . ',';
            $message = 'La modification de votre adresse e-mail à bien était prise en compte' . "\r\n";
            $message .= 'La nouvelle adresse e-mail enregistrée est : ' . $_POST['mail'] . '' . "\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
        }
        if (mail($to, $subject, $message, $headers)) {
            $formSuccess['sendMail'] = 'Votre adresse e-mail à bien était enregistrée, un e-mail vous à était envoyé afin que vous ayez la confirmation';
        } else {
            $formError['sendMailError'] = 'Un problème est survenu lors de la modification de votre adresse e-mail, veuillez réessayez ultérieurement';
        }
    }
}
/*  MOFICATION DU MOT DE PASSE
 * On vérifie que le formulaire a bien était soumis
 * On vérifie que les champs ne sont pas vide
 * On assigne nos attributs par la saisie de l'utilisateur
 */
if (isset($_POST['submitPassword'])) {
    if (!empty($_POST['password']) && !empty($_POST['newPassword'])) {
        $users->password = htmlspecialchars($_POST['password']);
        $users->newPassword = htmlspecialchars($_POST['newPassword']);
        // Si le mot de passe est différent de celui de la confirmation : message d'erreur
        if ($users->newPassword != $_POST['confirmPassword']) {
            $formError['passwordDiff'] = 'Vos deux mots de passe ne sont pas identiques';
        }
        // On vérifie que le format désiré est bien respecté
        if (!preg_match($regexPassword, $users->newPassword)) {
            $formError['wrongFormatPassword'] = 'Mot de passe : Minimum 11 caractères maximum 255 caractères';
        }
        if (!preg_match($regexPassword, $_POST['confirmPassword'])) {
            $formError['wrongFormatPassword'] = 'Mot de passe : Minimum 11 caractères maximum 255 caractères';
        }
        /* On vérifie que le mot de passe de l'utilisateur correspond bien avec le mot de passe chiffré de la base de données
         * Si le mot de passe est correct on assigne notre attribut par le mot de passe qu'on a chiffré grâce à la fonction password_hash
         */
        if (password_verify($users->password, $readUsers->password)) {
            $users->passwordHash = password_hash($users->newPassword, PASSWORD_BCRYPT);
        } else {
            $formError['badPassword'] = 'Mauvais mot de passe';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * Et que le mot de passe a bien était modifié
     * On envoie un e-mail à l'utilisateur confirmant la modification de son mot de passe
     */
    if (count($formError) == 0) {
        if ($users->updatePassword()) {
            $to = $readUsers->mail;
            $subject = 'APT : Confirmation de la modification de votre mot de passe';
            $headers = 'Bonjour ' . $readUsers->username . ',';
            $message = 'Je vous confirme la modification de votre nouveau mot de passe qui à bien était mis à jour dans notre base de données' . "\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
        }
        if (mail($to, $subject, $message, $headers)) {
            $formSuccess['sendPassword'] = 'Votre mot de passe a était changé, un e-mail de confirmation vous à était envoyé à votre adresse e-mail';
        } else {
            $formError['sendPasswordError'] = 'Un problème est survenu lors de l\'envoi de l\'e-mail, veuillez réessayez ultérieurement';
        }
    }
}
