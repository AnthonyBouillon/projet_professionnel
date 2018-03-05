<?php

$news = new news();
$users = new users();
if(isset($_SESSION['id'])){
$users->id = $_SESSION['id'];
}
$readUsers = $users->readUsers();
$regexTitle = '#^[\w\W]{1,60}$#';
$regexPlateform = '#^[\w\W]{1,30}$#';
$regexResume = '#^[\w\W]{1,500}$#';
$formError = array();
$formSuccess = array();
if (isset($_POST['submit'])) {
    if (!empty($_POST['title']) && !empty($_POST['plateform']) && !empty($_POST['resume']) && !empty($_POST['content']) && !empty($_FILES['picture'])) {
        $news->title = htmlspecialchars($_POST['title']);
        $news->plateform = htmlspecialchars($_POST['plateform']);
        $news->resume = htmlspecialchars($_POST['resume']);
        $news->content = htmlspecialchars($_POST['content']);
        if (!preg_match($regexTitle, $news->title)) {
            $formError['!regexTitle'] = 'Vous êtes limité à 60 caractères';
        }
        if (!preg_match($regexPlateform, $news->plateform)) {
            $formError['!regexPlateform'] = 'Vous êtes limité à 30 caractères';
        }
        if (!preg_match($regexResume, $news->resume)) {
            $formError['!regexResume'] = 'Vous êtes limité à 500 caractères';
        }
        $maxSize = 9000000;
        $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if ($_FILES['picture']['size'] <= $maxSize) {
            $extension = strtolower(substr(strrchr($_FILES['picture']['name'], '.'), 1));
        } else {
            $formError['bigFormat'] = 'Votre photo de profil ne doit pas dépasser 80 mo';
        }
        if (in_array($extension, $validsExtensions)) {
            $path = '../news/images/' . $users->id . '.' . $users->extension;
            $news->picture = $users->id . '.' . $extension;
            $movement = move_uploaded_file($_FILES['picture']['tmp_name'], $path);
        } else {
            $formError['badFormat'] = 'Votre image doit être au format : jpg, jpeg, png ou gif';
        }
    } else {
        $formError['empty'] = 'Veuillez remplir tous les champs';
    }
    if (count($formError) == 0) {
        $news->id = $_SESSION['id'];
        $news->addNews();
    }
}


