<footer id="main-footer">
    <div class="container py-5 py-md-5" style="max-width:80rem;">
        <div class="row g-5" style="color:var(--text-muted);">

            <!-- Column 1: Brand & Slogan -->
            <div class="col-12 col-md-4">
                <div class="mb-4">
                    <a href="<?php echo $site->url(); ?>" class="text-decoration-none d-flex align-items-center">
                        <?php if ($site->logo()): ?>
                            <img src="<?php echo $site->logo(); ?>"
                                 alt="<?php echo $site->title(); ?>"
                                 style="height:32px; width:auto;">
                            <span class="footer-site-name"><?php echo $site->title(); ?></span>
                        <?php else: ?>
                            <span class="footer-brand-text"><?php echo $site->title(); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <p class="text-uppercase fw-semibold small lh-base mb-4" style="max-width:18rem; letter-spacing:.04em;">
                    <?php echo $site->slogan(); ?>
                </p>
                <!-- Social Networks -->
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach (Theme::socialNetworks() as $key => $name): ?>
                        <a href="<?php echo $site->{$key}(); ?>"
                           target="_blank" rel="noopener noreferrer"
                           class="social-badge" title="<?php echo $name; ?>">
                            <?php echo substr($name, 0, 2); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Column 2: Categories -->
            <div class="col-12 col-md-4">
                <h3 class="footer-title">Categories</h3>
                <nav class="d-flex flex-column">
                    <?php foreach ($categories->keys() as $key): ?>
                        <?php $category = new Category($key); ?>
                        <?php if (count($category->pages()) > 0): ?>
                            <a href="<?php echo $category->permalink(); ?>" class="footer-link">
                                <?php echo $category->name(); ?>
                                <span class="category-count"><?php echo count($category->pages()); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Column 3: Navigation -->
            <div class="col-12 col-md-4">
                <h3 class="footer-title">Menu</h3>
                <nav class="d-flex flex-column">
                    <a href="<?php echo $site->url(); ?>" class="footer-link">Home</a>
                    <?php foreach ($staticContent as $staticPage): ?>
                        <a href="<?php echo $staticPage->permalink(); ?>" class="footer-link">
                            <?php echo $staticPage->title(); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="text-center text-md-start">
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mb-2">
                    <a href="https://manga18k.xyz" target="_blank" title="Manga18K - Đọc truyện miễn phí" class="text-decoration-none" style="color: var(--text-muted);">Manga18K - Đọc truyện miễn phí</a>
                    <a href="https://khaizinam.io.vn" target="_blank" title="khaizinam" class="text-decoration-none" style="color: var(--text-muted);">khaizinam</a>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <span>Copyright &copy; <?php echo date("Y"); ?> <?php echo $site->title(); ?></span>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery (local) -->
<script src="<?php echo DOMAIN_THEME . 'js/jquery.min.js'; ?>"></script>
<!-- Bootstrap 5 JS (local) -->
<script src="<?php echo DOMAIN_THEME . 'js/bootstrap.bundle.min.js'; ?>"></script>
<!-- Theme JS (cache-bust chung từ index) -->
<script src="<?php echo DOMAIN_THEME . 'js/main.js?v=' . $themeVer; ?>"></script>

<!-- Bludit Footer Plugins -->
<?php Theme::plugins('siteBodyEnd'); ?>
