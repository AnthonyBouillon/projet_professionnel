<?php
/*
 * 
 */
$users = new users();
$forumCategories = new forumCategories();
/*
 * 
 */
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
    $forumCategories->id_user = $_SESSION['id'];
    $users->username = $_SESSION['username'];
 
}
/*
 * 
 */
$readUsers = $users->readUsers();
$getCategories = $forumCategories->readCategories();

/*
 * 
 */
$regexName = '#^[\w\W]{1,60}$#';
$regexDescription = '#^[\w\W]{10,255}$#';
$formError = array();
$formSuccess = array();
/* * * * Créer une catégorie * * * *
 * 
 *  
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
        $formError['emptyForm'] = 'Veuillez remplir les  deux champs afin d\'ajouter une catégorie';
    }
    if (count($formError) == 0) {
        $forumCategories->createCategories();
        $getCategories = $forumCategories->readCategories();
        $formSuccess['createCategory'] = 'La catégorie à était ajouté au forum';
    }
}
/* * * * Modifier une catégorie * * * *
 * 
 *  
 */
if (isset($_POST['submitUpdate'])) {
    $forumCategories->id_categories = $_POST['idCategory'];
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
        $forumCategories->updateCategories();
        $getCategories = $forumCategories->readCategories();
        $formSuccess['updateCategory'] = 'La catégorie du forum à était modifié';
    }
}
/* * * * Supprimer une catégorie * * * *
 * 
 *  
 */
if (isset($_POST['submitDelete'])) {
    $forumCategories->id_category = $_POST['idCategory'];
    $forumCategories->id_category;
    $forumCategories->deleteCategories();
    $getCategories = $forumCategories->readCategories();
    $formSuccess['deleteCategory'] = 'La catégorie à bien était supprimé';
}


