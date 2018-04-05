<?php


/*
 * On instancie l'objet users
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs ou de validation
 */
$users = new users();
$formError = array();
$formSuccess = array();
/*
 * On vérifie que le formulaire à bien était soumis
 * On vérifie que nos superglobales $_POST ne sont pas vide et existent
 * On assigne la valeur des $_POST dans les attributs de l'objet users
 * On assigne notre tableau qui contient toute les informations de la table users dans une variable
 */
if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $users->username = $_POST['username'];
        $users->password = $_POST['password'];
        $readUsers = $users->readUsers();
        /*
         * On vérifie que le pseudo et le mot de passe sont correct
         * On vérifie si son compte est actif ou non 
         */
        if (!empty($readUsers->username) && password_verify($users->password, $readUsers->password)) {
            if ($readUsers->actif != 1) {
                $formError['notActif'] = 'Votre compte n\'est pas activé, veuillez regarder vos e-mails et cliquer sur le lien de confirmation avant de vous connecter';
            }
        } else {
            $formError['loginBad'] = 'Mauvais identifiant ou mot de passe !';
        }
    }else{
        $formError['empty'] = 'Veuillez remplir les champs avant de valider';
    }
    /*
     * On vérifie que le formulaire ne comporte aucune erreur
     * On assigne les $_SESSION par l'id et le pseudo de l'utilisateur
     * Puis on le redirige vers la page d'accueil
     */
    if (count($formError) == 0) {
        $_SESSION['id'] = $readUsers->id;
        $_SESSION['username'] = $readUsers->username;
        $formSuccess['loginSuccess'] = 'Vous êtes connecté';
        header('refresh:0;url=../Accueil');
    }
}

