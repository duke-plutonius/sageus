<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Sageus
 */

get_header();

?>

	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				
				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'sageus' ); ?></h1>
					</header>
					
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'sageus' ); ?></p>
						
						<?php get_search_form(); ?>
						
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
						
						<div class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Categories', 'sageus' ); ?></h2>
							<ul>
								<?php wp_list_categories( array( 'title_li' => '' ) ); ?>
							</ul>
						</div>
						
						<div class="widget widget_archive">
							<h2 class="widget-title"><?php esc_html_e( 'Archives', 'sageus' ); ?></h2>
							<ul>
								<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
							</ul>
						</div>
						
					</div>
				</section>
				
			</main>
		</div>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
