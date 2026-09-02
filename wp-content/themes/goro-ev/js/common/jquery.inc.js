jQuery(function($) {

//JavaScript有効時に表示、無効時にはCSSで非表示
$('.hide_if_no_js').removeClass('hide_if_no_js').addClass('show_if_js');
$('.hide_if_no_js').find(':disabled').prop("disabled", false);

//.show_if_no_js noscript的な扱い?
$('.show_if_no_js').hide();

});
