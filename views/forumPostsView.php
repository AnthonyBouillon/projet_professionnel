<?php

session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/forumPosts.php';
include_once '../controllers/forumPostsController.php';
include_once '../controllers/navBarController.php';
$classBody = NULL;
$title = 'Forum réponses';
include_once 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Plateform Together</h2>
    <table class="table table-bordered"> 

        <thead class="theadTable"> 
            <tr> 
                <th class="text-center">Auteur</th> 
                <th class="text-center">Message</th> 
                <th class="text-center">Date</th> 
            </tr> 
        </thead> 
        <tbody class="tbodyTable"> 
            <?php foreach ($readPosts as $posts) { ?>
                <tr> 
                    <td><?= $posts->username ?></td>  
                    <td><?= $posts->message ?></td> 
                    <td>Posté le : 00/00/0000</td> 
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
include_once 'footer.php';