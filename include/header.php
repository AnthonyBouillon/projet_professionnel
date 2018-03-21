<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Type d'encodage -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=1" /> 
        <meta name="description" content="Site communautaire de jeux vidéos" />
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../assets/lib/bootstrap/dist/css/bootstrap.min.css" />
        <!-- Font awesome -->
        <link rel="stylesheet" href="../assets/lib/fontawesome/css/font-awesome.min.css" />
        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/style.css" />
        <!-- Police -->
        <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One|Jura|Playfair+Display+SC|Press+Start+2P" rel="stylesheet" />
        <!-- ReCaptcha -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title><?= $title ?></title>
    </head>
    <body class="<?= $classBody ?>">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="../Accueil">APT</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="../Accueil">ACCUEIL</a></li>
                        <li><a href="../views/newsAllView.php">ACTUALITÉS</a></li>
                        <li><a href="../Catégorie-du-forum">FORUM</a></li>
                        <li><a href="../webTV">WEB TV</a></li>
                        <li><a href="https://discord.gg/vmXCWd5">DISCORD</a></li>
                    </ul>
                    <!-- Affiche un menu différent suivant si l'utilisateur est connecté ou non -->
                    <?php if (!isset($readUsers->id)) { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="../Inscription"><span class="glyphicon glyphicon-user"></span> INSCRIPTION</a></li>
                            <li><a href="../Connexion"><span class="glyphicon glyphicon-log-in"></span> CONNEXION</a></li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><img src="../members/avatars/<?= $readUsers->username . '/' . $readUsers->avatar; ?>" class="img-rounded avatarNav" /></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown"  href=""><?= $readUsers->username; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="Mon-profil">Mon profil</a></li>
                                    <li><a href="Modification-de-mon-profil">Modifier mon profil</a></li>
                                    <li><a href="Supprimer-mon-profil">Supprimer mon profil</a></li>
                                </ul>
                            </li>
                            <li><a href="Déconnexion" class="a_nav"><span class="glyphicon glyphicon-log-out"></span> DÉCONNEXION</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </nav>
