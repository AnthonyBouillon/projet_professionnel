<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include '../models/users.php';
include '../models/forumSubCategories.php';
include '../controllers/forumSubCategoriesController.php';
$classBody = NULL;
$title = 'Forum sous-catégories';
include 'header.php';
?>
<div class="container containerForum">
    <?php if (!empty($formError)) { ?>
        <div class="alert-danger">
            <p class="text-center h4"><?= !empty($formError['badRegexName']) ? $formError['badRegexName'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formError['badRegexDescription']) ? $formError['badRegexDescription'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formError['emptyForm']) ? $formError['emptyForm'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formError['badRegexUpdateName']) ? $formError['badRegexUpdateName'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formError['badRegexUpdateDescription']) ? $formError['badRegexUpdateDescription'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formError['emptyFormUpdate']) ? $formError['emptyFormUpdate'] : '' ?></p>
        </div>
    <?php } ?>
    <?php if (!empty($formSuccess)) { ?>
        <div class="alert-success">
            <p class="text-center h4"><?= !empty($formSuccess['createSubCategory']) ? $formSuccess['createSubCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['updateSubCategory']) ? $formSuccess['updateSubCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['deleteSubCategory']) ? $formSuccess['deleteSubCategory'] : '' ?></p>
        </div>
    <?php } ?>
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
                            <button type="button" name="updateSubCategory" class="displayForm formBtn" id="<?= $subCategory->id; ?>" title="Modifier une sous catégorie"><i class="far fa-edit"></i></button>
                            <button type="submit" name="deleteSubCategory" class="formBtn" id="deleteSubCategory" title="Supprimer une sous catégorie" onclick="return confirm('La suppression de la sous-catégorie ainsi que tout ce qui est lié à celui-ci est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                            <input type="hidden" name="idSubCategory" value="<?= $subCategory->id ?>" />
                        </form>
                        <div class="divForum well col-lg-6" id="divForum<?= $subCategory->id; ?>">
                            <form method="post" action="">
                                <input type="hidden" name="idSubCategory" value="<?= $subCategory->id ?>" />
                                <input type="text" name="name" class="form-control" placeholder="Titre de la sous-catégorie" />
                                <textarea name="description" class="form-control" placeholder="Description de la sous-catégorie"></textarea>
                                <input type="submit" name="submitUpdate" value="Valider la sous-catégorie"/>
                            </form>
                        </div>
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
include 'footer.php';

