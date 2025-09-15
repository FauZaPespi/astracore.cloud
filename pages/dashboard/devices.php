<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

// Check login
$isLogged = isset($_SESSION['user']);

$isLogged = false; // Si le client est connecté
//$_SESSION["id"] = 3;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);

    if (empty($user)) {
        header("Location: ../");
    }
}