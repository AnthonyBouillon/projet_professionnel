<?php
session_start();
if (!empty($_SESSION['id'])) {
    include_once '../models/database.php';
    include_once '../models/users.php';
    include_once '../controllers/profileUpdateController.php';
    $classBody = 'profileUpdateBody';
    $title = 'Modifier mon profil';
    include '../include/header.php';
    ?>

    <div class="container containerProfileUpdate">
        <div class="blocAddImg">
            <h2 class="text-center">La modification de votre profil ce passe ici</h2>
            <!-- Affichage de l'avatar -->
            <img src="../members/avatars/<?= $checkElement->username . '/' . $checkElement->avatar; ?>" class="avatar img-responsive img-rounded center-block" />
            <!-- Affichage des messages d'erreurs  et des succès-->
            <p class="text-center red bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
            <p class="text-center red bold h4"><?= !empty($formError['badFormat']) ? $formError['badFormat'] : ''; ?></p>
            <p class="text-center red bold h4"><?= !empty($formError['errorImport']) ? $formError['errorImport'] : ''; ?></p>
            <p class="text-center red bold h4"><?= !empty($formError['emptyAvatar']) ? $formError['emptyAvatar'] : ''; ?></p>
            <p class="text-center green bold h4"><?= !empty($formSuccess['avatarUpdate']) ? $formSuccess['avatarUpdate'] : ''; ?></p>
            <!-- Affichage du pseudo de l'utilisateur -->
            <h2 class="text-center bold userTitle"><?= wordwrap($checkElement->username, 15, ' ', 1); ?></h2>
            <!-- Formulaire de modification d'avatar -->
            <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-lg-offset-5 col-lg-7">
                        <label class="btn formBtn" for="avatar">Modifier une image</label>
                        <input id="avatar" type="file" name="avatar" onchange="$('#upload-file-info').html(this.files[0].name)">
                        <span class='label label-info' id="upload-file-info"></span><br/>
                        <button type="submit" name="submitAvatar" class="btn btn-primary">Valider mon image</button>
                    </div>
                </div>
            </form>
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
                            <label for="newMail" class="col-sm-4 control-label">Nouveau adresse e-mail : </label>
                            <div class="col-sm-8">
                                <input type="email" name="mail" class="form-control focusColor" placeholder="Saisissez votre nouveau e-mail" id="newMail" value="<?= $users->mail; ?>" required />
                            </div>
                        </div>
                        <div class="form-group barra">
                            <label for="mailConfirm" class="col-sm-4 control-label">Confirmer l'adresse e-mail : </label>
                            <div class="col-sm-8">
                                <input type="email" name="confirmMail" class="form-control focusColor" placeholder="Confirmer votre e-mail" id="mailConfirm" value="<?= !empty($_POST['confirmMail']) ?$_POST['confirmMail']  : ''; ?>" required />
                            </div>
                        </div>
                        <div class="form-group barra">
                            <div class="col-md-12">
                                <button type="submit" name="submitMail" class="btn btn-block center-block formBtn">Je modifie mon adresse e-mail</button>
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
                                <button type="submit" name="submitPassword" class="btn btn-block center-block formBtn">Je modifie mon mot de passe</button>
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
