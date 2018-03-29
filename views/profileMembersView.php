<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../models/admin.php';
include '../controllers/profileMembersController.php';
$classBody = NULL;
$title = 'Profil d\'un membre';
include '../include/header.php';
?>
<div class="container profileView">
    <div class="row">
                <div class="well well-lg">
                    <div class="row">
                        <!-- Block avatar -->
                        <?php foreach($readProfile as $test){ ?>
                        <div class="col-lg-4">
                            <img src="../members/avatars/<?= $test->username . '/' . $test->avatar; ?>" class="img-rounded avatarSizeProfile" />
                        </div>
                        <div class="col-lg-8">
                            <h2 class="text-center">Vous êtes sur le profil de  <?= $test->username ?></h2>
                            <p><span class="bold h4">Pseudo : </span><?= wordwrap($test->username, 21, ' ', 1); ?></p>
                            <p><span class="bold h4">E-mail : </span><?= $test->mail; ?></p>
                            <p><span class="bold h4">Date d'inscription : </span><?= $test->date; ?></p>
                        </div>
                        <?php  }  ?>
                    </div>
                </div>
    </div>
</div>
<?php
include '../include/footer.php';