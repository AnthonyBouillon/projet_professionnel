<?php
session_start();
include_once '../configuration.php';
include '../models/database.php';
include_once '../models/users.php';
include '../models/forumCategories.php';
include '../controllers/forumCategoriesController.php';
$classBody = NULL;
$title = 'Forum';
include '../include/header.php';
?>
<div class="container containerForum">
    <h2>Bienvenue sur le forum de All Plateform Together</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Catégories</th>
                <th>Sous-catégories</th>
                <th>Dernières activités</th>
            </tr>
        </thead>
        <tbody>
        <p class="alert-danger text-center"><?= !empty($formError['badRegexUpdateName']) ? $formError['badRegexUpdateName'] : '' ?></p>
        <p class="alert-danger text-center"><?= !empty($formError['badRegexUpdateDescription']) ? $formError['badRegexUpdateDescription'] : '' ?></p>
        <p class="alert-danger text-center"><?= !empty($formError['emptyFormUpdate']) ? $formError['emptyFormUpdate'] : '' ?></p>
        <p class="alert-success text-center"><?= !empty($formSuccess['updateCategory']) ? $formSuccess['updateCategory'] : '' ?></p>
        <p class="alert-success text-center"><?= !empty($formSuccess['deleteCategory']) ? $formSuccess['deleteCategory'] : '' ?></p>
        <?php foreach ($getCategories as $category) { ?>
            <tr>
                <td>

                    <a href="forumSubCategoriesView.php?id=<?= $category->id ?>" title="direction sous-catégorie de la catégorie"><span class="uppercaseCategories"><?= $category->name ?></span></a><br/><?= $category->description ?><br/>
                    <?php if (isset($_SESSION['id']) && $_SESSION['id'] == 2) { ?>
                        <form method="POST" action="">
                            <button type="button" name="updateCategory" class="displayForm formBtn" title="Modifier une catégorie" id="<?= $category->id; ?>"><i class="far fa-edit"></i></button>
                            <button type="submit" name="submitDelete"  class="formBtn" id="deleteCategory" title="Supprimer une catégorie" onclick="return confirm('La suppression de la catégorie ainsi que tout ce qui est lié à celui-ci est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                            <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                        </form>
                    <?php } ?>

                    <div class="divForum well col-lg-6" id="divForum<?= $category->id; ?>">
                        <form method="POST" action="">
                            <input type="text" name="name" class="form-control focusColor" placeholder="Titre de la catégorie" />
                            <textarea name="description" class="form-control focusColor" placeholder="Description de la catégorie"></textarea>
                            <input type="submit" name="submitUpdate" class="btn formBtn btn-block" value="Modifier la categorie"/>
                            <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                        </form>
                    </div>
                </td>
                <td class="text-center"></td>  
                <td></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <?php if (isset($_SESSION['id']) && $_SESSION['id'] == 2) { ?>
        <div class="well col-lg-6">
            <h2 class="text-center">Ajouter une catégorie</h2>
            <p class="alert-danger text-center"><?= !empty($formError['badRegexName']) ? $formError['badRegexName'] : '' ?></p>
            <p class="alert-danger text-center"><?= !empty($formError['badRegexDescription']) ? $formError['badRegexDescription'] : '' ?></p>
            <p class="alert-danger text-center"><?= !empty($formError['emptyForm']) ? $formError['emptyForm'] : '' ?></p>
            <p class="alert-success text-center"><?= !empty($formSuccess['createCategory']) ? $formSuccess['createCategory'] : '' ?></p>
            <form method="POST" action="">
                <div class="col-lg-12">
                    <label for="name">Titre</label>
                    <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre de la catégorie" />
                </div>
                <div class="col-lg-12">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control focusColor" id="description" placeholder="Description de la catégorie"></textarea>
                </div>
                <div class="col-lg-12">
                    <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Créer la catégorie"/>
                </div>
            </form>
        </div>
    <?php } ?>
</div>
<style>
    .containerForum{
        margin-top: 5%;
    }
    tr th{
        background-color: #A983BE;
    }
    td{
        padding: 20px!important;
    }
</style>
<?php
include '../include/footer.php';
