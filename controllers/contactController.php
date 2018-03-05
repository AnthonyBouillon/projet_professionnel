<?php

$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
/*
 * On assigne nos regex dans nos variables qui servira pour nos champs
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs et de réussite
 */
$regexUsername = '#^[a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_-]{1,30}$#';
$regexMail = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#';
$regexMessage = '#^[\w\W]{1,1000}$#';
$formError = array();
$formSuccess = array();
/*
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que nos superglobales $_POST ne sont pas vide et existent
 * On assigne la valeur des $_POST dans des variables
 * On vérifie que le format désiré des données saisies soient respectés
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) && !empty(['mail']) && !empty($_POST['object']) && !empty($_POST['message'])) {
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $message = $_POST['message'];
        if (!preg_match($regexUsername, $username)) {
            $formError['invalidUsername'] = 'Pseudo : Les caractères spéciaux et les espaces ne sont pas autorisés : limité à 30 caractères';
        }
        if (!preg_match($regexMail, $mail)) {
            $formError['invalidMail'] = 'Votre adresse mail n\'est pas valide.';
        }
        if (!preg_match($regexMessage, $message)) {
            $formError['invalidMessage'] = 'Message : Vous êtes limité à 1000 caractères';
        }
    } else {
        $formErrror['empty'] = 'Veuillez remplir tous les champs';
    }
    /*
     * On vérifie que le formulaire ne contient aucune erreur
     * Puis l'e-mail saisie par l'utilisateur nous sera envoyé
     */
    if (count($formError) == 0) {
        $to = 'anthonybouilloncontact@gmail.com';
        $subject = 'Sujet : ' . $_POST['object'];
        $text = 'Pseudo : ' . $username . "\r\n" . 'E-mail : ' . $mail . "\r\n" . 'Message : ' . $message;
        $headers = 'Adresse e-mail de l\'expediteur : ' . $mail;
        if (mail($to, $subject, $text, $headers)) {
            $formSuccess['sendMail'] = 'Votre message à était envoyé, vous recevrez une réponse si besoin prochainement.';
        } else {
            $formError['sendMailError'] = 'Un problème est survenu lors de la tentative d\'envoi veuillez réessayez ultérieurement';
        }
    }
}
