<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

// Check login
$isLogged = isset($_SESSION['user']);

$isLogged = false; // Si le client est connecté
//$_SESSION["id"] = 3;
if (isset($_SESSION["id"])) {
    $user = UserService::getUserById($_SESSION["id"]);

    $isLogged = !empty($user);
    echo $user->getUsername();
}
else {
    var_dump($_SESSION); 
}