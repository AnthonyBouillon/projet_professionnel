<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/admin.php';
include_once '../controllers/listOfMembersController.php';
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
                        <th scope="col">Modifier le status</th>
                        <th scope="col">Profil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($readStatus as $listMembers) { ?>
                        <tr>
                            <td><?= $listMembers->username . $listMembers->id_admin ?></td>
                            <td><?= $listMembers->rights ?></td>
                            <td>
                                <form action="" method="POST" >
                                    <select name="updateRights">
                                            <option>Choisissez le status</option>
                                            <option value="1">Administrateur</option>
                                            <option value="2">Rédacteur</option>
                                            <option value="3">Modérateur</option>
                                            <option value="4">Utilisateur</option>
                                            <input type="hidden" name="id_user" value="<?= $listMembers->id_user; ?>" />
                                            <input type="submit" name="submitUpdate" value="Valider" />
                                    </select>
                                </form>
                            </td>
                            <td><a href="profileMembersView.php?id=<?= $listMembers->id_user ?>"><i class="fas fa-user" title="Voir son profil"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php
include_once '../include/footer.php';
