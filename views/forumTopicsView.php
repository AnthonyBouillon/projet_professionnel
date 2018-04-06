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

