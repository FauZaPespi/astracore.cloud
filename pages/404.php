<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
    <style>
        /* 404 Custom Styles */
        .error-404 {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: var(--black);
            color: var(--white);
            user-select: none;
        }

        .error-404 h1 {
            font-size: clamp(4rem, 15vw, 8rem);
            font-weight: 900;
            background: linear-gradient(135deg, var(--white), var(--green-accent));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .error-404 p {
            font-size: 1.5rem;
            color: var(--gray-light);
            margin-bottom: 2rem;
        }

        .btn-back {
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            border: 2px solid var(--gray-dark);
            background: transparent;
            color: var(--white);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(15, 157, 102, 0.1);
            border-color: var(--green-primary);
        }

        .error-icon {
            font-size: 6rem;
            margin-bottom: 1rem;
            color: var(--green-accent);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#">Overview</a></li>
            <li><a href="#">Organisation</a></li>
            <li><a href="#">Docs</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="login" class="btn btn-ghost">Login</a>
            <a href="signup" class="btn btn-primary">Get Started</a>
        </div>
    </nav>

    <!-- 404 Section -->
    <section class="error-404 d-flex flex-column justify-content-center align-items-center text-center">
        
        <h1><i class="bi bi-exclamation-triangle-fill error-icon"></i><span class="invisible">.</span>404</h1>
        <p>Oops! The page you're looking for doesn't exist.</p>
        <a href="https://1.3.3.7/why so serious" onclick="history.back(); return false;" class="btn-back"><i class="bi bi-arrow-left-circle"></i><span class="invisible">..</span>Back to Home</a>
    </section>

    <!-- Footer -->
    <footer class="footer py-4 mt-auto">
        <div class="container text-center">
            <div class="footer-links mb-3 d-flex justify-content-center gap-3 flex-wrap">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-copyright">
                &copy; 2025 AstraCore.cloud - All rights reserved
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
