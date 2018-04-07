<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../models/forumTopics.php';
include '../controllers/forumTopicsController.php';
$classBody = 'forumBackground';
$title = 'Forum des sujets';
include 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Plateform Together</h2>
    <table class="table table-bordered"> 

        <thead class="theadTable"> 
            <tr> 
                <th class="text-center">Sujets</th> 
                <th class="text-center">Messages</th> 
                <th class="text-center">Dernières activités</th> 
            </tr> 
        </thead> 
        <tbody class="tbodyTable"> 
            <?php foreach ($readTopics as $topics) { ?>
                <tr> 
                    <td><a href="forumPostsView.php?id=<?= $topics->id ?>"><?= $topics->name ?></a></td>  
                    <td></td> 
                    <td></td>
                </tr> 
            <?php } ?> 
        </tbody> 
    </table>
    <div class="well col-lg-6">
        <h2 class="text-center">Ajouter un sujet</h2>
        <form method="POST" action="">
            <div class="col-lg-12">
                <label for="name">Titre</label>
                <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre du sujet" />
            </div>
            <div class="col-lg-12">
                <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Créer le sujet"/>
            </div>
        </form>
    </div>
</div>
<style>

</style>
<?php
include 'footer.php';

