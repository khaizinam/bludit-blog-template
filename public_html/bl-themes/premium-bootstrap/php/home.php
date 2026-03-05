<?php

// Prepare data
$allPages = array_values($content);

// Sticky pages
$stickyPages = [];
foreach ($pages->db as $key => $fields) {
    if ($fields['type'] === 'sticky') {
        $p = new Page($key);
        $stickyPages[] = $p;
    }
}
?>

<div class="d-flex flex-column gap-5">

    <!-- SECTION 1 — BREAKING BAR "CHÚ Ý" -->
    <div class="breaking-bar">
        <div class="container d-flex align-items-stretch" style="max-width:80rem;">
            <div class="breaking-label">CHÚ Ý</div>
            <div class="breaking-ticker">
                <marquee behavior="scroll" direction="left"
                         onmouseover="this.stop();" onmouseout="this.start();">
                    <?php if (empty($stickyPages)): ?>
                        Chào mừng bạn đến với <?php echo $site->title(); ?> &nbsp;·&nbsp; Chúc bạn một ngày tốt lành &nbsp;·&nbsp;
                    <?php else: ?>
                        <?php foreach ($stickyPages as $sp): ?>
                            <a href="<?php echo $sp->permalink(); ?>">
                                <?php echo $sp->title(); ?>
                            </a>
                            <span class="mx-4" style="color:#cbd5e1;">&nbsp;·&nbsp;</span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </marquee>
            </div>
        </div>
    </div>

    <!-- SECTION 2 — HERO / TIN NỔI BẬT -->
    <section class="container" style="max-width:80rem;">
        <div class="row g-4">

            <!-- Featured article (60%) -->
            <div class="col-12 col-lg-7">
                <?php if (isset($allPages[0])): $p0 = $allPages[0]; ?>
                <article class="hero-featured-article">
                    <a href="<?php echo $p0->permalink(); ?>" class="d-block">
                        <div class="hero-featured-img-wrap">
                            <img src="<?php echo $p0->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                                 alt="<?php echo $p0->title(); ?>"
                                 onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                                 class="hero-featured-img">
                            <span class="category-badge"><?php echo $p0->category(); ?></span>
                        </div>
                    </a>
                    <div class="mt-3">
                        <h2>
                            <a href="<?php echo $p0->permalink(); ?>" class="hero-title">
                                <?php echo $p0->title(); ?>
                            </a>
                        </h2>
                        <div class="meta-date my-2">
                            <time datetime="<?php echo $p0->dateRaw('c'); ?>">
                                <?php echo $p0->date(); ?>
                            </time>
                        </div>
                        <p style="color:var(--text-muted);line-height:1.7;font-size:1.05rem;">
                            <?php echo $p0->description(); ?>
                        </p>
                    </div>
                </article>
                <?php endif; ?>
            </div>

            <!-- Side list (40%) -->
            <div class="col-12 col-lg-5 d-flex flex-column gap-3">
                <?php for ($i = 1; $i <= 3; $i++): if (isset($allPages[$i])): $pi = $allPages[$i]; ?>
                <article class="side-article">
                    <a href="<?php echo $pi->permalink(); ?>" class="d-block flex-shrink-0">
                        <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                             alt="<?php echo $pi->title(); ?>"
                             onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                             class="side-article-img">
                    </a>
                    <div>
                        <span class="side-article-cat"><?php echo $pi->category(); ?></span>
                        <a href="<?php echo $pi->permalink(); ?>" class="side-article-title">
                            <?php echo $pi->title(); ?>
                        </a>
                        <div class="meta-date mt-1"><?php echo $pi->date(); ?></div>
                    </div>
                </article>
                <?php endif; endfor; ?>
            </div>

        </div>
    </section>

    <!-- SECTION 3 — MỚI NHẤT (6 bài) -->
    <section class="container" style="max-width:80rem;">
        <h2 class="section-heading">Mới nhất</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php for ($i = 0; $i < 6; $i++): if (isset($allPages[$i])): $pi = $allPages[$i]; ?>
            <div class="col">
                <article class="article-card">
                    <a href="<?php echo $pi->permalink(); ?>" class="d-block">
                        <div class="article-card-img-wrap">
                            <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                                 alt="<?php echo $pi->title(); ?>"
                                 onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                                 class="article-card-img">
                        </div>
                    </a>
                    <div class="article-card-body">
                        <span class="article-card-cat"><?php echo $pi->category(); ?></span>
                        <a href="<?php echo $pi->permalink(); ?>" class="article-card-title d-block">
                            <?php echo $pi->title(); ?>
                        </a>
                        <div class="meta-date mt-2"><?php echo $pi->date(); ?></div>
                        <p class="article-card-desc"><?php echo $pi->description(); ?></p>
                    </div>
                </article>
            </div>
            <?php endif; endfor; ?>
        </div>
    </section>

    <!-- SECTION 4 — TẤT CẢ BÀI VIẾT + LOAD MORE -->
    <section class="container py-4" style="max-width:80rem;"
             data-total="<?php echo count($allPages); ?>">
        <h2 class="section-heading">Tất cả bài viết</h2>

        <div id="article-list" class="mb-4">
            <?php
            $start = 6;
            $limit = 8;
            for ($i = $start; $i < ($start + $limit); $i++):
                if (isset($allPages[$i])): $pi = $allPages[$i];
            ?>
            <div class="list-article">
                <div class="list-article-img-wrap">
                    <a href="<?php echo $pi->permalink(); ?>">
                        <img src="<?php echo $pi->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                             alt="<?php echo $pi->title(); ?>"
                             onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                             class="list-article-img">
                    </a>
                </div>
                <div class="flex-grow-1">
                    <a href="<?php echo $pi->permalink(); ?>" class="list-article-title">
                        <?php echo $pi->title(); ?>
                    </a>
                    <div class="meta-date mt-1"><?php echo $pi->date(); ?></div>
                    <p class="list-article-desc d-none d-md-block mt-1"><?php echo $pi->description(); ?></p>
                </div>
            </div>
            <?php endif; endfor; ?>
        </div>

        <!-- Load More -->
        <div class="text-center pb-5">
            <button id="btn-load-more" class="btn-load-more">
                <span class="load-label">Xem thêm bài viết</span>
                <span class="spinner-text d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Đang tải...
                </span>
                <svg class="load-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="load-done-msg" class="load-done-msg mx-auto" style="max-width:320px;">
                Bạn đã xem hết tất cả bài viết
            </div>
        </div>
    </section>

    <!-- SECTION 5 — PAGINATION FALLBACK -->
    <?php if (Paginator::numberOfPages() > 1): ?>
    <section class="container" style="max-width:80rem;">
        <nav class="pagination-nav">
            <div>
                <?php if (Paginator::showPrev()): ?>
                <a href="<?php echo Paginator::previousPageUrl(); ?>" class="pagination-link">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Trang trước
                </a>
                <?php endif; ?>
            </div>
            <div class="pagination-info">
                Trang <?php echo Paginator::currentPage(); ?> / <?php echo Paginator::numberOfPages(); ?>
            </div>
            <div>
                <?php if (Paginator::showNext()): ?>
                <a href="<?php echo Paginator::nextPageUrl(); ?>" class="pagination-link">
                    Trang tiếp
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <?php endif; ?>
            </div>
        </nav>
    </section>
    <?php endif; ?>

</div>
