<?php
// Initialize theme helpers

// === AJAX HANDLER — Load More ===
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    if (ob_get_level()) ob_end_clean();

    $offset   = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit    = 8;
    $response = [];

    $publishedKeys = $pages->getPublishedDB();
    $keys = array_slice($publishedKeys, $offset, $limit);

    foreach ($keys as $key) {
        $p      = new Page($key);
        $cover  = $p->coverImage() ? $p->coverImage() : DOMAIN_THEME_IMG . 'place-holder.png';
        $response[] = [
            'title'       => $p->title(),
            'permalink'   => $p->permalink(),
            'date'        => $p->date(),
            'description' => $p->description(),
            'coverImage'  => $cover,
            'category'    => $p->category() ? current(explode(',', $p->category())) : 'Tin tức',
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
