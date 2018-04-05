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
<div class="container">
    <div class="row">
        <h2 class="text-center titleStyle"><i class="fas fa-book"></i> Glossaire</h2>
    </div>
    <div class="row">
        <table class="table table-bordered h4">
            <thead class="theadTable">
                <tr>
                    <th class="text-center">Mot</th>
                    <th class="text-center">Définition</th>
                </tr>
            </thead>
            <tbody class="tbodyTable">
                <tr>
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
