<?php

/*
 * 
 */
$users = new users();
$subCategories = new forumSubCategories();

if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}
$readUsers = $users->readUsers();
$readSubCategories = $subCategories->readSubCategories();
/*
 * 
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
 * 
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
        if (count($formError) == 0) {
            if ($subCategories->createSubCategories()) {
                $formSuccess['createSubCategory'] = 'Vous avez créé la sous-catégorie avec succès';
            }
        }
    }
}

/* * * * Modifier une catégorie * * * *
 * 
 *  
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
        $formError['emptyFormUpdate'] = 'Veuillez remplir les  deux champs afin d\'ajouter une catégorie';
    }
    if (count($formError) == 0) {
        if ($subCategories->updateSubCategories()) {
            $readSubCategories = $subCategories->readSubCategories();
            $formSuccess['updateSubCategory'] = 'La sous-catégorie du forum à était modifié avec succès';
        }
    }
}

if (isset($_POST['deleteSubCategory'])) {
    $subCategories->id_subCategory = $_POST['idSubCategory'];
    if ($subCategories->deleteSubCategories()) {
        $formSuccess['deleteSubCategory'] = 'La sous-catégorie du forum à était supprimé avec succès';
    }
    $readSubCategories = $subCategories->readSubCategories();
}
$readSubCategories = $subCategories->readSubCategories();
