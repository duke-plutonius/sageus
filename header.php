<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Sageus
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
		// Get theme options from Customizer
		$header_top_text_left  = get_theme_mod( 'sageus_header_top_text_left', '' );
		$header_top_text_right = get_theme_mod( 'sageus_header_top_text_right', '' );
		
		// Determine if we're on the static front page
		$is_front_page = is_front_page() && 'page' === get_option( 'show_on_front' );
	?>
	
	<?php if ( $is_front_page ) : ?>
		<!-- Front page has its own structure, so we don't need the standard header wrapper -->
	<?php else : ?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'sageus' ); ?></a>
	<?php endif; ?>
	
	<header class="site-header" role="banner">
		<div class="container">
			<?php if ( ! empty( $header_top_text_left ) ) : ?>
				<div class="header-top-text left">
					<?php echo wp_kses_post( $header_top_text_left ); ?>
				</div>
			<?php endif; ?>
			
			<div class="site-branding">
				<?php
					if ( has_custom_logo() ) :
						the_custom_logo();
					else :
						if ( is_front_page() && is_home() ) :
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						else :
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						endif;
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) :
							<p class="site-description"><?php echo $description; ?></p>
						endif;
					endif;
				?>
			</div>
			
			<?php if ( ! empty( $header_top_text_right ) ) : ?>
				<div class="header-top-text right">
					<?php echo wp_kses_post( $header_top_text_right ); ?>
				</div>
			<?php endif; ?>
			
			<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'sageus' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'fallback_cb'    => 'sageus_primary_menu_fallback',
					) );
				?>
			</nav>
		</div>
	</header>
	
	<?php if ( $is_front_page ) : ?>
		<!-- Front page content will be handled by front-page.php -->
	<?php else : ?>
		<div id="content" class="site-content">
	<?php endif; ?>
