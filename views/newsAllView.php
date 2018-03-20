<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsAllController.php';
$classBody = NULL;
$title = 'Actualités';
include '../include/header.php';
?>
<div class="container containerNewsAll">
    <?php if (!empty($checkArticle)) { ?>
        <!-- Titre de la page -->
        <h2 class="text-center jumbotron">Toutes les actualités du site</h2>
        <?php if (isset($users->id) && $users->id == 2) { ?>
            <p class="text-center"><a href="../admin/newsWritingView.php" class="btn formBtn">Ajouter un article</a></p>
        <?php } ?>
        <form class="navbar-form" method="POST" action="">
            <div class="col-xs-8 col-sm-offset-3 col-sm-6 col-md-10  col-lg-12 searchBar">
                <label for="search">Écrivez l'article rechercher : </label>
                <input type="search" class="form-control" name="search" id="search" placeholder="Faite votre recherche">
                <button type="submit" name="submit" class="btn btn-primary focusColor" id="searchBtn" title="Rechercher"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Affiche tous les articles -->
        <?php foreach ($checkArticle as $articles) { ?>
            <div class="row">
                <div class="well col-lg-offset-3 col-lg-6">
                    <p class="col-lg-12"><img src="../news/images/<?= $articles->picture; ?>" class="img-responsive centerImg"/></p>
                    <div class="col-lg-12">
                        <h2 class="text-center"><?= $articles->plateform; ?> | <?= $articles->title; ?></h2>
                        <p><?= $articles->resume; ?></p>
                        <p><a href="views/newView.php?id=<?= $articles->id ?>" class="btn btn-info bold">Voir l'article complet</a></p>
                        <p class="datePost h4 bold">Posté le :<?= $articles->date; ?></p>
                        <form method="POST" action="" class="editForm">
                            <input type="hidden" value="<?= $articles->id ?>" name="id" />
                            <?php if (isset($users->id) && $users->id == 2) { ?>
                                <p class="h4"><a href="../admin/newsUpdateView.php?id=<?= $articles->id ?>" class="btn btn-primary" >Modifier l'article</a> | 
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
