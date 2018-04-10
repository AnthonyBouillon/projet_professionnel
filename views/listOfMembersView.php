<?php
// crée une session ou restaure celle trouvée sur le serveur
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/admin.php';
include_once '../controllers/listOfMembersController.php';
// On assigne une classe à la balise body
$classBody = 'listOfMembersBackground';
// On assigne un titre à la balise title
$title = 'Liste des membres';
include_once 'header.php';
?>
<div class="container">
    <?php if (!empty($readStatus)) { ?>
        <h2 class="text-center margin titleStyle"><i class="fas fa-user"></i> Liste des membres</h2>
        <!-- Début du tableau -->
        <table class="table table-bordered h4">
            <!-- Titre du tableau -->
            <thead class="theadTable">
                <tr>
                    <th class="text-center">Pseudo</th>
                    <th class="text-center">Statut</th>
                    <!-- On vérifie si l'utilisateur à les droits suprême afin de lui afficher la modification de statut et la suppression de l'utilisateur -->
                    <?php if (!empty($_SESSION['id']) && $readUsers->id_cuyn_admin == 5 && $readUsers->id_cuyn_admin == 1) { ?>
                        <th class="text-center">Modifier le statut</th>
                        <th class="text-center">Supprimer l'utilisateur</th>
                    <?php } ?>
                    <th class="text-center">Profil</th>
                </tr>
            </thead>
            <!-- Corps du tableau -->
            <tbody class="tbodyTable">
                <!-- On parcourt le tableau afin d'afficher le pseudo et les droits -->
                <?php foreach ($readStatus as $listMembers) { ?>
                    <tr>
                        <td><?= $listMembers->username ?></td>
                        <td><?= $listMembers->rights ?></td>
                        <!-- On vérifie si l'utilisateur à les droits suprême afin de lui afficher la modification de statut et la suppression de l'utilisateur -->
                        <?php if (!empty($_SESSION['id']) && $readUsers->id_cuyn_admin == 5 && $readUsers->id_cuyn_admin == 1) { ?>
                            <td class="text-center">
                                <form action="" method="POST" >
                                    <select name="updateRights" class="btn btn-primary" >
                                        <option selected disabled>Choisissez un statut</option>
                                        <option value="1">Administrateur</option>
                                        <option value="2">Rédacteur</option>
                                        <option value="3">Modérateur</option>
                                        <option value="4">Utilisateur</option>
                                    </select>
                                    <!-- Champ permettant de récupérer l'id de l'utilisateur servant à la requête qui permet de modifier son statut -->
                                    <input type="hidden" name="id_user" value="<?= $listMembers->id_user; ?>" />
                                    <input type="submit" name="submitUpdate" class="btn btn-success" value="Valider" />
                                </form>
                            </td>
                            <td class="text-center">
                                <form method="POST" action="">
                                    <!-- Champ permettant de récupérer l'id de l'utilisateur servant à la requête qui permet de le supprimer -->
                                    <input type="hidden" name="id_user" value="<?= $listMembers->id_user; ?>" />
                                    <button type="submit" name="delete" class="btn btn-danger"  title="Supprimer l'utilisateur" onclick="return confirm('La suppression du compte est définitive, êtes-vous sûr de vouloir le supprimer ?')"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        <?php } ?>
                        <!-- Nous affichons l'id de chaque utilisateur afin qu'au clique on redirige l'utilisateur vers la page de son profil avec ses informations  -->
                        <td class="text-center"><a href="views/profileMembersView.php?id=<?= $listMembers->id_user ?>"><i class="fas fa-user" title="Voir son profil"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- Affichage si elles existent, les messages de succès ou d'erreur -->
        <?php if (!empty($success)) { ?>
            <div class="alert-success col-sm-offset-3 col-sm-6">
                <p class="text-center h4"><?= !empty($success['updateStatus']) ? $success['updateStatus'] : '' ?></p>
                <p class="text-center h4"><?= !empty($success['deleteUsers']) ? $success['deleteUsers'] : '' ?></p>
            </div>
            <?php }
        if (!empty($error)) { ?>
            <div class="alert-danger col-sm-offset-3 col-sm-6">
                <p class="text-center h4"><?= $error ?></p>
            </div>
            <?php
           }
    } else { ?>
        <h2 class="text-center margin titleStyle"><i class="fas fa-user"></i> Aucun membres n'est inscrit sur le site</h2>
   <?php } ?>
</div>
<?php
include_once 'footer.php';
