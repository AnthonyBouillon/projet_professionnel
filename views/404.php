<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/navBarController.php';
$title = 'Error 404';
$classBody = NULL;
include_once 'header.php';
?>
<div class="container-fluid">
    <div class="jumbotron errorBloc">  
        <div class="col-xs-offset-0 col-xs-6 col-sm-offset-2 col-sm-4 col-md-offset-2 col-md-4 col-lg-offset-3 col-lg-3">
            <h2 class="errorTitle">Error 404</h2>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="../assets/images/haha.jpg" alt=" Image de Nelson Muntz" title="Nelson Muntz : Ha ! Ha !" class="img-responsive" />
        </div>
        <h3 class="text-center errorH3 col-xs-12 col-sm-12 col-md-12 col-md-12 col-lg-offset-3 col-lg-6">Cette page n'existe pas ou n'existe plus..</h3>
        <p class="text-center errorParagraph col-xs-12 col-sm-12 col-md-12 col-lg-offset-3 col-lg-6">Rassurez-vous, cela arrive.<br/>Vous pouvez tout de même continuer votre navigation grâce au menu.<br/>
            <span class="bold">Si cette page s'affiche fréquemment :</span> veuillez m'en faire part via ce <a href="Contact">formulaire de contact</a>.</p>
    </div>
</div>
<?php
include_once 'footer.php';
