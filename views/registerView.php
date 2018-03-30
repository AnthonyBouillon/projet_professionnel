<?php
// Démarre la session
session_start();
include_once '../configuration.php';
include_once '../assets/reCaptcha/autoload.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/registerController.php';
// Attribut une classe à la balise body
$classBody = 'registerBackground';
// Attribut un titre à la balise title
$title = 'Inscription';
include 'header.php';
?>
<div class="container-fluid">
    <div class="col-lg-offset-3 col-lg-6 formRegisterBackground"> 
        <div class="row">
            <h2 class="formTitle col-xs-12 col-sm-12 col-md-12 col-lg-12 bold">Formulaire d'inscription</h2>
        </div>
        <!-- Affichage des messages d'erreurs -->
        <?php if (!empty($formError)) { ?>
            <div class="alert alert-danger">
                <p class="text-center bold h4"><?= !empty($formError['unavailableUsername']) ? $formError['unavailableUsername'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['unavailableMail']) ? $formError['unavailableMail'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['usernameTooBig']) ? $formError['usernameTooBig'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['mailWrongFormat']) ? $formError['mailWrongFormat'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['password']) ? $formError['password'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['wrongPassword']) ? $formError['wrongPassword'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['mailDiff']) ? $formError['mailDiff'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['passwordDiff']) ? $formError['passwordDiff'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['mail']) ? $formError['mail'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['formRegisterEmpty']) ? $formError['formRegisterEmpty'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['captcha']) ? $formError['captcha'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['formFail']) ? $formError['formFail'] : ''; ?></p>
            </div>
        <?php } 
        if (!empty($formSuccess)) { ?>
            <div class="alert alert-success">
                <p class="text-center bold h4"><?= !empty($formSuccess['captcha']) ? $formSuccess['captcha'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formSuccess['registerSuccess']) ? $formSuccess['registerSuccess'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formSuccess['sendMail']) ? $formSuccess['sendMail'] : ''; ?></p>
            </div>
        <?php } ?>
        <section class="col-xs-12 col-sm-12 col-md-12 col-lg-12 formRegisterBackground">
            <form method="POST" action="" class="form-horizontal ">
                <!-- Pseudo -->
                <div class="form-group fieldBackground">
                    <label for="username" class="col-sm-4 control-label">Pseudo</label>
                    <div class="col-sm-8">
                        <input type="text" name="username" class="form-control focusColor" id="username" placeholder="Saisissez votre pseudo" value="<?= $users->username ?>" required />
                    </div>
                </div>
                <!-- E-mail -->
                <div class="form-group fieldBackground">
                    <label for="mail" class="col-sm-4 control-label">Adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="email" name="mail" class="form-control focusColor" id="mail" placeholder="Saisissez votre adresse e-mail" value="<?= $users->mail ?>" required />
                    </div>
                </div>
                <!-- Confirmation de l'e-mail -->
                <div class="form-group fieldBackground">
                    <label for="confirmMail" class="col-sm-4 control-label inputForm">Confirmer l'adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="email" name="confirmMail" class="form-control focusColor" id="confirmMail" placeholder="Saisissez à nouveau votre adresse e-mail" value="<?= !empty($_POST['confirmMail']) ? $_POST['confirmMail'] : '' ?>" required />
                    </div>
                </div>
                <!-- Mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="password" class="col-sm-4 control-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control focusColor showPassword" id="password" placeholder="Saisissez votre mot de passe" required />
                    </div>
                </div>
                <!-- Confirmation du mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="confirmPassword" class="col-sm-4 control-label">Confirmer mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" name="confirmPassword" class="form-control focusColor showPassword" id="confirmPassword" placeholder="Saisissez à nouveau votre mot de passe" required />
                    </div>
                </div>
                <!-- Affichage des mots de passe -->
                <div class="form-group fieldBackground">
                    <label for="checkbox" class="col-xs-10 col-sm-4 control-label">Afficher les mots de passe</label>
                    <div class="col-xs-2 col-sm-1">
                        <input type="checkbox" class="form-control" id="checkbox" />
                    </div>
                </div>
                <!-- Captcha -->
                <div class="form-group fieldBackground">
                    <p class="text-center bold h4">Cocher le catpcha est obligatoire</p>
                    <div class="g-recaptcha  col-lg-offset-4 col-lg-6" data-sitekey="6LeHrEcUAAAAAL8BwgGykCkFGc8-kCB7Lve4d-nv">

                    </div>
                </div>
                <!-- Valider l'inscription -->
                <div class="form-group fieldBackground">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Je valide mon inscription</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
include 'footer.php';

