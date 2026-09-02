jQuery(function($) {


// contact form 7 送信時リセットをキャンセル
$('.wpcf7-form').each( function() {
	this.reset = function () { return null; };
});

$('#ocbt').on('click', function(){
	$('body').toggleClass('menuopen');
});

});
