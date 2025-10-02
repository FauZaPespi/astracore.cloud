<?php
require_once __DIR__ . "/../../class/SessionHandler.php";
require_once __DIR__ . "/../../class/UserService.php";
require_once __DIR__ . "/../../class/User.php";

// Check if user is logged in (optional for download page)
$isLogged = isset($_SESSION["userId"]);
$user = null;

if ($isLogged) {
    $user = UserService::getUserById($_SESSION["userId"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download AstraCore Agent - AstraCore.cloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <link rel="stylesheet" href="pages/css/settings.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <!-- Grid Background -->
    <div class="grid-background"></div>

    <!-- Navigation -->
    <nav class="navbar"> <a href="#" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="/astracore/">Home</a></li>
            <li><a href="/astracore/download">Download</a></li>
            <li><a href="/astracore/#docs">Docs</a></li>
        </ul>
        <div class="nav-buttons"> <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?> <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary"><?= $isLogged ? "Dashboard" : "Get Started" ?></a> </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 100px; min-height: 100vh; background: var(--black);">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="row">
                <div class="col-12">
                    <div class="page-header mb-5 text-center">
                        <h1 class="page-title">
                            <i class="bi bi-download me-2"></i>
                            Download AstraCore Agent
                        </h1>
                        <p class="page-description">Get started with AstraCore by downloading the agent for your platform</p>
                    </div>

                    <!-- Download Cards -->
                    <div class="row justify-content-center">
                        <!-- Linux Download -->
                        <div class="col-lg-5 col-md-6 mb-4">
                            <div class="card download-card">
                                <div class="card-header text-center">
                                    <div class="platform-icon text-success mb-3">
                                        <img width="64" height="64" src="https://img.icons8.com/color/96/linux--v1.png" alt="linux--v1" />
                                    </div>
                                    <h3 class="card-title">Linux Agent</h3>
                                    <p class="card-subtitle text-white mb-0">Ubuntu, Debian, CentOS, Nyarch, and more...</p>
                                </div>
                                <div class="card-body">
                                    <div class="download-info mb-4">
                                        <div class="info-item">
                                            <i class="bi bi-cpu me-2 text-success"></i>
                                            <span>x86 Architecture</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="bi bi-hdd me-2 text-success"></i>
                                            <span>~50 MB Download</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="bi bi-check-circle me-2 text-success"></i>
                                            <span>Ready for Production</span>
                                        </div>
                                    </div>

                                    <div class="requirements mb-4">
                                        <h6 class="text-white mb-2">System Requirements:</h6>
                                        <ul class="text-white small">
                                            <li>Computer with a working Linux Kernel</li>
                                            <li>32-bit architecture</li>
                                            <li>512 MB RAM minimum</li>
                                            <li>50 MB disk space</li>
                                        </ul>
                                    </div>

                                    <a href="/astracore/download?platform=linux"
                                        class="btn btn-primary w-100 download-btn"
                                        data-platform="linux">
                                        <i class="bi bi-download me-2"></i>
                                        Download for Linux
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Windows Download -->
                        <div class="col-lg-5 col-md-6 mb-4">
                            <div class="card download-card">
                                <div class="card-header text-center">
                                    <div class="platform-icon text-primary mb-3">
                                        <i class="bi bi-windows"></i>
                                    </div>
                                    <h3 class="card-title">Windows Agent</h3>
                                    <p class="card-subtitle text-white mb-0">Windows 10, 11, Server 2019+</p>
                                </div>
                                <div class="card-body">
                                    <div class="download-info mb-4">
                                        <div class="info-item">
                                            <i class="bi bi-cpu me-2 text-warning"></i>
                                            <span>x86 Architecture</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="bi bi-hdd me-2 text-warning"></i>
                                            <span>~100 MB Download</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="bi bi-clock me-2 text-warning"></i>
                                            <span>Coming Soon</span>
                                        </div>
                                    </div>

                                    <div class="requirements mb-4">
                                        <h6 class="text-white mb-2">System Requirements:</h6>
                                        <ul class="text-white small">
                                            <li>Windows 10 or later</li>
                                            <li>64-bit architecture</li>
                                            <li>1 GB RAM minimum</li>
                                            <li>100 MB disk space</li>
                                        </ul>
                                    </div>

                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        <i class="bi bi-clock me-2"></i>
                                        Coming Soon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Installation Instructions -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        <i class="bi bi-terminal me-2"></i>
                                        Installation Instructions
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Linux Instructions -->
                                        <div class="col-lg-6 mb-4">
                                            <h5 class="text-success">
                                                <i class="bi bi-tux me-2"></i>
                                                Linux Installation
                                            </h5>

                                            <div class="instruction-step mb-3 text-white">
                                                <div class="step-content ">
                                                    <strong>Download the agent</strong>
                                                    <p>Click the download button above to get the Linux binary.</p>
                                                </div>
                                            </div>

                                            <div class="instruction-step mb-3 text-white">
                                                <div class="step-content">
                                                    <strong>Make it executable</strong>
                                                    <div class="code-block mt-2">
                                                        <code>chmod +x astracore</code>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="instruction-step mb-3 text-white">
                                                <div class="step-content">
                                                    <strong>Run the agent</strong>
                                                    <div class="code-block mt-2">
                                                        <code>./astracore --install</code>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="instruction-step text-white">
                                                <div class="step-content">
                                                    <strong>Copy the token</strong>
                                                    <p>Copy the generated token and add your device through the dashboard.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Windows Instructions -->
                                        <div class="col-lg-6 mb-4">
                                            <h5 class="text-warning">
                                                <i class="bi bi-windows me-2"></i>
                                                Windows Installation (Coming Soon)
                                            </h5>

                                            <div class="instruction-step mb-3 opacity-50 text-warning">
                                                <div class="step-content">
                                                    <strong>Download the installer</strong>
                                                    <p>Download the .exe installer from above.</p>
                                                </div>
                                            </div>

                                            <div class="instruction-step mb-3 opacity-50 text-warning">
                                                <div class="step-content">
                                                    <strong>Run as Administrator</strong>
                                                    <p>Right-click and select "Run as Administrator".</p>
                                                </div>
                                            </div>

                                            <div class="instruction-step mb-3 opacity-50 text-warning">
                                                <div class="step-content">
                                                    <strong>Follow the wizard</strong>
                                                    <p>Complete the installation wizard steps.</p>
                                                </div>
                                            </div>

                                            <div class="instruction-step opacity-50 text-warning">
                                                <div class="step-content">
                                                    <strong>Get your token</strong>
                                                    <p>Find your token in the system tray application.</p>
                                                </div>
                                            </div>

                                            <div class="alert alert-warning mt-3">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                Windows agent is currently in development. Linux agent is recommended for production use.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <?php if ($isLogged): ?>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">
                                            <i class="bi bi-arrow-right-circle me-2"></i>
                                            Next Steps
                                        </h4>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="text-white mb-4">
                                            Once you've installed the agent and have your token, add your device to your account.
                                        </p>
                                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                                            <a href="/astracore/dashboard?tab=devices-add" class="btn btn-primary">
                                                <i class="bi bi-plus-circle me-2"></i>
                                                Add Device
                                            </a>
                                            <a href="/astracore/dashboard?tab=devices-list" class="btn btn-outline-secondary">
                                                <i class="bi bi-list-ul me-2"></i>
                                                View My Devices
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">
                                            <i class="bi bi-person-plus me-2"></i>
                                            Need an Account?
                                        </h4>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="text-white mb-4">
                                            Create a free AstraCore account to manage your devices and access the full platform.
                                        </p>
                                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                                            <a href="/astracore/signup" class="btn btn-primary">
                                                <i class="bi bi-person-plus me-2"></i>
                                                Create Account
                                            </a>
                                            <a href="/astracore/login" class="btn btn-outline-primary">
                                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                                Sign In
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <div class="footer-links mb-3 d-flex justify-content-center gap-3 flex-wrap">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-copyright">
                &copy; <?= date("Y") == "2025" ? date("Y") : "2025 - " . date("Y") ?> AstraCore.cloud - All rights reserved
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Download tracking
        document.querySelectorAll('.download-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const platform = this.dataset.platform;
                console.log(`Download started for platform: ${platform}`);

                // Update button state
                const icon = this.querySelector('i');
                const text = this.querySelector('span') || this;

                icon.className = 'bi bi-hourglass-split me-2';
                if (text.textContent) {
                    text.textContent = text.textContent.replace('Download', 'Downloading...');
                }

                // Reset after 3 seconds
                setTimeout(() => {
                    icon.className = 'bi bi-download me-2';
                    if (text.textContent) {
                        text.textContent = text.textContent.replace('Downloading...', 'Download');
                    }
                }, 3000);
            });
        });

        // Copy code blocks on click
        document.querySelectorAll('.code-block code').forEach(codeBlock => {
            codeBlock.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    // Show copied feedback
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.color = 'var(--green-accent)';

                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 1000);
                });
            });
        });
    </script>

    <style>
        .download-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .download-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(15, 157, 102, 0.15);
        }

        .platform-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2.5rem;
            color: white;
        }

        .linux-icon {
            background: linear-gradient(135deg, #FCC624, #F57C00);
        }

        .windows-icon {
            background: linear-gradient(135deg, #0078D4, #005A9E);
        }

        .download-info {
            background: rgba(15, 157, 102, 0.05);
            border: 1px solid rgba(15, 157, 102, 0.2);
            border-radius: 8px;
            padding: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            color: var(--gray-light);
            margin-bottom: 0.5rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .requirements ul {
            padding-left: 1rem;
        }

        .requirements li {
            margin-bottom: 0.25rem;
        }

        .code-block {
            background: rgba(47, 52, 63, 0.8);
            border: 1px solid rgba(15, 157, 102, 0.3);
            border-radius: 6px;
            padding: 0.75rem;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        }

        .code-block code {
            background: none;
            border: none;
            padding: 0;
            color: var(--green-accent);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .code-block code:hover {
            color: var(--white);
        }

        .grid-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
            background-image:
                linear-gradient(rgba(15, 157, 102, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 157, 102, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(50px, 50px);
            }
        }

        /* Animation delays for staggered appearance */
        .download-card:nth-child(1) {
            animation: cardFadeIn 0.8s ease-out;
            animation-delay: 0.1s;
            animation-fill-mode: both;
        }

        .download-card:nth-child(2) {
            animation: cardFadeIn 0.8s ease-out;
            animation-delay: 0.2s;
            animation-fill-mode: both;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <base href="/astracore/">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="pages/js/animation.js"></script>
    <script src="pages/js/home.js"></script>
</body>

</html>