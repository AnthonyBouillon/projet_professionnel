<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/profileDeleteController.php';
$classBody = NULL;
$title = 'Supprimer mon compte';
include_once 'header.php';
?>
<div class="container containerNew">
    <!-- Si le compte n'est pas supprimé, on affiche cette vue -->
    <?php if (!isset($success)) { ?>
        <div class="page-header">
            <h2 class="text-center" >Vous avez décidé de nous quitter <?= !empty($_SESSION['username']) ? $_SESSION['username'] : ''; ?> ?</h2>
            <h3 class="text-center">Si vous désirez supprimer votre compte, vous êtes au bon endroit</h3>
        </div>
        <div class="row"> 
            <div class="well well-lg col-lg-offset-2 col-lg-8">
                <p class="text-info h4">Pour supprimer votre compte il suffit de cliquer sur le bouton ci-dessous et de confirmer votre choix.<br/>
                    Sachez que toutes vos données seront entièrement supprimé (Pseudo, adresse e-mail, mot de passe), seuls vos commentaires resterons.. Mais votre pseudo sera remplacer par <em>Anonyme</em> pour tous les commentaires que vous avez pu poster sur le site.<br/>
                    Si vous avez le temps vous pouvez nous donner la raison de votre départ via ce formulaire de contact : <a href="">Lien fictif</a>, afin que nous puissions nous améliorer et permettre à nos utilisateurs d'avoir une raison de rester.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-5 col-lg-6">
                <form method="POST" action="">
                    <button type="submit" name="submit" class="btn formBtn" id="delete" onclick="return confirm('La suppression de votre compte est définitive, êtes-vous sûr de vouloir le supprimer ?')">Supprimer mon compte</button>
                </form> 
            </div>
        </div>
    <!-- Si le compte est supprimé, on affiche cette vue -->
    <?php } else { ?>
        <div class="alert-success">
            <p class="text-center h4"><?= $success ?></p>
            <p class="text-center h4"> Vous allez être redirigé dans <span id="chrono" class="red">5</span> <span class="red">secondes</span> sur la page d'inscription ou vous pouvez quitter cette page</p>
        </div>
    <?php } ?>
</div>
<?php
include_once 'footer.php';
