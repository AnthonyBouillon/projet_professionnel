<?php
include '../models/database.php';
include '../models/forumTopicsModel.php';
include '../controllers/forumTopicsController.php';
$classBody = NULL;
$title = 'Forum des sujets';
include '../include/header.php';
?>
<div class="container-fluid containerForum">
    <p><a href="forumSubCategoriesView.php">Revenir à la liste des sous-catégories</a></p>
    <table class="table table-bordered"> 

        <thead> 

            <tr> 
                <th>Sujets</th> 
                <th>Message</th> 
                <th>Dernières activités</th> 
            </tr> 

        </thead> 
        <tbody> 
            <?php foreach ($getTopics as $topics) { ?>
                <tr> 
                    <td><a href="forumTopicsView.php" title="direction sujets de la sous-catégorie"><?= $topics->name ?></a></td> 
                    <td>74127</td> 
                    <td>Dernier message : 05/03/2018</td> 
                </tr> 
            <?php } ?> 
        </tbody> 

    </table>
</div>
<style>
    .containerForum{
        margin-top: 10%;
    }
    tr th{
        background-color: #A983BE;
    }
    td{
        padding: 20px!important;
    }
    #divSubCategory{
        display: none;
    }
</style>
<?php
include '../include/footer.php';

