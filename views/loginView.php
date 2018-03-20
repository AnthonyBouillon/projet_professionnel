<?php
// Démarre la session
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../controllers/loginController.php';
// Attribut une classe à la balise body
$classBody = 'loginBackground';
// Attribut un titre à la balise title
$title = 'Connexion';
include '../include/header.php';
?>
<div class="container containerLogin">
    <div class="col-lg-12 formBackground">
        <h2 class="formTitle bold col-sm-12 col-lg-12">Formulaire de connexion</h2>
        <!-- Message d'erreurs -->
        <?php if (!empty($formError)) { ?>
            <div class="alert alert-danger">
                <p class="text-center red bold h4"><?= !empty($formError['loginBad']) ? $formError['loginBad'] : ''; ?></p>
                <p class="text-center red bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                <p class="text-center red bold h4"><?= !empty($formError['notActif']) ? $formError['notActif'] : ''; ?></p>
            </div>
        <?php } ?>
        <!-- Message de succès -->
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert alert-success">
                <p class="text-center bold h4"><?= !empty($formSuccess['loginSuccess']) ? $formSuccess['loginSuccess'] : ''; ?></p>
            </div>
        <?php } ?>
        <section class="col-sm-12 col-md-12">
            <form method="POST" action="" class="form-horizontal">
                <!-- Pseudo -->
                <div class="form-group fieldBackground">
                    <label for="username" class="col-sm-4 control-label">Pseudo</label>
                    <div class="col-sm-8">
                        <input type="text" name="username" class="form-control focusColor" id="username" placeholder="Saisissez votre pseudo" value="<?= $users->username ?>" required />
                    </div>
                </div>
                <!-- Mot de passe -->
                <div class="form-group fieldBackground">
                    <label for="password" class="col-sm-4 control-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" class="form-control focusColor showPassword" id="password" placeholder="Saisissez votre mot de passe" required />
                    </div> 
                    <!-- Voir le mot de passe -->
                    <label for="checkbox" class="col-xs-10 col-sm-4 control-label">Afficher le mot de passe</label>
                    <div class="col-xs-2 col-sm-1">
                        <input type="checkbox" class="form-control" id="checkbox" />
                    </div>
                    <div class="col-lg-12">
                        <a href="../Mot-de-passe-oublié-?" title="Lien dirigeant vers la récupération de compte">Mot de passe oublié ?</a>
                    </div>
                </div>
                <!-- Valider -->
                <div class="form-group fieldBackground">
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn" id="submit">Je me connecte</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
include '../include/footer.php';
