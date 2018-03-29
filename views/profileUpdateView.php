<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/profileUpdateController.php';
$classBody = 'profileUpdateBody';
$title = 'Modifier mon profil';
include '../include/header.php';
?>
<div class="container containerProfileUpdate">
    <div class="blocAddImg">
        <h2 class="text-center">Bienvenue sur la page de modification de votre profil <strong><?= $readUsers->username; ?></strong></h2>
        <img src="../members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="avatar img-responsive img-rounded center-block" alt="Image de profil"/><br/>
        <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-6">
                    <label class="btn formBtn btnWidth" for="avatar">Choisissez une image</label>
                    <input  type="file" name="avatar" id="avatar">
                    <button type="submit" name="submitAvatar" class="btn btn-primary btnWidth">Valider mon image</button>
                </div>
            </div>
        </form>
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert alert-success">
                <p class="text-center bold h4"><?= $formSuccess['avatarUpdate']; ?></p>
            </div>
            <?php }
        if (!empty($formError)) {  ?>
            <div class="alert alert-danger">
                <p class="text-center red bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                <p class="text-center red bold h4"><?= !empty($formError['badFormat']) ? $formError['badFormat'] : ''; ?></p>
                <p class="text-center red bold h4"><?= !empty($formError['errorImport']) ? $formError['errorImport'] : ''; ?></p>
                <p class="text-center red bold h4"><?= !empty($formError['emptyAvatar']) ? $formError['emptyAvatar'] : ''; ?></p>
            </div>
        <?php } ?>
    </div>
    <div class="btn-pref btn-group btn-group-justified">
        <div class="btn-group">
            <button type="button" id="btnModif" class="btn btn-info" href="#mail" data-toggle="tab"><i class="fas fa-envelope"></i> Modifier votre adresse e-mail</span></button>
        </div>
        <div class="btn-group">
            <button type="button" id="btnModif" class="btn btn-default" href="#password" data-toggle="tab"><i class="fas fa-key"></i> Modifier votre mot de passe</span></button>
        </div>
    </div>
    <div class="well">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="mail">
                <?php if (!empty($formError)) { ?>
                    <div class="alert alert-danger">
                        <p class="text-center red bold h4"><?= !empty($formError['mailExist']) ? $formError['mailExist'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['badMail']) ? $formError['badMail'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['mailSimilar']) ? $formError['mailSimilar'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['mailNotExist']) ? $formError['mailNotExist'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['unavailableMail']) ? $formError['unavailableMail'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['badNewMail']) ? $formError['badNewMail'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['mailDiff']) ? $formError['mailDiff'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['updateError']) ? $formError['updateError'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['wrongFormat']) ? $formError['wrongFormat'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['sendMailError']) ? $formError['sendMailError'] : ''; ?></p>
                    </div>
                    <?php  }
                if (!empty($formSuccess)) {  ?>
                    <div class="alert alert-success">
                        <p class="text-center green bold h4"><?= !empty($formSuccess['updateMail']) ? $formSuccess['updateMail'] : ''; ?></p>
                        <p class="text-center green bold h4"><?= !empty($formSuccess['sendMail']) ? $formSuccess['sendMail'] : ''; ?></p>
                    </div>
                <?php } ?>
                <form method="POST" action="" class="form-horizontal"> 
                    <div class="form-group barra">
                        <label for="newMail" class="col-sm-4 control-label">Nouvelle adresse e-mail : </label>
                        <div class="col-sm-8">
                            <input type="email" name="mail" class="form-control focusColor" placeholder="Saisissez votre nouveau e-mail" id="newMail" value="<?= $users->mail; ?>" required />
                        </div>
                    </div>
                    <div class="form-group barra">
                        <label for="mailConfirm" class="col-sm-4 control-label">Confirmer l'adresse e-mail : </label>
                        <div class="col-sm-8">
                            <input type="email" name="confirmMail" class="form-control focusColor" placeholder="Confirmer votre e-mail" id="mailConfirm" value="<?= !empty($_POST['confirmMail']) ? $_POST['confirmMail'] : ''; ?>" required />
                        </div>
                    </div>
                    <div class="form-group barra">
                        <div class="col-md-12">
                            <button type="submit" name="submitMail" class="btn btn-block center-block formBtn">Valide</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade in" id="password">
                <?php if (!empty($formError)) { ?>
                    <div class="alert alert-danger">
                        <p class="text-center red bold h4"><?= !empty($formError['passwordDiff']) ? $formError['passwordDiff'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['wrongFormatPassword']) ? $formError['wrongFormatPassword'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['sendPasswordError']) ? $formError['sendPasswordError'] : ''; ?></p>
                        <p class="text-center red bold h4"><?= !empty($formError['badPassword']) ? $formError['badPassword'] : ''; ?></p>
                    </div>
                    <?php }
                if (!empty($formSuccess)) { ?>
                    <div class="alert alert-success">
                        <p class="text-center green bold h4"><?= !empty($formSuccess['updatePassword']) ? $formSuccess['updatePassword'] : ''; ?></p>
                        <p class="text-center green bold h4"><?= !empty($formSuccess['sendPassword']) ? $formSuccess['sendPassword'] : ''; ?></p>
                    </div>
                <?php } ?>
                <form method="POST" action="" class="form-horizontal">
                    <!-- Mot de passe actuel -->
                    <div class="form-group">
                        <label for="pass" class="col-sm-4 control-label">Mot de passe actuel : </label>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="focusColor  form-control showPassword" placeholder="Saisissez votre mot de passe actuel" id="pass" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Nouveau mot de passe -->
                        <label for="newPassword" class="col-sm-4 control-label">Nouveau mot de passe : </label>
                        <div class="col-sm-8">
                            <input type="password" name="newPassword" class="focusColor form-control showPassword" placeholder="Saisissez votre nouveau mot de passe" id="newPassword" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Nouveau mot de passe -->
                        <label for="confirmPassword" class="col-sm-4 control-label">Confirmer mot de passe : </label>
                        <div class="col-sm-8">
                            <input type="password" name="confirmPassword" class="focusColor form-control showPassword" placeholder="Confirmer votre mot de passe" id="confirmPassword" required />                            </div>
                    </div>
                    <div class="form-group">
                        <!-- Voir les mots de passe -->
                        <label for="checkbox" class="col-sm-4 control-label">Afficher les mots de passe</label>
                        <div class="col-sm-8">
                            <input type="checkbox" class="form-control" id="checkbox" />
                        </div>
                    </div>
                    <!-- Valider l'inscription -->
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" name="submitPassword" class="btn btn-block center-block formBtn">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include '../include/footer.php';
