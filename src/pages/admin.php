<?php
require_once "../class/User.php";
require_once "../class/UserService.php";
/*
if ($_SESSION["role"] !== UserRole::Admin)
{
    header("Location: /signup");
}
*/
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <base href="/pages">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="stylesheet" href="pages/css/utils/forms.css">
    <link rel="stylesheet" href="pages/css/utils/animations.css">
    <link rel="stylesheet" href="pages/css/base/layout.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>
<body>
    <header>

    </header>
    <main>
        <?php
            $users = UserService::getAllUser();
            if (count($users) > 0)
            {
                echo "<ul>";
                foreach($users as $user)
                {
                    echo "<li>". $user["username"]. "</li>";
                }
                echo "</ul>";
            }
            else
            {
                echo "<h2>Il n'y pas d'utillisateurs</h2>";
            }
        ?>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="pages/js/animation.js"></script>
</body>