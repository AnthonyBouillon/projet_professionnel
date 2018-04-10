<?php

/*
 * On instancie nos objet users() pour récupérer les informations de l'utilisateur
 * et on instancie l'objet forumSubCategories() afin de récupérer les informations des sous-catégories
 */
$users = new users();
$subCategories = new forumSubCategories();
/*
 * Si l'utilisateur est connecté,
 * on assigne l'id et le pseudo de l'utilisateur dans nos attributs
 */
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}
/*
 * On apelle nos méthodes afin d'afficher les informations dont on a besoin
 */
$readUsers = $users->readUsers();
$readSubCategories = $subCategories->readSubCategories();
/*
 * Si l'id récupéré dans l'url existe,
 * on assigne l'id dans notre attribut qui servira pour nos requêtes
 */
if (!empty($_GET['id'])) {
    $subCategories->id_category = $_GET['id'];
}
/*
 * On prépare nos regex pour le nom et la description de la sous-catégorie
 * puis on assigne un tableau vide afin de personnalisé nos messages
 */
$regexName = '#^[\w\W]{1,60}$#';
$regexDescription = '#^[\w\W]{10,255}$#';
$formError = array();
$formSuccess = array();
/* Créer une sous-catégorie
 * On assigne l'id de la catégorie, l'id de l'utilisateur, le nom et la description
 * puis on vérifie si nos champs sont remplis afin de vérifié si nos regex sont bien respecté
 */
if (isset($_POST['submitCreate']) && !empty($users->id)) {
    $subCategories->id_category = $_GET['id'];
    $subCategories->id_user = $_SESSION['id'];
    $subCategories->name = htmlspecialchars($_POST['name']);
    $subCategories->description = htmlspecialchars($_POST['description']);
    if (!empty($subCategories->name) && !empty($subCategories->description)) {
        if (!preg_match($regexName, $subCategories->name)) {
            $formError['badRegexName'] = 'Titre : minimum 1 caractères, maximum 60 caractères';
        }
        if (!preg_match($regexDescription, $subCategories->description)) {
            $formError['badRegexDescription'] = 'Description : minimum 10 caractères, maximum 255 caractères';
        }
        /*
         * Si le formulaire ne comporte pas d'erreur
         * on apelle notre méthode afin de créer une sous-catégorie
         */
        if (count($formError) == 0) {
            if ($subCategories->createSubCategories()) {
                $formSuccess['createSubCategory'] = 'Vous avez créé la sous-catégorie avec succès';
            }
        }
    }
}
/* * * * Modifier une catégorie * * * *
 * On assigne l'id de la sous-catégorie, le nom et la description
 * puis on vérifie si nos champs sont remplis afin de vérifié si nos regex sont bien respecté
 */
if (isset($_POST['submitUpdate'])) {
    $subCategories->id_subCategory = $_POST['idSubCategory'];
    $subCategories->name = htmlspecialchars($_POST['name']);
    $subCategories->description = htmlspecialchars($_POST['description']);
    if (!empty($subCategories->name) && !empty($subCategories->description)) {
        if (!preg_match($regexName, $subCategories->name)) {
            $formError['badRegexUpdateName'] = 'Titre : minimum 1 caractères, maximum 60 caractères';
        }
        if (!preg_match($regexDescription, $subCategories->description)) {
            $formError['badRegexUpdateDescription'] = 'Description : minimum 10 caractères, maximum 255 caractères';
        }
    } else {
        $formError['emptyFormUpdate'] = 'Veuillez remplir les deux champs afin de modifier une sous-catégorie';
    }
    /*
     * Si le formulaire ne contient aucune erreur
     * on appelle notre méthode afin de modifier une sous-catégorie
     * puis on affiche
     */
    if (count($formError) == 0) {
        if ($subCategories->updateSubCategories()) {
            $readSubCategories = $subCategories->readSubCategories();
            $formSuccess['updateSubCategory'] = 'La sous-catégorie du forum à était modifié avec succès';
        }
    }
}
/*
 * Si le formulaire est soumis
 * on assigne l'id de la sous-catégorie 
 * puis on appelle notre méthode afin de supprimer la sous-catégorie et tout ce qui est lié
 */
if (isset($_POST['deleteSubCategory'])) {
    $subCategories->id_subCategory = $_POST['idSubCategory'];
    if ($subCategories->deleteSubCategories()) {
        $formSuccess['deleteSubCategory'] = 'La sous-catégorie du forum à était supprimé avec succès';
    }
    $readSubCategories = $subCategories->readSubCategories();
}
$readSubCategories = $subCategories->readSubCategories();
