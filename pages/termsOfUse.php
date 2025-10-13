<?php
global $isLogged;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - Privacy Policy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/base/layout.css">
    <link rel="stylesheet" href="pages/css/base/legal.css">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar"> <a href="#" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#overview">Overview</a></li>
            <li><a href="#organisation">Organisation</a></li>
            <li><a href="./doc">Docs</a></li>
        </ul>
        <div class="nav-buttons"> <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?> <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary"><?= $isLogged ? "Dashboard" : "Get Started" ?></a> </div>
    </nav>
    <article class="privacy-container">
        <h1>Terms of Use</h1>
        <p><strong>Last updated:</strong> October 7, 2025</p>

        <p>Welcome to <strong>AstraCore</strong>, a SaaS platform designed to simplify and centralize Linux server management. By creating an account or using our service, you agree to these Terms of Use. Please read them carefully.</p>

        <h2>Overview</h2>
        <p>AstraCore (“we”, “us”, or “our”) provides a platform for managing Linux servers and executing remote commands through a centralized dashboard and a local receiver agent. These Terms govern your access to and use of our platform, website, and related services (collectively, the “Service”).</p>

        <h2>Eligibility and Accounts</h2>
        <p>You must be at least 16 years old to use AstraCore. When creating an account, you agree to:</p>
        <ul>
            <li>Provide accurate and up-to-date information.</li>
            <li>Keep your login credentials secure.</li>
            <li>Be fully responsible for all activity under your account.</li>
        </ul>
        <p>We reserve the right to suspend or terminate accounts that violate these Terms or pose a security risk.</p>

        <h2>Use of the Service</h2>
        <p>AstraCore allows you to execute remote commands and manage infrastructure across Linux systems. You agree <strong>not</strong> to use the Service for any unlawful or malicious purposes, including:</p>
        <ul>
            <li>Running commands that cause data loss or system damage.</li>
            <li>Attempting unauthorized access to other systems.</li>
            <li>Deploying malware, exploits, or any harmful software.</li>
        </ul>
        <p><strong>You are fully responsible for any commands executed through AstraCore.</strong> If you choose to run a destructive or misconfigured command (e.g. <code>sudo rm -rf /</code>), <strong>you accept all consequences</strong>. AstraCore and its developers cannot and will not be held liable for any damage, loss, or system failure resulting from user actions.</p>

        <h2>Service Availability and Limitations</h2>
        <p>We aim to provide reliable and continuous access, but we do not guarantee uptime, performance, or availability. The Service is provided “as is” without any warranty of any kind, either express or implied. We may update, suspend, or discontinue parts of the Service at any time.</p>

        <h2>Data and Privacy</h2>
        <p>We collect only the data necessary to operate the Service, such as your account information and authentication details. We <strong>do not</strong> collect, log, or analyze commands executed through your infrastructure. For more details, please refer to our <a href="privacy-policy">Privacy Policy</a>.</p>

        <h2>Intellectual Property</h2>
        <p>AstraCore, including all branding, software, and interface design, is owned by its creators (<strong>NeoTech and FauZa</strong>) unless otherwise stated. Users retain ownership of their own infrastructure, code, and configurations.</p>

        <h2>Limitation of Liability</h2>
        <p>To the maximum extent permitted by law:</p>
        <ul>
            <li>AstraCore and its developers shall <strong>not</strong> be liable for any direct, indirect, incidental, or consequential damages arising from the use or inability to use the Service.</li>
            <li>This includes (but is not limited to) loss of data, server downtime, damage caused by executed commands, or security breaches resulting from user negligence.</li>
        </ul>
        <p>Use AstraCore at your own risk. You are solely responsible for the commands you execute and their effects on your systems.</p>

        <h2>Termination</h2>
        <p>We may suspend or terminate your access to the Service if you violate these Terms or use the Service in a way that could harm others or disrupt our systems.</p>
        <p>You may delete your account at any time. Some residual data may remain in backups for a limited period.</p>

        <h2>Governing Law</h2>
        <p>These Terms are governed by and construed in accordance with the laws of <strong>Switzerland</strong>, without regard to its conflict of law principles. Any dispute arising under these Terms shall be subject to the exclusive jurisdiction of the courts of Switzerland.</p>

        <h2>Changes to These Terms</h2>
        <p>We may update these Terms from time to time. Any changes will be posted on this page with an updated “Last updated” date. Continued use of the Service after changes constitutes acceptance of the new Terms.</p>

        <h2>Contact</h2>
        <p>For questions or concerns about these Terms, contact us at:<br>
            <a href="mailto:support@astracore.io">support@astracore.cloud</a>
        </p>
    </article>
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

</html>