<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/profileMembersController.php';
$classBody = NULL;
$title = 'Liste des membres';
include_once '../include/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <h2 class="text-center bold">Administrateur</h2>
            <ol>
        <?php  foreach ($readStatus as $listMembers) {
                    if ($listMembers->id_cuyn_admin == 1) {  ?>
                <li><a href="profileMembersView.php?id=<?= $listMembers->id ?>"><?= $listMembers->username ?></a></li>
        <?php  } }  ?>
            </ol>
        </div>
        <div class="col-lg-3">
            <h2 class="text-center bold">Rédacteur</h2>
                   <ol>
        <?php  foreach ($readStatus as $listMembers) {
                    if ($listMembers->id_cuyn_admin == 2) {  ?>
                        <li><a href="profileMembersView.php?id=<?= $listMembers->id ?>"><?= $listMembers->username ?></a></li>
        <?php  } }  ?>
            </ol>
        </div>
        <div class="col-lg-3">
            <h2 class="text-center bold">Modérateur</h2>
                   <ol>
        <?php  foreach ($readStatus as $listMembers) {
                    if ($listMembers->id_cuyn_admin == 3) {  ?>
                        <li><a href="profileMembersView.php?id=<?= $listMembers->id ?>"><?= $listMembers->username ?></a></li>
        <?php  } }  ?>
            </ol>
        </div>
        <div class="col-lg-3">
            <h2 class="text-center bold">Utilisateur</h2>
                   <ol>
        <?php  foreach ($readStatus as $listMembers) {
                    if ($listMembers->id_cuyn_admin == 4) {  ?>
                        <li><a href="profileMembersView.php?id=<?= $listMembers->id ?>"><?= $listMembers->username ?></a></li>
        <?php  } }  ?>
            </ol>
        </div>
    </div>
</div>


<?php
include_once '../include/footer.php';
