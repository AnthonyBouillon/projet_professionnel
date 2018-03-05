<?php

$users = new users();
$users->id = $_SESSION['id'];
$users->username = $_SESSION['username'];
$readUsers = $users->readUsers();