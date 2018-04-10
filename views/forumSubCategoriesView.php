<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/forumSubCategories.php';
include_once '../controllers/forumSubCategoriesController.php';
// On assigne une classe à la balise body
$classBody = 'forumBackground';
// On assigne un titre à la balise title
$title = 'Forum sous-catégories';
include_once 'header.php';
?>
<div class="container">
    <h2 class="text-center titleStyle">Bienvenue sur le forum de All Plateform Together</h2>
    <p><a href="../Catégorie-du-forum">Revenir à la liste des catégories</a></p>
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
            <p class="text-center h4"><?= !empty($formSuccess['createSubCategory']) ? $formSuccess['createSubCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['updateSubCategory']) ? $formSuccess['updateSubCategory'] : '' ?></p>
            <p class="text-center h4"><?= !empty($formSuccess['deleteSubCategory']) ? $formSuccess['deleteSubCategory'] : '' ?></p>
        </div>
    <?php } ?>
    <table class="table table-bordered"> 
        <!-- En-tête du tableau -->
        <thead> 
            <tr> 
                <th>Sous-catégories</th> 
                <th>Topics</th> 
                <th>Dernières activités</th> 
            </tr> 
        </thead> 
        <!-- Corps du tableau -->
        <tbody class="tbodyTable">
            <?php foreach ($readSubCategories as $subCategory) { ?>
                <tr> 
                    <td>
                        <a href="forumTopicsView.php?id=<?= $subCategory->id ?>" title="direction vers les posts des utilisateurs"><?= $subCategory->name ?></a><br/><?= $subCategory->description ?><br/>
                        <!-- Si l'utilisateur est connecté et qu'il est Modérateur ou Master, on affiche ces boutons -->
                        <?php if (!empty($_SESSION['id'])) {
                            if ($readUsers->id_cuyn_admin == 3 || $readUsers->id_cuyn_admin == 5) {  ?>
                                <form method="POST" action="">
                                    <!-- Modification d'une sous-catégorie -->
                                    <button type="button" name="updateSubCategory" class="displayForm formBtn" id="<?= $subCategory->id; ?>" title="Modifier une sous catégorie"><i class="far fa-edit"></i></button>
                                    <!-- Suppression d'une sous-catégorie -->
                                    <button type="submit" name="deleteSubCategory" class="formBtn" id="deleteSubCategory" title="Supprimer une sous catégorie" onclick="return confirm('La suppression de la sous-catégorie ainsi que tout ce qui est lié à celui-ci est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                                    <!-- Champ récupération de l'id d'une sous-catégorie -->
                                    <input type="hidden" name="idSubCategory" value="<?= $subCategory->id ?>" />
                                </form>
                                <?php
                            }
                        }
                        ?>
                          <!-- Formulaire modification d'une sous-catégorie -->
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
    <!-- Si l'utilisateur est connecté et qu'il est Modérateur ou Master, on affiche ce formulaire d'ajout de sous-catégorie -->
    <?php  if (!empty($_SESSION['id'])) {
        if ($readUsers->id_cuyn_admin == 3 || $readUsers->id_cuyn_admin == 5) {  ?>
            <div class="well col-lg-6">
                <h2 class="text-center">Ajouter une sous-catégorie</h2>
                <div class="col-lg-12">
                    <form method="post" action="">
                        <label for="name">Titre </label>
                        <input type="text" name="name" class="form-control focusColor" id="name" placeholder="Titre de la sous-catégorie" />
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control focusColor" id="description" placeholder="Description de la sous-catégorie"></textarea>
                        <input type="submit" name="submitCreate" class="btn formBtn btn-block" value="Valider la sous-catégorie"/>
                    </form>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php
include_once 'footer.php';

