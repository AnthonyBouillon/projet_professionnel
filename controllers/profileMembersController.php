
<?php
$users = new users();
if (isset($_SESSION['id'])) {
    $users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
if (isset($_GET['id'])) {
    $readProfile = $users->readProfile();
    var_dump($_GET['id']);
}
