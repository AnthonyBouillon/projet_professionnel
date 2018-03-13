<?php
// Démarre la session
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/logoutController.php';
header('refresh:5;url=Connexion');
$classBody = NULL;
// Assigne un titre à la balise title
$title = 'Déconnexion';
include '../include/header.php';

// Si il est connecté, affiche le contenu de la page
if(isset($_SESSION['id'])){
?>
    <div class="container containerLogout">
        <div class="page-header">
            <h2 class="text-center" >Vous êtes déconnecté</h2>
        </div>
        <div class="row"> 
            <div class="well col-lg-offset-2 col-lg-8">
                <p class="text-info h4">Vous allez être redirigé dans <span class="red" id="chrono">5</span> <span class="red">secondes</span> vers la page de connexion du site.<br/>
                Si ne n'est pas le cas, vous pouvez quitter cette page ou cliquez sur ce lien : <br/><a href="Connexion" class="red" title="lien qui redirige vers la page de connexion">Page de connexion</a></p>
            </div>
        </div>
    </div>
<?php
// Sinon la page 404 apparait
}else{
    header('Location:404.php');
}

// Détruit la session
session_destroy();
include '../include/footer.php';
