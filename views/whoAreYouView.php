<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
$classBody = NULL;
$title = 'Qui sommes-nous ?';
include_once 'header.php';
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
include_once 'footer.php';
