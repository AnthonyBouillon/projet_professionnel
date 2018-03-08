<?php

$users = new users();
$subCategories = new forumSubCategories();
$subCategories->id_categories = $_GET['id'];
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
if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['description'])) {
        $subCategories->id_categories = $_GET['id'];
        $subCategories->id_user = $_SESSION['id'];
        $subCategories->name = $_POST['name'];
        $subCategories->description = $_POST['description'];



        $subCategories->createSubCategories();
        $getSubCategories = $subCategories->readSubCategories();
    }
}

/* * * * Modifier une catégorie * * * *
 * 
 *  
 */
if (isset($_POST['submitUpdate'])) {
    $subCategories->id_subCategories = $_POST['idSubCategory'];
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
        $formSuccess['updateCategory'] = 'La catégorie du forum à était modifié';
    }
}

if (isset($_POST['deleteSubCategory'])) {
    $subCategories->id_subCategories = $_POST['idSubCategory'];
    $subCategories->deleteSubCategories();
    $getSubCategories = $subCategories->readSubCategories();
}
$getSubCategories = $subCategories->readSubCategories();
