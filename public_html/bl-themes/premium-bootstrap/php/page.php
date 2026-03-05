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

    <!-- Cover Image -->
    <?php if ($page->coverImage()): ?>
        <div class="mb-5">
            <img src="<?php echo $page->coverImage(); ?>"
                 alt="<?php echo $page->title(); ?>"
                 class="w-100"
                 style="border-radius:1.5rem;box-shadow:0 8px 24px rgba(0,0,0,.1);max-height:480px;object-fit:cover;">
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="article-content">
        <?php echo $page->content(); ?>
    </div>

    <!-- Related / Plugins -->
    <?php Theme::plugins('pageEnd'); ?>

</article>
