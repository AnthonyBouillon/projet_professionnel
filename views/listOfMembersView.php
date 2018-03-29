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
        <div class="col-xs-6 col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Status</th>
                        <th scope="col">Profil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($readStatus as $listMembers) { ?>
                        <tr>
                            <td><?= $listMembers->username ?></td>
                            <td><?= $listMembers->rights ?></td>
                            <td><a href="profileMembersView.php?id=<?= $listMembers->id ?>"><i class="fas fa-user" title="Voir son profil"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>


<?php
include_once '../include/footer.php';
