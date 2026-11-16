<?php
/**
 * The front page template
 *
 * This is the template that displays the static front page when 'page' is selected
 * as the front page option in Settings > Reading.
 *
 * It displays a full-screen hero panel plus up to three additional panels
 * built from static pages.
 *
 * @package Sageus
 */

// If posts should be shown on front page, redirect to index.php
if ( 'posts' === get_option( 'show_on_front' ) ) {
	include( get_template_directory() . '/index.php' );
	return;
}

get_header();

// Get theme options from Customizer
$header_top_text_left  = get_theme_mod( 'sageus_header_top_text_left', '' );
$header_top_text_right = get_theme_mod( 'sageus_header_top_text_right', '' );
$footer_image          = get_theme_mod( 'sageus_footer_image', '' );

// Panel page IDs from Customizer
$panel_pages = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$panel_pages[ $i ] = get_theme_mod( "sageus_panel_page_$i", 0 );
}

// Panel column layouts from Customizer
$panel_columns = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$panel_columns[ $i ] = get_theme_mod( "sageus_panel_column_$i", 'one' );
}

// Get hero page content
$hero_page = null;
$hero_image = '';
$hero_content = '';

$front_page_id = get_option( 'page_on_front' );
if ( $front_page_id ) {
	$hero_page = get_post( $front_page_id );
	if ( $hero_page ) {
		$hero_image = get_the_post_thumbnail_url( $front_page_id, 'full' );
		// Remove auto-p to prevent double application
		remove_filter( 'the_content', 'wpautop' );
		$hero_content = apply_filters( 'the_content', $hero_page->post_content );
		add_filter( 'the_content', 'wpautop' );
	}
}

?>

	<div class="front-page">
		
		<!-- Hero Section -->
		<section class="front-page-section hero" <?php if ( ! empty( $hero_image ) ) : ?>style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"<?php endif; ?>>
			<div class="parallax-bg" <?php if ( ! empty( $hero_image ) ) : ?>style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"<?php endif; ?>>
				<?php if ( ! empty( $hero_image ) ) : ?>
					<img src="<?php echo esc_url( $hero_image ); ?>" alt="" style="display:none;" />
				<?php endif; ?>
			</div>
			<div class="parallax-overlay"></div>
			
			<div class="hero-content">
				<?php if ( ! empty( $hero_content ) ) : ?>
					<div class="hero-text">
						<?php echo $hero_content; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		
		<?php
			// Panel sections (1-3)
			for ( $i = 1; $i <= 3; $i++ ) :
				if ( ! empty( $panel_pages[ $i ] ) && $panel_pages[ $i ] > 0 ) :
					$panel_page = get_post( $panel_pages[ $i ] );
					if ( $panel_page ) :
						$panel_image = get_the_post_thumbnail_url( $panel_pages[ $i ], 'full' );
						remove_filter( 'the_content', 'wpautop' );
						$panel_content = apply_filters( 'the_content', $panel_page->post_content );
						add_filter( 'the_content', 'wpautop' );
						$panel_title = get_the_title( $panel_page );
						$panel_class = 'panel panel-' . $i;
						$panel_layout = isset( $panel_columns[ $i ] ) ? $panel_columns[ $i ] : 'one';
						
						// Check if this is a portfolio page
						$is_portfolio = false;
						$template = get_page_template_slug( $panel_page );
						if ( 'page-portfolio.php' === $template || false !== strpos( $template, 'page-portfolio.php' ) ) {
							$is_portfolio = true;
						}
						
						// Special handling for portfolio panel
						if ( $is_portfolio ) :
							?>
							<section class="front-page-section <?php echo esc_attr( $panel_class . ' portfolio-panel' ); ?>" <?php if ( ! empty( $panel_image ) ) : ?>style="background-image: url('<?php echo esc_url( $panel_image ); ?>');"<?php endif; ?>>
								<div class="parallax-bg" <?php if ( ! empty( $panel_image ) ) : ?>style="background-image: url('<?php echo esc_url( $panel_image ); ?>');"<?php endif; ?>>
									<?php if ( ! empty( $panel_image ) ) : ?>
										<img src="<?php echo esc_url( $panel_image ); ?>" alt="" style="display:none;" />
									<?php endif; ?>
								</div>
								<div class="parallax-overlay"></div>
								<div class="container">
									<div class="panel-content one-column">
										<?php if ( ! empty( $panel_title ) ) : ?>
											<h2><?php echo esc_html( $panel_title ); ?></h2>
										<?php endif; ?>
										<?php
											// Display portfolio items (6 for front page panel)
											sageus_display_portfolio_panel( 6 );
										?>
									</div>
								</div>
							</section>
							<?php
						else :
							// Regular panel
							$reverse_layout = ( $i % 2 === 0 ); // Alternate layout
							?>
							<section class="front-page-section <?php echo esc_attr( $panel_class ); ?>" <?php if ( ! empty( $panel_image ) ) : ?>style="background-image: url('<?php echo esc_url( $panel_image ); ?>');"<?php endif; ?>>
								<div class="parallax-bg" <?php if ( ! empty( $panel_image ) ) : ?>style="background-image: url('<?php echo esc_url( $panel_image ); ?>');"<?php endif; ?>>
									<?php if ( ! empty( $panel_image ) ) : ?>
										<img src="<?php echo esc_url( $panel_image ); ?>" alt="" style="display:none;" />
									<?php endif; ?>
								</div>
								<div class="parallax-overlay"></div>
								<div class="container">
									<div class="panel-content <?php echo esc_attr( $panel_layout . '-column' ); ?><?php echo $reverse_layout ? ' reverse' : ''; ?>">
										<?php if ( 'one' === $panel_layout ) : ?>
											<div class="panel-text">
												<?php if ( ! empty( $panel_title ) ) : ?>
													<h2><?php echo esc_html( $panel_title ); ?></h2>
												<?php endif; ?>
												<?php echo $panel_content; ?>
											</div>
										<?php else : ?>
											<div class="panel-text">
												<?php if ( ! empty( $panel_title ) ) : ?>
													<h2><?php echo esc_html( $panel_title ); ?></h2>
												<?php endif; ?>
												<?php echo $panel_content; ?>
											</div>
											<?php if ( ! empty( $panel_image ) ) : ?>
												<div class="panel-image">
													<img src="<?php echo esc_url( $panel_image ); ?>" alt="<?php echo esc_attr( $panel_title ); ?>" />
												</div>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
							</section>
							<?php
						endif;
					endif;
				endfor;
			?>
			
			<?php
				// Footer image section
				if ( ! empty( $footer_image ) ) :
					?>
					<section class="front-page-section footer-image" style="background-image: url('<?php echo esc_url( $footer_image ); ?>');">
						<div class="parallax-bg" style="background-image: url('<?php echo esc_url( $footer_image ); ?>');">
							<img src="<?php echo esc_url( $footer_image ); ?>" alt="" style="display:none;" />
						</div>
					</section>
					<?php
				endif;
			?>
		
	</div><!-- .front-page -->
	
<?php get_footer(); ?>
