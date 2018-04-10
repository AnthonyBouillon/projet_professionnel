<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/forumCategories.php';
include_once '../models/forumSubCategories.php';
include_once '../controllers/forumCategoriesController.php';
// On assigne une classe à la balise body
$classBody = 'forumBackground';
// On assigne un titre à la balise title
$title = 'Forum';
include_once 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Platform Together</h2>
    <!-- Message d'erreur -->
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
    <!-- Message de succès -->
    <?php if (!empty($formSuccess)) { ?>
        <div class="alert-success">
            <p class="text-center h4"><?= !empty($formSuccess['createCategory']) ? $formSuccess['createCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['updateCategory']) ? $formSuccess['updateCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['deleteCategory']) ? $formSuccess['deleteCategory'] : '' ?></p>
        </div>
    <?php } ?>
    <!-- FORUM -->
    <table class="table tableForum table-bordered">
        <!-- En-tête du tableau -->
        <thead>
            <tr>
                <th>Catégories</th>
                <th>Sous-catégories</th>
                <th>Dernières activités</th>
            </tr>
        </thead>
        <!-- Corps du tableau -->
        <tbody  class="tbodyTable">
            <?php foreach ($readCategories as $category) { ?>
                <tr>
                    <td>
                        <!-- Nom de la catégorie | Lien direction sous-catégorie -->
                        <a href="views/forumSubCategoriesView.php?id=<?= $category->id ?>" title="direction sous-catégorie de la catégorie"><span class="uppercaseCategories"><?= $category->name ?></span></a>
                        <!-- Description de la sous-catégorie -->
                        <p><?= $category->description ?></p>
                        <!-- Si l'utilisateur est connecté et qu'il est Modérateur ou Master, on affiche ces boutons -->
                        <?php if (!empty($_SESSION['id'])) {
                            if ($readUsers->id_cuyn_admin == 3 || $readUsers->id_cuyn_admin == 5) {
                                ?>
                                <form method="POST" action="">
                                    <!-- Bouton modification d'une catégorie -->
                                    <button type="button" name="updateCategory" class="displayForm formBtn" title="Modifier une catégorie" id="<?= $category->id; ?>"><i class="far fa-edit"></i></button>
                                    <!-- Bouton suppression d'une catégorie -->
                                    <button type="submit" name="submitDelete"  class="formBtn" id="deleteCategory" title="Supprimer une catégorie" onclick="return confirm('La suppression de la catégorie ainsi que tout ce qui est lié à celui-ci est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                                    <!-- Champ récupération de l'id d'une catégorie -->
                                    <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                                </form>
                                <?php
                            }
                        }
                        ?>
                        <!-- Formulaire modification d'une catégorie -->
                        <div class="divForum well col-lg-6" id="divForum<?= $category->id ?>">
                            <form method="POST" action="">
                                <input type="text" name="name" class="form-control focusColor" placeholder="Titre de la catégorie" />
                                <textarea name="description" class="form-control focusColor" placeholder="Description de la catégorie"></textarea>
                                <input type="submit" name="submitUpdate" class="btn formBtn btn-block" value="Valider" />
                                <input type="hidden" name="idCategory" value="<?= $category->id ?>" />
                            </form>
                        </div>
                    </td>
                    <td></td>  
                    <td></td>
                </tr>
<?php } ?>
        </tbody>
    </table>
    <!-- Si l'utilisateur est connecté et qu'il est Modérateur ou Master, on affiche ce formulaire d'ajout de catégorie -->
    <?php if (!empty($_SESSION['id'])) {
        if ($readUsers->id_cuyn_admin == 3 || $readUsers->id_cuyn_admin == 5) {  ?>
            <div class="well col-lg-6">
                <h2 class="text-center">Ajouter une catégorie</h2>
                <form method="POST" action="">
                    <!-- Titre -->
                    <label for="name">Titre</label>
                    <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre de la catégorie" />
                    <!-- Description -->
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control focusColor" id="description" placeholder="Description de la catégorie"></textarea>
                    <!-- Valider la création d'une sous-catégorie -->
                    <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Valider" />
                </form>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php
include_once 'footer.php';
