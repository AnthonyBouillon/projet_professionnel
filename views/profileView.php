<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/profileController.php';
$classBody = 'backgroundProfile';
$title = 'Mon profil';
include_once 'header.php';
?>
<div class="container profileView">
    <div class="row">
                <div class="well well-lg">
                    <div class="row">
                        <!-- Block avatar -->
                        <div class="col-lg-4">
                            <img src="../members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="img-rounded avatarSizeProfile" />
                            <p class="text-center"><a href="Modification-de-mon-profil" title="Redirige à lvotre page de modification de profil">Modifier mon image</a></p>
                        </div>
                        <div class="col-lg-8">
                            <h2 class="text-center">Bienvenue sur votre profil</h2>
                            <p class="h4">Toutes vos informations concernant vos données ce trouvent sur cette page.</p>
                            <p><span class="bold h4">Pseudo : </span><?= wordwrap($readUsers->username, 21, ' ', 1); ?></p>
                            <p><span class="bold h4">E-mail : </span><?= $readUsers->mail; ?> | <a href="Modification-de-mon-profil">Modifier mon adresse e-mail</a></p>
                            <p><span class="bold h4">Mot de passe : </span>****** :  | <a href="Modification-de-mon-profil">Modifier mon mot de passe</a></p>
                            <p><span class="bold h4">Date d'inscription : </span><?= $readUsers->date; ?></p>
                        </div>
                    </div>
                </div>
    </div>
</div>
<?php
include_once 'footer.php';
