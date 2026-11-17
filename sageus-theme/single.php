<?php
/**
 * The template for displaying single posts
 *
 * @package Sageus
 */

get_header();

?>

	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				
				<?php
					while ( have_posts() ) : the_post();
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="single-featured-image">
								<?php the_post_thumbnail( 'sageus-theme-featured' ); ?>
							</div>
						<?php endif; ?>
						
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								
								<div class="entry-meta">
									<?php sageus_posted_on(); ?>
									<?php sageus_posted_by(); ?>
								</div>
							</header>
							
							<div class="entry-content">
								<?php
									the_content();
									
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sageus-theme' ),
										'after'  => '</div>',
									) );
									?>
							</div>
							
							<footer class="entry-footer">
								<?php sageus_entry_footer(); ?>
								
								<?php
									if ( get_edit_post_link() ) :
										edit_post_link(
											sprintf(
												/* translators: %s: Name of current post */
												__( 'Edit <span class="screen-reader-text">%s</span>', 'sageus-theme' ),
												get_the_title()
											),
											'<span class="edit-link">',
											'</span>'
										);
									endif;
								?>
							</footer>
							
							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
								?>
						</article>
						
						<?php
							// Previous/next post navigation
							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous Post', 'sageus-theme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Previous', 'sageus-theme' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next Post', 'sageus-theme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Next', 'sageus-theme' ) . '</span> <span class="nav-title">%title</span>',
							) );
							?>
						
					<?php endwhile; ?>
				
			</main>
		</div>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
