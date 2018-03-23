<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsAllController.php';
$classBody = 'newsBackground';
$title = 'Actualités';
include '../include/header.php';
?>
<div class="container">
    <?php if (!empty($checkArticle)) { ?>
        <!-- Titre de la page -->
        <div class="row test margin">
            <h2 class="text-center white">Toutes les actualités</h2>
        </div>
        <!-- Affiche tous les articles -->
        <?php foreach ($checkArticle as $articles) { ?>
            <div class="row">
                <div class="jumbotron col-lg-offset-3 col-lg-6 newAll">
                    <p class="col-lg-12"><img src="../news/images/<?=  $articles->picture; ?>" class="img-responsive centerImg"/></p>
                    <div class="col-lg-12">
                        <h2 class="text-center"><?= $articles->plateform; ?> | <?= $articles->title; ?></h2>
                        <p><?= $articles->resume; ?></p>
                        <p><a href="newView.php?id=<?= $articles->id ?>" class="btn btn-info bold">Voir l'article complet</a></p>
                        <p class="datePost h4 bold">Posté le :<?= $articles->date; ?></p>
                        <form method="POST" action="" class="editForm">
                            <input type="hidden" value="<?= $articles->id ?>" name="id" />
                            <?php if (isset($readUsers->id_cuyn_admin) && $readUsers->id_cuyn_admin == 1 && !empty($_SESSION['id'])) { ?>
                                <p class="h4"><a href="../admin/newsUpdateView.php?id=<?= $articles->id ?>" class="btn btn-success" >Modifier l'article</a> | 
                                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('La suppression de l\'article est définitive, êtes-vous sûr de vouloir le supprimer ?')"> Supprimer l'article</button></p>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <h2 class="text-center alert-danger">Cette page ne contient aucun article</h2>
    <?php } ?>
    <!-- PAGINATION -->
    <div class="row text-center">
        <?php
        for ($i = 1; $i <= $numberOfPages; $i++) {
            if ($i == $currentPage) {
                ?>
                <ul class="pagination">
                    <li><a href="newsAllView.php?id=<?= $i ?> " ><?= $i ?></a></li>
                </ul>
            <?php } else { ?>
                <ul class="pagination">
                    <li><a href="newsAllView.php?id=<?= $i ?> " class="paginationBtn"> <?= $i; ?></a></li>
                </ul>
                <?php
            }
        }
        ?>
    </div>
    <!-- /div container-fluid -->
</div>
<?php
include '../include/footer.php';
