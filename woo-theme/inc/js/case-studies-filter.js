(function($, window, document) {
  'use strict';

  let caseFilters = $('.success-stories-section .tabs-nav');

  /**
   *
   * @param {String} $category
   */
  function caseAjaxQuery(category) {
    const data = {
      'action':      casevars.handler,
      'post_type':   casevars.post_type,
      '_ajax_nonce': casevars.nonce_token,
      'category':    category,
    };

    $.ajax({
      url: casevars.ajaxurl,
      type: 'post',
      data: data,
      dataType: 'json',
      success: function (response) {
        let postContainer = $('.success-stories-section .active .posts-list');

        if (response && postContainer.length) {
          postContainer.html(response.content);
        }
        $("html, body").animate({scrollTop: $('.success-stories-section .tabs-nav').offset().top - 70}, 500);
      }
    });
  }

  if (caseFilters.length) {
    caseFilters.click(['a'], function (e) {
      e.preventDefault();

      const el = e.target;
      const category = $(el).data('category');

      if (category) {
        caseAjaxQuery(category);
      }
    });
  }
})(jQuery, window, document)
