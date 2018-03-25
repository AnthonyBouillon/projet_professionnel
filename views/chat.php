<?php
include_once '../configuration.php';
include_once '../models/database.php';
include_once '../models/users.php';
include_once '../models/chat.php';
include_once '../controllers/homeController.php';
?>

<?php foreach ($readMessages as $messages) { ?>
    <div class="well blocMessage">
        <p class="bold"><?= !empty($messages->username) ? $messages->username . ' à écrit ' : 'Visiteur' . ' à écrit '; ?> : </p>
        <p><?= wordwrap($messages->message, 20, ' ', 1); ?></p>
        <p>Date : <span class="bold"><?= $messages->date ?></span></p>
    </div>
<?php } ?>
