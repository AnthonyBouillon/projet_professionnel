<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/forumTopics.php';
include_once '../models/forumPosts.php';
include_once '../controllers/forumPostsController.php';
// On assigne une classe à la balise body
$classBody = 'forumBackground';
// On assigne un titre à la balise title
$title = 'Forum réponses';
include_once 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Plateform Together</h2>
    <table class="table table-bordered"> 
        <!-- En-tête du forum -->
        <thead class="theadTable"> 
            <tr> 
                <th class="text-center">Auteur</th> 
                <th class="text-center">Titre du sujet : <?= $readNameByPost->name ?></th> 
            </tr> 
        </thead> 
        <!-- Corps du forum -->
        <tbody class="tbodyTable">  
            <?php foreach ($readPosts as $posts) { ?>
                <tr> 
                    <td>
                        <p class="bold">
                            <img src="../members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="avatarForum img-responsive img-rounded center-block" alt="Image de profil"/><br/>
                            <?= $posts->username ?>
                        </p>
                        <p><span class="bold">Statut : </span><?= $posts->rights ?></p>
                        <p><span class="bold">Date d'inscription : </span><?= $posts->dateUsers ?></p>
                    </td> 
                    <td>
                        <p><?= $posts->message ?></p><hr/>
                        <p class="bold">Posté le :<?= $posts->datePost ?></p>
                        <p><button type="button">Modifier</button> | <button type="submit">Supprimer</button></p>
                    </td> 
                </tr> 
            <?php } ?> 
        </tbody> 
    </table>
    <!-- Formulaire pour répondre au sujet -->
    <?php if (!empty($_SESSION['id'])) { ?>
        <div class="well col-lg-6">
            <form method="POST" action="">
                <div class="col-lg-12">
                    <label for="message">Répondre au sujet</label>
                    <input type="text" name="message" class="form-control focusColor" id="message" placeholder="Réponse du sujet" />
                </div>
                <div class="col-lg-12">
                    <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Valider"/>
                </div>
            </form>
        </div>
    <?php } ?>
</div>
<?php
include_once 'footer.php';
