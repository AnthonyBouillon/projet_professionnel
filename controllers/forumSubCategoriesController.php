<?php

$users = new users();
$subCategories = new forumSubCategories();
if (isset($_GET['id'])) {
    $subCategories->id_category = $_GET['id'];
}
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
}

$readUsers = $users->readUsers();
$getSubCategories = $subCategories->readSubCategories();
$regexName = '#^[\w\W]{1,60}$#';
$regexDescription = '#^[\w\W]{10,255}$#';
$formError = array();


// Insertion
if (isset($_POST['submit']) && !empty($users->id)) {
    if (!empty($_POST['name']) && !empty($_POST['description'])) {
        $subCategories->id_category = $_GET['id'];
        $subCategories->id_user = $_SESSION['id'];
        $subCategories->name = $_POST['name'];
        $subCategories->description = $_POST['description'];
        if($subCategories->createSubCategories()){
            $formSuccess['createSubCategory'] = 'Vous avez créé la sous-catégorie avec succès';
        }
        $getSubCategories = $subCategories->readSubCategories();
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
        $subCategories->updateSubCategories();
        $getSubCategories = $subCategories->readSubCategories();
        $formSuccess['updateSubCategory'] = 'La sous-catégorie du forum à était modifié avec succès';
    }
}

if (isset($_POST['deleteSubCategory'])) {
    $subCategories->id_subCategory = $_POST['idSubCategory'];
    if($subCategories->deleteSubCategories()){
        $formSuccess['deleteSubCategory'] = 'La sous-catégorie du forum à était supprimé avec succès';
    }
    $getSubCategories = $subCategories->readSubCategories();
}
$getSubCategories = $subCategories->readSubCategories();
