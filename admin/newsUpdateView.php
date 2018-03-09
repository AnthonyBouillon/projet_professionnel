<?php
// Démarre la session
session_start();
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/news.php';
include_once '../controllers/newsUpdateController.php';
// Attribut une classe à la balise body
$classBody = NULL;
// Attribut un titre à la balise title
$title = 'Modification de l\'article';
include '../include/header.php';
?>
<div class="container containerNew">
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titre" /><br/>
        <input type="text" name="plateform" placeholder="Plateforme"  /><br/>
        <input type="text" name="resume" placeholder="Résumer"  /><br/>
        <input type="text" name="content" placeholder="Contenue"  /><br/>
        <input type="file" name="picture"  /><br/>
        <input type="submit" name="submit" />
    </form>
</div>
<?php
include '../include/footer.php';
