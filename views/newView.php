<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/news.php';
include_once '../models/users.php';
include_once '../models/comments.php';
include_once '../controllers/newController.php';
$classBody = 'newsBackground';
$title = 'Actualité';
include_once 'header.php';
?>
<div class="container containerNewsAll margin containerNews">
    <?php if ($readArticles != null) { ?>
        <!-- Nous parcourons notre tableau afin d'afficher l'article complet -->
        <?php foreach ($readArticles as $article) { ?>
            <div class="well jumbotron margin border col-lg-12">
                <!-- Affichage de l'image -->
                <p><img src="../news/images/<?= $article->picture; ?>" class="img-responsive img-thumbnail centerImg"/></p>
                <div class="col-lg-offset-1 col-lg-10">
                    <!-- Affichage du nom de la plateforme ainsi que le titre -->
                    <h2 class="text-center"><?= $article->plateform; ?> | <?= $article->title; ?></h2>
                    <!-- Affichage du contenu de l'article, tout les 20 caractères, un espace se créer -->
                    <p class="h4"><?= wordwrap($article->content, 20, ' ', 1); ?></p>
                    <!-- Affichage de la date de la création d'article -->
                    <p class="datePost h4"><span class="bold">Posté le :<?= $article->date; ?></span></p>
                </div>
            </div>
        <?php } ?>
        <!-- Titre du formulaire d'ajout de commentaire -->
        <div class="col-lg-12 formBackground">
            <h2 class="text-center white"><label for="comment" >Ajouter un commentaire</label></h2>
            <!-- Affichage des messages d'erreurs -->
            <?php if (!empty($error['empty']) || !empty($error['notInsertComment']) || !empty($error['logout']) || !empty($error['commentBadRegex'])) { ?>
                <div class="alert-danger">
                    <p class="text-center bold  h4"><?= $error['empty'] ?></p>
                    <p class="text-center bold h4"><?= $error['notInsertComment'] ?></p>
                    <p class="text-center bold h4"><?= $error['logout'] ?></p>
                    <p class="text-center bold h4"><?= $error['commentBadRegex'] ?></p>
                </div>
            <?php } ?>
            <!-- Affichage des messages de succès -->
            <?php if (!empty($success['insertComment'])) { ?>
                <div class="alert-success">
                    <p class="text-center bold h4"><?= $success['insertComment'] ?></p>
                </div>
            <?php } ?>
            <!-- Formulaire d'ajouts de commentaires -->
            <form method="POST" action="" class="form-horizontal">
                <div class="form-group">
                    <textarea  class="form-control focusColor" name="comment" id="comment" placeholder="Écrivez un commentaire" rows="8" required></textarea>   
                </div>
                <div class="form-group">
                    <button type="submit" name="submitAdd" class="btn btn-block formBtn">Valider mon commentaire</button>
                </div>
            </form>
        </div>
        <!-- Bloc de la partie des commentaires -->
        <div class="jumbotron border allComments">
            <!-- Affichage des nombres total de commentaires -->
            <p class="purple">Nombre de commentaires : <span class="bold"><?= $countComments ?>  </p>
            <!-- Affichage des messages de succès de suppresion de commentaire -->
            <?php if (!empty($success['deleteComment'])) { ?>
                <div class="text-center alert-success">
                    <p class="text-center  h4"><?= $success['deleteComment'] ?></p>
                </div>
            <?php } ?>
            <!-- Nous parcourons un tableau afin d'afficher toutes les informations de l'utilisateur et de son commentaire -->
            <?php foreach ($readComments as $comments) { ?> 
                <div class="well col-lg-12 border">
                    <!-- Affichage du pseudo et de l'image de l'utilisateur -->
                    <h2 class=""><img src="../members/avatars/<?= $comments->username . '/' . $comments->avatar; ?>" class="img-rounded avatarNav" /><?= !empty($comments->username) ? $comments->username : 'Anonyme'; ?> a écrit : </h2><hr/>
                    <!-- Affichage du contenu du commentaire -->
                    <p class="h4"><?= wordwrap($comments->comment, 18, ' ', 1); ?></p>
                    <!-- Affichage de la date de création du commentaire -->
                    <p class="datePost h4">Commenté le : <span class="bold"><?= $comments->date; ?></span></p>
                    <!-- Si l'utilisateur est connecté et que l'id de la session correspond avec celui de la base de données, on affiche -->
                    <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $comments->id_cuyn_users) { ?>  
                    <!-- Bouton qui permet d'afficher le formulaire de modification de commentaire -->
                        <button class="col-lg-1 editBtn" idComment="<?= $comments->id ?>" title="Editer mon commentaire"><i class="far fa-edit"></i></button>    
                        <!-- Formulaire de modification du commentaire -->
                        <form method="POST" action="" class="editForm">
                            <!-- On affiche l'id du commentaire pour le récupérer -->
                            <input type="hidden" value="<?= $comments->id ?>"  name="idComment"/>
                            <!-- Bouton qui permet de supprimer un commentaire -->
                            <button type="submit" name="deleteBtn" class="col-lg-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre commentaire ?')"  title="Supprimer mon commentaire"><i class="fas fa-trash-alt" ></i></button>
                        </form>
                    <?php } ?><br/><br/>
                    <form method="POST" action="" class="editForm">
                        <!-- Formulaire de modification du commentaires -->
                        <input type="hidden" value="<?= $comments->id ?>"  name="idComment"/>
                        <div id="divUpdate<?= $comments->id; ?>" class="divUpdate">   
                            <textarea name="commentUpdate"  class="form-control focusColor" rows="4" placeholder="Ecrivez ici pour modifier votre commentaire..."></textarea>
                            <button type="submit" name="edit" class="btn btn-block center-block formBtn">Valider</button>
                        </div>
                        <!-- Affichage des message d'erreur -->
                        <?php if (!empty($error['emptyComment']) || !empty($error['!regexUpdate']) || !empty($error['!regexUpdate'])) { ?>
                            <div class="text-center alert-danger">
                                <p class="text-center bold h4"><?= $error['emptyComment'] ?></p>
                                <p class="text-center bold h4"><?= $error['!regexUpdate'] ?></p>
                                <p class="text-center bold h4"><?= $error['!updateComment'] ?></p>
                            </div>
                        <?php } ?>
                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($success['updateComment'])) { ?>
                            <div class="text-center alert-success">
                                <p class="text-center bold h4"><?= $success['updateComment'] ?></p>
                            </div>
                        <?php } ?>
                    </form>
                </div>     
            <?php } ?>
        </div>
    <?php } else { ?>
        <h2 class="text-center alert-danger margin">L'article que vous essayez de voir n'existe pas</h2>
    <?php } ?>
</div>
<?php
include_once 'footer.php';
