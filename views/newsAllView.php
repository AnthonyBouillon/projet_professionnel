<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsAllController.php';
$classBody = 'newsBackground';
$title = 'Actualités';
include_once 'header.php';
?>
<div class="container">
    <div class="row margin">
        <!-- Si notre tableau contient des articles, nous affichons cette vue -->
        <?php if (!empty($readArticle)) { ?>
            <h2 class="text-center white">Toutes les actualités</h2>
            <!-- Lien qui redirige  vers la page d'ajout d'article -->
            <div class="row">
                <p class="text-center"><a href="../Rédaction_d'article" class="btn btn-success black">Ajouter un nouvel article</a></p>
            </div>
            <!-- Si la page contient un message personnalisé, la div + le message qu'il contient s'afficherons -->
            <?php if (!empty($error)) { ?>
                <div class="alert-danger col-lg-offset-3 col-lg-6">
                    <p class="bold text-center"><?= !empty($error['!deleteNew']) ? $error['!deleteNew'] : '' ?></p>
                </div>
            <?php  }
                if (!empty($success)) { ?>
                <div class="alert-success col-lg-offset-3 col-lg-6">
                    <p class="bold text-center"><?= !empty($success['deleteNew']) ? $success['deleteNew'] : '' ?></p>
                </div>
            <?php } ?>
        </div>
        <!-- On parcours notre tableau afin d'afficher les éléments dont on a besoin -->
        <?php foreach ($readArticle as $articles) { ?> 
            <div class="row">
                <div class="col-lg-offset-3 col-lg-6 newAll">
                    <!-- On récupère l'image de l'article en indiquant le chemin et le nom de l'image -->
                    <p class="col-lg-12 text-center"><img src="../news/images/<?= $articles->picture; ?>" class="img-responsive img-thumbnail"/></p>
                    <div class="col-lg-12">
                        <!-- On affiche le nom de la plateforme et le titre de l'article -->
                        <h2 class="text-center"><?= $articles->plateform; ?> | <?= $articles->title; ?></h2>
                        <!-- On affiche le résumé de l'article -->
                        <p><?= $articles->resume; ?></p>
                        <!-- On affiche l'id de l'article afin de redigiré vers la même page et le même article mais plus complet -->
                        <p><a href="views/newView.php?id=<?= $articles->id ?>" class="btn btn-info bold">Voir l'article complet</a></p>
                        <!-- On affiche la date de la création de l'article -->
                        <p class="datePost h4 bold">Posté le :<?= $articles->date; ?></p>
                        <form method="POST" action="" class="editForm">
                            <!-- Ce champ nous permet de récupérer l'id de l'article -->
                            <input type="hidden" value="<?= $articles->id ?>" name="id_new" />
                            <!-- Lien redirigeant vers la page qui permet de modifier l'article  et un bouton de type submit qui permet de supprimer l'article-->
                            <p class="h4"><a href="../Modification_d'article?id=<?= $articles->id ?>" class="btn btn-success" >Modifier l'article</a> | <button type="submit" name="submitDelete" class="btn btn-danger" onclick="return confirm('La suppression de l\'article est définitive, êtes-vous sûr de vouloir le supprimer ?')">Supprimer l'article</button></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row text-center">
            <?php
            /*
             * Tant que le nombre est inférieur ou égale au nombre de page total,
             * on incrémente
             * Donc sur la page actuel on affiche notre lien avec le lien de la page
             * Sinon on affiche les autres liens pour les autres pages
             * Ce qui fait une pagination complète
             */
            for ($i = 1; $i <= $numberOfPages; $i++) {
                if ($i == $currentPage) { ?>
                    <ul class="pagination">
                        <li><a href="../Toutes-les-actualités?id=<?= $i ?> " ><?= $i ?></a></li>
                    </ul>
                <?php } else { ?>
                    <ul class="pagination">
                        <li><a href="../Toutes-les-actualités?id=<?= $i ?> " class="paginationBtn"> <?= $i; ?></a></li>
                    </ul>
                    <?php
                }
            }
            ?>
        </div>
        <!-- Si la page ne contient aucun article, affiche cette vue -->
    <?php } else { ?>
        <h2 class="text-center alert-danger">Cette page ne contient aucun article</h2>
        <p class="text-center"><a href="../admin/newsWritingView.php" class="btn btn-success black">Ajouter un article</a></p>
            <!-- Si la page contient un message personnalisé, la div + le message qu'il contient s'afficherons -->
            <?php if (!empty($error)) { ?>
                <div class="alert-danger col-lg-offset-3 col-lg-6">
                    <p class="bold text-center"><?= !empty($error['!deleteNew']) ? $error['!deleteNew'] : '' ?></p>
                </div>
            <?php  }
                if (!empty($success)) { ?>
                <div class="alert-success col-lg-offset-3 col-lg-6">
                    <p class="bold text-center"><?= !empty($success['deleteNew']) ? $success['deleteNew'] : '' ?></p>
                </div>
            <?php }
     } ?>
</div>
<?php
include_once 'footer.php';
