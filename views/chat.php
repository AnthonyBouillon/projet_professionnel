<?php
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/chat.php';
include_once '../controllers/homeController.php';
/*
 * Nous parcourront dans notre tableau les 50 derniers messages de la base de données
 * Si le pseudo de l'utilisateur lié au message existent nous l'affichons,
 * sinon nous écrivons 'Visiteur' à la place
 */
 foreach ($readMessages as $messages) { ?>
    <div class="well blocMessage">
        <p class="bold"><?= !empty($messages->username) ? $messages->username . ' à écrit ' : 'Visiteur' . ' à écrit '; ?> : </p>
        <!-- Nous utilisons cette fonction afin d'ajouter un espace tous les 20 caractères pour le coté responsive -->
        <p><?= wordwrap($messages->message, 20, ' ', 1); ?></p>
        <!-- Nous affichons la date de création du message -->
        <p>Date : <span class="bold"><?= $messages->date ?></span></p>
    </div>
<?php } 
