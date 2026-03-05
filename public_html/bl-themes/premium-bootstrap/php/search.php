<?php
// Lấy từ khoá tìm kiếm từ URL (Bludit truyền qua biến $searchTerm hoặc parse từ URL)
$keyword = "";
if (!empty($searchTerm)) {
    $keyword = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
} elseif (!empty($_GET["search"])) {
    $keyword = htmlspecialchars($_GET["search"], ENT_QUOTES, 'UTF-8');
} else {
    // Parse keyword từ URL: .../search/keyword
    $path  = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $parts = explode("/search/", $path);
    if (isset($parts[1])) {
        $keyword = htmlspecialchars(urldecode(trim($parts[1], "/")), ENT_QUOTES, 'UTF-8');
    }
}
?>

<div class="search-result-wrap">

    <!-- Header tìm kiếm -->
    <div class="search-result-header">
        <h1 class="search-result-title">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 style="width:28px;height:28px;vertical-align:middle;margin-right:.5rem;" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
            </svg>
            Kết quả tìm kiếm
        </h1>
        <?php if ($keyword): ?>
            <p class="search-result-keyword">
                Từ khoá: <strong>"<?php echo $keyword; ?>"</strong>
                &nbsp;·&nbsp;
                <?php $count = count($content); ?>
                <?php echo $count; ?> bài viết
            </p>
        <?php endif; ?>
    </div>

    <!-- Form tìm kiếm lại -->
    <form class="search-result-form" role="search" onsubmit="return searchSubmit(this);">
        <div class="search-result-input-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
            </svg>
            <input type="search" name="q"
                   class="search-result-input"
                   value="<?php echo $keyword; ?>"
                   placeholder="Tìm kiếm bài viết..."
                   aria-label="Tìm kiếm lại">
        </div>
        <button type="submit" class="search-result-btn">Tìm kiếm</button>
    </form>

    <!-- Kết quả -->
    <?php if (empty($content)): ?>
        <div class="search-empty">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                 style="width:56px;height:56px;color:var(--text-faint);" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
            </svg>
            <p>Không tìm thấy bài viết nào</p>
            <small>Hãy thử từ khoá khác hoặc kiểm tra lại chính tả</small>
        </div>
    <?php else: ?>
        <div class="search-result-list">
            <?php foreach ($content as $page): ?>
            <article class="list-article">
                <div class="list-article-img-wrap">
                    <a href="<?php echo $page->permalink(); ?>">
                        <img src="<?php echo $page->coverImage() ?: DOMAIN_THEME_IMG . 'place-holder.png'; ?>"
                             alt="<?php echo $page->title(); ?>"
                             onerror="this.onerror=null;this.src='<?php echo DOMAIN_THEME_IMG . 'place-holder.png'; ?>';"
                             class="list-article-img">
                    </a>
                </div>
                <div class="flex-grow-1">
                    <span class="article-card-cat"><?php echo $page->category(); ?></span>
                    <a href="<?php echo $page->permalink(); ?>" class="list-article-title d-block">
                        <?php echo $page->title(); ?>
                    </a>
                    <div class="meta-date mt-1"><?php echo $page->date(); ?></div>
                    <?php if ($page->description()): ?>
                        <p class="list-article-desc d-none d-md-block mt-1"><?php echo $page->description(); ?></p>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
