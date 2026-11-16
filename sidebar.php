<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Sageus
 */

// Don't show sidebar on static front page
if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
	return;
}

?>

<aside id="secondary" class="sidebar widget-area" role="complementary">
	<?php
		// Check if it's a portfolio page
		$is_portfolio = false;
		if ( is_page() ) {
			$template = get_page_template_slug();
			if ( 'page-portfolio.php' === $template || 'templates/page-portfolio.php' === $template ) {
				$is_portfolio = true;
			}
		}
		
		// For portfolio pages, use portfolio-specific sidebar
		if ( $is_portfolio && is_active_sidebar( 'portfolio-sidebar' ) ) :
			dynamic_sidebar( 'portfolio-sidebar' );
		elseif ( is_active_sidebar( 'sidebar-1' ) ) :
			dynamic_sidebar( 'sidebar-1' );
		else :
			// Fallback for when no widgets are active
			?>
			<div class="widget widget_search">
				<h2 class="widget-title"><?php esc_html_e( 'Search', 'sageus' ); ?></h2>
				<?php get_search_form(); ?>
			</div>
			
			<div class="widget widget_recent_entries">
				<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'sageus' ); ?></h2>
				<ul>
					<?php
						$recent_posts = wp_get_recent_posts( array(
							'numberposts' => 5,
							'post_status'  => 'publish',
						) );
						
						foreach ( $recent_posts as $post ) :
							?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $post['ID'] ) ); ?>">
									<?php echo esc_html( $post['post_title'] ); ?>
								</a>
							</li>
							<?php
						endforeach;
						
						wp_reset_postdata();
					?>
				</ul>
			</div>
			
			<div class="widget widget_archive">
				<h2 class="widget-title"><?php esc_html_e( 'Archives', 'sageus' ); ?></h2>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</div>
			<?php
		endif;
	?>
</aside><!-- #secondary -->
