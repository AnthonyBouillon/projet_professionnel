<?php

/*
 * On instancie nos objets users() pour utiliser les informations de l'utilisateur
 * On instancie nos objets forumCategories() pour utiliser les informations des catégories
 */
$users = new users();
$forumCategories = new forumCategories();
/*
 * Si l'utilisateur est connecté
 * on assigne sa session qui contient son id dans notre attribut de la classe users()
 * on assigne sa session qui contient son pseudo dans notre attribut de la classe users()
 * on assigne sa session qui contient son id dans notre attribut de la classe forumCategories()
 */
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $forumCategories->id_user = $_SESSION['id'];
}
/*
 * On assigne notre méthode readUsers afin d'afficher dans le menu les informations de l'utilisateur
 * On assigne notre méthode readCategories afin de récupérer et d'afficher les catégories du forum
 */
$readUsers = $users->readUsers();
$readCategories = $forumCategories->readCategories();

/*
 * On prépare nos regex pour le nom et la description de la catégorie
 * puis on assigne un tableau vide afin de personnalisé nos messages
 */
$regexName = '#^[\w\W]{1,60}$#';
$regexDescription = '#^[\w\W]{10,255}$#';
$formError = array();
$formSuccess = array();
/* * * * Créer une catégorie * * * *
 * Si le formulaire est soumis
 * on assigne dans nos attributs nos $_POST correspondant avec la fonction htmlspecialchars afin de convertir les entités en HTML
 * Si le nom et la catégorie n'est pas vide,
 * on vérifie si le format de nos champs sont respectés, sinon message d'erreur
 */
if (isset($_POST['submitCreate'])) {
    $forumCategories->name = htmlspecialchars($_POST['name']);
    $forumCategories->description = htmlspecialchars($_POST['description']);
    if (!empty($forumCategories->name) && !empty($forumCategories->description)) {
        if (!preg_match($regexName, $forumCategories->name)) {
            $formError['badRegexName'] = 'Titre : minimum 1 caractères, maximum 60 caractères';
        }
        if (!preg_match($regexDescription, $forumCategories->description)) {
            $formError['badRegexDescription'] = 'Description : minimum 10 caractères, maximum 255 caractères';
        }
    } else {
        $formError['emptyForm'] = 'Veuillez remplir les deux champs afin d\'ajouter une catégorie';
    }
    /*
     * Si le formulaire ne comporte aucune erreur
     * on appelle notre méthode qui nous permet de créer une catégorie
     * et ensuite on apelle notre méthode qui nous permet de l'afficher
     */
    if (count($formError) == 0) {
        if ($forumCategories->createCategories()) {
            $readCategories = $forumCategories->readCategories();
        }
        $formSuccess['createCategory'] = 'La catégorie à était ajouté au forum';
    }
}
/* * * * Modifier une catégorie * * * *
 * 
 *  
 */
if (isset($_POST['submitUpdate'])) {
    $forumCategories->id_category = $_POST['idCategory'];
    $forumCategories->name = htmlspecialchars($_POST['name']);
    $forumCategories->description = htmlspecialchars($_POST['description']);
    if (!empty($forumCategories->name) && !empty($forumCategories->description)) {
        if (!preg_match($regexName, $forumCategories->name)) {
            $formError['badRegexUpdateName'] = 'Titre : minimum 1 caractères, maximum 60 caractères';
        }
        if (!preg_match($regexDescription, $forumCategories->description)) {
            $formError['badRegexUpdateDescription'] = 'Description : minimum 10 caractères, maximum 255 caractères';
        }
    } else {
        $formError['emptyFormUpdate'] = 'Veuillez remplir les  deux champs afin d\'ajouter une catégorie';
    }
    if (count($formError) == 0) {
        if ($forumCategories->updateCategories()) {
            $readCategories = $forumCategories->readCategories();
            $formSuccess['updateCategory'] = 'La catégorie du forum à était modifié';
        }
    }
}
/* * * * Supprimer une catégorie * * * *
 * Si le formulaire est soumis
 * on assigne l'id de la catégorie dans notre attribut
 * puis si la requête est exécuté on affiche les catégories
 * et on affiche un message de confirmation
 */
if (isset($_POST['submitDelete'])) {
    $forumCategories->id_category = $_POST['idCategory'];
    if ($forumCategories->deleteCategories()) {
        $readCategories = $forumCategories->readCategories();
        $formSuccess['deleteCategory'] = 'La catégorie a était supprimé avec succès';
    }
}
