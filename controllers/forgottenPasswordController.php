<?php
/*
 * On instancie l'objet users
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs
 */
$users = new users();
$formError = array();
$formSuccess = array();
/*
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que le champ n'est pas vide
 * On assigne la valeur du $_POST dans l'attribut de l'objet users
 * On assigne notre tableau qui contient toute les informations de la table users dans une variable
 * On vérifie que l'adresse e-mail existe
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['mail'])) {
        $users->mail = $_POST['mail'];
        $checkElements = $users->checkElements();
        if (!isset($checkElements->mail)) {
            $formError['notExistMail'] = 'L\'email saisie n\'existe pas';
        }
    } else {
        $formError['errorMail'] = 'Veuillez saisir votre e-mail';
    }
    /*
     * On vérifie que le formulaire ne comporte aucune erreur
     * On vérifie que l'adresse e-mail saisie correspond avec celui trouvé dans la base de donnée
     * Puis on envoie un e-mail avec l'id de l'adresse e-mail et la meme clé que celui qui à était créé pour l'inscription
     */
    if (count($formError) == 0) {
        if ($users->mail == $checkElements->mail) {
            $to = $users->mail;
            $subject = 'APT récupération du compte';
            $message = 'Bienvenue sur All Plateform Together,' . "\r\n\r\n";
            $message .= 'Pour modifier le mot de passe de votre compte, veuillez cliquer sur le lien ci dessous' . "\r\n";
            $message .= 'ou copier/coller dans votre navigateur internet.' . "\r\n\r\n";
            $message .= 'http://projetprofessionnel/views/recoveryPasswordView.php?id=' . $checkElements->id . '&key=' . $checkElements->keyMail . "\r\n\r\n";
            $message .= '--------------------------------------------------' . "\r\n\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
            $headers = 'De : ' . $users->mail;
            // On vérifie que l'e-mail a était envoyez
            if (mail($to, $subject, $message, $headers)) {
                $formSuccess['sendMail'] = 'Un e-mail a était envoyez à votre adresse e-mail';
            } else {
                $formError['failMail'] = 'Un problème est survenu lors de la tentative d\'envoi de l\'e-mail, veuillez réessayez ultérieurement';
            }
        }
    }
}







