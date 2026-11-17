<?php
/**
 * Template Name: Portfolio Template
 *
 * The template for displaying portfolio items in a grid with filtering.
 *
 * @package Sageus
 */

get_header();

?>

	<div class="container portfolio-template">
		<div id="primary" class="content-area full-width-content">
			<main id="main" class="site-main" role="main">
				
				<?php
					while ( have_posts() ) : the_post();
						
						<header class="page-header">
							<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
							
							<?php
								$description = get_the_excerpt();
								if ( $description ) :
									?>
									<div class="page-description">
										<?php echo wp_kses_post( $description ); ?>
									</div>
									<?php
								endif;
							?>
						</header>
						
						<div class="entry-content">
							<?php
								the_content();
								
								// Display portfolio items
								sageus_display_portfolio_items( 120, '' );
								?>
						</div>
						
						<?php if ( get_edit_post_link() ) : ?>
							<footer class="entry-footer">
								<?php
									edit_post_link(
										sprintf(
											/* translators: %s: Name of current post */
											__( 'Edit <span class="screen-reader-text">%s</span>', 'sageus-theme' ),
											get_the_title()
										),
										'<span class="edit-link">',
										'</span>'
									);
									?>
							</footer>
						<?php endif; ?>
						
					<?php endwhile; ?>
				
			</main>
		</div>
		
	</div>
	
<?php get_footer(); ?>
