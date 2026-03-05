<?php
// Tự động tạo mã version dứa trên file sửa đổi mới nhất (cho CSS/JS chung)
$themeVer = '1.0.1';
?>
<!DOCTYPE html>
<html lang="<?php echo Theme::lang(); ?>">
<head>
    <?php include(THEME_DIR_PHP . 'head.php'); ?>
</head>
<body>

    <!-- Bludit: Site Body Begin -->
    <?php Theme::plugins('siteBodyBegin'); ?>

    <!-- Navbar -->
    <?php include(THEME_DIR_PHP . 'navbar.php'); ?>

    <!-- Main Content -->
    <main id="main-content" class="container py-4 py-md-5" style="max-width:80rem;">
        <?php
            if ($WHERE_AM_I == 'page') {
                include(THEME_DIR_PHP . 'page.php');
            } elseif ($WHERE_AM_I == 'search') {
                include(THEME_DIR_PHP . 'search.php');
            } else {
                include(THEME_DIR_PHP . 'home.php');
            }
        ?>
    </main>


    <!-- Footer -->
    <?php include(THEME_DIR_PHP . 'footer.php'); ?>

</body>
</html>
