<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../models/forumTopics.php';
include '../controllers/forumTopicsController.php';
$classBody = NULL;
$title = 'Forum des sujets';
include 'header.php';
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
             <?php foreach ($readTopics as $topics) { ?>
                <tr> 
                    <td><a href="forumPostsView.php?id=<?= $topics->id ?>"><?= $topics->name ?></a></td>  
                    <td></td> 
                    <td></td>
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
include 'footer.php';

