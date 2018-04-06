<?php
// Démarre la session
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsUpdateController.php';
// Attribut une classe à la balise body
$classBody = 'newsWritingBackground';
// Attribut un titre à la balise title
$title = 'Modification de l\'article';
include_once 'header.php';
?>
<div class="container-fluid containerProfileUpdate">
    <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-lg-offset-3 col-lg-6 formContactBackground">
        <div class="row">
            <h2 class="formTitle col-sm-12 bold">Modification d'article</h2>
        </div>
        <!-- Affichage des messages de succès -->
        <?php if (!empty($success)) { ?>
            <div class="alert alert-success">
                <p class="text-center bold"><?= !empty($success['updateTitle']) ? $success['updateTitle'] : '' ?></p>
                <p class="text-center bold"><?= !empty($success['updatePlatform']) ? $success['updatePlatform'] : '' ?></p>
                <p class="text-center bold"><?= !empty($success['updateResume']) ? $success['updateResume'] : '' ?></p>
                <p class="text-center bold"><?= !empty($success['updateContent']) ? $success['updateContent'] : '' ?></p>
                <p class="text-center bold"><?= !empty($success['updatePicture']) ? $success['updatePicture'] : '' ?></p>
            </div>
        <?php }
        if (!empty($error)) {
            ?>
            <!-- Affichage des messages d'erreurs -->
            <div class="alert alert-danger">
                <p class="text-center bold"><?= !empty($error['bigFormat']) ? $error['bigFormat'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['badFormat']) ? $error['badFormat'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['!updateTitle']) ? $error['!updateTitle'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['!updatePlatform']) ? $error['!updatePlatform'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['!updateResume']) ? $error['!updateResume'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['!updateContent']) ? $error['!updateContent'] : '' ?></p>
                <p class="text-center bold"><?= !empty($error['!updatePicture']) ? $error['!updatePicture'] : '' ?></p>
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <!-- Utilisation l'attribut enctype="multipart/form-data" afin d'upload des images provenant de l'utilisateur -->
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group fieldBackground">
                    <!-- Titre de l'article -->
                    <label class="control-label col-sm-4" for="title">Titre : </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control focusColor" name="title" id="title" placeholder="Écrivez votre pseudo" value="<?= !empty($_POST['title']) ? $_POST['title'] : ''; ?>" />
                    </div>
                </div>
                <!-- Titre de l'article -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-sm-4" for="plateform">Plateforme : </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control focusColor" name="plateform" id="plateform" placeholder="Écrivez votre adresse e-mail" value="<?= !empty($_POST['plateform']) ? $_POST['plateform'] : ''; ?>" />
                    </div>
                </div>
                <!-- Résumer de l'article -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="resume">Résumer : </label>
                    <div class="col-lg-8">
                        <textarea  class="form-control focusColor" name="resume" id="resume" placeholder="Écrivez votre message" rows="8"><?= !empty($_POST['resume']) ? $_POST['resume'] : ''; ?></textarea> 
                    </div>
                </div>
                <!-- Contenu de l'article -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="content">Contenu : </label>
                    <div class="col-lg-8">
                        <textarea  class="form-control focusColor" name="content" id="content" placeholder="Écrivez votre message" rows="8"><?= !empty($_POST['content']) ? $_POST['content'] : ''; ?></textarea> 
                    </div>
                </div>
                <!-- Parcourir une image pour l'article -->
                <div class="form-group fieldBackground">
                    <div class="col-lg-offset-5 col-lg-7">
                        <label class="btn formBtn" for="picture">Ajouter une image</label>
                        <input  type="file" name="picture" id="picture" accept="image/*" />
                    </div>
                </div>
                <!-- Valider la création de l'article -->
                <div class="form-group fieldBackground">
                    <div class="col-lg-12">
                        <button type="submit" name="submitUpdate" class="btn btn-block formBtn">Valider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
