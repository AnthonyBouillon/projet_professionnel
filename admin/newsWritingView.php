<?php
// Démarre la session
session_start();

include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsWritingController.php';
// Attribut une classe à la balise body
$classBody = 'newsWritingBackground';
// Attribut un titre à la balise title
$title = 'Rédaction d\'article';
include '../include/header.php';

if (isset($readUsers->id_cuyn_admin) && $readUsers->id_cuyn_admin == 1) {
    ?>
    <div class="container">
        <div class="col-lg-12 formBackground">
            <div class="row">
                <h2 class="formTitle col-sm-12 bold">Rédaction d'un nouvelle article</h2>
            </div>
            <?php if (!empty($formError)) { ?>
                <div class="alert-danger">
                    <p class="text-center  bold h4"><?= !empty($formError['emptyAvatar']) ? $formError['emptyAvatar'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['badFormat']) ? $formError['badFormat'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['emptyInput']) ? $formError['emptyInput'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['emptyPicture']) ? $formError['emptyPicture'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['!regexTitle']) ? $formError['!regexTitle'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['!regexPlateform']) ? $formError['!regexPlateform'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['!regexResume']) ? $formError['!regexResume'] : ''; ?></p>
                    <p class="text-center  bold h4"><?= !empty($formError['notCreateNews']) ? $formError['notCreateNews'] : ''; ?></p>
                </div>
            <?php } ?>
            <?php if (!empty($formSuccess)) { ?>
                <div class="alert-success">
                    <p class="text-center bold h4"><?= !empty($formSuccess['createNews']) ? $formSuccess['createNews'] : ''; ?></p>
                </div>
            <?php } ?>
            <section class="col-md-12">
                <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
                    <!-- Pseudo -->
                    <div class="form-group fieldBackground">
                        <label for="title" class="col-sm-4 control-label">Titre</label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control focusColor" id="title" placeholder="Saisissez le titre" value="<?php !empty($_POST['title']) ?  $_POST['title'] : ''; ?>" required />
                        </div>
                    </div>
                    <!-- E-mail -->
                    <div class="form-group fieldBackground">
                        <label for="plateform" class="col-sm-4 control-label">Plateforme</label>
                        <div class="col-sm-8">
                            <input type="text" name="plateform" class="form-control focusColor" id="plateform" placeholder="Saisissez le nom de la plateforme" value="<?php !empty($_POST['plateform']) ?  $_POST['plateform'] : ''; ?>" required />
                        </div>
                    </div>
                    <!-- Confirmation de l'e-mail -->
                    <div class="form-group fieldBackground">
                        <label for="resume" class="col-sm-4 control-label">Résumer</label>
                        <div class="col-sm-8">
                            <textarea name="resume" class="form-control focusColor articleTextarea" id="resume" placeholder="Saisissez le résumer (court)"  rows="10" required></textarea>
                        </div>
                    </div>
                    <!-- Mot de passe -->
                    <div class="form-group fieldBackground">
                        <label for="content" class="col-sm-4 control-label">Contenue</label>
                        <div class="col-sm-8">
                            <textarea name="content" class="form-control focusColor content articleTextarea" id="content" placeholder="Saisissez le contenue" rows="10"  required></textarea>
                        </div>
                    </div>
                    <!-- Confirmation du mot de passe -->
                    <div class="form-group fieldBackground">
                        <div class="col-lg-offset-5 col-lg-7">
                            <label class="btn formBtn" for="picture">Ajouter une image</label>
                            <input  type="file" name="picture" id="picture" onchange="$('#upload-file-info').html(this.files[0].name)" required />
                            <span class='label label-info' id="upload-file-info"></span><br/>
                        </div>
                    </div>
                    <!-- Valider l'inscription -->
                    <div class="form-group fieldBackground">
                        <div class="col-md-12">
                            <button type="submit" name="submit" class="btn btn-block formBtn">J'enregistre mon article</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <?php
} else {
    header('Location: ../404');
}
include '../include/footer.php';
