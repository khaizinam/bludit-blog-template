<footer class="mt-auto border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 transition-colors duration-300">
    <div class="container mx-auto px-4 max-w-5xl py-12 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-slate-500 dark:text-slate-400">
            
            <!-- Column 1: Brand & Slogan -->
            <div class="space-y-6">
                <a href="<?php echo $site->url(); ?>" class="inline-flex items-center">
                    <?php if ($site->logo()): ?>
                        <img src="<?php echo $site->logo(); ?>" alt="<?php echo $site->title(); ?>" class="h-8 w-auto">
                    <?php else: ?>
                        <span class="text-2xl font-black bg-gradient-to-r from-primary-600 to-primary-400 bg-clip-text text-transparent italic">
                            <?php echo $site->title(); ?>
                        </span>
                    <?php endif ?>
                </a>
                <p class="text-sm leading-relaxed max-w-xs uppercase font-medium tracking-tight">
                    <?php echo $site->slogan(); ?>
                </p>
                <!-- Social Networks -->
                <div class="flex space-x-4">
                    <?php foreach (Theme::socialNetworks() as $key => $name): ?>
                        <a href="<?php echo $site->{$key}(); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-primary-500 transition-colors" title="<?php echo $name; ?>">
                            <span class="sr-only"><?php echo $name; ?></span>
                            <!-- We can use icons or just initials for a premium minimalist look -->
                            <span class="text-xs font-bold uppercase tracking-widest border border-slate-200 dark:border-slate-800 px-2 py-1 rounded">
                                <?php echo substr($name, 0, 2); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Column 2: Categories -->
            <div>
                <h3 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-8">Categories</h3>
                <nav class="flex flex-col space-y-4">
                    <?php foreach ($categories->keys() as $key): ?>
                        <?php $category = new Category($key); ?>
                        <?php if (count($category->pages()) > 0): ?>
                        <a href="<?php echo $category->permalink(); ?>" class="text-sm hover:text-primary-500 transition-colors inline-block w-fit">
                            <?php echo $category->name(); ?>
                            <span class="text-[10px] ml-1 bg-slate-100 dark:bg-slate-900 px-1.5 py-0.5 rounded-full text-slate-400">
                                <?php echo count($category->pages()); ?>
                            </span>
                        </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </nav>
            </div>

            <!-- Column 3: Navigation -->
            <div>
                <h3 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-8">Menu</h3>
                <nav class="flex flex-col space-y-4 text-sm">
                    <a href="<?php echo $site->url(); ?>" class="hover:text-primary-500 transition-colors">Home</a>
                    <?php foreach ($staticContent as $staticPage): ?>
                        <a href="<?php echo $staticPage->permalink(); ?>" class="hover:text-primary-500 transition-colors">
                            <?php echo $staticPage->title(); ?>
                        </a>
                    <?php endforeach ?>
                </nav>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="mt-20 pt-8 border-t border-slate-100 dark:border-slate-900 flex flex-col md:flex-row items-center justify-between text-[11px] font-bold tracking-widest uppercase">
            
            <div class="mb-4 md:mb-0">
                <?php echo $site->footer(); ?>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Powered By -->
                <?php if (!defined('BLUDIT_PRO')): ?>
                    <div class="flex items-center space-x-2">
                        <img class="w-4 h-4 grayscale opacity-40 dark:invert" src="<?php echo DOMAIN_THEME_IMG.'favicon.png'; ?>" alt="Bludit"/>
                        <span>Powered by <a href="https://www.bludit.com" target="_blank" rel="noopener" class="text-primary-600 hover:text-primary-500 underline underline-offset-4 decoration-1">BLUDIT</a></span>
                    </div>
                <?php endif; ?>
                
                <span>Copyright &copy; <?php echo date('Y'); ?> <?php echo $site->title(); ?></span>
            </div>

        </div>
    </div>
</footer>

<!-- Bludit Footer -->
<?php Theme::plugins('siteBodyEnd'); ?>
