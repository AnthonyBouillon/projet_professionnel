<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../models/forumSubCategories.php';
include '../controllers/forumSubCategoriesController.php';
$classBody = NULL;
$title = 'Forum sous-catégories';
include '../include/header.php';
?>
<div class="container containerForum">
    <p><a href="../Catégorie-du-forum">Revenir à la liste des catégories</a></p>
    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <th>Sous-catégories</th> 
                <th>Topics</th> 
                <th>Dernières activités</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($getSubCategories as $subCategory) { ?>
                <tr> 
                    <td><a href="forumTopicsView.php?id=<?= $subCategory->id ?>" title="direction vers les posts des utilisateurs"><?= $subCategory->name ?></a><br/><?= $subCategory->description ?><br/>
                        <form method="POST" action="">
                            <button type="button" name="updateSubCategory" class="displayForm" id="updateSubCategory" title="Modifier une sous catégorie"><i class="far fa-edit"></i></button>
                            <button type="submit" name="deleteSubCategory" id="deleteSubCategory" title="Supprimer une sous catégorie" onclick="return confirm('La suppression de la sous-catégorie ainsi que tout ce qui est lié à celui-ci est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                            <input type="text" name="idSubCategory" value="<?= $subCategory->id ?>" />
                        </form>
                        <div class="">
                            <form method="post" action="">
                                <input type="text" name="idSubCategory" value="<?= $subCategory->id ?>" />
                                <input type="text" name="name" class="form-control" placeholder="Titre de la sous-catégorie" />
                                <textarea name="description" class="form-control" placeholder="Description de la sous-catégorie"></textarea>
                                <input type="submit" name="submitUpdate" value="Valider la sous-catégorie"/>
                            </form>
                        </div>
                    </td>  
                    <td></td> 
                    <td></td>
                </tr> 
            <?php } ?> 
        </tbody> 
    </table>
    
    <div class="well col-lg-6">
        <h2 class="text-center">Ajouter une sous-catégorie</h2>
        <div class="col-lg-12">
            <form method="post" action="">
                <label for="name">Titre </label>
                <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre de la sous-catégorie" />
                <label for="description">Description</label>
                <textarea name="description" class="form-control focusColor" id="description" placeholder="Description de la sous-catégorie"></textarea>
                <input type="submit" name="submit" class="btn formBtn btn-block" value="Valider la sous-catégorie"/>
            </form>
        </div>
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

