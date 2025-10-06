<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";
require_once "class/utils/logger/LogError.php";
require_once "class/utils/logger/LogSuccess.php";

$isLogged = false;

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}

$jsonChangelog = file_get_contents("/home/fauza/web/astracore/changelog.json");
$changelog = json_decode($jsonChangelog, true);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - One Website. Thousands of Machines. Full Control.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="doc">Docs</a></li>
            <li><a href="doc#changelog">Changelog</a></li>
            <li><a href="mailto:support@astracore.cloud">Contact</a></li>
        </ul>
        <div class="nav-buttons">
            <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?>
            <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary">
                <?= $isLogged ? "Dashboard" : "Get Started" ?>
            </a>
        </div>
    </nav>

    <!-- Hero / Docs Header -->
    <section class="hero d-flex flex-column justify-content-center text-center">
        <div class="hero-bg"></div>
        <div class="hero-content container">
            <h1>Documentation & Release Notes</h1>
            <p class="hero-subtitle">
                Stay up-to-date with the latest features, improvements, and bug fixes for AstraCore.
                Browse the docs to understand how to get the most out of the platform.
            </p>
        </div>
    </section>

    <!-- Documentation / Changelog -->
    <section id="docs" class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">📖 Documentation</h2>

            <div class="accordion" id="docsAccordion">

                <!-- Getting Started -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSetup">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetup">
                            Getting Started
                        </button>
                    </h2>
                    <div id="collapseSetup" class="accordion-collapse collapse show" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            <h5>1. Installation & First Run</h5>
                            <ul>
                                <li>Download and run the program.</li>
                                <li>If a <code>.env</code> file does not exist:
                                    <ul>
                                        <li>The program generates a unique authentication token.</li>
                                        <li>The token is saved in <code>.env</code> and displayed in the terminal.</li>
                                        <li><strong>Important:</strong> Copy and keep the token safe!</li>
                                        <li>Restart the program so the settings apply.</li>
                                    </ul>
                                </li>
                            </ul>

                            <h5>2. Configuration</h5>
                            <ul>
                                <li><strong>Port:</strong> Default is <code>6769</code>.</li>
                                <li><strong>Authentication Token:</strong> Stored as <code>ASTRA_TOKEN</code> in <code>.env</code>.</li>
                                <li><strong>Panel Integration:</strong> Insert the token into your AstraCore Panel.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- API Endpoints -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingAPI">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAPI">
                            API Endpoints
                        </button>
                    </h2>
                    <div id="collapseAPI" class="accordion-collapse collapse" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            <h5>1. Healthcheck</h5>
                            <p><strong>URL:</strong> <code>GET /</code></p>
                            <p><strong>Purpose:</strong> Confirms the server is running.</p>
                            <pre><code>curl http://127.0.0.1:6769/</code></pre>
                            <p><strong>Response:</strong> "AstraCore receiver script is healthy and running."</p>

                            <h5>2. Execute Command</h5>
                            <p><strong>URL:</strong> <code>POST /execute</code></p>
                            <p><strong>Authentication:</strong> Include header <code>x-astra-token</code> with your token.</p>
                            <p><strong>Payload:</strong></p>
                            <pre><code>{
  "syntax": "ls -la"
}</code></pre>
                            <p><strong>Example:</strong></p>
                            <pre><code>curl -X POST http://127.0.0.1:6769/execute \
  -H "x-astra-token: &lt;your_token&gt;" \
  -H "Content-Type: application/json" \
  -d '{"syntax":"ls -la"}'</code></pre>
                            <p><strong>Response:</strong> Output of the command (stdout or stderr).</p>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSecurity">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurity">
                            Security Features
                        </button>
                    </h2>
                    <div id="collapseSecurity" class="accordion-collapse collapse" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Do not share your token.</li>
                                <li>Only trusted users should have access.</li>
                                <li>Commands run with the permissions of the user running the receiver.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Error Handling -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingErrors">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseErrors">
                            Error Handling
                        </button>
                    </h2>
                    <div id="collapseErrors" class="accordion-collapse collapse" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Missing or wrong token: <code>401 Unauthorized</code></li>
                                <li>Missing command syntax: <code>400 Bad Request</code></li>
                                <li>Command fails: Returns the error output.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSummary">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSummary">
                            Summary
                        </button>
                    </h2>
                    <div id="collapseSummary" class="accordion-collapse collapse" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            <ol>
                                <li>Start the program. If <code>.env</code> is missing, copy the token and restart.</li>
                                <li>Use the healthcheck endpoint to verify the server is running.</li>
                                <li>Use the execute endpoint to run commands with the correct token.</li>
                                <li>Keep your token secure.</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Changelog Section -->
    <section id="changelog" class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">📝 Changelog</h2>
            <div class="row justify-content-center">
                <?php foreach ($changelog as $date => $improvements) { ?>
                    <div class="col-auto changelog-entry mb-4">
                        <h4><?= $date ?></h4>
                        <ul>
                            <?php foreach ($improvements as $improvement) { ?>
                                <li><?= $improvement ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">❓ FAQ</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 text-start">
                    <p><strong>Q: How do I connect my first server?</strong><br>
                        A: Simply install the AstraCore agent and use the dashboard to link it with your account.</p>
                    <p><strong>Q: Is my data encrypted?</strong><br>
                        A: Yes, we use end-to-end encryption for all communications between your servers and AstraCore.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <div class="footer-links mb-3 d-flex justify-content-center gap-3 flex-wrap">
                <a href="privacy-policy">Privacy</a>
                <a href="terms-of-use">Terms</a>
                <a href="mailto:support@astracore.cloud">Contact</a>
            </div>
            <div class="footer-copyright">
                &copy; <?= date("Y") ?> AstraCore.cloud - All rights reserved
            </div>
        </div>
    </footer>

    <style>
        .justify-content-center {
            display: flex;
            flex-direction: column;
            align-content: center;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>