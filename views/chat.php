<?php
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/chat.php';
include_once '../controllers/homeController.php';
/*
 * Nous vérifions que notre tableau n'est pas vide
 * ensuite nous parcouront notre tableau afin d'afficher le pseudo, le message et la date de l'utilisateur ou du visiteur
 * Si le tchat ne contient aucun message, on le stipule au utilisateur
 */
if ($readMessages != NULL) {
    foreach ($readMessages as $messages) {
        ?>
        <div class="well blocMessage">
            <!-- Si le message n'est pas lié à un pseudo, on affiche "Visiteur" à la place -->
            <p class="bold"><?= !empty($messages->username) ? $messages->username . ' à écrit ' : 'Visiteur' . ' à écrit '; ?> : </p>
            <!-- Nous utilisons cette fonction afin d'ajouter un espace tous les 20 caractères pour le coté responsive -->
            <p><?= wordwrap($messages->message, 20, ' ', 1); ?></p>
            <!-- Nous affichons la date de création du message -->
            <p>Date : <span class="bold"><?= $messages->date ?></span></p>
        </div>
        <?php
    }
} else {
    ?>
    <div class="well blocMessage">
        <p class="bold text-center">Le tchat ne contient aucun message</p>
    </div>
    <?php
}
