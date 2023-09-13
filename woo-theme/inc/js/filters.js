(function ($, window, document) {
    'use strict';
    function setQueryStringParameter(name, value, append=false) {
        const url = new URL(window.document.URL);
        if (value.length){
            if (append) url.searchParams.append(name, value);
            else url.searchParams.set(name, value);
        }else{
            url.searchParams.delete(name);
        }
        window.history.replaceState(null, "", url.toString());
    }

    var page = {
        init: function () {
            page.search_clear();
            page.filter_news();
            page.pagination();
            page.filter_faq();
        },
        search_clear: function() {
            if ($('.search-result-form').length) {
                $('.search-result-form').on('click', 'button[type="reset"]', function(e) {
                    e.preventDefault();
                    window.location.href = $('#main-search').attr('action')+'?s=';
                });
            }
        },
        filter_news: function() {
            if ($('.news-filters').length) {
                $('.news-filters').on('click', 'a', function(e) {
                    e.preventDefault();
                    var term = $(this).attr('data-term');

                    if (term != 'all') {
                        setQueryStringParameter('category', term);
                    } else {
                        setQueryStringParameter('category', '');
                    }

                    $('.news-filters li a').each(function (i) {
                        $(this).removeClass('active');
                    });

                    $(this).addClass('active');

                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : vars.ajax.action,
                            post_type : vars.ajax.post_type,
                            term : term,
                            _ajax_nonce: vars.ajax.filter_nonce_token
                        },
                        type: 'POST',
                        success: function success(response) {
                            if (response) {
                                if ($('.listing-news').length) {
                                    $('.listing-news').html(response.content);
                                    $('.news-pagination').html(response.pagination);
                                } else {
                                    $('.products').html(response.content);
                                }
                            }
                        }
                    });
                });
            }
        },
        pagination: function() {
            $('.news-pagination').on('click', '.page-numbers', function(e){
                e.preventDefault();
                var term = $('.news-filters .active').attr('data-term');
                var paged = $(this).attr('data-num');

                if (paged > 0) {
                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : vars.ajax.action,
                            post_type : vars.ajax.post_type,
                            term : term,
                            paged : paged,
                            _ajax_nonce: vars.ajax.filter_nonce_token
                        },
                        type: "POST",
                        success: function success(response) {
                            if (response) {
                                $('.listing-news').html(response.content);
                                $('.news-pagination').html(response.pagination);

                                //Scroll to up
                                $("html, body").animate({scrollTop: $('.news-filters').offset().top - 200}, 500);
                            }
                        }
                    });
                }
            });
        },
        filter_faq: function() {
            if ($('.faq-inner').length) {
                $('.categories-list').on('click', 'span', function(e) {
                    e.preventDefault();
                    var term = $(this).closest('.category-item').attr('data-term');
                    var data_attr = $('#faq-search-form').serialize();

                    $('.faq-inner .buttons-holder').addClass('hidden');
                    $('.categories-list li').each(function (i) {
                        $(this).removeClass('active');
                    });

                    $(this).closest('.category-item').addClass('active');

                    if (term != 'all') {
                        setQueryStringParameter('category', term);
                    } else {
                        setQueryStringParameter('category', '');
                    }

                    if ($('input[name="search"]').length) {
                        setQueryStringParameter('search', $('input[name="search"]').val());
                    }

                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : vars.ajax.action,
                            post_type : vars.ajax.post_type,
                            term : term,
                            data_attr: data_attr,
                            _ajax_nonce: vars.ajax.filter_nonce_token
                        },
                        type: 'POST',
                        success: function success(response) {
                            if (response) {
                                $('.faq-inner .accordion').html(response.content);
                                if (response.button !== 0){
                                    $('.faq-inner .bd-load-more').attr('data-paged', response.button);
                                    $('.faq-inner .buttons-holder').removeClass('hidden');
                                }
                            }
                        }
                    });
                });

                $('.faq-inner').on('click', '.btn-search', function(e){
                    e.preventDefault();
                    var data_attr = $('#faq-search-form').serialize();

                    $('.faq-inner .buttons-holder').addClass('hidden');
                    setQueryStringParameter('category', '');
                    $('.categories-list li').each(function (i) {
                        $(this).removeClass('active');
                    });

                    if ($('input[name="search"]').length) {
                        var search = $('input[name="search"]').val();
                        setQueryStringParameter('search', $('input[name="search"]').val());
                    }

                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : vars.ajax.action,
                            post_type : vars.ajax.post_type,
                            term : 'all',
                            data_attr: data_attr,
                            term_update: true,
                            _ajax_nonce: vars.ajax.filter_nonce_token
                        },
                        type: "POST",
                        success: function success(response) {
                            if (response) {
                                $('.faq-inner .accordion').html(response.content);

                                if (response.terms) {
                                    $('.categories-list').html(response.terms);
                                }

                                if (response.button !== 0){
                                    $('.faq-inner .bd-load-more').attr('data-paged', response.button);
                                    $('.faq-inner .buttons-holder').removeClass('hidden');
                                }
                            }
                        }
                    });
                });

                $('.faq-inner').on('click', '.bd-load-more', function(e){
                    e.preventDefault();
                    var term = $('.categories-list .active').attr('data-term');
                    var data_attr = $('#faq-search-form').serialize();
                    var paged = $(this).attr('data-paged');

                    if (paged > 0) {
                        $.ajax({
                            url: ajaxvars.ajaxurl,
                            data: {
                                action : vars.ajax.action,
                                post_type : vars.ajax.post_type,
                                term : term,
                                data_attr: data_attr,
                                paged : paged,
                                _ajax_nonce: vars.ajax.filter_nonce_token
                            },
                            type: "POST",
                            success: function success(response) {
                                if (response) {
                                    $('.faq-inner .accordion li:last').after(response.content);
                                    if (data_attr === '') {
                                        $('.categories-list').html(response.pagination);
                                    }

                                    if (response.button !== 0){
                                        $('.faq-inner .bd-load-more').attr('data-paged', response.button);
                                        $('.faq-inner .buttons-holder').removeClass('hidden');
                                    } else {
                                        $('.faq-inner .buttons-holder').addClass('hidden');
                                    }
                                }
                            }
                        });
                    }
                });
            }
        },
        load: function () {
            if ($('.faq-inner').length) {
                var term = $('.categories-list .active').attr('data-term');
                var data_attr = $('#faq-search-form').serialize();

                if (term != '') {
                    let searchParams = new URLSearchParams(window.location.search);
                    if (searchParams.has('category')) {
                        term = searchParams.get('category');
                        $('.categories-list .category-item[data-term|="'+term+'"]').addClass('active');
                    }
                }

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : vars.ajax.action,
                        post_type : vars.ajax.post_type,
                        term : term,
                        data_attr: data_attr,
                        _ajax_nonce: vars.ajax.filter_nonce_token
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.faq-inner .accordion').html(response.content);

                            if (response.terms) {
                                $('.categories-list').html(response.terms);
                            }

                            if (response.button !== 0){
                                $('.faq-inner .bd-load-more').attr('data-paged', response.button);
                                $('.faq-inner .buttons-holder').removeClass('hidden');
                            } else {
                                $('.faq-inner .buttons-holder').addClass('hidden');
                            }
                        }
                    }
                });
            }
        },
        resize: function () {
        },
        scroll: function () {
        }
    };

    $(document).ready(page.init);
    $(window).on({
        'load': page.load,
        'resize': page.resize,
        'scroll': page.scroll
    });
})(jQuery, window, document);