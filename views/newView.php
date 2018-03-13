<?php
/*
 * On démarre la session
 * On inclut nos modèles
 * On inclut notre controlleur
 * On inclut notre header
 */
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/news.php';
include_once '../models/users.php';
include '../models/comments.php';
include '../controllers/newController.php';
$classBody = NULL;
$title = 'Actualité';
include '../include/header.php';
?>
<div class="container containerNew">
    <!-- On parcours notre tableau afin d'afficher l'article qui correspond à son id -->
    <?php foreach ($readArticles as $article) { ?>
        <div class="well col-lg-12">
            <p><img src="../news/images/<?= $article->picture; ?>" class="img-responsive centerImg"/></p>
            <div class="col-lg-offset-1 col-lg-10">
                <h2 class="text-center"><?= $article->plateform; ?> <?= $article->title; ?></h2>
                <p class="h4"><?= $article->content; ?></p>
                <p class="datePost h4">Posté le :<?= $article->date; ?></p>
            </div>
        </div>
    <?php } ?>
        <div class="col-lg-12 formBackground">
            <section class="col-lg-12">
                <h2 class="text-center white"><label for="comment" >Ajouter un commentaire</label></h2>
                <!-- Affichage des messages d'erreurs-->
                <p class="text-center yellow h4"><?= !empty($error['empty']) ? $error['empty'] : ''; ?></p>
                <p class="text-center yellow h4"><?= !empty($error['notInsertComment']) ? $error['notInsertComment'] : ''; ?></p>
                <p class="text-center yellow h4"><?= !empty($error['logout']) ? $error['logout'] : ''; ?></p>
                <p class="text-center yellow h4"><?= !empty($error['commentBadRegex']) ? $error['commentBadRegex'] : ''; ?></p>
                <!-- Affichage du message qui confirme la réussite de son interaction -->
                <p class="text-center green h4"><?= !empty($success['insertComment']) ? $success['insertComment'] : ''; ?></p>
                <!-- Formulaire d'ajouts de commentaires -->
                <form method="POST" action="" class="form-horizontal">
                    <div class="form-group barra">
                        <textarea  class="form-control focusColor" name="comment" id="comment" placeholder="Écrivez un commentaire" rows="8" required></textarea>   
                    </div>
                    <div class="form-group barra">
                        <button type="submit" name="submit" class="btn btn-block formBtn">Valider mon commentaire</button>
                    </div>
                </form>
            </section>
        </div>
        <div class="jumbotron allComments">
            <!-- Affichage du message qui confirme la réussite de son interaction -->
            <p class="text-center green h4"><?= !empty($success['deleteComment']) ? $success['deleteComment'] : ''; ?></p>
            <!-- On parcours notre tableau afin d'afficher les  commentaires qui correspond à son article -->
            <?php foreach ($readComments as $comments) { ?>  
                <div class="well col-lg-12">
                    <!-- Affichage des commentaires -->
                    <h2 class=""><?= !empty($comments->username) ? $comments->username : 'Anonyme'; ?> a dit : </h2><hr/>
                    <p class="h4"><?= wordwrap($comments->comment, 20, ' ', 1); ?></p>
                    <p class="datePost h4">Le :<?= $comments->date; ?></p>
                    <?php if (!empty($_SESSION['id'])) { ?>
                        <button class="col-lg-1 responseBtn" idComment="<?= $comments->id; ?>" title="Répondre au commentaire"><i class="fas fa-comment"></i></button>
                    <?php } ?>
                    <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $comments->id_cuyn_users) { ?>  
                        <!-- Affichage des messages d'erreurs-->
                        <p class="text-center red h4"><?= !empty($error['emptyComment']) ? $error['emptyComment'] : ''; ?></p>
                        <p class="text-center red h4"><?= !empty($error['!regexUpdate']) ? $error['!regexUpdate'] : ''; ?></p>
                        <p class="text-center red h4"><?= !empty($error['!updateComment']) ? $error['!updateComment'] : ''; ?></p>
                        <!-- Affichage du message qui confirme la réussite de son interaction -->
                        <p class="text-center green h4"><?= !empty($success['updateComment']) ? $success['updateComment'] : ''; ?></p>    
                        <button class="col-lg-1 editBtn" idComment="<?= $comments->id; ?>" title="Editer mon commentaire"><i class="far fa-edit"></i></button>    
                        <!-- Formulaire de modification du commentaire -->
                        <form method="POST" action="" class="editForm">
                            <input type="hidden" value="<?= $comments->id ?>"  name="idComment"/>
                            <button type="submit" name="deleteBtn" class="col-lg-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre commentaire ?')"  title="Supprimer mon commentaire"><i class="fas fa-trash-alt" ></i></button>
                        </form>
                    <?php } ?>
                    <form method="POST" action="" class="editForm">
                    <!-- Formulaire de modification du commentaires -->
                    <input type="hidden" value="<?= $comments->id ?>"  name="idComment"/>
                        <div id="divUpdate<?= $comments->id; ?>" class="divUpdate">   
                            <textarea name="commentUpdate"  class="form-control" rows="4" placeholder="Ecrivez ici pour modifier votre commentaire..."></textarea>
                            <button type="submit" name="edit" class="btn btn-block center-block formBtn">Je modifie mon commentaire</button>
                        </div>
                        <!-- Formulaire de réponse aux commentaires -->
                        <div id="divResponse<?= $comments->id; ?>" class="divResponse">    
                            <textarea name="responseComment" class="form-control" rows="4" placeholder="Ecrivez ici pour répondre à son commentaire..."></textarea>
                            <button type="submit" name="response" class="btn btn-block center-block formBtn">Je répond au commentaire</button>
                        </div>
                    </form>
                </div>     
        <?php } ?>
        </div>
    </div>
<?php
include '../include/footer.php';
