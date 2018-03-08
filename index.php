<?php
session_start();
include_once 'models/database.php';
include_once 'models/users.php';
include_once 'models/chat.php';
include_once 'controllers/homeController.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=1" />
        <link rel="stylesheet" href="assets/lib/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/lib/fontawesome/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One|Jura|Playfair+Display+SC|Press+Start+2P" rel="stylesheet" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title>Accueil</title>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">APT</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">ACCUEIL</a></li>
                        <li><a href="views/newsAllView.php">ACTUALITÉS</a></li>
                        <li><a href="views/forumCategoriesView.php">FORUM</a></li>
                        <li><a href="#band">WEB TV</a></li>
                        <li><a href="https://discord.gg/StQbQ9">DISCORD</a></li>
                    </ul>
                    <!-- Affiche un menu différent suivant si l'utilisateur est connecté ou non -->
                    <?php if (!empty($_SESSION['id'])) { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><img src="members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="img-rounded avatarNav" /></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown"  href=""><?= $_SESSION['username']; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="views/profileView.php">Mon profil</a></li>
                                    <li><a href="views/profileUpdateView.php">Modifier mon profil</a></li>
                                    <li><a href="views/profileDeleteView.php">Supprimer mon profil</a></li>
                                </ul>
                            </li>
                            <li><a href="views/logoutView.php" class="a_nav"><span class="glyphicon glyphicon-log-out"></span> DÉCONNEXION</a></li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="views/registerView.php"><span class="glyphicon glyphicon-user"></span> INSCRIPTION</a></li>
                            <li><a href="views/loginView.php"><span class="glyphicon glyphicon-log-in"></span> CONNEXION</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <!-- Présentation -->
                <div class="col-md-6 col-lg-offset-1 col-lg-5 well well-info blocPresentation">
                    <div class="col-lg-offset-2 col-lg-8">
                        <h2 class="text-center titlePresentation">Présentation du site</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
                <!-- Tchat -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-offset-1 col-lg-4">
                    <h2 class="text-center titleChat">Salon de discussion</h2>
                    <p class="text-center h4 black"><?= !empty($formError['errorRegex']) ? $formError['errorRegex'] : ''; ?></p>
                    <p class="text-center h4 red"><?= !empty($formError['emptyMessage']) ? $formError['emptyMessage'] : ''; ?></p>
                    <!-- Tchat -->
                    <div class="receiveMessage" id="receiveMessage">
                        <?php foreach ($readMessages as $messages) { ?>
                            <p>
                                <span class="bold"><?= !empty($messages->username) ? $messages->username . ' à dit ' : 'Visiteur' . ' à dit '; ?> : </span>
                                <?= wordwrap($messages->message, 20, ' ', 1); ?>
                            </p>
                        <?php } ?>
                    </div>
                    <!--Valider -->
                    <form method="POST" action="">
                        <textarea class="form-control inputForm" name="message" id="message" placeholder="Écrivez votre message" required></textarea>
                        <button type="submit" class="form-control" name="submit" id="sendMessage">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <!--  Information -->
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                        <h3>Information</h3>
                        <ul>
                            <li><a href="Qui_sommes-nous?">Qui sommes-nous ?</a></li>
                            <li><a href="views/contactView.php">Me contacter via formulaire</a></li>
                        </ul>
                    </div>
                    <!-- Vous êtes perdu ? -->
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                        <h3>Vous êtes perdu ?</h3>
                        <ul>
                            <li><a href="glossary">Glossaire</a></li>
                            <li><a href="sitemap">Plan du site</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Les Script Jquery, Bootstrap, Font awesome et le script js -->
        <script src="assets/lib/jquery/dist/jquery.min.js"></script>
        <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        <script src="assets/js/script.js"></script>
    </body>
</html>
