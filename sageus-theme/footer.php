<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #page div and all content after
 *
 * @package Sageus
 */

// Get theme options
$footer_image = get_theme_mod( 'sageus-theme_footer_image', '' );
$is_front_page = is_front_page() && 'page' === get_option( 'show_on_front' );

if ( $is_front_page ) {
	// Footer for front page - close the front-page div and add site footer
	?>
	</div><!-- .front-page -->
	
	<footer class="site-footer" role="contentinfo">
		<div class="container">
			<?php
				// Footer widgets
				if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
					?>
					<div class="footer-widgets">
						<?php
							for ( $i = 1; $i <= 4; $i++ ) :
								if ( is_active_sidebar( 'footer-' . $i ) ) :
									<div class="footer-widget">
										<?php dynamic_sidebar( 'footer-' . $i ); ?>
									</div>
								endif;
							endfor;
						?>
					</div>
					<?php
				endif;
			?>
			
			<?php
				// Social menu
				if ( has_nav_menu( 'social' ) ) :
					?>
					<nav class="social-menu" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'sageus-theme' ); ?>">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'social',
								'container'      => false,
								'menu_id'        => 'social-menu',
								'menu_class'     => 'social-links',
								'fallback_cb'    => false,
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
								'item_spacing'   => 'preserve',
							) );
						?>
					</nav>
					<?php
				endif;
			?>
			
			<div class="footer-copyright">
				<?php
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'sageus-theme' ), 'Sageus', '<a href="">Plutonius</a>' );
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( '', ' | ' );
					}
				?>
				<br />
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'sageus-theme' ) ); ?>">
					<?php printf( esc_html__( 'Proudly powered by %s', 'sageus-theme' ), 'WordPress' ); ?>
				</a>
			</div>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
	</body>
</html>
	<?php
} else {
	// Footer for regular pages
	?>
		</div><!-- #content -->
		
		<footer class="site-footer" role="contentinfo">
			<div class="container">
				<?php
					// Footer widgets
					if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
						?>
						<div class="footer-widgets">
							<?php
								for ( $i = 1; $i <= 4; $i++ ) :
									if ( is_active_sidebar( 'footer-' . $i ) ) :
										<div class="footer-widget">
											<?php dynamic_sidebar( 'footer-' . $i ); ?>
										</div>
									endif;
								endfor;
							?>
						</div>
						<?php
					endif;
				?>
				
				<?php
					// Social menu
					if ( has_nav_menu( 'social' ) ) :
						?>
						<nav class="social-menu" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'sageus-theme' ); ?>">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'social',
									'container'      => false,
									'menu_id'        => 'social-menu',
									'menu_class'     => 'social-links',
									'fallback_cb'    => false,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>',
									'item_spacing'   => 'preserve',
								) );
							?>
						</nav>
						<?php
					endif;
				?>
				
				<div class="footer-copyright">
					<?php
						printf( esc_html__( 'Theme: %1$s by %2$s.', 'sageus-theme' ), 'Sageus', '<a href="">Plutonius</a>' );
						if ( function_exists( 'the_privacy_policy_link' ) ) {
							the_privacy_policy_link( '', ' | ' );
						}
					?>
					<br />
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'sageus-theme' ) ); ?>">
						<?php printf( esc_html__( 'Proudly powered by %s', 'sageus-theme' ), 'WordPress' ); ?>
					</a>
				</div>
			</div>
		</footer>
		
	</div><!-- #page -->
	
	<?php wp_footer(); ?>
	</body>
</html>
	<?php
}
