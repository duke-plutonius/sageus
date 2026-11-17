<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package Sageus
 */

get_header();

// Check if this is the front page
if ( is_front_page() && 'page' === get_option( 'show_on_front' ) ) {
	// This should be handled by front-page.php
	// If we're here, redirect to front-page.php
	include( get_template_directory() . '/front-page.php' );
	return;
}

// Check if this is a portfolio page
$is_portfolio = false;
$template = get_page_template_slug();
if ( 'page-portfolio.php' === $template || false !== strpos( $template, 'page-portfolio.php' ) ) {
	$is_portfolio = true;
}

?>

	<div class="container">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				
				<?php
					while ( have_posts() ) : the_post();
						
						<?php if ( has_post_thumbnail() && ! $is_portfolio ) : ?>
							<div class="page-featured-image">
								<?php the_post_thumbnail( 'sageus-theme-featured' ); ?>
							</div>
						<?php endif; ?>
						
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
							
							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
								?>
						</article>
						
					<?php endwhile; ?>
				
			</main>
		</div>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
