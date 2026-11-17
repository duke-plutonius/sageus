<?php
/**
 * Sageus Theme Functions
 *
 * @package Sageus
 */

// Define theme version
if ( ! defined( 'SAGEUS_VERSION' ) ) {
	define( 'SAGEUS_VERSION', '1.0' );
}

// Define theme paths
if ( ! defined( 'SAGEUS_INC_DIR' ) ) {
	define( 'SAGEUS_INC_DIR', get_template_directory() . '/inc' );
}

/**
 * Sageus Theme Setup
 */
function sageus_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'sageus-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Register custom image sizes
	add_image_size( 'sageus-theme-square', 400, 400, true ); // Square for blog panels
	add_image_size( 'sageus-theme-featured', 2000, 1200, true ); // Featured images
	add_image_size( 'sageus-theme-logo', 200, 200, false ); // Site logo max height 200px

	// Enable support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 2000,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Enable support for Custom Background
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) );

	// Enable support for Custom Header
	add_theme_support( 'custom-header', array(
		'default-image' => '',
		'width'         => 2000,
		'height'        => 1200,
		'flex-width'    => true,
		'flex-height'   => true,
	) );

	// Enable support for Custom Colors
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Enable support for HTML5 markup
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for Post Formats
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'sageus-theme' ),
		'social'  => esc_html__( 'Social Menu', 'sageus-theme' ),
	) );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add excerpt support for pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'sageus_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function sageus_content_width() {
	$content_width = 700; // Default content width for posts and pages
	
	// For front page, use 1120px
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$content_width = 1120;
	}
	
	// For full-width pages
	if ( is_page_template( 'page-full-width.php' ) ) {
		$content_width = 1520;
	}
	
	/**
	 * Filter Sageus content width of the theme.
	 *
	 * @since Sageus 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$content_width = apply_filters( 'sageus_content_width', $content_width );
	
	// Finally, set the content width
	$GLOBALS['content_width'] = absint( $content_width );
}
add_action( 'after_setup_theme', 'sageus_content_width', 0 );

/**
 * Register widget areas
 */
function sageus_widgets_init() {
	// Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'sageus-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'sageus-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// Portfolio Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Portfolio Sidebar', 'sageus-theme' ),
		'id'            => 'portfolio-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in the portfolio sidebar.', 'sageus-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// Footer widget areas
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer %d', 'sageus-theme' ), $i ),
			'id'            => 'footer-' . $i,
			'description'   => sprintf( esc_html__( 'Add widgets here to appear in footer column %d.', 'sageus-theme' ), $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'sageus_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function sageus_scripts() {
	// Load theme stylesheet
	wp_enqueue_style( 'sageus-theme-style', get_stylesheet_uri(), array(), SAGEUS_VERSION );

	// Load Google Fonts
	wp_enqueue_style( 'sageus-theme-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Open+Sans:400,400i,600,700&display=swap', array(), null );

	// Load Font Awesome for social icons (fallback)
	wp_enqueue_style( 'sageus-theme-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0' );

	// Load main JavaScript file
	wp_enqueue_script( 'sageus-theme-script', get_template_directory_uri() . '/js/sageus-theme.js', array( 'jquery' ), SAGEUS_VERSION, true );

	// Localize script for AJAX and other functionality
	wp_localize_script( 'sageus-theme-script', 'sageus-themeData', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'theme_url' => get_template_directory_uri(),
	) );

	// Add comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sageus_scripts' );

/**
 * Enqueue admin styles
 */
function sageus_admin_styles( $hook ) {
	// Only load on widget admin page
	if ( 'widgets.php' === $hook ) {
		wp_enqueue_style( 'sageus-theme-admin', get_template_directory_uri() . '/css/admin.css', array(), SAGEUS_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'sageus_admin_styles' );

/**
 * Load theme customizer
 */
require_once SAGEUS_INC_DIR . '/customizer.php';

/**
 * Load portfolio functionality
 */
require_once SAGEUS_INC_DIR . '/portfolio.php';

/**
 * Load template tags
 */
require_once SAGEUS_INC_DIR . '/template-tags.php';

/**
 * Fallback for primary menu
 */
function sageus_primary_menu_fallback() {
	?>
	<ul id="primary-menu" class="menu">
		<li class="menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'sageus-theme' ); ?></a></li>
		<?php
			$pages = wp_get_recent_posts( array(
				'numberposts' => 5,
				'post_status' => 'publish',
				'post_type'   => 'page',
			) );
			
			foreach ( $pages as $page ) :
				?>
				<li class="menu-item"><a href="<?php echo esc_url( get_permalink( $page['ID'] ) ); ?>"><?php echo esc_html( $page['post_title'] ); ?></a></li>
				<?php
			endforeach;
			
			wp_reset_postdata();
		?>
	</ul>
	<?php
}

/**
 * Filter the except length
 */
function sageus_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 55;
}
add_filter( 'excerpt_length', 'sageus_excerpt_length' );

/**
 * Filter the excerpt more text
 */
function sageus_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '...';
}
add_filter( 'excerpt_more', 'sageus_excerpt_more' );

/**
 * Add body classes for different page types
 */
function sageus_body_classes( $classes ) {
	// Add class for static front page
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$classes[] = 'static-front-page';
	}

	// Add class for blog index
	if ( is_home() && 'posts' === get_option( 'show_on_front' ) ) {
		$classes[] = 'blog-index';
	}

	// Add class for portfolio pages
	if ( is_page_template( 'page-portfolio.php' ) || is_page_template( 'templates/page-portfolio.php' ) ) {
		$classes[] = 'portfolio-page';
	}

	// Add class if sidebar is hidden
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'sageus_body_classes' );

/**
 * Modify the read more link
 */
function sageus_modify_read_more_link() {
	return '<a class="more-link" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'sageus-theme' ) . '</a>';
}
add_filter( 'the_content_more_link', 'sageus_modify_read_more_link' );

/**
 * Add pingback url auto-discovery header for singularly identifiable articles
 */
function sageus_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sageus_pingback_header' );

/**
 * Display portfolio panel on front page
 * Called from front-page.php
 */
function sageus_display_portfolio_panel( $limit = 6 ) {
	// Check if Jetpack Portfolio plugin is active
	if ( class_exists( 'Jetpack_Portfolio' ) && post_type_exists( 'jetpack-portfolio' ) ) {
		$post_type = 'jetpack-portfolio';
	} elseif ( post_type_exists( 'portfolio' ) ) {
		$post_type = 'portfolio';
	} else {
		// Use the fallback portfolio post type
		$post_type = 'sageus_portfolio';
	}

	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$portfolio_query = new WP_Query( $args );

	if ( $portfolio_query->have_posts() ) :
		?>
		<div class="portfolio-grid">
			<?php
				while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
					$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'sageus-theme-square' );
					$terms = get_the_terms( get_the_ID(), 'jetpack-portfolio-type' );
					if ( ! $terms && post_type_exists( 'sageus_portfolio' ) ) {
						$terms = get_the_terms( get_the_ID(), 'sageus_portfolio_type' );
					}
					
					?>
					<div class="portfolio-item">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="portfolio-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'sageus-theme-square' ); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<div class="portfolio-info">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
								<div class="portfolio-types">
									<?php
										$term_names = array();
										foreach ( $terms as $term ) {
											$term_names[] = $term->name;
										}
										echo esc_html( implode( ', ', $term_names ) );
									?>
								</div>
							<?php endif; ?>
							<?php the_excerpt(); ?>
						</div>
					</div>
					<?php
				endwhile;
				
				wp_reset_postdata();
			?>
		</div>
		<?php
	else :
		?>
		<p class="no-portfolio-items">
			<?php esc_html_e( 'No portfolio items found.', 'sageus-theme' ); ?>
		</p>
		<?php
	endif;
}

/**
 * Add social icon classes to menu items based on URL
 */
function sageus_add_social_icon_class( $items, $menu, $args ) {
	// Only modify the social menu
	if ( 'social' !== $args->theme_location ) {
		return $items;
	}

	$social_services = array(
		'bandcamp.com' => 'bandcamp',
		'codepen.io' => 'codepen',
		'digg.com' => 'digg',
		'dribbble.com' => 'dribbble',
		'dropbox.com' => 'dropbox',
		'facebook.com' => 'facebook',
		'flickr.com' => 'flickr',
		'foursquare.com' => 'foursquare',
		'github.com' => 'github',
		'plus.google.com' => 'googleplus',
		'instagram.com' => 'instagram',
		'linkedin.com' => 'linkedin',
		'path.com' => 'path',
		'pinterest.com' => 'pinterest',
		'getpocket.com' => 'pocket',
		'polldaddy.com' => 'polldaddy',
		'reddit.com' => 'reddit',
		'skype.com' => 'skype',
		'soundcloud.com' => 'soundcloud',
		'spotify.com' => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com' => 'tumblr',
		'twitch.tv' => 'twitch',
		'twitter.com' => 'twitter',
		'vimeo.com' => 'vimeo',
		'vine.co' => 'vine',
		'wordpress.com' => 'wordpress',
		'wordpress.org' => 'wordpress',
		'youtube.com' => 'youtube',
	);

	foreach ( $items as &$item ) {
		$url = strtolower( $item->url );
		
		// Check for mailto links
		if ( strpos( $url, 'mailto:' ) === 0 ) {
			$item->classes[] = 'social-icon-email';
			continue;
		}
		
		// Check for /feed/ links
		if ( strpos( $url, '/feed/' ) !== false || strpos( $url, '/rss' ) !== false || strpos( $url, '/atom' ) !== false ) {
			$item->classes[] = 'social-icon-rss';
			continue;
		}
		
		// Check for social media URLs
		foreach ( $social_services as $domain => $service ) {
			if ( strpos( $url, $domain ) !== false ) {
				$item->classes[] = 'social-icon-' . $service;
				break;
			}
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'sageus_add_social_icon_class', 10, 3 );

/**
 * Modify the menu item output to add icon spans
 */
function sageus_add_social_icon_span( $item_output, $item, $depth, $args ) {
	// Only modify the social menu
	if ( 'social' !== $args->theme_location ) {
		return $item_output;
	}

	// Check if this item has a social icon class
	$icon_class = '';
	foreach ( $item->classes as $class ) {
		if ( strpos( $class, 'social-icon-' ) === 0 ) {
			$icon_class = $class;
			break;
		}
	}

	if ( ! empty( $icon_class ) ) {
		$icon_name = str_replace( 'social-icon-', '', $icon_class );
		$icon_html = '<i class="fa fa-' . esc_attr( $icon_name ) . '" aria-hidden="true"></i>';
		$item_output = str_replace( '</a>', $icon_html . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'sageus_add_social_icon_span', 10, 4 );

/**
 * Remove the social icon class from the menu item output
 * (we already added the icon span, so we don't need the class)
 */
function sageus_clean_social_menu_classes( $classes, $item, $args ) {
	// Only modify the social menu
	if ( 'social' !== $args->theme_location ) {
		return $classes;
	}

	// Remove social-icon-* classes from the output
	$classes = array_filter( $classes, function( $class ) {
		return strpos( $class, 'social-icon-' ) !== 0;
	} );

	return $classes;
}
add_filter( 'nav_menu_css_class', 'sageus_clean_social_menu_classes', 10, 3 );
