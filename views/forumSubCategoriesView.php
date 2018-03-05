<?php
include '../models/database.php';
include '../models/forumSubCategories.php';
include '../controllers/forumSubCategoriesController.php';
$classBody = NULL;
$title = 'Forum sous-catégories';
include '../include/header.php';
?>
<div class="container containerForum">
    <p><a href="forumCategoriesView.php">Revenir à la liste des catégories</a></p>
    <table class="table table-bordered"> 

        <thead> 

            <tr> 
                <th>Sous-catégories</th> 
                <th>Sujets</th> 
                <th>Dernières activités</th> 

            </tr> 

        </thead> 
        <tbody> 
            <?php foreach ($getsubCategories as $subCategory) { ?>
                <tr> 
                    <td><a href="forumTopicsView.php?id=<?= $subCategory->id ?>" title="direction vers les posts des utilisateurs"><?= $subCategory->name ?></a><br/><?= $subCategory->description ?><br/><button type="button" name="updateSubCategory" id="updateSubCategory" title="Modifier une sous catégorie"><i class="far fa-edit"></i></button><button type="button" name="deleteSubCategory" id="deleteSubCategory" title="Supprimer une sous catégorie"><i class="far fa-trash-alt"></i></button></td>  
                    <td>74127</td> 
                    <td>Dernier message : 05/03/2018</td>
            
                    
                </tr> 
            <?php } ?> 
        </tbody> 

    </table>
        <button type="button" name="addSubCategory" id="addForum">Ajouter une sous-catégorie</button>
        <div class="divForum">
            <form method="post" action="">
                <input type="text" name="name" class="form-control" placeholder="Titre de la sous-catégorie" />
            <textarea name="description" class="form-control" placeholder="Description de la sous-catégorie"></textarea>
            <input type="submit" name="submit" value="Valider la sous-catégorie"/>
            </form>
        </div>
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

