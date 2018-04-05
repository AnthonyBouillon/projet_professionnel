<?php
session_start();
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../controllers/navBarController.php';
$classBody = 'glossaryBackground';
$title = 'Glossaire';
include_once 'header.php';
?>
<div class="container-fluid">
    <div class="row">
        <h2 class="text-center margin"><i class="fas fa-book"></i> Glossaire</h2>
    </div>
    <div class="row center-block">
        <table class="table table-bordered h4">
            <thead class="theadTable">
                <tr>
                    <th>Mot</th>
                    <th>Définition</th>
                </tr>
            </thead>
            <tbody>
                <tr class="info">
                    <td class="bold">All Platform Together</td>
                    <td>Acronyme A.P.T est de l'anglais qui signifie Toutes Plateformes Réunis en français.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php
include_once 'footer.php';
