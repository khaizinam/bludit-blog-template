<script>window.SITE_URL = '<?php echo $site->url(); ?>';</script>
<nav id="main-navbar" class="glass">
    <div class="container" style="max-width:80rem;">
        <div class="d-flex align-items-center justify-content-between h-100 px-3">

            <!-- Logo -->
            <a href="<?php echo $site->url(); ?>" class="text-decoration-none d-flex align-items-center">
                <?php if ($site->logo()): ?>
                    <img src="<?php echo $site->logo(); ?>"
                         alt="<?php echo $site->title(); ?>"
                         style="height:40px; width:auto; object-fit:contain;">
                    <span class="navbar-site-name"><?php echo $site->title(); ?></span>
                <?php else: ?>
                    <span class="navbar-brand-text"><?php echo $site->title(); ?></span>
                <?php endif; ?>
            </a>

            <!-- Desktop menu + tools -->
            <div class="d-flex align-items-center gap-4">

                <!-- Static pages (desktop) -->
                <div class="d-none d-md-flex gap-4">
                    <?php foreach ($staticContent as $staticPage): ?>
                        <a href="<?php echo $staticPage->permalink(); ?>"
                           class="nav-link px-0">
                            <?php echo $staticPage->title(); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?php if (pluginActivated('pluginSearch')): ?>
                <!-- Search toggle button -->
                <button id="btn-search" aria-label="Tìm kiếm">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
                    </svg>
                </button>
                <?php endif; ?>

                <!-- Dark mode toggle -->
                <button id="btn-dark-mode" aria-label="Toggle dark mode">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg class="icon-sun" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg class="icon-moon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>

                <!-- Hamburger (mobile) -->
                <button class="navbar-toggler d-md-none" type="button"
                        data-bs-toggle="collapse" data-bs-target="#mobileMenu"
                        aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="collapse d-md-none" id="mobileMenu">
            <div class="px-3 pb-3 d-flex flex-column gap-2">
                <?php foreach ($staticContent as $staticPage): ?>
                    <a href="<?php echo $staticPage->permalink(); ?>"
                       class="nav-link py-2 border-bottom" style="border-color:var(--border)!important;">
                        <?php echo $staticPage->title(); ?>
                    </a>
                <?php endforeach; ?>

                <?php if (pluginActivated('pluginSearch')): ?>
                <!-- Search form in mobile menu -->
                <form class="search-mobile-form mt-2" role="search" onsubmit="return searchSubmit(this);">
                    <div class="search-mobile-input-wrap">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
                        </svg>
                        <input type="search" name="q" class="search-mobile-input"
                               placeholder="Tìm kiếm bài viết..."
                               aria-label="Tìm kiếm">
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if (pluginActivated('pluginSearch')): ?>
<!-- Search Overlay -->
<div id="search-overlay" role="dialog" aria-modal="true" aria-label="Tìm kiếm">
    <div class="search-overlay-backdrop" id="search-backdrop"></div>
    <div class="search-overlay-box">
        <form class="search-overlay-form" role="search" onsubmit="return searchSubmit(this);">
            <svg class="search-overlay-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
            </svg>
            <input id="search-overlay-input" type="search" name="q"
                   class="search-overlay-input"
                   placeholder="Tìm kiếm bài viết..."
                   autocomplete="off"
                   aria-label="Tìm kiếm">
            <button type="button" id="btn-search-close" aria-label="Đóng tìm kiếm">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </form>
        <p class="search-overlay-hint">Nhấn <kbd>Enter</kbd> để tìm kiếm · <kbd>Esc</kbd> để đóng</p>
    </div>
</div>
<?php endif; ?>
