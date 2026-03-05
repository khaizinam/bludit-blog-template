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
     BUILD HTML HELPER — list-article row
     ============================================================= */
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

  /* =============================================================
     GENERIC LOAD-MORE INITIALISER
     Fix #4: ẩn nút ngay khi total <= offset (không còn bài)
     ============================================================= */
  function initLoadMore(opts) {
    // opts: { btnId, listId, doneMsgId, startOffset, batchSize, totalAttr }
    var $section  = $(opts.btnId).closest('[data-total]');
    var total     = parseInt($section.attr('data-total'), 10) || 0;
    var loader    = { offset: opts.startOffset, loading: false, done: false };

    var $btn      = $(opts.btnId);
    var $list     = $(opts.listId);
    var $doneMsg  = $(opts.doneMsgId);

    // Fix #4: ẩn nút ngay khi không còn bài nào để load
    if (total <= opts.startOffset) {
      $btn.hide();
      return;
    }

    $btn.on('click', function () {
      if (loader.loading || loader.done) return;
      loader.loading = true;

      var $spinner = $btn.find('.spinner-text');
      var $label   = $btn.find('.load-label');
      var $icon    = $btn.find('.load-icon, svg:not(.spinner-text svg)');

      $spinner.removeClass('d-none').show();
      $label.hide();
      $icon.hide();
      $btn.prop('disabled', true);

      $.getJSON('?ajax=1&offset=' + loader.offset)
        .done(function (data) {
          if (!data || data.length === 0) {
            loader.done = true;
            $btn.hide();
            $doneMsg.fadeIn();
          } else {
            $.each(data, function (i, item) {
              $list.append(buildListArticleHTML(item));
            });
            loader.offset += data.length;
            if (data.length < opts.batchSize) {
              loader.done = true;
              $btn.hide();
              $doneMsg.fadeIn();
            }
          }
        })
        .fail(function () {
          console.error('Lỗi khi tải bài viết');
        })
        .always(function () {
          loader.loading = false;
          $spinner.addClass('d-none').hide();
          $label.show();
          $icon.show();
          $btn.prop('disabled', false);
        });
    });
  }

  /* =============================================================
     INIT
     ============================================================= */
  $(function () {
    initDarkMode();

    // Home page load-more (articles start from offset 14: 6 in grid + 8 in list)
    if ($('#btn-load-more').length) {
      initLoadMore({
        btnId:       '#btn-load-more',
        listId:      '#article-list',
        doneMsgId:   '#load-done-msg',
        startOffset: 14,
        batchSize:   8
      });
    }

    // Page view load-more (articles listed from offset 8)
    if ($('#btn-page-load-more').length) {
      initLoadMore({
        btnId:       '#btn-page-load-more',
        listId:      '#page-article-list',
        doneMsgId:   '#page-load-done-msg',
        startOffset: 8,
        batchSize:   8
      });
    }
  });

})(jQuery);
