<?php

/*
 * On instancie l'objet users
 * On assigne une regex dans une variable qui servira pour nos champs
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs et de réussites
 */
$users = new users();
$regexUsername = '#^[a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]{1,30}$#';
$regexMail = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
$regexPassword = '#^[\w\W]{11,255}$#';
$formError = array();
$formSuccess = array();
/*
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que nos superglobales $_POST ne sont pas vide et existent
 * On assigne la valeur des $_POST dans les attributs de l'objet users
 * On utilise les fonctions strip_tags ou htmlspecialchars afin de supprimer ou de convertir les balises HTML et PHP
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) && !empty($_POST['mail']) && !empty($_POST['confirmMail']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        $users->username = htmlspecialchars($_POST['username']);
        $users->mail = htmlspecialchars($_POST['mail']);
        $users->password = htmlspecialchars($_POST['password']);
        $users->passwordHash = password_hash($users->password, PASSWORD_BCRYPT);
        /*
         * On vérifie que le pseudo et l'adresse e-mail ne sont pas enregistrés dans la base de donnée
         * On vérifie que les champs qui doivent être identiques le sont
         * On vérifie que le format désiré des données saisies soient respectés
         */
        // On assigne notre tableau qui contient toute les informations de la table users dans une variable
        $readUsers = $users->readUsers();
        if (!empty($readUsers->username)) {
            $formError['unavailableUsername'] = 'Le pseudo est déjà utilisé';
        }
        if (!empty($readUsers->mail)) {
            $formError['unavailableMail'] = 'L\'adresse e-mail est déjà utilisé';
        }
        if ($users->mail != $_POST['confirmMail']) {
            $formError['mailDiff'] = 'Les adresses e-mails ne sont pas identiques';
        }
        if ($users->password != $_POST['confirmPassword']) {
            $formError['passwordDiff'] = 'Les mots de passe ne sont pas identiques';
        }
        if (!preg_match($regexUsername, $users->username)) {
            $formError['usernameTooBig'] = 'Pseudo : Les caractères spéciaux et les espaces ne sont pas autorisés : limité à 30 caractères';
        }
        if (!preg_match($regexMail, $users->mail)) {
            $formError['mailWrongFormat'] = 'Format autorisé : exemple@exemple.fr/com';
        }
        if (!preg_match($regexMail, $_POST['confirmMail'])) {
            $formError['mailWrongFormat'] = 'Format autorisé : exemple@exemple.fr/com';
        }
        if (!preg_match($regexPassword, $users->password)) {
            $formError['wrongPassword'] = 'Mot de passe : Minimum 11 caractères, maximum 255 caractères';
        }
        if (!preg_match($regexPassword, $_POST['confirmPassword'])) {
            $formError['wrongPassword'] = 'Mot de passe : Minimum 11 caractères, maximum 255 caractères';
        }
        /*
         * On assigne la clé secrète à notre objet
         * On vérifie que la réponse du CAPTCHA est positif
         */
        $recaptcha = new \ReCaptcha\ReCaptcha('6LeHrEcUAAAAAHEwEAJ3zGH8SpvW0EFxP9EnWOR1');
        if (isset($_POST['g-recaptcha-response'])) {
            $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
            if (!$resp->isSuccess()) {
                $errors = $resp->getErrorCodes();
                $formError['captcha'] = 'Captcha invalide';
            }
        }
    }
    /*
     * On vérifie que le formulaire ne contient aucune erreur
     * On assigne une chaine de caractère mélangé aléatoirement dans l'attribut de l'objet users
     * On vérifie que l'utilisateur à était enregistré dans la base de donnée
     * Puis on envoie un e-mail de confirmation de compte à l'utilisateur inscrit
     */
    if (count($formError) == 0) {
        $users->keyMail = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789');
        if ($users->createUsers()) {
            $readUsers = $users->readUsers();
            $to = $users->mail;
            $subject = 'Votre inscription sur le site APT';
            $message = 'Bienvenue ' . $readUsers->username . ' sur All Plateform Together,' . "\r\n\r\n";
            $message .= 'Pour activer votre compte, veuillez cliquer sur le lien ci dessous' . "\r\n";
            $message .= 'ou copier/coller dans votre navigateur internet.' . "\r\n\r\n";
            $message .= 'http://projetprofessionnel/views/validationView.php?id=' . $readUsers->id . '&key=' . $users->keyMail . "\r\n\r\n";
            $message .= '--------------------------------------------------' . "\r\n\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
            $headers = 'De : ' . $users->mail;
            if (mail($to, $subject, $message, $headers)) {
                $formSuccess['sendMail'] = 'Votre compte est créé, veuillez confirmez votre compte en cliquant sur le lien envoyé à votre adresse e-mail. Vous pouvez quitter cette page.';
            } else {
                $formError['failMail'] = 'Un problème est survenu lors de la tentative d\'envoi de l\'e-mail, essayez de vous connecté ou réessayez';
            }
        } else {
            $formError['formFail'] = 'Erreur lors de votre création de compte, veuillez réessayez ultérieurement';
        }
    }
}