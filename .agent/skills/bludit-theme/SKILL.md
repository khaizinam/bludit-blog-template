---
name: bludit-theme
description: Hướng dẫn phát triển, debug, và bảo trì theme cho Bludit CMS. Bao gồm cấu trúc file, PHP API, CSS/JS conventions, workflow phát triển, và cách debug.
---

# Bludit Theme Development Skill

## 1. Cấu trúc thư mục một Bludit Theme

```
bl-themes/
└── your-theme/
    ├── metadata.json       # Thông tin theme (tên, version, author)
    ├── index.php           # Entry point: HTML wrapper, include các partial
    ├── init.php            # Khởi tạo: AJAX handlers, helper functions
    ├── php/
    │   ├── head.php        # <head>: meta, CSS, fonts, dark mode script
    │   ├── navbar.php      # Navigation bar
    │   ├── home.php        # Trang chủ (danh sách bài)
    │   ├── page.php        # Trang bài viết đơn
    │   └── footer.php      # Footer + script JS cuối trang
    ├── css/
    │   └── main.css        # Toàn bộ CSS của theme
    ├── js/
    │   └── main.js         # Toàn bộ JS của theme (jQuery)
    └── img/
        ├── favicon.png
        └── place-holder.png
```

## 2. PHP API thường dùng

### Site object (`$site`)
```php
$site->url()          // URL gốc của site
$site->title()        // Tên site
$site->slogan()       // Slogan / tagline
$site->description()  // Mô tả site
$site->logo()         // URL ảnh logo (rỗng nếu chưa set)
$site->footer()       // Nội dung footer HTML
```

### Page object (`$page`, `$pi`, `new Page($key)`)
```php
$page->title()        // Tiêu đề bài
$page->description()  // Mô tả ngắn
$page->content()      // Nội dung HTML đầy đủ
$page->date()         // Ngày đã format (ví dụ: "MARCH 4, 2026")
$page->dateRaw('c')   // Ngày ISO 8601 (datetime attribute)
$page->permalink()    // URL của bài
$page->coverImage()   // URL ảnh bìa (rỗng nếu không có)
$page->category()     // Tên category (string)
$page->categoryKey()  // Key category (dùng để khởi tạo Category object)
$page->key()          // Unique key của bài
$page->isStatic()     // true nếu là static page
```

### Pages object (`$pages`)
```php
$pages->db                    // Mảng toàn bộ pages kể cả draft
$pages->getPublishedDB()      // Mảng keys các bài đã publish (theo thứ tự mới nhất)
```

### Category object
```php
$categories->keys()           // Mảng tất cả category keys
$cat = new Category($key);
$cat->name()                  // Tên category
$cat->permalink()             // URL category
$cat->pages()                 // Mảng page keys thuộc category
```

### Paginator
```php
Paginator::numberOfPages()    // Tổng số trang
Paginator::currentPage()      // Trang hiện tại
Paginator::showPrev()         // bool: có trang trước không
Paginator::showNext()         // bool: có trang tiếp không
Paginator::previousPageUrl()  // URL trang trước
Paginator::nextPageUrl()      // URL trang tiếp
```

### Theme helpers
```php
Theme::css('css/main.css')             // <link> tag với cache-bust
Theme::js('js/main.js')               // <script> tag với cache-bust
Theme::favicon('img/favicon.png')     // <link rel="icon"> tag
Theme::metaTags('title')              // <title> tag
Theme::metaTags('description')        // <meta description> tag
Theme::plugins('siteHead')            // Chèn plugin hooks
Theme::plugins('siteBodyBegin')
Theme::plugins('siteBodyEnd')
Theme::plugins('pageEnd')
Theme::lang()                         // Ngôn ngữ site (vd: 'vi', 'en')
Theme::socialNetworks()               // Mảng ['twitter'=>'Twitter', ...]
```

### WHERE_AM_I
```php
$WHERE_AM_I   // 'page' | 'home' | 'category' | 'tag' | 'search'
```

## 3. Biến môi trường & Constants

```php
DOMAIN_THEME_IMG    // URL đến thư mục img/ của theme
THEME_DIR_PHP       // Path tuyệt đối đến thư mục php/ của theme
BLUDIT_PRO          // Defined nếu là bản Pro
```

## 4. AJAX Handler Pattern (trong init.php)

```php
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    $offset = (int)($_GET['offset'] ?? 0);
    $limit  = 8;

    $keys     = array_slice($pages->getPublishedDB(), $offset, $limit);
    $response = [];
    foreach ($keys as $key) {
        $p = new Page($key);
        $response[] = [
            'title'       => $p->title(),
            'permalink'   => $p->permalink(),
            'date'        => $p->date(),
            'description' => $p->description(),
            'coverImage'  => $p->coverImage() ?: DOMAIN_THEME_IMG . 'place-holder.png',
            'category'    => $p->category() ?: 'Tin tức',
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
```

## 5. CSS Conventions

- Dùng CSS Variables (`:root`) cho màu, spacing, radius — **không hardcode giá trị màu trong component**.
- Dark mode dùng `[data-bs-theme="dark"]` selector (Bootstrap 5 data attribute).
- Accent color: `var(--accent)` — thay đổi một chỗ ảnh hưởng toàn bộ.
- Prefix class theo block:
  - `.article-card-*` cho card grid
  - `.list-article-*` cho list view
  - `.hero-*` cho featured article
  - `.breaking-*` cho ticker bar
  - `.page-sidebar-*` cho sidebar trong page view

## 6. JS Conventions (jQuery)

- Bọc toàn bộ trong `(function($){ 'use strict'; })(jQuery);`
- Khởi tạo trong `$(function(){ ... })` (DOM ready)
- Dùng `data-*` attributes để truyền PHP data sang JS (không inline `<script>` trong PHP)
  - Ví dụ: `data-total="<?php echo count($allPages); ?>"` → JS đọc bằng `$el.attr('data-total')`
- Pass PHP constants sang JS duy nhất 1 lần qua `window.*`:
  ```html
  <script>window.THEME_IMG = '<?php echo DOMAIN_THEME_IMG; ?>img/place-holder.png';</script>
  ```

## 7. Quy tắc phân công CSS/JS/PHP

| Loại logic | Nơi đặt |
|---|---|
| Màu, spacing, typography | `main.css` (CSS variables) |
| Hiệu ứng hover, animation | `main.css` |
| Dark mode styles | `main.css` (`[data-bs-theme="dark"]`) |
| Toggle dark mode | `main.js` |
| Load more / AJAX | `main.js` |
| Dữ liệu động (posts, category...) | PHP partial trong `php/` |
| Truyền config PHP → JS | `head.php` hoặc `data-*` attributes |
| AJAX endpoints | `init.php` (đầu file) |

## 8. Workflow phát triển

### Bước chuẩn
1. **Đọc file** liên quan trước khi sửa (view_file toàn bộ partial + css + js)
2. **Xác định bước** thuộc CSS, JS hay PHP (ưu tiên CSS/JS)
3. **Sửa CSS** trước → kiểm tra visual
4. **Sửa PHP partial** nếu cần thêm HTML structure
5. **Sửa JS** cho interactivity
6. **Test** bằng cách reload trang, kiểm tra dark/light mode, mobile responsive

### Debug checklist
- [ ] Kiểm tra console browser có lỗi JS không?
- [ ] PHP error? Bật `display_errors` hoặc check log `/var/log/apache2/error.log`
- [ ] AJAX không gọi được? Thêm `console.log(data)` trong `.done(function(data){...})`
- [ ] CSS không áp dụng? Kiểm tra specificity, dùng DevTools > Computed
- [ ] Dark mode bị flash? Đảm bảo script detect theme ở `<head>` trước khi render body
- [ ] `$page->coverImage()` trả về rỗng? Dùng `?: DOMAIN_THEME_IMG.'place-holder.png'`
- [ ] `$pages->getPublishedDB()` trả về array keys → phải `new Page($key)` để lấy object

## 9. metadata.json

```json
{
    "name": "Theme Name",
    "description": "Mô tả theme",
    "version": "1.0.0",
    "author": "Your Name",
    "email": "",
    "website": ""
}
```

## 10. Cách kiểm tra theme đang active

```bash
cat /var/www/flight-blog/public_html/bl-content/databases/site.php
# Tìm dòng: "theme": "premium-bootstrap"
```

## 11. Cache busting

`Theme::css()` và `Theme::js()` tự động append `?v=<version>` từ `metadata.json`.  
Khi sửa CSS/JS và không thấy thay đổi → tăng `version` trong `metadata.json`.
