<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
if (isset($_SESSION['id'])) {
    $users = new users();
    $users->id = $_SESSION['id'];
    $users->username = $_SESSION['username'];
    $readUsers = $users->readUsers();
}
$title = 'Error 403';
$classBody = NULL;
include 'header.php';
?>
<div class="jumbotron errorBloc">  
    <div class="col-xs-offset-0 col-xs-6 col-sm-offset-2 col-sm-4 col-md-offset-2 col-md-4 col-lg-offset-3 col-lg-3">
        <h2 class="errorTitle">Error 403</h2>
        <p>Vous ne passerez pas !</p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <img src="../assets/images/gandalf.jpg" alt=" Image de Nelson Muntz" title="Nelson Muntz : Ha ! Ha !" class="img-responsive" />
    </div>
    <h3 class="text-center errorH3 col-xs-12 col-sm-12 col-md-12 col-md-12 col-lg-offset-3 col-lg-6">L'accès à cette page vous est interdite !</h3>
    <p class="text-center errorParagraph col-xs-12 col-sm-12 col-md-12 col-lg-offset-3 col-lg-6">Il est inutile que vous essayez d'y revenir ça n'y changera rien, Gandalf vous y empechera<br/>Vous pouvez tout de même continuer votre navigation grâce au menu.<br/></p>
</div>
<?php
include 'footer.php';
