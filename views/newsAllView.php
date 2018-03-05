<?php
session_start();
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsAllController.php';
$classBody = NULL;
$title = 'Toutes les actualités';
include '../include/header.php';
?>
<div class="container containerNewsAll">
    <p class="text-center"><a href="../admin/newsWritingView.php">Ajouter un article</a></p>
    <?php if (!empty($checkArticle)) { ?>
        <!-- Titre de la page -->
        <h2 class="text-center jumbotron">Toutes les actualités du site</h2>
        <div class="row">
            <!-- Barre de recherche -->
            <form class="navbar-form" method="POST" action="">
                <!-- Barre de recherche d'actualités -->
                <div class="col-xs-8 col-sm-offset-3 col-sm-6 col-md-10 col-lg-offset-4 col-lg-6 searchBar">
                    <input type="search" class="form-control" name="search" id="search" placeholder="Faite votre recherche">
                    <button type="submit" name="submit" class="btn btn-primary" id="searchBtn" title="Rechercher"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <!-- Affiche tous les articles -->
        <?php foreach ($checkArticle as $articles) { ?>
            <div class="row">
                <div class="well col-lg-offset-3 col-lg-6">
                    <!-- Image de l'article -->
                    <p class="col-lg-12"><img src="../news/images/<?= $articles->picture; ?>" class="img-responsive centerImg"/></p>
                    <div class="card-body col-lg-12">
                        <!-- Nom de la plateform + le titre de l'article -->
                        <h2 class="card-title"><?= $articles->plateform; ?> <?= $articles->title; ?></h2>
                        <!-- Résumer de l'article -->
                        <p class="card-text"><?= $articles->resume; ?></p>
                        <!-- Lien afin de voir l'article complet -->
                        <a href="newView.php?id=<?= $articles->id ?>" class="btn btn-info">Voir l'article complet</a>
                        <!-- Date de l'article -->
                        <p class="datePost h4">Posté le :<?= $articles->date; ?></p>
                        <form method="POST" action="" class="editForm">
                            <input type="hidden" value="<?= $articles->id ?>" name="id" />
                            <p class="h4"><button type="submit" name="update" class="btn btn-primary">Modifier l'article</button> | <button type="submit" name="delete" class="btn btn-danger"> Supprimer l'article</button></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <!-- Si il n'y a pas d'article -->
        <h2 class="text-center alert-danger">Cette page ne contient aucun article</h2>
<?php } ?>

    <!-- PAGINATION -->
    <div class="row text-center">
        <?php
        for ($i = 1; $i <= $numberOfPages; $i++) {
            if ($i == $currentPage) {
                ?>
                <ul class="pagination">
                    <li><a href="" ><?= $i ?></a></li>
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
