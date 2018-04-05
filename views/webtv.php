<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/navBarController.php';
$title = 'Web TV';
$classBody = NULL;
include 'header.php';
?>
<div class="container">
    <div class="row">
        <h2 class="text-center">En cours de construction</h2>
    </div>
    <div class="row center-block">
        <img src="https://2.bp.blogspot.com/-S-RnhRYTQrk/Vq3jyHesheI/AAAAAAAAAac/CoOz0Gqx2S0/s1600/loading1.gif" class="img-responsive center-block avatar" />
    </div>
</div>
<?php
include 'footer.php';