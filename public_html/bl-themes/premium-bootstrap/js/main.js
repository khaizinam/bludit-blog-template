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
     SEARCH
     ============================================================= */

  // Hàm submit search dùng chung cho cả overlay lẫn mobile form
  window.searchSubmit = function (form) {
    var q = $(form).find('input[name="q"]').val().trim();
    if (!q) return false;
    var baseUrl = window.SITE_URL || (window.location.origin + "/");
    // Đảm bảo baseUrl luôn kết thúc bằng một dấu "/"
    if (baseUrl.charAt(baseUrl.length - 1) !== '/') {
        baseUrl += '/';
    }
    window.location.href = baseUrl + "search/" + encodeURIComponent(q);
    return false;
  };

  function openSearchOverlay() {
    var $overlay = $('#search-overlay');
    if (!$overlay.length) return;
    $overlay.css('display', 'flex');
    // Trigger reflow để transition opacity hoạt động
    $overlay[0].offsetHeight;
    $overlay.addClass('is-open');
    $('body').css('overflow', 'hidden');
    setTimeout(function () {
      $('#search-overlay-input').trigger('focus');
    }, 260);
  }

  function closeSearchOverlay() {
    var $overlay = $('#search-overlay');
    $overlay.removeClass('is-open');
    $('body').css('overflow', '');
    // Ẩn hoàn toàn sau khi transition kết thúc (250ms)
    setTimeout(function () {
      $overlay.css('display', 'none');
    }, 260);
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
        batchSize:   8,
      });
    }

    // Page view load-more (articles listed from offset 8)
    if ($('#btn-page-load-more').length) {
      initLoadMore({
        btnId:       '#btn-page-load-more',
        listId:      '#page-article-list',
        doneMsgId:   '#page-load-done-msg',
        startOffset: 8,
        batchSize:   8,
      });
    }

    // Search overlay toggle
    $('#btn-search').on('click', function () {
      openSearchOverlay();
    });

    // Đóng overlay khi click backdrop
    $('#search-backdrop').on('click', function () {
      closeSearchOverlay();
    });

    // Đóng overlay khi click nút X
    $('#btn-search-close').on('click', function () {
      closeSearchOverlay();
    });

    // Đóng overlay khi nhấn Esc
    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' && $('#search-overlay').hasClass('is-open')) {
        closeSearchOverlay();
      }
    });
  });

})(jQuery);
