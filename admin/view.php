<?php
// Démarre la session
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
// Attribut une classe à la balise body
$classBody = NULL;
// Attribut un titre à la balise title
$title = 'Partie administrateur';
include '../include/header.php';
$users = new users();
$readUsers = $users->readAllUsers();
?>
<div class="container">
    <h2 class="text-center">Partie adminitrateur</h2>


    <div class="row">
        <div class="col-lg-6">
            <h2 class="text-center">Utilisateur : </h2>
            <ol>
                
                <?php foreach($readUsers as $allUsers){ ?>
                <li><?= $allUsers->username ?></li>
                <?php }  ?>
            </ol>
        </div>

        <div class="col-lg-6">
            <h2 class="text-center">Admin : </h2>
            <ol>
                <li>NOM</li>
                <li>NOM</li>
                <li>NOM</li>
                <li>NOM</li>
                <li>NOM</li>
            </ol>
        </div>
    </div>
</div>
<?php
include '../include/footer.php';
