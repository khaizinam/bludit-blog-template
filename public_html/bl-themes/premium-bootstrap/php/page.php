<?php
// --- Prepare data for internal link sections ---

// Latest 5 posts
$latestPosts = [];
$publishedKeys = $pages->getPublishedDB();
$latestKeys = array_slice($publishedKeys, 0, 5);
foreach ($latestKeys as $lk) {
    $latestPosts[] = new Page($lk);
}

// Related posts (same category, exclude current, max 4)
$relatedPosts = [];
$currentCat = $page->categoryKey();
if ($currentCat) {
    $cat = new Category($currentCat);
    foreach ($cat->pages() as $rk) {
        if ($rk === $page->key()) continue;
        $relatedPosts[] = new Page($rk);
        if (count($relatedPosts) >= 4) break;
    }
}

// All posts count for load-more
$allPublishedCount = count($publishedKeys);
$pageLoadMoreOffset = 8; // first 8 shown statically below
?>

<article class="article-page px-3">

    <!-- Post Header -->
    <header>
        <?php if (!$page->isStatic()): ?>
            <time datetime="<?php echo $page->date('c'); ?>" class="article-page-date">
                <?php echo $page->date(); ?>
            </time>
        <?php endif; ?>

        <h1 class="article-page-title"><?php echo $page->title(); ?></h1>

        <?php if ($page->description()): ?>
            <p class="article-page-desc"><?php echo $page->description(); ?></p>
        <?php endif; ?>
    </header>

    <!-- Cover Image (Fix #6: max-width 400px, centered) -->
    <?php if ($page->coverImage()): ?>
        <div class="cover-image-wrap">
            <img src="<?php echo $page->coverImage(); ?>"
                 alt="<?php echo $page->title(); ?>"
                 class="cover-img">
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="article-content">
        <?php echo $page->content(); ?>
    </div>

    <!-- Related / Plugins -->
    <?php Theme::plugins('pageEnd'); ?>

</article>

<!-- ================================================================
     FIX #5 — Internal link sections (SEO internal linking)
     ================================================================ -->
<div class="container" style="max-width:768px; margin:0 auto;">

    <!-- Section A: Bài mới nhất -->
    <?php if (!empty($latestPosts)): ?>
    <div class="page-sidebar-section">
        <h2 class="section-heading">Bài viết mới nhất</h2>
        <div>
            <?php foreach ($latestPosts as $lp): ?>
            <div class="latest-post-item">
                <a href="<?php echo $lp->permalink(); ?>" class="flex-shrink-0">
                    <img src="<?php echo $lp->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                         onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                         alt="<?php echo $lp->title(); ?>"
                         class="latest-post-thumb">
                </a>
                <div>
                    <a href="<?php echo $lp->permalink(); ?>" class="latest-post-title">
                        <?php echo $lp->title(); ?>
                    </a>
                    <div class="latest-post-date"><?php echo $lp->date(); ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section B: Bài viết liên quan -->
    <?php if (!empty($relatedPosts)): ?>
    <div class="page-sidebar-section">
        <h2 class="section-heading">Bài viết liên quan</h2>
        <div class="row row-cols-2 g-3">
            <?php foreach ($relatedPosts as $rp): ?>
            <div class="col">
                <article class="related-card">
                    <a href="<?php echo $rp->permalink(); ?>" class="d-block" style="overflow:hidden;">
                        <img src="<?php echo $rp->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                             onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                             alt="<?php echo $rp->title(); ?>"
                             class="related-card-img">
                    </a>
                    <div class="related-card-body">
                        <span class="related-card-cat"><?php echo $rp->category(); ?></span>
                        <a href="<?php echo $rp->permalink(); ?>" class="related-card-title">
                            <?php echo $rp->title(); ?>
                        </a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section C: Tất cả bài viết + load more -->
    <div class="page-sidebar-section"
         data-total="<?php echo $allPublishedCount; ?>">
        <h2 class="section-heading">Tất cả bài viết</h2>

        <div id="page-article-list" class="mb-4">
            <?php
            $pageListKeys = array_slice($publishedKeys, 0, $pageLoadMoreOffset);
            foreach ($pageListKeys as $plk):
                $pli = new Page($plk);
            ?>
            <div class="list-article">
                <div class="list-article-img-wrap">
                    <a href="<?php echo $pli->permalink(); ?>">
                        <img src="<?php echo $pli->coverImage() ?: DOMAIN_THEME_IMG.'place-holder.png'; ?>"
                             onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG.'place-holder.png'; ?>';"
                             class="list-article-img"
                             alt="<?php echo $pli->title(); ?>">
                    </a>
                </div>
                <div class="flex-grow-1">
                    <a href="<?php echo $pli->permalink(); ?>" class="list-article-title">
                        <?php echo $pli->title(); ?>
                    </a>
                    <div class="meta-date mt-1"><?php echo $pli->date(); ?></div>
                    <p class="list-article-desc d-none d-md-block mt-1"><?php echo $pli->description(); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Load More -->
        <div class="text-center pb-5">
            <button id="btn-page-load-more">
                <span class="load-label">Xem thêm bài viết</span>
                <span class="spinner-text d-none">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Đang tải...
                </span>
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="page-load-done-msg" class="load-done-msg mx-auto mt-3" style="max-width:320px;display:none;">
                Bạn đã xem hết tất cả bài viết
            </div>
        </div>
    </div>

</div>
