<?php
global $isLogged;
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

    <section class="">

    <h1>Discover our plans</h1>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card pricing-card">
                    <div class="card-title">
                        <h1>Free</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list">
                            <li>Maximum server count: <b>3</b></li>   
                            <li>Maximum module count: <b>5</b></li>   
                        </ul>
                        <a href="" class="btn btn-secondary btn-disabled">Included</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card pricing-card">
                    <div class="card-title">
                        <h1>Premium</h1>
                    </div>
                    <div class="card-body">
                        <h4>Lifetime license</h4>
                        <ul class="list">
                            <li>Maximum server count: <b>Unlimited</b></li>   
                            <li>Maximum module count: <b>Unlimited</b></li>    
                        </ul>
                        <h3>267$</h3>
                        <a href="./subscribe" class="btn btn-primary">Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
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