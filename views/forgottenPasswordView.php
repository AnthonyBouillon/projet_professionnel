<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../controllers/forgottenPasswordController.php';
$classBody = NULL;
$title = 'Mot de passe oublié ?';
include 'header.php';
?>

<div class="container-fluid containerForgetPassword">
    <div class="col-lg-offset-3 col-lg-6 formBackground">
        <div class="row">
            <h2 class="formTitle bold col-sm-12">Formulaire des mots de passe oubliés</h2>
        </div>
        <div class="col-md-12">
            <!-- Message d'erreurs -->
            <?php if (!empty($formError)) { ?>
                <div class="alert-danger">
                    <p class="text-center bold h4"><?= !empty($formError['notExistMail']) ? $formError['notExistMail'] : ''; ?></p>
                </div>
            <?php } ?>
            <?php if (!empty($formSuccess)) { ?>
                <div class="alert-success">
                    <p class="text-center  bold h4"><?= !empty($formSuccess['sendMail']) ? $formSuccess['sendMail'] : ''; ?></p>
                </div>
            <?php } ?>
            <form method="POST" action="" class="form-horizontal">
                <!-- Adresse e-mail -->
                <div class="form-group fieldBackground">
                    <label for="mail" class="col-sm-4 control-label">Adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="email" name="mail" class="form-control focusColor" id="mail" placeholder="Saisissez votre adresse e-mail" required />
                    </div>
                </div>
                <!-- Valider -->
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
