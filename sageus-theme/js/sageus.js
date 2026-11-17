/**
 * Sageus Theme JavaScript
 *
 * Handles theme-specific functionality including:
 * - Parallax scrolling
 * - Portfolio filtering
 * - Mobile menu toggle
 * - Smooth scrolling
 */

jQuery(document).ready(function($) {
	// Check if we're on a touch device
	var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;

	// ============================================
	// Parallax Scrolling
	// ============================================
	
	// Only enable parallax on non-touch devices for performance
	if ( ! isTouchDevice ) {
		$(window).on('scroll', function() {
			var scrollTop = $(window).scrollTop();
			
			// Parallax for hero section
			$('.front-page-section.hero .parallax-bg').css({
				'transform': 'translateY(' + (scrollTop * 0.5) + 'px)'
			});
			
			// Parallax for panel sections
			$('.front-page-section.panel .parallax-bg').each(function() {
				var $section = $(this).closest('.front-page-section');
				var sectionOffset = $section.offset().top;
				var sectionHeight = $section.outerHeight();
				
				// Calculate parallax offset based on section position
				var parallaxOffset = (scrollTop - sectionOffset) * 0.3;
				
				// Only apply parallax when section is in view
				if ( scrollTop > sectionOffset - $(window).height() && scrollTop < sectionOffset + sectionHeight ) {
					$(this).css({
						'transform': 'translateY(' + parallaxOffset + 'px)'
					});
				}
			});
			
			// Parallax for footer image
			$('.front-page-section.footer-image .parallax-bg').css({
				'transform': 'translateY(' + (scrollTop * 0.2) + 'px)'
			});
		});
	}

	// ============================================
	// Portfolio Filtering
	// ============================================
	
	$('.portfolio-filters a').on('click', function(e) {
		e.preventDefault();
		var filter = $(this).data('filter');
		
		// Update active class
		$('.portfolio-filters li').removeClass('active');
		$(this).parent().addClass('active');
		
		// Filter items with fade animation
		if ( filter === '*' ) {
			$('.portfolio-item').fadeIn(300);
		} else {
			$('.portfolio-item').each(function() {
				if ( $(this).is(filter) ) {
					$(this).fadeIn(300);
				} else {
					$(this).fadeOut(300);
				}
			});
		}
		
		// Scroll to portfolio grid
		var $portfolioGrid = $('.portfolio-grid');
		if ( $portfolioGrid.length ) {
			$('html, body').animate({
				scrollTop: $portfolioGrid.offset().top - 100
			}, 500);
		}
	});

	// ============================================
	// Mobile Menu Toggle
	// ============================================
	
	// Add mobile menu button
	var $mobileMenuButton = $('<button class="mobile-menu-toggle" aria-label="' + sageus-themeData.menuToggleLabel + '" aria-expanded="false" aria-controls="primary-menu"><span class="screen-reader-text">' + sageus-themeData.menuToggleLabel + '</span><span class="hamburger"></span></button>');
	
	// Insert before the navigation
	$('.main-navigation').before($mobileMenuButton);
	
	// Toggle mobile menu
	$mobileMenuButton.on('click', function() {
		var isExpanded = $(this).attr('aria-expanded') === 'true';
		$(this).attr('aria-expanded', !isExpanded);
		$('.main-navigation ul').slideToggle(300);
	});
	
	// ============================================
	// Smooth Scrolling
	// ============================================
	
	// Smooth scroll for anchor links
	$('a[href*="#"]').not('[href="#"]').on('click', function(e) {
		var target = $(this.hash);
		if ( target.length ) {
			e.preventDefault();
			var targetOffset = target.offset().top;
			
			// Account for fixed header
			if ( $('.site-header').css('position') === 'fixed' ) {
				targetOffset -= $('.site-header').outerHeight();
			}
			
			$('html, body').animate({
				scrollTop: targetOffset
			}, 800);
			
			// Update URL hash
			window.location.hash = this.hash;
		}
	});

	// ============================================
	// Header Background on Scroll
	// ============================================
	
	var $header = $('.site-header');
	var headerOffset = $header.offset().top;
	
	$(window).on('scroll', function() {
		var scrollTop = $(window).scrollTop();
		
		// Add solid background when scrolling
		if ( scrollTop > 50 ) {
			$header.addClass('scrolled');
		} else {
			$header.removeClass('scrolled');
		}
	});

	// ============================================
	// Responsive Video Embeds
	// ============================================
	
	function responsiveVideos() {
		$('iframe[src*="youtube.com"], iframe[src*="vimeo.com"], iframe[src*="dailymotion.com"]').each(function() {
			var $video = $(this);
			var aspectRatio = 16 / 9;
			var width = $video.attr('width') || $video.width();
			var height = $video.attr('height') || $video.height();
			
			// Calculate new height based on aspect ratio
			if ( width && ! height ) {
				height = width / aspectRatio;
				$video.css('height', height + 'px');
			} else if ( height && ! width ) {
				width = height * aspectRatio;
				$video.css('width', width + 'px');
			}
			
			// Wrap in responsive container
			if ( ! $video.parent().hasClass('video-container') ) {
				$video.wrap('<div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;"></div>');
				$video.css({
					'position': 'absolute',
					'top': '0',
					'left': '0',
					'width': '100%',
					'height': '100%'
				});
			}
		});
	}
	
	// Run on load and resize
	responsiveVideos();
	$(window).on('resize', responsiveVideos);

	// ============================================
	// Back to Top Button
	// ============================================
	
	var $backToTop = $('<button class="back-to-top" aria-label="' + sageus-themeData.backToTopLabel + '"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>');
	$('body').append($backToTop);
	
	$backToTop.on('click', function() {
		$('html, body').animate({
			scrollTop: 0
		}, 800);
	});
	
	$(window).on('scroll', function() {
		if ( $(this).scrollTop() > 300 ) {
			$backToTop.fadeIn(200);
		} else {
			$backToTop.fadeOut(200);
		}
	});

	// ============================================
	// FitVids for responsive video
	// ============================================
	
	// Check if FitVids is loaded, otherwise use our own implementation
	if ( typeof $.fn.fitVids === 'function' ) {
		$('body').fitVids();
	}

	// ============================================
	// Keyboard Navigation
	// ============================================
	
	// Add focus styles for keyboard navigation
	$(document).on('keydown', function(e) {
		if ( e.key === 'Tab' ) {
			$('body').addClass('keyboard-navigation');
		}
	});
	
	$(document).on('mousedown', function() {
		$('body').removeClass('keyboard-navigation');
	});

	// ============================================
	// Accessibility Enhancements
	// ============================================
	
	// Skip to content link
	$('.skip-link').on('click', function(e) {
		e.preventDefault();
		var target = $(this).attr('href');
		$(target).attr('tabindex', -1).focus();
	});

	// Add focus outline for interactive elements
	$('a, button, input, select, textarea').on('focus', function() {
		$(this).addClass('focus-outline');
	});
	
	$('a, button, input, select, textarea').on('blur', function() {
		$(this).removeClass('focus-outline');
	});

	// ============================================
	// Initialize
	// ============================================
	
	// Trigger scroll event to set initial state
	$(window).trigger('scroll');
	
	// Hide mobile menu on larger screens
	$(window).on('resize', function() {
		if ( $(window).width() > 768 ) {
			$('.main-navigation ul').css('display', '');
			$('.mobile-menu-toggle').attr('aria-expanded', 'false');
		}
	});

});

// ============================================
// Standalone Functions (not jQuery dependent)
// ============================================

// Check if element is in viewport
function isElementInViewport(el) {
	var rect = el.getBoundingClientRect();
	return (
		rect.top >= 0 &&
		rect.left >= 0 &&
		rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		rect.right <= (window.innerWidth || document.documentElement.clientWidth)
	);
}

// Debounce function for performance
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if ( ! immediate ) func.apply(context, args);
		};
		var callNow = immediate && ! timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if ( callNow ) func.apply(context, args);
	};
}
