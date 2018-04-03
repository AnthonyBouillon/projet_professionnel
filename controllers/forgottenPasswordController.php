<?php

/*
 * On instancie l'objet users
 * puis on assigne un tableau vide dans une variable afin de personnalisé nos messages 
 */
$users = new users();
$formError = array();
$formSuccess = array();

// Si l'utilisateur est connecté, on le redigire vers la page d'accueil
if(isset($_SESSION['id'])){
    header('Location: Accueil');
}
/*
 * Si le formulaire est soumis,
 * on vérifie que le champ n'est pas vide et existe,
 * puis on assigne la saisie du champ dans notre attribut en utilisant htmlspecialchars pour convertir nos entités en HTML
 * et on vérifie si l'adresse e-mail saisie existe ou non dans la base de données
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['mail'])) {
        $users->mail = htmlspecialchars($_POST['mail']);
        $readUsers = $users->readUsers();
        if (!isset($readUsers->mail)) {
            $formError['notExistMail'] = 'L\'adresse e-mail saisie n\'existe pas';
        }
    } else {
        $formError['errorMail'] = 'Veuillez saisir votre adresse e-mail';
    }
    /*
     * Si le formulaire ne comporte aucune erreur,
     * on désigne le destinataire de l'e-mail
     * puis le contenu du message avec le lien qui redirigera l'utilisateur vers le nouveau formulaire
     */
    if (count($formError) == 0) {
            $to = $users->mail;
            $subject = 'APT récupération du compte';
            $message = 'Bienvenue sur All Plateform Together,' . "\r\n\r\n";
            $message .= 'Pour modifier le mot de passe de votre compte, veuillez cliquer sur le lien ci dessous' . "\r\n";
            $message .= 'ou copier/coller dans votre navigateur internet.' . "\r\n\r\n";
            $message .= 'http://projetprofessionnel/views/recoveryPasswordView.php?id=' . $readUsers->id . '&key=' . $readUsers->keyMail . "\r\n\r\n";
            $message .= '--------------------------------------------------' . "\r\n\r\n\r\n";
            $message .= 'Cordialement le responsable du site';
            $headers = 'De : ' . $users->mail;
            // Si l'e-mail est envoyé, message de confirmation, sinon message d'erreur
            if (mail($to, $subject, $message, $headers)) {
                $formSuccess['sendMail'] = 'Un e-mail a était envoyez à votre adresse e-mail, vous pouvez dès à présent quitter cette page';
            } else {
                $formError['failMail'] = 'Un problème est survenu lors de la tentative d\'envoi de l\'e-mail, veuillez réessayez ultérieurement';
            }
    }
}







