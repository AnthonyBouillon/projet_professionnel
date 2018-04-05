<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/navBarController.php';
$classBody = 'whoAreYouBackground';
$title = 'Qui sommes-nous ?';
include_once 'header.php';
?>
<div class="container">
    <div class="row">
        <h2 class="text-center titleStyle">Nous sommes ce que nous sommes, mais qui sommes-nous ?</h2>
    </div>
    <div class="row well well-info">
        <img src="../assets/images/whoAreYou.gif" alt="Image" class="img-responsive img-circle centerImg" />
        <div class="h4">
            <div class=" col-lg-offset-2 col-lg-8">
                <h3 class="text-center margin bold">Des joueurs  de jeux vidéo !</h3>
                <p>Non ergo erunt homines deliciis diffluentes audiendi, si quando de amicitia, quam nec usu nec ratione habent cognitam, disputabunt. Nam quis est, pro deorum fidem atque hominum! qui velit, ut neque diligat quemquam nec ipse ab ullo diligatur, circumfluere omnibus copiis atque in omnium rerum abundantia vivere? Haec enim est tyrannorum vita nimirum, in qua nulla fides, nulla caritas, nulla stabilis benevolentiae potest esse fiducia, omnia semper suspecta atque sollicita, nullus locus amicitiae.</p>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
