<?php
/*
 * On instancie notre objet users
 * Si l'utilisateur est connecté
 * on assigne la session de l'utilisateur
 * puis on affiche ses informations dans le menu
 */
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
/*
 * On prépare nos regex dont on aura besoin
 * On assigne un tableau vide pour nos messages personnalisés
 */
$regexUsername = '#^[a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]{1,30}$#';
$regexMail = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
$regexMessage = '#^[\w\W]{1,1000}$#';
$formError = array();
$formSuccess = array();
/*
 * Si l'utilisateur valide le formulaire
 * et que tous les champs sont remplis
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) && !empty(['mail']) && !empty($_POST['object']) && !empty($_POST['message'])) {
        // On assigne les saisies de l'utilisateur dans nos variables
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $message = $_POST['message'];
        $object = $_POST['object'];
        /*
         * On vérifie que le format désiré pour les saisies de l'utilisateur soit bien respecté
         * puis on vérifie que l'utilisateur à bien sélectionné un sujet
         */
        if (!preg_match($regexUsername, $username)) {
            $formError['invalidUsername'] = 'Pseudo : Les caractères spéciaux et les espaces ne sont pas autorisés : limité à 30 caractères';
        }
        if (!preg_match($regexMail, $mail)) {
            $formError['invalidMail'] = 'Votre adresse e-mail n\'est pas valide.';
        }
        if (!preg_match($regexMessage, $message)) {
            $formError['invalidMessage'] = 'Message : Vous êtes limité à 1000 caractères';
        }
        if (!isset($object)) {
            $formError['invalidObject'] = 'Veuillez sélectionner un sujet parmis la liste déroulante';
        }
    } else {
        $formErrror['empty'] = 'Veuillez remplir tous les champs';
    }
/*
 * Si le formulaire ne comporte aucune erreur
 * on envoie un e-mail au responsable du site qui contient les informations saisie de l'utilisateur
 */
    if (count($formError) == 0) {
        $to = 'anthonybouilloncontact@gmail.com';
        $subject = 'Sujet : ' . $_POST['object'];
        $text = 'Pseudo : ' . $username . "\r\n" . 'E-mail : ' . $mail . "\r\n" . 'Message : ' . $message;
        $headers = 'Adresse e-mail de l\'expediteur : ' . $mail;
        if (mail($to, $subject, $text, $headers)) {
            $formSuccess['sendMail'] = 'Votre message à était envoyé, vous recevrez une réponse prochainement.';
        } else {
            $formError['sendMailError'] = 'Un problème est survenu lors de la tentative d\'envoi veuillez réessayez ultérieurement';
        }
    }
}
