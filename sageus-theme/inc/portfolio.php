<?php
/**
 * Sageus Theme Portfolio Functionality
 *
 * @package Sageus
 */

/**
 * Register Portfolio post type if no portfolio plugin is active
 */
function sageus_register_portfolio_post_type() {
	// Check if Jetpack Portfolio is active
	if ( class_exists( 'Jetpack_Portfolio' ) && post_type_exists( 'jetpack-portfolio' ) ) {
		return;
	}

	// Check if another portfolio plugin is active
	if ( post_type_exists( 'portfolio' ) ) {
		return;
	}

	// Register custom portfolio post type
	$labels = array(
		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'sageus-theme' ),
		'singular_name'         => _x( 'Portfolio Item', 'Post Type Singular Name', 'sageus-theme' ),
		'menu_name'             => __( 'Portfolio', 'sageus-theme' ),
		'name_admin_bar'        => __( 'Portfolio Item', 'sageus-theme' ),
		'archives'              => __( 'Portfolio Archives', 'sageus-theme' ),
		'attributes'            => __( 'Portfolio Attributes', 'sageus-theme' ),
		'parent_item_colon'     => __( 'Parent Portfolio Item:', 'sageus-theme' ),
		'all_items'             => __( 'All Portfolio Items', 'sageus-theme' ),
		'add_new_item'          => __( 'Add New Portfolio Item', 'sageus-theme' ),
		'add_new'               => __( 'Add New', 'sageus-theme' ),
		'new_item'              => __( 'New Portfolio Item', 'sageus-theme' ),
		'edit_item'             => __( 'Edit Portfolio Item', 'sageus-theme' ),
		'update_item'           => __( 'Update Portfolio Item', 'sageus-theme' ),
		'view_item'             => __( 'View Portfolio Item', 'sageus-theme' ),
		'view_items'            => __( 'View Portfolio Items', 'sageus-theme' ),
		'search_items'          => __( 'Search Portfolio Items', 'sageus-theme' ),
		'not_found'             => __( 'Not found', 'sageus-theme' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sageus-theme' ),
		'featured_image'        => __( 'Featured Image', 'sageus-theme' ),
		'set_featured_image'    => __( 'Set featured image', 'sageus-theme' ),
		'remove_featured_image' => __( 'Remove featured image', 'sageus-theme' ),
		'use_featured_image'    => __( 'Use as featured image', 'sageus-theme' ),
		'insert_into_item'      => __( 'Insert into portfolio item', 'sageus-theme' ),
		'uploaded_to_this_item' => __( 'Uploaded to this portfolio item', 'sageus-theme' ),
		'items_list'            => __( 'Portfolio Items list', 'sageus-theme' ),
		'items_list_navigation' => __( 'Portfolio Items list navigation', 'sageus-theme' ),
		'filter_items_list'     => __( 'Filter portfolio items list', 'sageus-theme' ),
	);

	$args = array(
		'label'                 => __( 'Portfolio Item', 'sageus-theme' ),
		'description'           => __( 'Portfolio items for showcasing your work', 'sageus-theme' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'post-formats' ),
		'taxonomies'            => array( 'sageus_portfolio_type' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rest_base'             => 'sageus_portfolio',
	);

	register_post_type( 'sageus_portfolio', $args );
}
add_action( 'init', 'sageus_register_portfolio_post_type' );

/**
 * Register Portfolio Type taxonomy
 */
function sageus_register_portfolio_taxonomy() {
	// Check if Jetpack Portfolio is active
	if ( class_exists( 'Jetpack_Portfolio' ) && taxonomy_exists( 'jetpack-portfolio-type' ) ) {
		return;
	}

	// Check if another portfolio taxonomy exists
	if ( taxonomy_exists( 'portfolio_type' ) ) {
		return;
	}

	$labels = array(
		'name'              => _x( 'Portfolio Types', 'taxonomy general name', 'sageus-theme' ),
		'singular_name'     => _x( 'Portfolio Type', 'taxonomy singular name', 'sageus-theme' ),
		'search_items'      => __( 'Search Portfolio Types', 'sageus-theme' ),
		'all_items'         => __( 'All Portfolio Types', 'sageus-theme' ),
		'parent_item'       => __( 'Parent Portfolio Type', 'sageus-theme' ),
		'parent_item_colon' => __( 'Parent Portfolio Type:', 'sageus-theme' ),
		'edit_item'         => __( 'Edit Portfolio Type', 'sageus-theme' ),
		'update_item'       => __( 'Update Portfolio Type', 'sageus-theme' ),
		'add_new_item'      => __( 'Add New Portfolio Type', 'sageus-theme' ),
		'new_item_name'     => __( 'New Portfolio Type Name', 'sageus-theme' ),
		'menu_name'         => __( 'Portfolio Types', 'sageus-theme' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'portfolio-type' ),
		'show_in_rest'      => true,
	);

	// Register taxonomy for both custom portfolio and Jetpack portfolio (if it exists later)
	register_taxonomy( 'sageus_portfolio_type', array( 'sageus_portfolio' ), $args );
	
	// Also register for 'portfolio' post type if it exists
	if ( post_type_exists( 'portfolio' ) ) {
		register_taxonomy_for_object_type( 'sageus_portfolio_type', 'portfolio' );
	}
}
add_action( 'init', 'sageus_register_portfolio_taxonomy' );

/**
 * Create a portfolio page template
 * This function checks if a page uses the portfolio template and displays portfolio items
 */
function sageus_portfolio_template_content( $content ) {
	// Only run on pages with portfolio template
	if ( ! is_page() ) {
		return $content;
	}

	$template = get_page_template_slug();
	if ( 'page-portfolio.php' !== $template && false === strpos( $template, 'page-portfolio.php' ) ) {
		return $content;
	}

	// Check if we should display the portfolio
	if ( is_main_query() && in_the_loop() ) {
		ob_start();
		
		// Display portfolio items
		sageus_display_portfolio_items();
		
		$portfolio_content = ob_get_clean();
		
		// Replace the content with portfolio if it's empty or just the title
		if ( empty( trim( strip_tags( $content ) ) ) || $content === get_the_title() ) {
			return $portfolio_content;
		}
		
		// Otherwise, append portfolio to the content
		return $content . $portfolio_content;
	}

	return $content;
}
add_filter( 'the_content', 'sageus_portfolio_template_content' );

/**
 * Display portfolio items
 */
function sageus_display_portfolio_items( $limit = -1, $category = '' ) {
	// Check if Jetpack Portfolio plugin is active
	if ( class_exists( 'Jetpack_Portfolio' ) && post_type_exists( 'jetpack-portfolio' ) ) {
		$post_type = 'jetpack-portfolio';
		$taxonomy = 'jetpack-portfolio-type';
	} elseif ( post_type_exists( 'portfolio' ) ) {
		$post_type = 'portfolio';
		$taxonomy = 'portfolio_type';
	} else {
		// Use the fallback portfolio post type
		$post_type = 'sageus_portfolio';
		$taxonomy = 'sageus_portfolio_type';
	}

	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	// Filter by category if specified
	if ( ! empty( $category ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	$portfolio_query = new WP_Query( $args );

	if ( $portfolio_query->have_posts() ) :
		// Get all portfolio types for filters
		$all_types = array();
		if ( taxonomy_exists( $taxonomy ) ) {
			$terms = get_terms( array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
			) );
			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$all_types[ $term->slug ] = $term->name;
				}
			}
		}
		
		?>
		<div class="portfolio-container">
			<?php if ( ! empty( $all_types ) ) : ?>
				<ul class="portfolio-filters">
					<li class="active"><a href="#" data-filter="*"><?php esc_html_e( 'All', 'sageus-theme' ); ?></a></li>
					<?php foreach ( $all_types as $slug => $name ) : ?>
						<li><a href="#" data-filter=".<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			
			<div class="portfolio-grid">
				<?php
					while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
						$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'sageus-theme-square' );
						$terms = get_the_terms( get_the_ID(), $taxonomy );
						
						// Get term classes for filtering
						$term_classes = '';
						if ( $terms && ! is_wp_error( $terms ) ) {
							foreach ( $terms as $term ) {
								$term_classes .= ' ' . esc_attr( $term->slug );
							}
						}
						
						?>
						<div class="portfolio-item<?php echo $term_classes; ?>">
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
		</div>
		
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Portfolio filtering
			$('.portfolio-filters a').on('click', function(e) {
				e.preventDefault();
				var filter = $(this).data('filter');
				
				// Update active class
				$('.portfolio-filters li').removeClass('active');
				$(this).parent().addClass('active');
				
				// Filter items
				$('.portfolio-item').fadeOut(300, function() {
					if (filter === '*' || $(this).is(filter)) {
						$(this).fadeIn(300);
					}
				});
			});
		});
		</script>
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
 * Flush rewrite rules on theme activation
 */
function sageus_activate() {
	// Register post type and taxonomy first
	sageus_register_portfolio_post_type();
	sageus_register_portfolio_taxonomy();
	
	// Flush rewrite rules
	flush_rewrite_rules();
}
add_action( 'after_setup_theme', 'sageus_activate' );

/**
 * Deactivate theme cleanup
 */
function sageus_deactivate() {
	// Flush rewrite rules
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sageus_deactivate' );

/**
 * Add portfolio rewrite rules
 */
function sageus_portfolio_rewrite_rules() {
	// Add rewrite rule for portfolio archive
	add_rewrite_rule( '^portfolio/?$', 'index.php?post_type=sageus_portfolio', 'top' );
	add_rewrite_rule( '^portfolio/page/([0-9]{1,})/?$', 'index.php?post_type=sageus_portfolio&paged=$matches[1]', 'top' );
	
	// Add rewrite rule for portfolio type taxonomy
	add_rewrite_rule( '^portfolio-type/([^/]+)/?$', 'index.php?sageus_portfolio_type=$matches[1]', 'top' );
	add_rewrite_rule( '^portfolio-type/([^/]+)/page/([0-9]{1,})/?$', 'index.php?sageus_portfolio_type=$matches[1]&paged=$matches[2]', 'top' );
}
add_action( 'init', 'sageus_portfolio_rewrite_rules' );

/**
 * Change the portfolio archive title
 */
function sageus_portfolio_archive_title( $title ) {
	if ( is_post_type_archive( 'sageus_portfolio' ) || is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'portfolio' ) ) {
		$title = esc_html__( 'Portfolio', 'sageus-theme' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'sageus_portfolio_archive_title' );

/**
 * Add portfolio template to page template dropdown
 */
function sageus_add_portfolio_template( $templates ) {
	$templates['page-portfolio.php'] = esc_html__( 'Portfolio Template', 'sageus-theme' );
	return $templates;
}
add_filter( 'theme_page_templates', 'sageus_add_portfolio_template' );

/**
 * Register portfolio template
 */
function sageus_register_portfolio_template( $template ) {
	if ( is_page_template( 'page-portfolio.php' ) ) {
		$template = get_template_directory() . '/page-portfolio.php';
	}
	return $template;
}
add_filter( 'template_include', 'sageus_register_portfolio_template' );
