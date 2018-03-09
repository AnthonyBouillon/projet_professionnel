<?php
// Démarre la session
session_start();
include '../models/database.php';
include '../models/users.php';
include '../controllers/validationController.php';
// Attribut une classe à la balise body
$classBody = NULL;
// Attribut un titre à la balise title
$title = 'Activation du compte';
include '../include/header.php';
if (empty($error['confirmed'])) {
    header('refresh:5;url=loginView.php');
}
?>
<div class="container containerValidateCount">
    <div class="row">
        <h2 class="text-center alert-info col-xs-12 col-sm-12 col-md-12 col-lg-12"><?= !empty($error['confirmed']) ? $error['confirmed'] : 'Compte activé'; ?></h2>
    </div>
    <?php if (!isset($error['confirmed'])) { ?>
        <div class="row well well-info h4">
            <p class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Félicitation votre compte est activé et vous pouvez dès à présent vous connecter. <br/>
                Vous allez être redigiré vers la page de connexion dans <span id="chrono" class="green">5</span><span class="green"> secondes</span> .<br/>Si la redirection ne fonctionne pas, cliqué sur ce lien : <a href="loginView.php">connexion</a></p>
        </div>
    <?php } else { ?>
        <div class="row well well-info h4">
            <p class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">Vous allez être redigiré vers la page de connexion dans <span id="chrono" class="green">5</span><span class="green"> secondes</span> .<br/>Si la redirection ne fonctionne pas, cliqué sur ce lien : <a href="loginView.php">connexion</a></p>
        </div>
    <?php } ?>
</div>
<?php
include '../include/footer.php';
