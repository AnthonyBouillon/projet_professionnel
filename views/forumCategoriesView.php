<?php
include '../models/database.php';
include '../models/forumCategories.php';
include '../controllers/forumCategoriesController.php';
$classBody = NULL;
$title = 'Forum';
include '../include/header.php';
?>
<div class="container containerForum">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Catégories</th>
                <th>Sous-catégories</th>
                <th>Dernières activités</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($getCategories as $category) { ?>
                <tr>
                    <td>
                        <a href="forumSubCategoriesView.php?id=<?= $category->id ?>" title="direction sous-catégorie de la catégorie"><?= $category->name ?></a><br/><?= $category->description ?><br/>

                        <form method="POST" action="">
                            <button type="button" name="updateCategory" id="addForum" title="Modifier une catégorie"><i class="far fa-edit"></i></button>
                            <button type="submit" name="deleteCategory" id="deleteCategory" title="Supprimer une catégorie"><i class="far fa-trash-alt"></i></button>
                            <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                        </form>
                        <div id=".divForum">
                            <form method="POST" action="">
                                <input type="text" name="name" class="form-control" placeholder="Titre de la catégorie" />
                                <textarea name="description" class="form-control" placeholder="Description de la catégorie"></textarea>
                                <input type="submit" name="submitUpdate" value="Modifier la categorie"/>
                                <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                            </form>
                        </div>
                    </td>
                    <td>74127</td>
                    <td>Dernier Sujet : L'époque du bastion<br/>Dernier message : 05/03/2018</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type="button" name="addCategory" id="addForum">Ajouter une catégorie</button>
    <div class="divForum">
        <form method="POST" action="">
            <input type="text" name="name" class="form-control" placeholder="Titre de la catégorie" />
            <textarea name="description" class="form-control" placeholder="Description de la catégorie"></textarea>
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
</style>
<?php
include '../include/footer.php';
