<?php
$subCategories = new forumSubCategories();
$getsubCategories = $subCategories->getSubCategories();

// Insertion
if(isset($_POST['submit'])){
    if(!empty($_POST['name']) && !empty($_POST['description'])){
        $subCategories->InsertSubCategories();
    }
}