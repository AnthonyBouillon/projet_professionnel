<?php
/*
 * On démarre la session
 * On inclut le model et le controller correspondant
 * On assigne null à notre classe qui ce trouve dans le body
 * On assigne un titre dans une variale qui ce trouve dans la balise title du header
 * On inclut notre header
 */
session_start();
include '../models/database.php';
include '../models/users.php';
include '../controllers/recoveryPasswordController.php';
$classBody = NULL;
$title = 'Initialisation du mot de passe';
include '../include/header.php';
?>
<div class="container-fluid containerNew">
    <div class="col-lg-offset-3 col-lg-6 formBackground">
        <h2 class="formTitle bold col-sm-12">Formulaire de récupération du compte</h2>
        <!-- Affichent les messages d'erreurs du formulaire -->
        <p class="text-center white bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
        <p class="text-center yellow bold h4"><?= !empty($formError['notPassSimilar']) ? $formError['notPassSimilar'] : ''; ?></p>
        <p class="text-center yellow bold h4"><?= !empty($formError['badRegex']) ? $formError['badRegex'] : ''; ?></p>
        <p class="text-center green bold h4"><?= !empty($formSuccess['updatePass']) ? $formSuccess['updatePass'] : ''; ?></p>
        <section class="col-md-12">
            <form method="POST" action="" class="form-horizontal">
                <!-- Mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="password" class="col-sm-4 control-label">Nouveau mot de passe : </label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control focusColor showPassword" id="password" placeholder="Saisissez votre mot de passe" required />
                    </div>
                </div>
                <!-- Comfirmation mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="confirmPassword" class="col-sm-4 control-label">Confirmer mot de passe : </label>
                    <div class="col-sm-8">
                        <input type="password" name="confirmPassword" class="form-control focusColor showPassword" id="confirmPassword" placeholder="Saisissez à nouveau votre mot de passe" required />
                    </div>
                </div>
                <div class="form-group fieldBackground">
                    <!-- Voir les mots de passe -->
                    <label for="checkbox" class="col-xs-10 col-sm-4 control-label">Afficher les mots de passe : </label>
                    <div class="col-xs-2 col-sm-1">
                        <input type="checkbox" class="form-control" id="checkbox" />
                    </div>
                </div>
                <!-- Valider -->
                <div class="form-group fieldBackground">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Envoyez moi un e-mail</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
include '../include/footer.php';
