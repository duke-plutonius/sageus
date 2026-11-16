<?php
/**
 * Sageus Theme Template Tags
 *
 * @package Sageus
 */

/**
 * Display the posted on date
 */
function sageus_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date */
		esc_html_x( 'Posted on %s', 'post date', 'sageus' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Display the posted by author
 */
function sageus_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author */
		esc_html_x( 'by %s', 'post author', 'sageus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>';
}

/**
 * Display the entry footer with categories, tags, etc.
 */
function sageus_entry_footer() {
	// Hide category and tag text for pages
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'sageus' ) );
		if ( $categories_list && sageus_categorized_blog() ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'sageus' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'sageus' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sageus' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'sageus' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() )
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'sageus' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Check if the blog has more than one category
 */
function sageus_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'sageus_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'sageus_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than one category so sageus_categorized_blog should return true
		return true;
	} else {
		// This blog has only one category so sageus_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in sageus_categorized_blog
 */
function sageus_category_transient_flusher() {
	// Like, beat it. Dig it.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// OK, that's a little old school. Let's try this.
	delete_transient( 'sageus_categories' );
}
add_action( 'edit_category', 'sageus_category_transient_flusher' );
add_action( 'save_post', 'sageus_category_transient_flusher' );

/**
 * Get the social icon for a URL
 */
function sageus_get_social_icon( $url ) {
	$url = strtolower( $url );
	
	// Define social services and their icons
	$social_services = array(
		'bandcamp.com' => 'bandcamp',
		'codepen.io' => 'codepen',
		'digg.com' => 'digg',
		'dribbble.com' => 'dribbble',
		'dropbox.com' => 'dropbox',
		'facebook.com' => 'facebook',
		'flickr.com' => 'flickr',
		'foursquare.com' => 'foursquare',
		'github.com' => 'github',
		'plus.google.com' => 'google-plus',
		'instagram.com' => 'instagram',
		'linkedin.com' => 'linkedin',
		'path.com' => 'path',
		'pinterest.com' => 'pinterest',
		'getpocket.com' => 'pocket',
		'polldaddy.com' => 'polldaddy',
		'reddit.com' => 'reddit',
		'skype.com' => 'skype',
		'soundcloud.com' => 'soundcloud',
		'spotify.com' => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com' => 'tumblr',
		'twitch.tv' => 'twitch',
		'twitter.com' => 'twitter',
		'vimeo.com' => 'vimeo',
		'vine.co' => 'vine',
		'wordpress.com' => 'wordpress',
		'wordpress.org' => 'wordpress',
		'youtube.com' => 'youtube',
	);

	// Check for mailto links
	if ( strpos( $url, 'mailto:' ) === 0 ) {
		return 'envelope';
	}

	// Check for /feed/ links
	if ( strpos( $url, '/feed/' ) !== false || strpos( $url, '/rss' ) !== false || strpos( $url, '/atom' ) !== false ) {
		return 'rss';
	}

	// Check for social media URLs
	foreach ( $social_services as $domain => $service ) {
		if ( strpos( $url, $domain ) !== false ) {
			return $service;
		}
	}

	// Default icon
	return 'link';
}

/**
 * Display social menu
 */
function sageus_social_menu() {
	if ( has_nav_menu( 'social' ) ) {
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
	}
}

/**
 * Get the portfolio items count
 */
function sageus_get_portfolio_count() {
	// Check if Jetpack Portfolio plugin is active
	if ( class_exists( 'Jetpack_Portfolio' ) && post_type_exists( 'jetpack-portfolio' ) ) {
		$post_type = 'jetpack-portfolio';
	} elseif ( post_type_exists( 'portfolio' ) ) {
		$post_type = 'portfolio';
	} else {
		$post_type = 'sageus_portfolio';
	}

	$count = wp_count_posts( $post_type );
	return $count->publish;
}

/**
 * Check if we're on a portfolio page
 */
function sageus_is_portfolio() {
	// Check if it's a portfolio archive
	if ( is_post_type_archive( array( 'jetpack-portfolio', 'portfolio', 'sageus_portfolio' ) ) ) {
		return true;
	}

	// Check if it's a portfolio single
	if ( is_singular( array( 'jetpack-portfolio', 'portfolio', 'sageus_portfolio' ) ) ) {
		return true;
	}

	// Check if it's a portfolio taxonomy
	if ( is_tax( array( 'jetpack-portfolio-type', 'portfolio_type', 'sageus_portfolio_type' ) ) ) {
		return true;
	}

	// Check if it's a page with portfolio template
	if ( is_page_template( 'page-portfolio.php' ) || is_page_template( 'templates/page-portfolio.php' ) ) {
		return true;
	}

	return false;
}

/**
 * Get the portfolio URL
 */
function sageus_get_portfolio_url() {
	// Check if Jetpack Portfolio plugin is active
	if ( class_exists( 'Jetpack_Portfolio' ) && post_type_exists( 'jetpack-portfolio' ) ) {
		return get_post_type_archive_link( 'jetpack-portfolio' );
	} elseif ( post_type_exists( 'portfolio' ) ) {
		return get_post_type_archive_link( 'portfolio' );
	} elseif ( post_type_exists( 'sageus_portfolio' ) ) {
		return get_post_type_archive_link( 'sageus_portfolio' );
	}
	
	return home_url( '/portfolio/' );
}
