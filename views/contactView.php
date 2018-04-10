<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/contactController.php';
// On assigne une classe à la balise body
$classBody = 'contactBackground';
// On assigne un titre à la balise title
$title = 'Formulaire de contact';
include_once 'header.php';
?>
<div class="container-fluid containerContact">
    <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-lg-offset-3 col-lg-6 formContactBackground">
        <div class="row">
            <h2 class="formTitle col-sm-12 bold">Contactez nous</h2>
        </div>
        <!-- Affichage des messages de succès-->
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert alert-success">
                <p class="text-center bold h4"><?= !empty($formSuccess['sendMail']) ? $formSuccess['sendMail'] : ''; ?></p>
            </div>
        <?php } ?>
        <!-- Affichage des messages d'erreur-->
        <?php if (!empty($formError)) { ?>
            <div class="alert alert-danger">
                <p class="text-center bold h4"><?= !empty($formError['empty']) ? $formError['empty'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['invalidMessage']) ? $formError['invalidMessage'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['invalidUsername']) ? $formError['invalidUsername'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['invalidObject']) ? $formError['invalidObject'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['invalidMail']) ? $formError['invalidMail'] : ''; ?></p>
                <p class="text-center bold h4"><?= !empty($formError['sendMailError']) ? $formError['sendMailError'] : ''; ?></p>
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <form method="POST" action="" class="form-horizontal">
                <!-- Pseudo -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-sm-4" for="username">Pseudo ou Nom : </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control focusColor" name="username" id="username" placeholder="Écrivez votre pseudo" required />
                    </div>
                </div>
                <!-- Adresse e-mail -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-sm-4" for="mail">Votre adresse e-mail : </label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control focusColor" name="mail" id="mail" placeholder="Écrivez votre adresse e-mail" required />
                    </div>
                </div>
                <!-- Sélection des sujets --> 
                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="object">Sujet : </label>
                    <div class="col-lg-8">
                        <select name="object" class="form-control focusColor" id="object" required>
                            <option selected disabled>Sélectionner votre choix</option>
                            <option value="j'ai une question">J'ai une question</option>
                            <option value="J'ai une remarque">J'ai une remarque</option>
                            <option value="J'ai un problème">J'ai un problème</option>
                            <option value="C'est à propos de vôtre site">C'est à propos de vôtre site</option>
                            <option value="Autre..">Autre..</option>
                        </select>
                    </div>
                </div>
                <!-- Textarea message --> 
                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="message">Message : </label>
                    <div class="col-lg-8">
                        <textarea  class="form-control focusColor" name="message" id="message" placeholder="Écrivez votre message" rows="8" required></textarea> 
                    </div>
                </div>
                <!-- Valider --> 
                <div class="form-group fieldBackground">
                    <div class="col-lg-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
