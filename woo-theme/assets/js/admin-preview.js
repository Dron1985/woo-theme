jQuery(function ($) {
    $('body').on('click', '.block-editor-block-toolbar .components-toolbar-group .components-button .eye,.block-editor-block-toolbar .components-toolbar-group .components-button .eye-close ', function () {
        let button = $(this).parent();
        $(button).find('.eye').toggle();
        $(button).find('.eye-close').toggle();
        $(button).find('.block-preview').toggle('hidden')
    })
});