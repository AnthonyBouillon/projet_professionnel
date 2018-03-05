<?php
$title = 'Error 500';
include '../include/header.php';
?>
<div class="jumbotron errorBloc">  
    <div class="col-xs-offset-0 col-xs-6 col-sm-offset-2 col-sm-4 col-md-offset-2 col-md-4 col-lg-offset-3 col-lg-3">
        <h2 class="page_error_title">Error 500</h2>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <img src="../assets/images/img_broken.png" alt=" Image d'una mennette cassé" title="Serveur broyé" class="img-responsive" />
    </div>
    <h3 class="text-center errorH3 col-xs-12 col-sm-12 col-md-12 col-md-12 col-lg-offset-3 col-lg-6">Cette page est temporairement indisponible.. Et cela ne vient pas de vous ! Mais de nous..</h3>
    <p class="text-center errorParagraph col-xs-12 col-sm-12 col-md-12 col-lg-offset-3 col-lg-6">Nous allons résoudre ce problème prochainement.<br/>Vous pouvez tout de même continuer votre navigation grâce au menu.<br/>
        <span class="bold">Si cette page s'affiche fréquemment ou plutôt qu'il ne s'affiche pas comme il le devrait :</span> veuillez m'en faire part via ce <a href="Contact">formulaire de contact</a>.</p>
</div>
<?php
include 'include/footer.php';
