/**
 * PREMIUM BOOTSTRAP THEME — main.js
 * Requires: jQuery 3.x, Bootstrap 5
 * Replaces: Alpine.js + inline Tailwind JS
 */

(function ($) {
  'use strict';

  /* =============================================================
     DARK MODE
     ============================================================= */
  var THEME_KEY = 'color-theme';

  function applyTheme(mode) {
    $('html').attr('data-bs-theme', mode);
    localStorage.setItem(THEME_KEY, mode);
  }

  function initDarkMode() {
    var saved = localStorage.getItem(THEME_KEY);
    if (saved) {
      applyTheme(saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
      applyTheme('dark');
    } else {
      applyTheme('light');
    }
  }

  $('#btn-dark-mode').on('click', function () {
    var current = $('html').attr('data-bs-theme');
    applyTheme(current === 'dark' ? 'light' : 'dark');
  });

  /* =============================================================
     BREAKING BAR — pause marquee on hover
     (marquee tag handles itself, but we add jQuery fallback)
     ============================================================= */
  // Already handled by inline onmouseover/onmouseout on <marquee>,
  // but we rebuild it as a CSS ticker fallback if needed.

  /* =============================================================
     LOAD MORE — replaces Alpine.js articleLoader
     ============================================================= */
  var articleLoader = {
    offset: 14,
    loading: false,
    done: false,
    placeholderUrl: ''   // set from PHP via window.THEME_IMG
  };

  function buildListArticleHTML(item) {
    var placeholder = window.THEME_IMG || '';
    return '<div class="list-article fade-in-up">' +
      '<div class="list-article-img-wrap">' +
        '<a href="' + item.permalink + '">' +
          '<img src="' + item.coverImage + '" ' +
               'onerror="this.onerror=null;this.src=\'' + placeholder + '\'" ' +
               'class="list-article-img" alt="' + $('<div>').text(item.title).html() + '">' +
        '</a>' +
      '</div>' +
      '<div class="flex-grow-1">' +
        '<a href="' + item.permalink + '" class="list-article-title">' + item.title + '</a>' +
        '<div class="meta-date mt-1">' + item.date + '</div>' +
        '<p class="list-article-desc d-none d-md-block mt-1">' + item.description + '</p>' +
      '</div>' +
    '</div>';
  }

  $('#btn-load-more').on('click', function () {
    if (articleLoader.loading || articleLoader.done) return;

    articleLoader.loading = true;
    var $btn = $(this);
    var $spinner = $btn.find('.spinner-text');
    var $label   = $btn.find('.load-label');
    var $icon    = $btn.find('.load-icon');

    $spinner.show();
    $label.hide();
    $icon.hide();
    $btn.prop('disabled', true);

    $.getJSON('?ajax=1&offset=' + articleLoader.offset)
      .done(function (data) {
        if (!data || data.length === 0) {
          articleLoader.done = true;
          $btn.hide();
          $('#load-done-msg').fadeIn();
        } else {
          var $list = $('#article-list');
          $.each(data, function (i, item) {
            $list.append(buildListArticleHTML(item));
          });
          articleLoader.offset += data.length;
          if (data.length < 8) {
            articleLoader.done = true;
            $btn.hide();
            $('#load-done-msg').fadeIn();
          }
        }
      })
      .fail(function () {
        console.error('Lỗi khi tải bài viết');
      })
      .always(function () {
        articleLoader.loading = false;
        $spinner.hide();
        $label.show();
        $icon.show();
        $btn.prop('disabled', false);
      });
  });

  /* =============================================================
     INIT
     ============================================================= */
  $(function () {
    initDarkMode();
  });

})(jQuery);
