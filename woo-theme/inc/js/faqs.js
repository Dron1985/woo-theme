"use strict";

document.addEventListener('DOMContentLoaded', () => {
    /**
     * Get First element by class.
     */
    function getElByClassFirst(elClass, $parent = '') {
        let $el = $parent === '' ? document.getElementsByClassName(elClass) : $parent.getElementsByClassName(elClass);
        return $el.length > 0 ? $el[0] : '';
    }

    /**
     * Update content by AJAX.
     */
    function updateAjaxData() {
        $.ajax({
            type: 'POST',
            url: ajaxvars.ajaxurl,
            data: {
                action: 'faqs_load',
                data: {
                    'term_slug': urlObject.searchParams.get('category'),
                    'text': urlObject.searchParams.get('text'),
                    'items_pp': $section.getAttribute('data-items-pp')
                },
                _ajax_nonce: faqs_vars.faqs_nonce
            },
            success: function (response) {
                if (response.result) {
                    let $wrap = getElByClassFirst('buttons-holder', $section);
                    if (response.content.display_load_btn) {
                        $wrap.classList.remove('hidden');
                    }
                    else {
                        $wrap.classList.add('hidden');
                    }

                    let $ul = getElByClassFirst('accordion', $section);
                    $ul.innerHTML = response.content.content;

                    let $span, slug;
                    for (let $el of $ulCategory.children) {
                        $span = getElByClassFirst('bd-item-count', $el);
                        slug = $el.getAttribute('data-id');
                        if (slug == '--') {
                            $span.innerHTML = '(' + response.content.term_all + ')';
                        }
                        else {
                            if (slug in response.content.terms) {
                                $span.innerHTML = '(' + response.content.terms[slug] + ')';
                            }
                            else {
                                $span.innerHTML = 0;
                            }
                        }
                    }
                }
            }
        });
    }

    /*
     * Main code.
     */
    let $section = getElByClassFirst('bd-faq-section');
    let urlObject = new URL(document.location.href);
    let $form = getElByClassFirst('category-form-search', $section);
    let $ulCategory = getElByClassFirst('categories-list', $section);

    // Search by Form.
    if ($form) {
        $form.addEventListener('submit', (e) => {
            e.preventDefault();
            let searchText = getElByClassFirst('bd-key-search', $form).value;
            if (urlObject.searchParams.get('text') != searchText) {
                if (searchText) {
                    urlObject.searchParams.set('text', searchText);
                }
                else {
                    urlObject.searchParams.delete('text');
                }
                history.pushState(null, document.title, urlObject.toString());

                updateAjaxData();
            }
        });
    }

    // Filter by Category.
    if ($ulCategory) {
        $ulCategory.addEventListener('click', (e) => {
            e.preventDefault();

            let $elem = e.target;
            let tag = $elem.tagName;
            if (tag !== 'LI') {
                $elem = $elem.parentNode;
            }

            let slug = $elem.getAttribute('data-id');
            if (slug) {
                if (slug === '--') {
                    slug = null;
                }
                if (urlObject.searchParams.get('category') != slug) {
                    for (let $el of $ulCategory.children) {
                        $el.classList.remove('active');
                    }
                    $elem.classList.add('active');

                    if (slug) {
                        urlObject.searchParams.set('category', slug);
                    }
                    else {
                        urlObject.searchParams.delete('category');
                    }
                    history.pushState(null, document.title, urlObject.toString());

                    updateAjaxData();
                }
            }
        });
    }

    // Load More button.
    let $loadMore = $section ? getElByClassFirst('bd-load-more', $section) : null;
    if ($loadMore) {
        $loadMore.addEventListener('click', (e) => {
            e.preventDefault();

            let $ul = getElByClassFirst('accordion', $section);
            let items_pp = $section.getAttribute('data-items-pp');
            let process = 0;
            let last = 0;
            for (let $el of $ul.children) {
                if ($el.classList.contains('hidden')) {
                    if (process < items_pp) {
                        $el.classList.remove('hidden');
                        process++;
                    }
                    else {
                        last++;
                    }
                }
            }
            let $wrap = getElByClassFirst('buttons-holder', $section);
            if ($wrap && !last) {
                $wrap.classList.add('hidden');
            }
        });
    }
});
