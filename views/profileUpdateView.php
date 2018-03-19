<?php
session_start();
if (!empty($_SESSION['id'])) {
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
            <h2 class="text-center">Bienvenue sur votre profil <strong><?= $readUsers->username; ?></strong></h2>
            <!-- Affichage de l'avatar -->
            <img src="../members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="avatar img-responsive img-rounded center-block" /><br/>
            <!-- Affichage des messages d'erreurs  et des succès-->


            <!-- Affichage du pseudo de l'utilisateur -->
            <!-- Formulaire de modification d'avatar -->
            <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <label class="btn formBtn btnWidth" for="avatar">Choisissez une image</label>
                        <input id="avatar" type="file" name="avatar" onchange="$('#upload-file-info').html(this.files[0].name)">
                        <span class='label label-info' id="upload-file-info"></span><br/>
                        <button type="submit" name="submitAvatar" class="btn btn-primary btnWidth">Valider mon image</button>
                    </div>
                </div>
            </form>
            <?php if (!empty($formSuccess)) { ?>
                <div class="alert alert-success">
                    <p class="text-center bold h4"><?= !empty($formSuccess['avatarUpdate']) ? $formSuccess['avatarUpdate'] : ''; ?></p>
                </div>
            <?php } ?>
            <?php if (!empty($formError)) { ?>
                <div class="alert alert-danger">
                    <p class="text-center red bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['badFormat']) ? $formError['badFormat'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['errorImport']) ? $formError['errorImport'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['emptyAvatar']) ? $formError['emptyAvatar'] : ''; ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- Bouton qui permet de switch entre le formulaire de modification d'adresse e-mail et de mot de passe -->
        <div class="btn-pref btn-group btn-group-justified">
            <div class="btn-group">
                <button type="button" id="btnModif" class="btn btn-info" href="#mail" data-toggle="tab"><i class="fas fa-envelope"></i> <span class="hidden-xs">Modifier votre adresse e-mail</span></button>
            </div>
            <div class="btn-group">
                <button type="button" id="btnModif" class="btn btn-default" href="#password" data-toggle="tab"><i class="fas fa-key"></i> <span class="hidden-xs">Modifier votre mot de passe</span></button>
            </div>
        </div>
        <div class="well">
            <!-- Classe qui permet de naviguer entre les deux éléments sans quitter la page -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="mail">
                    <!-- Affichage des messages d'erreurs et des succès -->

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
                    <p class="text-center green bold h4"><?= !empty($formSuccess['updateMail']) ? $formSuccess['updateMail'] : ''; ?></p>
                    <p class="text-center green bold h4"><?= !empty($formSuccess['sendMail']) ? $formSuccess['sendMail'] : ''; ?></p>
                    <!-- Formulaire de modification d'adresse e-mail -->
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
                    <!-- Affichage des messages d'erreurs et des succès -->
                    <p class="text-center red bold h4"><?= !empty($formError['passwordDiff']) ? $formError['passwordDiff'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['wrongFormatPassword']) ? $formError['wrongFormatPassword'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['sendPasswordError']) ? $formError['sendPasswordError'] : ''; ?></p>
                    <p class="text-center red bold h4"><?= !empty($formError['badPassword']) ? $formError['badPassword'] : ''; ?></p>
                    <p class="text-center green bold h4"><?= !empty($formSuccess['updatePassword']) ? $formSuccess['updatePassword'] : ''; ?></p>
                    <p class="text-center green bold h4"><?= !empty($formSuccess['sendPassword']) ? $formSuccess['sendPassword'] : ''; ?></p>
                    <form method="POST" action="" class="form-horizontal">
                        <!-- Ancien mot de passe -->
                        <div class="form-group barra">
                            <label for="pass" class="col-sm-4 control-label">Mot de passe actuel : </label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="focusColor  form-control showPassword" placeholder="Saisissez votre mot de passe actuel" id="pass" required />
                            </div>
                        </div>
                        <div class="form-group barra">
                            <!-- Nouveau mot de passe -->
                            <label for="newPassword" class="col-sm-4 control-label">Nouveau mot de passe : </label>
                            <div class="col-sm-8">
                                <input type="password" name="newPassword" class="focusColor form-control showPassword" placeholder="Saisissez votre nouveau mot de passe" id="newPassword" required />
                            </div>
                        </div>
                        <div class="form-group barra">
                            <!-- Nouveau mot de passe -->
                            <label for="confirmPassword" class="col-sm-4 control-label">Confirmer mot de passe : </label>
                            <div class="col-sm-8">
                                <input type="password" name="confirmPassword" class="focusColor form-control showPassword" placeholder="Confirmer votre mot de passe" id="confirmPassword" required />                            </div>
                        </div>

                        <div class="form-group barra">
                            <!-- Voir les mots de passe -->
                            <label for="checkbox" class="col-sm-4 control-label">Afficher les mots de passe</label>
                            <div class="col-sm-8">
                                <input type="checkbox" class="form-control" id="checkbox" />
                            </div>
                        </div>

                        <!-- Valider l'inscription -->
                        <div class="form-group barra">
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
} else {
    header('Location:404.php');
}

include '../include/footer.php';
