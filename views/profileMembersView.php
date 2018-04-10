<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/profileMembersController.php';
$classBody = NULL;
$title = 'Profil d\'un membre';
include_once 'header.php';
?>
<div class="container profileView">
    <div class="well well-lg">
        <div class="row">
            <!-- Si le profil de l'utilisateur existe, on affiche cette vue, sinon on affiche une autre vue -->
            <?php if ($readProfile != null) { ?>
                <div class="col-lg-4">
                    <!-- Affichage de l'image du profil  de l'utilisateur -->
                    <img src="../members/avatars/<?= $readProfile->username . '/' . $readProfile->avatar; ?>" class="img-rounded avatarSizeProfile" />
                </div>
                <div class="col-lg-8">
                    <!-- Affichage du pseudo -->
                    <h2 class="text-center">Vous êtes sur le profil de  <?= $readProfile->username ?></h2>
                    <p><span class="bold h4">Pseudo : </span><?= wordwrap($readProfile->username, 21, ' ', 1); ?></p>
                    <!-- Affichage de l'e-mail -->
                    <p><span class="bold h4">E-mail : </span><?= $readProfile->mail; ?></p>
                    <!-- Affichage de la date d'inscription -->
                    <p><span class="bold h4">Date d'inscription : </span><?= $readProfile->date; ?></p>
                </div>
            <?php } else { ?>
                <div class="col-lg-12">
                    <h2 class="text-center">Le profil que vous essayez de voir n'existe pas</h2>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
