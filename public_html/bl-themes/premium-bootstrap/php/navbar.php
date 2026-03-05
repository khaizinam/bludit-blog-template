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
            </div>
        </div>
    </div>
</nav>
