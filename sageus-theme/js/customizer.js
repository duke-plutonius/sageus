/**
 * Sageus Theme Customizer Live Preview
 *
 * Handles live preview for customizer settings
 */

jQuery(document).ready(function($) {
	// Site title and description
	wp.customize('blogname', function(value) {
		value.bind(function(to) {
			$('.site-title a, .site-title').text(to);
		});
	});

	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});

	// Header Top Text
	wp.customize('sageus-theme_header_top_text_left', function(value) {
		value.bind(function(to) {
			$('.header-top-text.left').html(to);
		});
	});

	wp.customize('sageus-theme_header_top_text_right', function(value) {
		value.bind(function(to) {
			$('.header-top-text.right').html(to);
		});
	});

	// Custom Colors
	wp.customize('sageus-theme_primary_color', function(value) {
		value.bind(function(to) {
			$('body').css('--sageus-theme-primary-color', to);
			$('.site-title a, .site-title').css('color', to);
			$('.main-navigation a:hover, .main-navigation .current-menu-item > a').css('background-color', to);
			$('.pagination a:hover, .pagination .current').css('background-color', to);
			$('.comment-form .submit').css('background-color', to);
		});
	});

	wp.customize('sageus-theme_secondary_color', function(value) {
		value.bind(function(to) {
			$('body').css('--sageus-theme-secondary-color', to);
			$('a').css('color', to);
		});
	});

	wp.customize('sageus-theme_text_color', function(value) {
		value.bind(function(to) {
			$('body').css('--sageus-theme-text-color', to);
			$('body, .entry-content, .widget').css('color', to);
		});
	});

	wp.customize('sageus-theme_link_color', function(value) {
		value.bind(function(to) {
			$('body').css('--sageus-theme-link-color', to);
			$('a').css('color', to);
		});
	});

	// Custom Fonts
	wp.customize('sageus-theme_heading_font', function(value) {
		value.bind(function(to) {
			$('h1, h2, h3, h4, h5, h6, .site-title, .site-description, .widget-title, .main-navigation a, .panel-text h2, .portfolio-info h3').css('font-family', to + ', sans-serif');
		});
	});

	wp.customize('sageus-theme_body_font', function(value) {
		value.bind(function(to) {
			$('body, .entry-content, .widget').css('font-family', to + ', sans-serif');
		});
	});

	// Footer Image
	wp.customize('sageus-theme_footer_image', function(value) {
		value.bind(function(to) {
			if (to) {
				$('.front-page-section.footer-image').css('background-image', 'url(' + to + ')');
				$('.front-page-section.footer-image .parallax-bg').css('background-image', 'url(' + to + ')');
			} else {
				$('.front-page-section.footer-image').css('background-image', 'none');
				$('.front-page-section.footer-image .parallax-bg').css('background-image', 'none');
			}
		});
	});

	// Panel pages (these will require a refresh)
	wp.customize('sageus-theme_panel_page_1', function(value) {
		value.bind(function(to) {
			// Panel changes require page refresh
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

	wp.customize('sageus-theme_panel_page_2', function(value) {
		value.bind(function(to) {
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

	wp.customize('sageus-theme_panel_page_3', function(value) {
		value.bind(function(to) {
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

	// Panel column layouts
	wp.customize('sageus-theme_panel_column_1', function(value) {
		value.bind(function(to) {
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

	wp.customize('sageus-theme_panel_column_2', function(value) {
		value.bind(function(to) {
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

	wp.customize('sageus-theme_panel_column_3', function(value) {
		value.bind(function(to) {
			if (wp.customize.selectiveRefresh) {
				wp.customize.selectiveRefresh.requestChangeset();
			}
		});
	});

});
