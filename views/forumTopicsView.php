<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/forumTopics.php';
include_once '../controllers/forumTopicsController.php';
// On assigne une classe à la balise body
$classBody = 'forumBackground';
// On assigne un titre à la balise title
$title = 'Forum des sujets';
include_once 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Plateform Together</h2>
    <table class="table table-bordered"> 
        <!-- En-tête du tableau -->
        <thead class="theadTable"> 
            <tr> 
                <th class="text-center">Sujets</th> 
                <th class="text-center">Messages</th> 
                <th class="text-center">Dernières activités</th> 
            </tr> 
        </thead> 
        <tbody class="tbodyTable"> 
            <!-- Corps du tableau -->
            <?php foreach ($readTopics as $topics) { ?>
                <tr> 
                    <td>
                        <p><a href="forumPostsView.php?id=<?= $topics->id ?>"><?= $topics->name ?></a></p><hr/>
                        <p><button type="button">Modifier</button> | <button type="submit">Supprimer</button></p>
                    </td>  
                    <td></td> 
                    <td></td>
                </tr> 
            <?php } ?> 
        </tbody> 
    </table>
    <div class="well col-lg-6">
        <h2 class="text-center">Ajouter un sujet</h2>
        <form method="POST" action="">
            <label for="name">Titre</label>
            <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre du sujet" />
            <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Créer le sujet"/>
        </form>
    </div>
</div>
<?php
include_once 'footer.php';

