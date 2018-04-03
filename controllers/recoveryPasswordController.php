<?php

/*
 * On instancie l'objet users
 * puis on prépare notre regex pour le mot de passe
 * et on assigne un tableau vide dans une variable pour nos message personnalisés
 */
$users = new users();
$regexPassword = '#^[\w\W]{11,255}$#';
$formError = array();
$formSuccess = array();
// Si l'utilisateur est connecté, il est redirigé vers la page d'accueil
if (isset($_SESSION['id'])) {
    header('Location: ../Accueil');
}
/*
 * On vérifie que l'id et la clé n'est pa vide et existe
 * sinon la page 404 apparait
 * puis on assigne l'id et on assigne notre méthode dans une variable afin de vérifié si la clé correspond bien avec celle qui est dans la base de données
 */
if (!empty($_GET['id']) && !empty($_GET['key'])) {
    $users->id = $_GET['id'];
    $readUsers = $users->readUsers();
    if ($readUsers->keyMail != $_GET['key']) {
        header('Location:404.php');
    }
    /*
     * On vérifie que le formulaire a était soumis
     * puis on vérifie que nos champs ne sont pas vide et qu'ils existent
     */
    if (isset($_POST['submit'])) {
        if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
            /*
             * On assigne le nouveau mot de passe dans notre attribut
             * puis on hash ce même mot de passe pour plus de sécurité
             * utilisation de htmlspecialchars pour convertir nos entités en HTML
             * et password_hash afin de haché le nouveau mot de passe de l'utilisateur
             */
            $users->password = htmlspecialchars($_POST['password']);
            $users->passwordHash = password_hash($users->password, PASSWORD_BCRYPT);
        } else {
            $formError['empty'] = 'Veuillez remplir tous les champs';
        }
        /*
         * On vérifie que la saisie des deux champs soit identiques
         * puis on vérifie que le format désiré pour le nouveau mot de passe soit respecté
         */
        if ($users->password != $_POST['confirmPassword']) {
            $formError['notPassSimilar'] = 'Les deux mots de passe doit-être identiques';
        }
        if (!preg_match($regexPassword, $users->password)) {
            $formError['badRegex'] = 'Mot de passe : Minimum 11 caractères, maximum 255 caractères';
        }
        /*
         * Si le formulaire ne comporte aucune erreur
         * on appelle notre méthode qui nous permet de modifier le mot de passe de l'utilisateur
         * et on envoi un e-mail de confirmation de la modification du mot de passe à l'utilisateur
         */
        if (count($formError) == 0) {
            if ($users->updatePassword()) {
                $to = $readUsers->mail;
                $subject = 'APT mot de passe modifié';
                $message = 'Bienvenue sur All Plateform Together,' . "\r\n\r\n";
                $message .= 'Votre mot de passe a était modifier avec succès, vous pouvez vous connecté sur notre site avec votre nouveau mot de passe en cliquant sur le lien ci-dessous' . "\r\n";
                $message .= 'ou copier/coller dans votre navigateur internet.' . "\r\n\r\n";
                $message .= 'http://projetprofessionnel/Accueil' . "\r\n\r\n";
                $message .= '--------------------------------------------------' . "\r\n\r\n\r\n";
                $message .= 'Cordialement le responsable du site';
                $headers = 'Message provenant de : All platform Together';
                // Si l'e-mail est envoyé, message de confirmation, sinon message d'erreur
                if (mail($to, $subject, $message, $headers)) {
                    $formSuccess['updatePass'] = 'Votre mot de passe a était changé et vous recevrez la confirmation dans votre boite mail, vous pouvez dès à présent vous connecter avec votre nouveau mot de passe';
                } else {
                    $formError['failMail'] = 'Un problème est survenu lors de la tentative d\'envoi de l\'e-mail, veuillez réessayez ultérieurement';
                }
            }
        }
    }
} else {
    header('Location:404.php');
}

