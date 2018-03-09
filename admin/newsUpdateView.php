<?php
// Démarre la session
session_start();
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsUpdateController.php';
// Attribut une classe à la balise body
$classBody = NULL;
// Attribut un titre à la balise title
$title = 'Modification de l\'article';
include '../include/header.php';
?>

<?php
include '../include/footer.php';
