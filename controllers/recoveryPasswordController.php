<?php

/*
 * On instancie l'objet users
 * On assigne une regex dans une variable qui servira pour nos champs
 * On assigne un tableau vide dans une variable qui servira à créer nos messages d'erreurs et de réussite
 */
$users = new users();
$regexPassword = '#^[\w\W]{11,255}$#';
$formError = array();
$formSuccess = array();
/*
 * On vérifie que l'url contient un id et une clé
 * On assigne l'id de l'url dans notre attribut de l'objet users
 * On assigne notre tableau qui contient toute les informations de la table users dans une variable
 * On vérifie que la clé de l'url correspond avec celui enregistré dans la base de donnée lié à son id
 */
if (!empty($_GET['id']) && !empty($_GET['key'])) {
    $users->id = $_GET['id'];
    $readUsers = $users->readUsers();
    if ($checkElement->keyMail != $_GET['key']) {
        header('Location:404.php');
    }
    /*
     * On vérifie que le formulaire à bien était soumis
     * On vérifie que nos $_POST ne sont pas vide
     * Puis on les assignent à nos attributs de notre objet users
     * On vérifie que les deux champs sont identiques
     * Puis on vérifie que le format désiré soit correct
     */
    if (isset($_POST['submit'])) {
        if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
            $users->password = htmlspecialchars($_POST['password']);
            $users->passwordHash = password_hash($users->password, PASSWORD_BCRYPT);
        } else {
            $formError['empty'] = 'Veuillez remplir tous les champs';
        }
        if ($users->password != $_POST['confirmPassword']) {
            $formError['notPassSimilar'] = 'Les deux mots de passe doit-être identiques';
        }
        if (!preg_match($regexPassword, $users->password)) {
            $formError['badRegex'] = 'Password : Minimum 11 caractères, maximum 255 caractères';
        }
        /*
         * On vérifie que le formulaire ne contient aucune erreur
         * Puis on modifie son mot de passe
         */
        if (count($formError) == 0) {
            if ($users->updatePassword()) {
                $formSuccess['updatePass'] = 'Votre mot de passe a était changé, vous pouvez à présent vous connecter avec votre nouveau mot de passe';
            }
        }
    }
} else {
    header('Location:404.php');
}

