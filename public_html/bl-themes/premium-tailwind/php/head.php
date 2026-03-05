<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="Bludit">

<!-- Dynamic title tag -->
<?php echo Theme::metaTags('title'); ?>

<!-- Dynamic description tag -->
<?php echo Theme::metaTags('description'); ?>

<!-- Include Favicon -->
<?php if ($site->logo()): ?>
    <link rel="icon" type="image/png" href="<?php echo $site->logo(); ?>">
<?php else: ?>
    <?php echo Theme::favicon('img/favicon.png'); ?>
<?php endif; ?>

<!-- Tailwind CSS Play CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f0f9ff',
                        100: '#e0f2fe',
                        200: '#bae6fd',
                        300: '#7dd3fc',
                        400: '#38bdf8',
                        500: '#0ea5e9',
                        600: '#0284c7',
                        700: '#0369a1',
                        800: '#075985',
                        900: '#0c4a6e',
                    }
                },
                fontFamily: {
                    sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                }
            }
        }
    }
</script>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Google Fonts: Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style type="text/tailwindcss">
    @layer base {
        body { 
            @apply flex flex-col min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100 font-sans;
        }
    }
    .glass { @apply bg-white/70 backdrop-blur-md border border-white/20 dark:bg-slate-900/70 dark:border-slate-800/20; }
    
    /* Typography improvements for Bludit content */
    .prose { @apply max-w-none; }
    .prose h1, .prose h2, .prose h3 { @apply tracking-tight font-black mt-8 mb-4; }
    .prose p { @apply leading-relaxed mb-4; }
    .prose a { @apply text-primary-600 dark:text-primary-400 font-bold decoration-2 underline-offset-4 hover:underline; }
</style>
<!-- Theme Scripts -->
<script>
    // Check for saved dark mode preference
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    function toggleDarkMode() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
</script>

<!-- Load Bludit Plugins: Site head -->
<?php Theme::plugins('siteHead'); ?>
