<?php

require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

global $user;

if(!$_SESSION["userId"])
{
    header("Location: /login");
}

$error      = false;
$cardNumber = "";
$cardDate   = "";
$cardCvv    = "";
$cardHolder = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get card info
    $cardNumber = trim(filter_input(INPUT_POST, "card-number", FILTER_VALIDATE_INT));
    $cardDate   = trim(filter_input(INPUT_POST, "card-date",   FILTER_SANITIZE_SPECIAL_CHARS));
    $cardCvv    = trim(filter_input(INPUT_POST, "card-cvv",    FILTER_VALIDATE_INT));
    $cardHolder = trim(filter_input(INPUT_POST, "card-holder", FILTER_SANITIZE_SPECIAL_CHARS));

    // Check card info
    $error = empty($cardNumber) || empty($cardDate) || empty($cardCvv) || empty($cardHolder);


    if (!$error) {

        if(!$user)
        {

        }


    } else {
        new LogWarning("Failed payment attempt for user: $login", "AUTH");
        $error = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - Pricing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/base/layout.css">
    <link rel="stylesheet" href="pages/css/base/legal.css">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="stylesheet" href="pages/css/base/pricing.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar"> 
        <a href="/" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#overview">Overview</a></li>
            <li><a href="./download">Download</a></li>
            <li><a href="./doc">Docs</a></li>
            <li><a href="./pricing">Pricing</a></li>
        </ul>
        <div class="nav-buttons"> <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?> <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary"><?= $isLogged ? "Dashboard" : "Get Started" ?></a> </div>
    </nav>

    <!-- Payment form -->
    <section class="">
        <h1>Subscribe</h1>

        <div class="payment-card">
            <form class="subscribe-form" method="post">
                <div class="form-group">
                    <label class="form-label" for="card-number">Card number</label>
                    <input
                        type="number"
                        name="card-number"
                        id="card-number"
                        value=""
                        class="form-input"
                        placeholder="xxxx xxxx xxxx xxxx"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card-date">Expiration Date</label>
                    <input
                        type="text"
                        name="card-date"
                        id="card-date"
                        value=""
                        class="form-input"
                        placeholder="12/30"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card-cvv">CVV</label>
                    <input
                        type="text"
                        name="card-cvv"
                        id="card-cvv"
                        value=""
                        class="form-input"
                        placeholder="12/30"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card-holder">Cardholder name</label>
                    <input
                        type="text"
                        name="card-holder"
                        id="card-holder"
                        value=""
                        class="form-input"
                        placeholder="John Doe"
                        required>
                </div>

                <input type="submit" value="Pay" class="btn btn-primary ">
            </form>
        </div>
        

    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">

                <!-- Center Content -->
                <div class="col-md-8 offset-md-2 text-center">
                    <div class="footer-links d-flex justify-content-center gap-3 flex-wrap mb-2">
                        <a href="privacy-policy">Privacy</a>
                        <a href="terms-of-use">Terms</a>
                        <a href="mailto:support@astracore.cloud">Contact</a>
                    </div>
                    <div class="footer-copyright">
                        &copy; <?= date("Y") == "2025" ? date("Y") :  "2025 - " . date("Y"); ?> AstraCore.cloud - All rights reserved
                    </div>
                </div>

                <!-- Right GitHub Link -->
                <div class="col-md-2 text-center text-md-end mt-3 mt-md-0">
                    <a href="https://github.com/Res-NeoTech/astracore_receiver" target="_blank" class="github-link text-decoration-none">
                        <i class="bi bi-github"></i> Open Source
                    </a>
                </div>

            </div>
        </div>
    </footer>
</body>