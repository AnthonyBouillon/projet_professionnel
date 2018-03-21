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
include '../include/header.php';
?>
<div class="container-fluid containerProfileUpdate">
    <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-lg-offset-3 col-lg-6 formContactBackground">
        <div class="row">
            <h2 class="formTitle col-sm-12 bold">Modification d'article</h2>
        </div>
        <!-- Affichage des messages d'erreurs ou de succès-->
        <?php if (!empty($formSuccess)) { ?>
            <div class="alert alert-success">

            </div>
        <?php } ?>
        <?php if (!empty($formError)) { ?>
            <div class="alert alert-danger">

            </div>
        <?php } ?>

        <section class="col-lg-12">
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
                <!-- Pseudo -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-sm-4" for="title">Titre : </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control focusColor" name="title" id="title" placeholder="Écrivez votre pseudo"  />
                    </div>
                </div>
                <!-- Adresse e-mail -->
                <div class="form-group fieldBackground">
                    <label class="control-label col-sm-4" for="plateform">Plateforme : </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control focusColor" name="plateform" id="plateform" placeholder="Écrivez votre adresse e-mail" />
                    </div>
                </div>

                <!-- Message --> 
                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="resume">Résumer : </label>
                    <div class="col-lg-8">
                        <textarea  class="form-control focusColor" name="resume" id="resume" placeholder="Écrivez votre message" rows="8"></textarea> 
                    </div>
                </div>

                <div class="form-group fieldBackground">
                    <label class="control-label col-lg-4" for="content">Contenu : </label>
                    <div class="col-lg-8">
                        <textarea  class="form-control focusColor" name="content" id="content" placeholder="Écrivez votre message" rows="8"></textarea> 
                    </div>
                </div>
                <div class="form-group fieldBackground">
                    <div class="col-lg-offset-5 col-lg-7">
                        <label class="btn formBtn" for="picture">Ajouter une image</label>
                        <input  type="file" name="picture" id="picture" onchange="$('#upload-file-info').html(this.files[0].name)" required />
                        <span class='label label-info' id="upload-file-info"></span><br/>
                    </div>
                </div>

                <!-- Valider --> 
                <div class="form-group fieldBackground">
                    <div class="col-lg-12">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Valider</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
include '../include/footer.php';
