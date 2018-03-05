<?php
session_start();
include '../models/database.php';
include '../models/users.php';
include '../controllers/profileController.php';
$classBody = 'backgroundProfile';
$title = 'Mon profil';
include '../include/header.php';
?>
<div class="container profileView">
    <div class="row">
                <div class="well well-lg">
                    <div class="row">
                        <!-- Block avatar -->
                        <div class="col-lg-4">
                            <img src="../members/avatars/<?= $checkElement->username . '/' . $checkElement->avatar; ?>" class="img-rounded avatarSizeProfile" />
                            <p class="text-center"><a href="profileUpdateView.php" title="Redirige à lvotre page de modification de profil">Modifier mon image</a></p>
                        </div>
                        <div class="col-lg-8">
                            <h2 class="text-center">Bienvenue sur votre profil</h2>
                            <p class="h4">Toutes vos informations concernant vos données ce trouvent sur cette page.</p>
                            <p><span class="bold h4">Pseudo : </span><?= wordwrap($checkElement->username, 21, ' ', 1); ?></p>
                            <p><span class="bold h4">E-mail : </span><?= $checkElement->mail; ?> | <a href="profileUpdateView.php">Modifier mon adresse e-mail</a></p>
                            <p><span class="bold h4">Mot de passe : </span>****** :  | <a href="profileUpdateView.php">Modifier mon mot de passe</a></p>
                            <p><span class="bold h4">Date d'inscription : </span><?= $checkElement->date; ?></p>
                        </div>
                    </div>
                </div>
    </div>
</div>
<?php
include '../include/footer.php';
