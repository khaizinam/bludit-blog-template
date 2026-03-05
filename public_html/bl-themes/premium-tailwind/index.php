<!DOCTYPE html>
<html lang="<?php echo Theme::lang(); ?>" class="scroll-smooth">
<head>
    <?php include(THEME_DIR_PHP . 'head.php'); ?>
</head>
<body class="flex flex-col min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 font-sans">

    <!-- Load Bludit Plugins: Site Body Begin -->
    <?php Theme::plugins('siteBodyBegin'); ?>

    <!-- Navbar -->
    <?php include(THEME_DIR_PHP . 'navbar.php'); ?>

    <!-- Main Content -->
    <main id="main-content" class="flex-grow container mx-auto px-4 py-12 max-w-5xl">
        <?php
            if ($WHERE_AM_I == 'page') {
                include(THEME_DIR_PHP . 'page.php');
            } else {
                include(THEME_DIR_PHP . 'home.php');
            }
        ?>
    </main>

    <!-- Footer -->
    <?php include(THEME_DIR_PHP . 'footer.php'); ?>

</body>
</html>
