<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Sageus
 */

// Determine if we're showing the blog index or static front page
if ( 'page' === get_option( 'show_on_front' ) && is_front_page() ) {
	// This is a static front page - handled by front-page.php
	// But if we're here, it means front-page.php doesn't exist yet
	// So let's redirect to the actual front page logic
	include( get_template_directory() . '/front-page.php' );
	return;
}

get_header();

// Check if we should show the blog format
$is_blog = ( is_home() || ( is_front_page() && 'posts' === get_option( 'show_on_front' ) ) );

?>

	<div class="container blog-index">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				
				<?php if ( have_posts() ) : ?>
					
					<?php if ( $is_blog && ! is_paged() ) : ?>
						<header class="page-header">
							<h1 class="page-title">
								<?php
									if ( is_home() && ! is_front_page() ) :
										single_post_title();
									elseif ( is_front_page() ) :
										esc_html_e( 'Blog', 'sageus' );
									endif;
								?>
							</h1>
							<?php
								$description = get_the_archive_description();
								if ( $description ) :
									<div class="archive-description"><?php echo wp_kses_post( $description ); ?></div>
								endif;
							?>
						</header>
					<?php endif; ?>
					
					<?php if ( $is_blog ) : ?>
						<!-- Blog format: square panels, three across -->
						<div class="posts-grid">
							<?php
								while ( have_posts() ) : the_post();
									?>
									<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-panel' ); ?>>
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="post-thumbnail">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail( 'sageus-square' ); ?>
												</a>
											</div>
										<?php endif; ?>
										
										<div class="post-content">
											<header class="entry-header">
												<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
												
												<div class="post-meta">
													<span class="post-date">
														<?php sageus_posted_on(); ?>
													</span>
													<span class="post-author">
														<?php sageus_posted_by(); ?>
													</span>
												</div>
											</header>
										</div>
									</article>
									<?php
								endwhile;
								?>
						</div>
						
						<?php
							the_posts_pagination( array(
								'prev_text' => esc_html__( 'Previous', 'sageus' ),
								'next_text' => esc_html__( 'Next', 'sageus' ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'sageus' ) . ' </span>',
							) );
							
						?>
					<?php else : ?>
						<!-- Regular archive/index format -->
						<?php
							while ( have_posts() ) : the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="entry-header">
										<?php
											if ( is_singular() ) :
												the_title( '<h1 class="entry-title">', '</h1>' );
											else :
												the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
											endif;
											
											if ( 'post' === get_post_type() ) :
												<div class="entry-meta">
													<?php sageus_posted_on(); ?>
													<?php sageus_posted_by(); ?>
												</div>
											endif;
										?>
									</header>
									
									<?php if ( has_post_thumbnail() && ! is_search() ) : ?>
										<div class="single-featured-image">
											<?php the_post_thumbnail( 'sageus-featured' ); ?>
										</div>
									<?php endif; ?>
									
									<div class="entry-content">
										<?php
											the_content( sprintf(
												wp_kses(
													/* translators: %s: Name of current post. Only visible to screen readers */
													__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'sageus' ),
													array(
														'span' => array(
															'class' => array(),
														),
													)
												),
												get_the_title()
											) );
											
											wp_link_pages( array(
												'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sageus' ),
												'after'  => '</div>',
											) );
										?>
									</div>
									
									<footer class="entry-footer">
										<?php sageus_entry_footer(); ?>
									</footer>
								</article>
								<?php
									// If comments are open or we have at least one comment, load up the comment template
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
									
								endwhile;
								
								the_posts_pagination( array(
									'prev_text' => esc_html__( 'Previous', 'sageus' ),
									'next_text' => esc_html__( 'Next', 'sageus' ),
									'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'sageus' ) . ' </span>',
								) );
								?>
						
					<?php endif; ?>
					
				<?php else : ?>
						<article class="no-results">
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'sageus' ); ?></h1>
							</header>
							
							<div class="entry-content">
								<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
									<p><?php
										printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'sageus' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) );
									?></p>
								<?php elseif ( is_search() ) : ?>
									<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'sageus' ); ?></p>
									<?php get_search_form(); ?>
								<?php else : ?>
									<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'sageus' ); ?></p>
									<?php get_search_form(); ?>
								<?php endif; ?>
							</div>
						</article>
					<?php endif; ?>
				
			</main>
		</div>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
