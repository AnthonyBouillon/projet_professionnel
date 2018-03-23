<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsAllController.php';
$title = 'Web TV';
$classBody = NULL;
include '../include/header.php';
?>

<?php
include '../include/footer.php';