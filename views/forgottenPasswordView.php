<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/forgottenPasswordController.php';
$classBody = NULL;
$title = 'Mot de passe oublié ?';
include_once 'header.php';
?>
<div class="container-fluid containerForgetPassword">
    <p class="col-lg-offset-3 col-lg-6 jumbotron h4">Entrez votre adresse e-mail qui vous a servis à vous inscrire sur le site, afin de recevoir un e-mail qui vous redirigera vers un formulaire qui vous permettra de récupérer votre compte en choisissant un nouveau mot de passe.</p>
    <div class="col-lg-offset-3 col-lg-6 formBackground">
        <div class="row">
            <h2 class="formTitle bold col-sm-12">Formulaire des mots de passe oubliés</h2>
        </div>
        <div class="col-md-12">
            <!-- Affichage des messages d'erreurs -->
            <?php if (!empty($formError)) { ?>
                <div class="alert-danger">
                    <p class="text-center bold h4"><?= !empty($formError['notExistMail']) ? $formError['notExistMail'] : ''; ?></p>
                    <p class="text-center bold h4"><?= !empty($formError['errorMail']) ? $formError['errorMail'] : ''; ?></p>
                    <p class="text-center bold h4"><?= !empty($formError['failMail']) ? $formError['failMail'] : ''; ?></p>
                </div>
            <?php } ?>
            <?php if (!empty($formSuccess)) { ?>
            <!-- Affichage des messages de succès -->
                <div class="alert-success">
                    <p class="text-center  bold h4"><?= $formSuccess['sendMail'] ?></p>
                </div>
            <?php } ?>
            <form method="POST" action="" class="form-horizontal">
                <!-- Adresse e-mail -->
                <div class="form-group fieldBackground">
                    <label for="mail" class="col-sm-4 control-label">Adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="email" name="mail" class="form-control focusColor" id="mail" placeholder="Saisissez votre adresse e-mail" value="<?= $users->mail ?>" required />
                    </div>
                </div>
                <!-- Valider l'envoie d'e-mail au destinataire -->
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
include_once 'footer.php';
