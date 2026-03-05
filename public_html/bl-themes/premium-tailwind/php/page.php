<article class="max-w-3xl mx-auto py-12">
    <!-- Post Header -->
    <header class="mb-12 text-center">
        <?php if (!$page->isStatic()): ?>
            <div class="mb-4">
                <time datetime="<?php echo $page->date('c'); ?>" class="text-sm font-bold text-primary-500 uppercase tracking-widest">
                    <?php echo $page->date(); ?>
                </time>
            </div>
        <?php endif ?>
        
        <h1 class="text-4xl md:text-5xl font-black mb-8 dark:text-white leading-tight">
            <?php echo $page->title(); ?>
        </h1>

        <?php if ($page->description()): ?>
            <p class="text-xl text-slate-500 dark:text-slate-400 font-medium italic">
                <?php echo $page->description(); ?>
            </p>
        <?php endif ?>
    </header>


    <!-- Main Body Content -->
    <div class="prose prose-lg prose-slate dark:prose-invert max-w-none 
                prose-headings:font-black prose-headings:tracking-tight 
                prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline
                prose-pre:rounded-2xl prose-pre:bg-slate-900 prose-pre:shadow-xl
                prose-img:rounded-3xl prose-img:shadow-lg">
        <?php echo $page->content(); ?>
    </div>

    <!-- Related Articles -->
    <?php Theme::plugins('pageEnd'); ?>
</article>
