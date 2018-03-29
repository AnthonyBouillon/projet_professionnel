<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/admin.php';
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
                        <th scope="col">Modif status</th>
                        <th scope="col">Profil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($readUser as $listMembers) { ?>
                        <tr>
                            <td><?= $listMembers->username  ?></td>
                            <td><?= $listMembers->rights ?></td>
                            <td>
                                <form action="" method="POST" >
                                    <select name="updateRights">
                                        <?php foreach ($readStatus as $status) { ?>
                                            <option value="<?= $status->id ?>" <?= $listMembers->id_cuyn_admin == $status->id ? 'selected' : ''; ?>><?= $status->rights ?></option>
                                        <?php } ?>
                                            <input type="submit" name="submitUpdate" value="Valider" />
                                    </select>
                                </form>
                            </td>

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
