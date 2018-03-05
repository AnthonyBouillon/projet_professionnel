<?php

$forumCategories = new forumCategories();
$getCategories = $forumCategories->getCategories();

if (isset($_POST['submit'])) {
    $forumCategories->InsertCategories();
}
if (isset($_POST['deleteCategory'])) {
    $forumCategories->id = $_POST['idCategory'];
    $forumCategories->deleteCategories();
}else{
    var_dump('PAS de DELETE');
}
if (isset($_POST['submitUpdate'])) {
    $forumCategories->id = $_POST['idCategory'];
    $forumCategories->name = $_POST['name'];
    $forumCategories->description = $_POST['description'];
    $forumCategories->updateCategories();
}else{
    var_dump('PAS de UPDATE');
}