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
include_once 'header.php';
?>
<div class="container">
    <div class="col-lg-12 formBackground">
        <div class="row">
            <h2 class="fieldBackground col-sm-12 bold text-center">Rédaction d'un nouvel article</h2>
        </div>
        <!-- Affichage des messages d'erreur -->
        <?php if (!empty($formError)) { ?>
            <div class="alert-danger">
                <p class="text-center  bold h4"><?= !empty($formError['emptyAvatar']) ? $formError['empty'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['badFormat']) ? $formError['badFormat'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['emptyPicture']) ? $formError['emptyPicture'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['bigFormat']) ? $formError['bigFormat'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['!regexTitle']) ? $formError['!regexTitle'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['!regexPlateform']) ? $formError['!regexPlateform'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['!regexResume']) ? $formError['!regexResume'] : ''; ?></p>
                <p class="text-center  bold h4"><?= !empty($formError['notCreateNews']) ? $formError['notCreateNews'] : ''; ?></p>
            </div>
        <?php } ?>
        <!-- Affichage des messages de succès -->
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert-success">
                <p class="text-center bold h4"><?= $formSuccess['createNews'] ?></p>
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
                <!-- Titre -->
                <div class="form-group fieldBackground">
                    <label for="title" class="col-sm-4 control-label">Titre</label>
                    <div class="col-sm-8">
                        <input type="text" name="title" class="form-control focusColor" id="title" placeholder="Saisissez le titre" value="<?= !empty($_POST['title']) ? $_POST['title'] : ''; ?>" required />
                    </div>
                </div>
                <!-- Plateforme -->
                <div class="form-group fieldBackground">
                    <label for="plateform" class="col-sm-4 control-label">Plateforme</label>
                    <div class="col-sm-8">
                        <input type="text" name="plateform" class="form-control focusColor" id="plateform" placeholder="Saisissez le nom de la plateforme" value="<?= !empty($_POST['plateform']) ? $_POST['plateform'] : ''; ?>" required />
                    </div>
                </div>
                <!-- Résumer de l'article -->
                <div class="form-group fieldBackground">
                    <label for="resume" class="col-sm-4 control-label">Résumer</label>
                    <div class="col-sm-8">
                        <textarea name="resume" class="form-control focusColor articleTextarea" id="resume" placeholder="Saisissez le résumer (court)"  rows="10"  required></textarea>
                    </div>
                </div>
                <!-- Le contenu de l'article -->
                <div class="form-group fieldBackground">
                    <label for="content" class="col-sm-4 control-label">Contenu</label>
                    <div class="col-sm-8">
                        <textarea name="content" class="form-control focusColor content articleTextarea" id="content" placeholder="Saisissez le contenue" rows="10"  required></textarea>
                    </div>
                </div>
                <!-- L'ajout d'image -->
                <div class="form-group fieldBackground">
                    <div class="col-lg-offset-5 col-lg-7">
                        <label class="btn formBtn" for="picture">Ajouter une image</label>
                        <input  type="file" name="picture" id="picture"  required />
                        <span class='label label-info' id="upload-file-info"></span><br/>
                    </div>
                </div>
                <!-- Valider la création d'article -->
                <div class="form-group fieldBackground">
                    <div class="col-md-12">
                        <button type="submit" name="submitCreate" class="btn btn-block formBtn">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
