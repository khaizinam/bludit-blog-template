<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="generator" content="Bludit">

<!-- Dynamic title tag -->
<?php echo Theme::metaTags('title'); ?>

<!-- Dynamic description tag -->
<?php echo Theme::metaTags('description'); ?>

<!-- Favicon -->
<?php if ($site->logo()): ?>
    <link rel="icon" type="image/png" href="<?php echo $site->logo(); ?>">
<?php else: ?>
    <?php echo Theme::favicon('img/favicon.png'); ?>
<?php endif; ?>

<!-- Google Fonts: Inter (loaded via main.css @import) -->

<!-- Bootstrap 5 CSS (local) -->
<link rel="stylesheet" href="<?php echo DOMAIN_THEME . 'css/bootstrap.min.css'; ?>">

<!-- Theme CSS (cache-bust chung từ index) -->
<link rel="stylesheet" href="<?php echo DOMAIN_THEME . 'css/main.css?v=' . $themeVer; ?>">

<!-- Dark mode: apply before paint to avoid flash -->
<script>
(function(){
  var t = localStorage.getItem('color-theme');
  var prefer = window.matchMedia('(prefers-color-scheme: dark)').matches;
  document.documentElement.setAttribute('data-bs-theme', (t === 'dark' || (!t && prefer)) ? 'dark' : 'light');
})();
</script>

<!-- Pass theme image path to JS -->
<script>
window.THEME_IMG = '<?php echo DOMAIN_THEME_IMG; ?>img/place-holder.png';
</script>

<!-- Load Bludit Plugins: Site head -->
<?php Theme::plugins('siteHead'); ?>
