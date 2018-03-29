<?php

/*
 * On instancie l'objet users,
 * on assigne l'id de l'utilisateur qui a était récupérer lors de sa connexion et qui a était stocké dans une session
 * et qui nous servira pour nos méthodes dans la classe users
 * puis on assigne le pseudo dans l'attribut qui nous servira à indiquer dans quel nom de dossier l'image doit être déplacé
 */
$users = new users();
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
// Si l'utilisateur n'est pas connecté, la page 404 apparait
!isset($users->id) ? header('Location:404') : '';
// On assigne une regex pour l'adresse e-mail et le mot de passe
$regexMail = '#^[a-zAZ0-9._-]+@[a-zAZ0-9._-]{2,}\.[a-z]{2,4}$#';
$regexPassword = '#[\w\W]{11,255}#';
// On appelle la méthode readUsers pour afficher les données de l'utilisateur (menu, affichage profil)
$readUsers = $users->readUsers();
// On assigne un tableau vide qu'on remplira pour nos erreurs.
$formError = array();
$formSuccess = array();
/*  MODIFICATION D'UNE IMAGE DE PROFIL
 * Si l'utilisateur valide son image
 * on assigne une valeur qui définira le poid maximum de l'image
 * on assigne dans un tableau les extensions qu'on autorise
 */
if (isset($_POST['submitAvatar'])) {
    $maxSize = 9000000;
    $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (empty($_FILES['avatar'])) {
        $formError['emptyAvatar'] = 'Veuillez ajouter une image pour valider';
    }
    /*
     * Si la taille de l'image est inférieur à la valeur qu'on a assigner précédemment
     * on utilise la fonction strrchr afin de trouver la dernière occurence d'une chaîne
     * et on utilise substr qui retourne un segment de la chaîne
     */
    if ($_FILES['avatar']['size'] <= $maxSize) {
        $users->extension = substr(strrchr($_FILES['avatar']['name'], '.'), 1);
    } else {
        $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 8 mo';
    }
    /*
     * On vérifie dans le tableau si l'extension récupérer fait partie des extensions valides
     * puis on assigne le chemin où ce trouvera l'image avec comme nom d'image l'id de l'utilisateur . l'extension
     */
    if (in_array($users->extension, $validsExtensions)) {
        $path = '../members/avatars/' . $users->username . '/' . $users->id . '.' . $users->extension;
        $movement = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
    } else {
        $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
    }
    /*
     * Si le formulaire ne comporte aucune erreur,
     * on appelle la méthode updateAvatar afin de mettre à jour l'image dans la base de données
     * puis on rapelle notre méthode readUsers afin d'afficher après la soumission du formulaire l'image qui à était modifié
     */
    if (count($formError) == 0) {
        $users->updateAvatar();
        $readUsers = $users->readUsers();
        $formSuccess['avatarUpdate'] = 'Votre image de profil à était modifié avec succès';
    }
}
/*  MOFICATION DE L'ADRESSE E-MAIL
 * Si le formulaire est soumis
 * et que les deux champs ne sont pas vide
 */
if (isset($_POST['submitMail'])) {
    if (!empty($_POST['mail']) && !empty($_POST['confirmMail'])) {
        /*
         *  On assigne dans notre attribut la valeur saisie de l'utilisateur du champ mail
         *  et on ajoute la fonction htmlspecialchars afin de convertir les entités HTML
         */
        $users->mail = htmlspecialchars($_POST['mail']);
        /*
         * On apelle la méthode readMail qui nous servira à vérifier toutes les adresses e-mails existante dans la bdd
         * Si l'adresse e-mail existe déja dans la base de données, message d'erreur
         */
        $readMail = $users->readMail();
        if (!empty($readMail->mail) && $users->mail != $readUsers->mail) {
            $formError['mailExist'] = 'L\'adresse e-mail existe déja';
            // Si la saisie est la même que son adresse e-mail actuel dans la base de données, message d'erreur
        } elseif ($users->mail == $readUsers->mail) {
            $formError['mailSimilar'] = 'Cette adresse e-mail est déjà enregistré comme étant la votre';
        }
        // On vérifie que les deux champs sont identiques
        if ($users->mail != $_POST['confirmMail']) {
            $formError['mailDiff'] = 'Les deux adresses e-mail doit-être identiques';
        }
        // On vérifie si l'adresse e-mail saisie correspond au format désiré
        if (!preg_match($regexMail, $users->mail)) {
            $formError['wrongFormat'] = 'L\'adresse e-mail doit-être de ce format : exemple@email.com';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * et que la méthode afin de modifier l'adresse e-mail retourne vrais
     */
    if (count($formError) == 0) {
        if ($users->updateMail()) {
            /*
             * on assigne l'adresse e-mail de l'utilisateur comme destinataire
             * on assigne un sujet,
             * un message
             */
            $to = $_POST['mail'];
            $subject = 'APT : Confirmation de la modification de votre adresse e-mail';
            $headers = 'Bonjour ' . $users->username . ',';
            $message = 'La modification de votre adresse e-mail à bien était prise en compte' . "\r\n";
            $message .= 'La nouvelle adresse e-mail enregistrée est : ' . $_POST['mail'] . '' . "\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
        }
        /*
         * Si l'e-mail à était envoyé
         * message de confirmation, sinon message d'erreur
         */
        if (mail($to, $subject, $message, $headers)) {
            $formSuccess['sendMail'] = 'Votre adresse e-mail à bien était enregistrée, un e-mail vous à était envoyé afin que vous ayez la confirmation';
        } else {
            $formError['sendMailError'] = 'Un problème est survenu lors de la modification de votre adresse e-mail, veuillez réessayez ultérieurement';
        }
    }
}
/*  MOFICATION DU MOT DE PASSE
 * On vérifie que le formulaire a bien était soumis,
 * que les deux champs ne sont pas vide,
 */
if (isset($_POST['submitPassword'])) {
    if (!empty($_POST['password']) && !empty($_POST['newPassword'])) {
        // On assigne dans nos attribut les valeurs du $_POST
        $users->password = htmlspecialchars($_POST['password']);
        $users->newPassword = htmlspecialchars($_POST['newPassword']);
        // Si les deux champs sont différent, message d'erreur
        if ($users->newPassword != $_POST['confirmPassword']) {
            $formError['passwordDiff'] = 'Vos deux mots de passe ne sont pas identiques';
        }
        // On vérifie que le format désiré est bien respecté
        if (!preg_match($regexPassword, $users->newPassword)) {
            $formError['wrongFormatPassword'] = 'Mot de passe : Minimum 11 caractères maximum 255 caractères';
        }
        /*
         * On vérifie que le mot de passe saisie correspond à son mot de passe chiffré dans la base de données
         * puis on assigne notre attribut par le nouveau mot de passe saisie en le chiffrant lui aussi
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
     * on modifie sont mot de passe 
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
