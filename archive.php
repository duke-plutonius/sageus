<?php
/**
 * The template for displaying archive pages
 *
 * @package Sageus
 */

get_header();

?>

	<div class="container archive">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				
				<?php if ( have_posts() ) : ?>
					
					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							$description = get_the_archive_description();
							if ( $description ) :
								?>
								<div class="archive-description"><?php echo wp_kses_post( $description ); ?></div>
								<?php
							endif;
						?>
					</header>
					
					<?php
						while ( have_posts() ) : the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<?php
										the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
										
										if ( 'post' === get_post_type() ) :
											<div class="entry-meta">
												<?php sageus_posted_on(); ?>
												<?php sageus_posted_by(); ?>
											</div>
										endif;
									?>
								</header>
								
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="single-featured-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'sageus-featured' ); ?>
										</a>
									</div>
								<?php endif; ?>
								
								<div class="entry-content">
									<?php the_excerpt(); ?>
									
									<?php
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
						endwhile;
						
						the_posts_pagination( array(
							'prev_text' => esc_html__( 'Previous', 'sageus' ),
							'next_text' => esc_html__( 'Next', 'sageus' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'sageus' ) . ' </span>',
						) );
						
					?>
				<?php else : ?>
					<article class="no-results">
						<header class="entry-header">
							<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'sageus' ); ?></h1>
						</header>
						
						<div class="entry-content">
							<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'sageus' ); ?></p>
							<?php get_search_form(); ?>
						</div>
					</article>
				<?php endif; ?>
				
			</main>
		</div>
		
		<?php get_sidebar(); ?>
	</div>
	
<?php get_footer(); ?>
