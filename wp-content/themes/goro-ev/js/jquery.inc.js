jQuery(function($) {

// contact form 7 送信時リセットをキャンセル
$('.wpcf7-form').each( function() {
	this.reset = function () { return null; };
});

$('#ocbt').on('click', function(){
	$('body').toggleClass('menuopen');
});

$('#mainmenu a').on('click', function(){
	$('body').removeClass('menuopen');
});

// ==========================================================================
// Mainvisual Slideshow Script (左右スライド & 無限ループ)
// ==========================================================================
(function() {
	var $slideshow = $("#mainvisual.slideshow");
	if (!$slideshow.length) return;

	var $slidesContainer = $slideshow.find(".slideshow-slides");
	var $slides = $slideshow.find(".slide-item");
	var $dots = $slideshow.find(".indicator-dot");
	var $prevBtn = $slideshow.find(".slide-prev");
	var $nextBtn = $slideshow.find(".slide-next");
	var $btnPause = $slideshow.find(".btn-pause");
	var $btnPlay = $slideshow.find(".btn-play");

	var originalCount = parseInt($slideshow.data("original-count"), 10) || $dots.length;
	var totalSlides = $slides.length;
	if (originalCount <= 1 || totalSlides <= 1) return;

	// 多重化時の初期位置を中央のセットの先頭に設定
	var repeatCount = parseInt($slideshow.data("repeat-count"), 10) || 1;
	var middleSet = Math.floor(repeatCount / 2);
	var currentIndex = middleSet * originalCount; // 実際のDOM上のスライド番号
	var isAnimating = false;
	var isPlaying = true;
	var timer = null;
	var intervalTime = 5000; // 5秒間隔

	// 初期位置をセット（アニメーションなし）
	function updateSlidePosition(noTransition) {
		if (noTransition) {
			$slidesContainer.addClass("no-transition");
		} else {
			$slidesContainer.removeClass("no-transition");
		}

		var offsetPercent = - (currentIndex * 100);
		$slidesContainer.css("transform", "translateX(" + offsetPercent + "%)");

		if (noTransition) {
			// 強制リフロー
			$slidesContainer[0].offsetHeight;
			$slidesContainer.removeClass("no-transition");
		}

		// インジケーター（本来の枚数）とアクセシビリティ（aria-hidden / tabindex）の同期
		var realIndex = currentIndex % originalCount;
		$dots.removeClass("is-active").attr("aria-selected", "false");
		$dots.eq(realIndex).addClass("is-active").attr("aria-selected", "true");

		$slides.each(function(idx) {
			var $item = $(this);
			var isCurrent = (idx === currentIndex);
			var isClone = $item.hasClass("is-clone");

			if (isCurrent) {
				$item.addClass("is-active").attr("aria-hidden", "false");
				$item.find("a").removeAttr("tabindex");
			} else {
				$item.removeClass("is-active");
				$item.attr("aria-hidden", "true");
				$item.find("a").attr("tabindex", "-1");
			}
		});
	}

	function goToSlide(targetIndex) {
		if (isAnimating) return;
		isAnimating = true;

		currentIndex = targetIndex;
		updateSlidePosition(false);

		// トランジション終了後にループの境界チェックを行い、中央セットへワープ
		setTimeout(function() {
			var realIndex = currentIndex % originalCount;
			if (currentIndex < originalCount || currentIndex >= (repeatCount - 1) * originalCount) {
				currentIndex = middleSet * originalCount + realIndex;
				updateSlidePosition(true);
			}
			isAnimating = false;
		}, 1020); // CSSのtransition 1.0s + マージン
	}

	function nextSlide() {
		goToSlide(currentIndex + 1);
	}

	function prevSlide() {
		goToSlide(currentIndex - 1);
	}

	function startAutoPlay() {
		if (timer) clearInterval(timer);
		timer = setInterval(nextSlide, intervalTime);
		isPlaying = true;
		$btnPause.addClass("is-active");
		$btnPlay.removeClass("is-active");
	}

	function stopAutoPlay() {
		if (timer) {
			clearInterval(timer);
			timer = null;
		}
		isPlaying = false;
		$btnPause.removeClass("is-active");
		$btnPlay.addClass("is-active");
	}

	$nextBtn.on("click", function() {
		nextSlide();
		if (isPlaying) startAutoPlay();
	});

	$prevBtn.on("click", function() {
		prevSlide();
		if (isPlaying) startAutoPlay();
	});

	$dots.on("click", function() {
		var targetOriginalIndex = parseInt($(this).data("slide-index"), 10);
		var targetIndex = middleSet * originalCount + targetOriginalIndex;
		goToSlide(targetIndex);
		if (isPlaying) startAutoPlay();
	});

	$btnPause.on("click", function() {
		stopAutoPlay();
	});

	$btnPlay.on("click", function() {
		startAutoPlay();
	});

	// 初期表示位置をセット
	updateSlidePosition(true);

	// 自動再生開始
	startAutoPlay();
})();

});
