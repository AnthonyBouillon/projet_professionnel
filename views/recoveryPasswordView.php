<?php
/*
 * On démarre la session
 * On inclut les models et le controller correspondant
 * On assigne null à notre classe qui ce trouve dans le body
 * On assigne un titre dans une variable qui ce trouve dans la balise title du header
 * On inclut notre header
 */
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../controllers/recoveryPasswordController.php';
$classBody = NULL;
$title = 'Initialisation du mot de passe';
include 'header.php';
?>
<div class="container-fluid containerRecovery">
    <div class="col-lg-offset-3 col-lg-6 formBackground">
        <h2 class="formTitle bold col-sm-12">Formulaire de récupération du compte</h2>
        <!-- Affichage des messages d'erreurs -->
        <?php if (!empty($formError)) { ?>
            <div class="alert-danger">
                <p class="text-center bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['notPassSimilar']) ? $formError['notPassSimilar'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['badRegex']) ? $formError['badRegex'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['failMail']) ? $formError['failMail'] : ''; ?></p>
            </div>
        <?php } ?>
        <!-- Affichage des messages de succès -->
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert-success">
                <p class="text-center bold h4"><?= !empty($formSuccess['updatePass']) ? $formSuccess['updatePass'] : ''; ?></p>
            </div>
        <?php } ?>
        <div class="col-md-12">
            <form method="POST" action="" class="form-horizontal">
                <!-- Nouveau mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="password" class="col-sm-4 control-label">Nouveau mot de passe : </label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control focusColor showPassword" id="password" placeholder="Saisissez votre nouveau  mot de passe" required />
                    </div>
                </div>
                <!-- Confirmation du mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="confirmPassword" class="col-sm-4 control-label">Confirmer mot de passe : </label>
                    <div class="col-sm-8">
                        <input type="password" name="confirmPassword" class="form-control focusColor showPassword" id="confirmPassword" placeholder="Saisissez à nouveau votre mot de passe" required />
                    </div>
                </div>
                <div class="form-group fieldBackground">
                    <!-- Afficher les mots de passe -->
                    <label for="checkbox" class="col-xs-10 col-sm-4 control-label">Afficher les mots de passe : </label>
                    <div class="col-xs-2 col-sm-1">
                        <input type="checkbox" class="form-control" id="checkbox" />
                    </div>
                </div>
                <!-- Valider le nouveau mot de passe du compte utilisateur -->
                <div class="form-group fieldBackground">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'footer.php';
