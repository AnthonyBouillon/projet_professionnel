<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/admin.php';
include_once '../controllers/listOfMembersController.php';
$classBody = NULL;
$title = 'Liste des membres du site';
include_once 'header.php';
?>
<div class="container-fluid containerContact">
    <h2 class="text-center">Liste des membres</h2><hr/>
    <div class="col-xs-6 col-lg-12">
        <!-- Le tableau pour les utilisateurs sans droit comporte 3 colonnes : Pseudo, status , profil
         Le tableau pour les utilisateurs étant administrateur ou Master comporte une colonne en plus qui leurs permet de modifier un status d'un utilisateur -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Status</th>
                    <!-- Si l'utilisateur a les droits, on affiche la colonne affichant la modification d'un status -->
                    <?php
                    if (!empty($_SESSION['id'])) {
                        if ($readUsers->id_cuyn_admin == 1 || $readUsers->id_cuyn_admin == 5) {
                            ?>
                            <th scope="col">Modifier le status</th>
                            <?php
                        }
                    }
                    ?>
                    <th scope="col">Profil</th>
                </tr>
            </thead>
            <tbody>
                <!-- On parcours notre tableau afin d'afficher le pseudo, le status et l'id de tous les utilisateurs -->
                <?php foreach ($readStatus as $listMembers) { ?>
                    <tr>
                        <td><?= $listMembers->username ?></td>
                        <td><?= $listMembers->rights ?></td>
                        <!-- Si l'utilisateur a les droits, on affiche le select qui nous permet de modifier un status -->
                        <?php
                        if (!empty($_SESSION['id'])) {
                            if ($readUsers->id_cuyn_admin == 1 || $readUsers->id_cuyn_admin == 5) {
                                ?>
                                <td>
                                    <form action="" method="POST" >
                                        <select name="updateRights" class="btn formBtn">
                                            <option selected disabled>Choisissez le status</option>
                                            <option value="1">Administrateur</option>
                                            <option value="2">Rédacteur</option>
                                            <option value="3">Modérateur</option>
                                            <option value="4">Utilisateur</option>
                                            <input type="hidden" name="id_user" value="<?= $listMembers->id_user; ?>" />
                                            <input type="submit" name="submitUpdate" class="btn btn-success" value="Valider" />
                                        </select>
                                    </form>
                                </td>
                                <?php
                            }
                        }
                        ?>
                        <!-- Nous affichons l'id de chaque utilisateur afin qu'au clique on redirige l'utilisateur vers la page de son profil avec ses informations  -->
                        <td><a href="profileMembersView.php?id=<?= $listMembers->id_user ?>"><i class="fas fa-user" title="Voir son profil"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (!empty($success)) { ?>
            <div class="alert-success col-sm-offset-3 col-sm-6">
                <p class="text-center h4"><?= $success?></p>
            </div>
        <?php } ?>
        <?php if (!empty($error)) { ?>
            <div class="alert-danger col-sm-offset-3 col-sm-6">
                <p class="text-center h4"><?= $error ?></p>
            </div>
        <?php } ?>
    </div>
</div>
<?php
include_once 'footer.php';
