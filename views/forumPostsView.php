<?php

session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/navBarController.php';
$classBody = NULL;
$title = 'Forum sous-catégories';
include_once 'header.php';
?>
<?php
include_once 'footer.php';