<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - One Website. Thousands of Machines. Full Control.</title>
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="icon" type="image/png" href="pages/assets/favicon.png">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#overview">Overview</a></li>
            <li><a href="#organisation">Organisation</a></li>
            <li><a href="#docs">Docs</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="#" class="btn btn-ghost">Login</a>
            <a href="#" class="btn btn-primary">Get Started</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1>One Website. <br>Thousands of Machines. <br>Full Control.</h1>
            <p class="hero-subtitle">
                AstraCore is the next-generation SaaS platform for centralized Linux server management.
                Control your entire infrastructure from a single, powerful interface.
            </p>
            <div class="hero-buttons">
                <a href="#" class="btn btn-primary">Get Started</a>
                <a href="#" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="overview fade-in" id="overview">
        <h2 class="section-title">Why AstraCore?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0-4 0m2-6v4m0 4v8m7.557-5.255A2 2 0 1 0 12 18m0-14v10m0 4v2m4-13a2 2 0 1 0 4 0a2 2 0 0 0-4 0m2-3v1m0 4v4m2 8l2-2l-2-2m-3 0l-2 2l2 2" />
                    </svg></div>
                <h3>Centralized Control</h3>
                <p>Manage thousands of Linux machines from a single dashboard. No more SSH chaos, no more scattered configurations.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 13a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zm3-2V7a4 4 0 1 1 8 0v4m-1 5h.01m-3 0h.01m-3 0h.01" />
                    </svg></div>
                <h3>Secure by Design</h3>
                <p>Enterprise-grade security with end-to-end encryption, role-based access control, and comprehensive audit logs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                            <path d="m8 9l3 3l-3 3m5 0h3" />
                            <path d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </g>
                    </svg></div>
                <h3>Custom Commands</h3>
                <p>Create, deploy, and execute custom commands across your infrastructure with advanced scheduling and automation.</p>
            </div>
        </div>
    </section>

    <!-- Organisation Section -->
    <section class="organisation fade-in" id="organisation">
        <div class="org-content">
            <h2 class="section-title">Our Development Approach</h2>
            <p class="org-subtitle">
                Built with a modern, efficient, and low-level tech stack to guarantee optimal performance and unlock the full potential of your server.
            </p>
            <div class="team-cards">
                <div class="team-card">
                    <img class="team-avatar" src="https://api.fauza.dev/discord/pfp.php" alt="FauZa" draggable="false">
                    <h4>FauZa</h4>
                    <p>Full-Stack Developer, Co-Founder</p>
                </div>
                <div class="team-card">
                    <img class="team-avatar" src="https://cdn.maksym.ch/pfp" alt="NeoTech" draggable="false">
                    <h4>NeoTech</h4>
                    <p>Full-Stack Developer, Co-Founder</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta fade-in">
        <h2 class="cta-title">Ready to take control of your infrastructure?</h2>
        <a href="#" class="btn-beta">Connect my server</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Contact</a>
        </div>
        <p class="footer-copyright">&copy;<?= date("Y") ?> AstraCore.cloud</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="pages/js/home.js"></script>
</body>

</html>