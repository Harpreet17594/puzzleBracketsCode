<?php
/**
 * Custom Functions
 */

/**
 * Check a plugin active
 *
 * @param $plugin_var
 *
 * @return bool
 */
function thim_plugin_active( $plugin_dir, $plugin_file = null ) {
	$plugin_file            = $plugin_file ? $plugin_file : ( $plugin_dir . '.php' );
	$plugin                 = $plugin_dir . '/' . $plugin_file;
	$active_plugins_network = get_site_option( 'active_sitewide_plugins' );

	if ( isset( $active_plugins_network[ $plugin ] ) ) {
		return true;
	}

	$active_plugins = get_option( 'active_plugins' );

	if ( in_array( $plugin, $active_plugins ) ) {
		return true;
	}

	return false;
}

/**
 * Get header layouts
 *
 * @return string CLASS for header layouts
 */
function thim_header_layout_class() {

	echo ' template-' . get_theme_mod( 'header_template', 'layout-1' );

	if ( get_theme_mod( 'show_sticky_menu', true ) ) {
		echo ' sticky-header';
	}

	if ( isset( $thim_options['header_retina_logo'] ) && get_theme_mod( 'header_retina_logo' ) ) {
		echo ' has-retina-logo';
	}

	$header_palette = get_theme_mod( 'header_palette', 'white' );
	echo ' palette-' . $header_palette;
	switch ( $header_palette ) {
		case 'transparent':
			echo ' header-overlay';
			break;
		case 'white':
			echo ' header-default';
			break;
		default:
			if ( get_theme_mod( 'header_position', 'default' ) === 'default' ) {
				echo ' header-default';
			} else {
				echo ' header-overlay';
			}

			if ( get_theme_mod( 'sticky_menu_style', 'same' ) === 'custom' ) {
				echo ' custom-sticky';
			} else {
				echo '';
			}
			break;
	}
}

/**
 * Get Header Logo
 *
 * @return string
 */
if ( ! function_exists( 'thim_header_logo' ) ) {
	function thim_header_logo() {
		$page_title            = thim_page_title();
		$thim_options          = get_theme_mods();
		$thim_logo_src         = THIM_URI . "assets/images/logo.png";
		$thim_mobile_logo_src  = THIM_URI . "assets/images/mobile-logo.png";
		$thim_logo_white_src   = THIM_URI . "assets/images/logo-2.png";
		$thim_logo_whitex2_src = THIM_URI . "assets/images/logo-2x2.png";
		$thim_retina_logo_src  = '';


		$header_template = get_theme_mod( 'header_template', 'layout-1' );


		if ( isset( $thim_options['header_logo'] ) && $thim_options['header_logo'] <> '' ) {
			$thim_logo_src = get_theme_mod( 'header_logo' );
			if ( is_numeric( $thim_logo_src ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo_src, 'full' );
				$thim_logo_src   = $logo_attachment[0];
			}
		}

		if ( isset( $thim_options['header_mobile_logo'] ) && $thim_options['header_mobile_logo'] <> '' ) {
			$thim_mobile_logo_src = get_theme_mod( 'header_mobile_logo' );
			if ( is_numeric( $thim_mobile_logo_src ) ) {
				$logo_attachment      = wp_get_attachment_image_src( $thim_mobile_logo_src, 'full' );
				$thim_mobile_logo_src = $logo_attachment[0];
			}
		}


		$thim_logo_size = @getimagesize( $thim_logo_src );
		$logo_size      = $thim_logo_size[3];


		echo '<a class="no-sticky-logo" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home">';
		echo '<img class="logo" src="' . esc_url( $thim_logo_src ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"  ' . $logo_size . '/>';

		if ( get_theme_mod( 'header_retina_logo', false ) ) {
			$thim_retina_logo_src = get_theme_mod( 'header_retina_logo' );
			if ( is_numeric( $thim_retina_logo_src ) ) {
				$logo_attachment      = wp_get_attachment_image_src( $thim_retina_logo_src, 'full' );
				$thim_retina_logo_src = $logo_attachment[0];
			}

			if ( $header_template == 'layout-2' ) {
				if ( $page_title['show_text'] ) {
					//code
				} else {
					$thim_retina_logo_src = $thim_logo_whitex2_src;
				}
			}

			$thim_logo_size = @getimagesize( $thim_retina_logo_src );
			$logo_size      = $thim_logo_size[3];

			echo '<img class="retina-logo" src="' . esc_url( $thim_retina_logo_src ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"  ' . $logo_size . '/>';
		}

		$thim_logo_size = @getimagesize( $thim_mobile_logo_src );
		$logo_size      = $thim_logo_size[3];

		echo '<img class="mobile-logo" src="' . esc_url( $thim_mobile_logo_src ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ' . $logo_size . '/>';
		echo '</a>';
	}
}
add_action( 'thim_header_logo', 'thim_header_logo' );
add_action( 'thim_popup_logo', 'thim_header_logo' );

/**
 * Get Header Sticky logo
 *
 * @return string
 */
if ( ! function_exists( 'thim_header_sticky_logo' ) ) {
	function thim_header_sticky_logo() {
		$site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
		if ( get_theme_mod( 'header_sticky_logo' ) != '' ) {
			$thim_logo_stick_logo     = get_theme_mod( 'header_sticky_logo' );
			$thim_logo_stick_logo_src = $thim_logo_stick_logo; // For the default value
			if ( is_numeric( $thim_logo_stick_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $thim_logo_stick_logo, 'full' );
				if ( $logo_attachment ) {
					$thim_logo_stick_logo_src = $logo_attachment[0];
				} else {
					$thim_logo_stick_logo_src = THIM_URI . 'assets/images/logo.png';
				}
			}
			$thim_logo_size = @getimagesize( $thim_logo_stick_logo_src );
			$logo_size      = $thim_logo_size[3];

			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
					<img src="' . $thim_logo_stick_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		} else {
			$thim_logo_stick_logo_src = THIM_URI . 'assets/images/logo.png';
			$thim_logo_size           = @getimagesize( $thim_logo_stick_logo_src );
			$logo_size                = $thim_logo_size[3];

			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
					<img src="' . $thim_logo_stick_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		}
	}
}
add_action( 'thim_header_sticky_logo', 'thim_header_sticky_logo' );

/**
 * Get Page Title Content For Single
 *
 * @return string HTML for Page title bar
 */
function thim_get_single_page_title_content() {
	$post_id = get_the_ID();

	if ( get_post_type( $post_id ) == 'post' ) {
		$categories = get_the_category();
	} elseif ( get_post_type( $post_id ) == 'attachment' ) {
		echo '<h2 class="title">' . esc_html__( 'Attachment', 'course-builder' ) . '</h2>';

		return;
	} else {// Custom post type
		$categories = get_the_terms( $post_id, 'taxonomy' );
	}
	if ( ! empty( $categories ) ) {
		echo '<h2 class="title">' . esc_html( $categories[0]->name ) . '</h2>';
	}
}

/**
 * Get Page Title Content For Date Format
 *
 * @return string HTML for Page title bar
 */
function thim_get_page_title_date() {
	if ( is_year() ) {
		echo '<h2 class="title">' . esc_html__( 'Year', 'course-builder' ) . '</h2>';
	} elseif ( is_month() ) {
		echo '<h2 class="title">' . esc_html__( 'Month', 'course-builder' ) . '</h2>';
	} elseif ( is_day() ) {
		echo '<h2 class="title">' . esc_html__( 'Day', 'course-builder' ) . '</h2>';
	}

	$date  = '';
	$day   = intval( get_query_var( 'day' ) );
	$month = intval( get_query_var( 'monthnum' ) );
	$year  = intval( get_query_var( 'year' ) );
	$m     = get_query_var( 'm' );

	if ( ! empty( $m ) ) {
		$year  = intval( substr( $m, 0, 4 ) );
		$month = intval( substr( $m, 4, 2 ) );
		$day   = substr( $m, 6, 2 );

		if ( strlen( $day ) > 1 ) {
			$day = intval( $day );
		} else {
			$day = 0;
		}
	}

	if ( $day > 0 ) {
		$date .= $day . ' ';
	}
	if ( $month > 0 ) {
		global $wp_locale;
		$date .= $wp_locale->get_month( $month ) . ' ';
	}
	$date .= $year;
	echo '<div class="description">' . esc_attr( $date ) . '</div>';
}

/**
 * Get Page Title Content
 *
 * @return string HTML for Page title bar
 */
if ( ! function_exists( 'thim_page_title_content' ) ) {
	function thim_page_title_content() {
		if ( is_front_page() ) {// Front page
			echo '<h2 class="title">' . get_bloginfo( 'name' ) . '</h2>';
			echo '<div class="description">' . get_bloginfo( 'description' ) . '</div>';
		} elseif ( is_home() ) {// Post page
			echo '<h2 class="title">' . esc_html__( 'Blog', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_bloginfo( 'description' ) . '</div>';
		} elseif ( is_page() ) {// Page
			echo '<h2 class="title">' . get_the_title() . '</h2>';
		} elseif ( is_single() ) {// Single
			thim_get_single_page_title_content();
		} elseif ( is_author() ) {// Author
			echo '<h2 class="title">' . esc_html__( 'Author', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_the_author() . '</div>';
		} elseif ( is_search() ) {// Search
			echo '<h2 class="title">' . esc_html__( 'Search', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . get_search_query() . '</div>';
		} elseif ( is_tag() ) {// Tag
			echo '<h2 class="title">' . esc_html__( 'Tag', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . single_tag_title( '', false ) . '</div>';
		} elseif ( is_category() ) {// Archive
			echo '<h2 class="title">' . esc_html__( 'Category', 'course-builder' ) . '</h2>';
			echo '<div class="description">' . single_cat_title( '', false ) . '</div>';
		} elseif ( is_404() ) {
			echo '<h2 class="title">' . esc_html__( '404 Page', 'course-builder' ) . '</h2>';
		} elseif ( is_date() ) {
			thim_get_page_title_date();
		}
	}
}
add_action( 'thim_page_title_content', 'thim_page_title_content' );

/**
 * Get breadcrumb for page
 *
 * @return string
 */
function thim_get_breadcrumb_items_other() {
	global $author;
	$userdata   = get_userdata( $author );
	$categories = get_the_category();
	if ( is_front_page() ) { // Do not display on the homepage
		return;
	}
	if ( is_home() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html__( 'Blog', 'course-builder' ) . '</span></li>';
	} else if ( is_category() ) { // Category page
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">' . esc_html( $categories[0]->cat_name ) . '</span></li>';
	} else if ( is_tag() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( single_term_title( '', false ) ) . '">' . esc_html( single_term_title( '', false ) ) . '</span></li>';
	} else if ( is_year() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></li>';
	} else if ( is_author() ) { // Auhor archive
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( $userdata->display_name ) . '">' . esc_attr__( 'Author', 'course-builder' ) . ' ' . esc_html( $userdata->display_name ) . '</span></li>';
	} else if ( get_query_var( 'paged' ) ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Page', 'course-builder' ) . ' ' . get_query_var( 'paged' ) . '">' . esc_html__( 'Page', 'course-builder' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</span></li>';
	} else if ( is_search() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Search results for:', 'course-builder' ) . ' ' . esc_attr( get_search_query() ) . '">' . esc_html__( 'Search results for:', 'course-builder' ) . ' ' . esc_html( get_search_query() ) . '</span></li>';
	} elseif ( is_404() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( '404 Page', 'course-builder' ) . '">' . esc_html__( '404 Page', 'course-builder' ) . '</span></li>';
	} elseif ( is_post_type_archive() ) {
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . post_type_archive_title( '', false ) . '">' . post_type_archive_title( '', false ) . '</span></li>';
	}
}

/**
 * Get content breadcrumbs
 *
 * @return string
 */
if ( ! function_exists( 'thim_breadcrumbs' ) ) {
	function thim_breadcrumbs() {
		if ( function_exists( 'learn_press_is_profile' ) && learn_press_is_profile() ) {
			$user = learn_press_get_profile_user();

			if ( $user ) {
				$user_meta = get_user_meta( $user->ID );
				$user_meta = array_map( function ( $a ) {
					return $a[0];
				}, $user_meta );

				thim_get_user_socials( $user_meta );
			}

			return;
		}

		global $post;
		if ( is_front_page() ) { // Do not display on the homepage
			return;
		}
		$categories   = get_the_category();
		$thim_options = get_theme_mods();
		$icon         = '<i class="fa fa-angle-right" aria-hidden="true"></i>';

		// Build the breadcrums
		echo '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url() ) . '" title="' . esc_attr__( 'Home', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Home', 'course-builder' ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
		if ( is_single() ) { // Single post (Only display the first category)
			if ( isset( $categories[0] ) ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" title="' . esc_attr( $categories[0]->cat_name ) . '"><span itemprop="name">' . esc_html( $categories[0]->cat_name ) . '</span></a></li>';
			}

			if ( get_post_type() === 'lp_course' ) {
				$terms = get_terms( 'course_category' ); // Get all terms of a taxonomy
				if ( $terms && ! is_wp_error( $terms ) ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $terms[0]->term_id ) ) . '" title="' . esc_attr( $terms[0]->name ) . '"><span itemprop="name">' . esc_html( $terms[0]->name ) . '</span></a></li>';
				}
			}

			if ( get_post_type() === 'tp_event' ) {
				$terms = get_terms( 'tp_event_category' ); // Get all terms of a taxonomy
				if ( $terms && ! is_wp_error( $terms ) ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_category_link( $terms[0]->term_id ) ) . '" title="' . esc_attr( $terms[0]->name ) . '"><span itemprop="name">' . esc_html( $terms[0]->name ) . '</span></a></li>';
				} else {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'tp_event' ) ) . '" title="' . esc_attr__( 'Events', 'course-builder' ) . '"><span itemprop="name">' . esc_attr__( 'Events', 'course-builder' ) . '</span></a></li>';
				}
			}
			//echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';
		} else if ( is_page() ) {
			// Standard page
			if ( $post->post_parent ) {
				$anc = get_post_ancestors( $post->ID );
				$anc = array_reverse( $anc );
				// Parent page loop
				foreach ( $anc as $ancestor ) {
					echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '"><span itemprop="name">' . esc_html( get_the_title( $ancestor ) ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
				}
			}

			// Current page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '"> ' . esc_html( get_the_title() ) . '</span></li>';
		} elseif ( is_day() ) {// Day archive
			// Year link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
			// Month link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
			// Day display
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'jS' ) ) . '"> ' . esc_html( get_the_time( 'jS' ) ) . ' ' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></li>';

		} else if ( is_month() ) {
			// Year link
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '"><span itemprop="name">' . esc_html( get_the_time( 'Y' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></a><span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span></li>';
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . esc_html( get_the_time( 'M' ) ) . ' ' . esc_html__( 'Archives', 'course-builder' ) . '</span></li>';
		}
		thim_get_breadcrumb_items_other();
		echo '</ul>';
	}
}

/**
 * Breadcrumb for LearnPress
 */
if ( ! function_exists( 'thim_learnpress_breadcrumb' ) ) {
	function thim_learnpress_breadcrumb() {

		// Do not display on the homepage
		if ( is_front_page() || is_404() ) {
			return;
		}

		// Get the query & post information
		global $post;
		$icon = '<span class="breadcrum-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>';
		// Build the breadcrums
		echo '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs" class="breadcrumbs">';

		// Home page
		echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr__( 'Home', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Home', 'course-builder' ) . '</span></a>' . $icon . '</li>';

		if ( is_single() ) {

			$categories = get_the_terms( $post, 'course_category' );

			if ( get_post_type() == 'lp_course' ) {
				// All courses
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a>' . $icon . '</li>';
			}
			if ( get_post_type() == 'lp_collection' ) {
				// All courses
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_collection' ) ) . '" title="' . esc_attr__( 'Collections', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Collections', 'course-builder' ) . '</span></a>' . $icon . '</li>';
			} else {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '" title="' . esc_attr( get_the_title( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '"><span itemprop="name">' . esc_html( get_the_title( get_post_meta( $post->ID, '_lp_course', true ) ) ) . '</span></a>' . $icon . '</li>';
			}

			// Single post (Only display the first category)
			if ( isset( $categories[0] ) ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $categories[0] ) ) . '" title="' . esc_attr( $categories[0]->name ) . '"><span itemprop="name">' . esc_html( $categories[0]->name ) . '</span></a>' . $icon . '</li>';
			}
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';

		} else if ( is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) {
			// All courses
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a>' . $icon . '</li>';

			// Category page
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr( single_term_title( '', false ) ) . '">' . esc_html( single_term_title( '', false ) ) . '</span></li>';
		} else if ( ! empty( $_REQUEST['s'] ) && ! empty( $_REQUEST['ref'] ) && ( $_REQUEST['ref'] == 'course' ) ) {
			// All courses
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_course' ) ) . '" title="' . esc_attr__( 'All courses', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'All courses', 'course-builder' ) . '</span></a>' . $icon . '</li>';

			// Search result
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'Search results for:', 'course-builder' ) . ' ' . esc_attr( get_search_query() ) . '">' . esc_html__( 'Search results for:', 'course-builder' ) . ' ' . esc_html( get_search_query() ) . '</span></li>';
		} else if ( get_post_type() == 'lp_collection' ) {
			// All courses
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_post_type_archive_link( 'lp_collection' ) ) . '" title="' . esc_attr__( 'Collections', 'course-builder' ) . '"><span itemprop="name">' . esc_html__( 'Collections', 'course-builder' ) . '</span></a></li>';
		} else {
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name" title="' . esc_attr__( 'All courses', 'course-builder' ) . '">' . esc_html__( 'All courses', 'course-builder' ) . '</span></li>';
		}

		echo '</ul>';
	}
}

/**
 * Get list sidebars
 */
if ( ! function_exists( 'thim_get_list_sidebar' ) ) {
	function thim_get_list_sidebar() {
		global $wp_registered_sidebars;

		$sidebar_array = array();
		$dp_sidebars   = $wp_registered_sidebars;

		$sidebar_array[''] = esc_attr__( '-- Select Sidebar --', 'course-builder' );

		foreach ( $dp_sidebars as $sidebar ) {
			$sidebar_array[ $sidebar['name'] ] = $sidebar['name'];
		}

		return $sidebar_array;
	}
}

/**
 * Turn on and get the back to top
 *
 * @return string HTML for the back to top
 */
if ( ! class_exists( 'thim_back_to_top' ) ) {
	function thim_back_to_top() {
		if ( get_theme_mod( 'feature_backtotop', true ) ) {
			?>
			<div id="back-to-top">
				<?php
				get_template_part( 'templates/footer/back-to-top' );
				?>
			</div>
			<?php
		}
	}
}
add_action( 'thim_space_body', 'thim_back_to_top', 10 );

/**
 * Switch footer layout
 *
 * @return string HTML footer layout
 */
if ( ! function_exists( 'thim_footer_layout' ) ) {
	function thim_footer_layout() {
		$template_name = 'templates/footer/' . get_theme_mod( 'footer_template', 'default' );
		get_template_part( $template_name );
	}
}

/**
 * Footer Widgets
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_footer_widgets' ) ) {
	function thim_footer_widgets() {
		$footer_col = get_theme_mod( 'footer_columns' );
		$col        = 12 / get_theme_mod( 'footer_columns', 6 );
		for ( $i = 1; $i <= get_theme_mod( 'footer_columns', 4 ); $i ++ ): ?>
			<?php
			if ( get_theme_mod( 'footer_columns' ) == 5 ) {
				if ( $i == 1 || $i == 5 ) {
					$col = '3';
				} else {
					$col = '2';
				}
			}
			?>
			<?php if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) { ?>
				<div class="footer-col footer-col<?php echo esc_attr( $footer_col ); ?> col-xs-12 col-md-<?php echo esc_attr( $col ); ?>">
					<?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?>
				</div>
			<?php } ?>
		<?php endfor;
	}
}


/**
 * Footer After Main Widgets
 *
 * @return bool
 * @return string
 */

if ( ! function_exists( 'thim_footer_after_main_widgets' ) ) {
	function thim_footer_after_main_widgets() {
		if ( is_active_sidebar( 'after_main' ) ) {
			dynamic_sidebar( 'after_main' );
		}
	}
}


/**
 * Footer Sticky Widgets
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_footer_sticky_widgets' ) ) {
	function thim_footer_sticky_widgets() {
		if ( is_active_sidebar( 'footer_sticky' ) ) {
			dynamic_sidebar( 'footer_sticky' );
		}
	}
}

/**
 * Footer Copyright bar
 *
 * @return bool
 * @return string
 */
if ( ! function_exists( 'thim_copyright_bar' ) ) {
	function thim_copyright_bar() {
		if ( get_theme_mod( 'copyright_bar', true ) ) : ?>
			<div class="copyright-text">
				<?php
				$link_default   = sprintf( '&copy; 2017 <a href="%1$s" ref="nofollow">Course Builder</a> Theme. All rights reserved.', esc_url( 'https://wordpresslms.thimpress.com/' ) );
				$copyright_text = get_theme_mod( 'copyright_text', $link_default );
				echo wp_kses( $copyright_text, array( 'a' => array( 'href' => array() ) ) );
				?>
			</div>
		<?php endif;
	}
}

/**
 * Footer menu
 *
 * @return bool
 * @return array
 */
if ( ! function_exists( 'thim_copyright_menu' ) ) {
	function thim_copyright_menu() {
		if ( get_theme_mod( 'copyright_menu', true ) ) :
			if ( has_nav_menu( 'copyright_menu' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'copyright_menu',
					'container'      => false,
					'items_wrap'     => '<ul id="copyright-menu" class="list-inline">%3$s</ul>',
					'depth'          => 1,
				) );
			}
		endif;
	}
}

/**
 * Theme Feature: RTL Support.
 *
 * @return @string
 */
if ( ! function_exists( 'thim_feature_rtl_support' ) ) {
	function thim_feature_rtl_support() {
		if ( get_theme_mod( 'feature_rtl_support', false ) ) {
			echo " dir=\"rtl\"";
		}
	}

	add_filter( 'language_attributes', 'thim_feature_rtl_support', 10 );
}


/**
 * Theme Feature: Open Graph insert doctype
 *
 * @param $output
 */
if ( ! function_exists( 'thim_doctype_opengraph' ) ) {
	function thim_doctype_opengraph( $output ) {
		if ( get_theme_mod( 'feature_open_graph_meta', true ) ) {
			return $output . ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"';
		}
	}

	add_filter( 'language_attributes', 'thim_doctype_opengraph' );
}

/**
 * Theme Feature: Preload
 *
 * @return string HTML for preload
 */
if ( ! function_exists( 'thim_preloading' ) ) {
	function thim_preloading() {
		$preloading = get_theme_mod( 'theme_feature_preloading', false );
		if ( $preloading ) {

			echo '<div id="thim-preloading">';

			thim_loading_icon();

			echo '</div>';

		}
	}

	add_action( 'thim_before_body', 'thim_preloading', 10 );
}

/**
 * Theme Feature: loading icon
 *
 * @return string HTML for loading icon
 */
if ( ! function_exists( 'thim_loading_icon' ) ) {
	function thim_loading_icon() {
		$loading = get_theme_mod( 'theme_feature_loading', 'chasing-dots' );

		echo '<div class="thim-loading-icon">';

		switch ( $loading ) {
			case 'custom-image':
				$loading_image = get_theme_mod( 'theme_feature_loading_custom_image', false );
				if ( $loading_image ) {
					include locate_template( 'templates/features/loading/' . $loading . '.php' );
				}
				break;
			default:
				include locate_template( 'templates/features/loading/' . $loading . '.php' );
				break;
		}

		echo '</div>';
	}

}

/**
 * Theme Feature: Open Graph meta tag
 *
 * @param string
 */
if ( ! function_exists( 'thim_add_opengraph' ) ) {
	function thim_add_opengraph() {
		global $post;

		if ( get_theme_mod( 'feature_open_graph_meta', true ) ) {
			if ( is_single() ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					$img_src = esc_attr( $img_src[0] );
				} else {
					$img_src = THIM_URI . 'assets/images/opengraph.png';
				}
				if ( $excerpt = $post->post_excerpt ) {
					$excerpt = strip_tags( $post->post_excerpt );
					$excerpt = str_replace( "", "'", $excerpt );
				} else {
					$excerpt = get_bloginfo( 'description' );
				}
				?>

				<meta property="og:title" content="<?php echo the_title(); ?>" />
				<meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:url" content="<?php echo the_permalink(); ?>" />
				<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>" />
				<meta property="og:image" content="<?php echo esc_attr( $img_src ); ?>" />

				<?php
			} else {
				return;
			}
		}
	}

	add_action( 'wp_head', 'thim_add_opengraph', 10 );
}


/**
 * Theme Feature: Google theme color
 */
if ( ! function_exists( 'thim_google_theme_color' ) ) {
	function thim_google_theme_color() {
		if ( get_theme_mod( 'feature_google_theme', false ) ) { ?>
			<meta name="theme-color"
			      content="<?php echo esc_attr( get_theme_mod( 'feature_google_theme_color', '#333333' ) ) ?>">
			<?php
		}
	}

	add_action( 'wp_head', 'thim_google_theme_color', 10 );
}

/**
 * Responsive: enable or disable responsive
 *
 * @return string
 * @return bool
 */
if ( ! function_exists( 'thim_enable_responsive' ) ) {
	function thim_enable_responsive() {
		if ( get_theme_mod( 'enable_responsive', true ) ) {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		}
	}

	add_action( 'wp_head', 'thim_enable_responsive', 1 );
}


/**
 * Override ajax-loader contact form
 *
 * $return mixed
 */

function thim_wpcf7_ajax_loader() {
	return THIM_URI . 'assets/images/icons/ajax-loader.gif';
}

add_filter( 'wpcf7_ajax_loader', 'thim_wpcf7_ajax_loader' );


/**
 * aq_resize function fake.
 * Aq_Resize
 */
if ( ! class_exists( 'Aq_Resize' ) ) {
	function thim_aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
		return $url;
	}
}


/**
 * Get feature image
 *
 * @param int  $width
 * @param int  $height
 * @param bool $link
 *
 * @return string
 */
function thim_feature_image( $width = 1024, $height = 768, $link = true ) {
	global $post;
	if ( has_post_thumbnail() ) {
		if ( $link != true && $link != false ) {
			the_post_thumbnail( $post->ID, $link );
		} else {
			$get_thumbnail = simplexml_load_string( get_the_post_thumbnail( $post->ID, 'full' ) );
			if ( $get_thumbnail ) {
				$thumbnail_src = $get_thumbnail->attributes()->src;
				$img_url       = $thumbnail_src;
				$data          = @getimagesize( $img_url );
				$width_data    = $data[0];
				$height_data   = $data[1];
				if ( $link ) {
					if ( ( $width_data < $width ) || ( $height_data < $height ) ) {
						echo '<div class="thumbnail"><a href="' . esc_url( get_permalink() ) . '" title = "' . get_the_title() . '">';
						echo '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
						echo '</a></div>';
					} else {
						$image_crop = thim_aq_resize( $img_url[0], $width, $height, true );
						echo '<div class="thumbnail"><a href="' . esc_url( get_permalink() ) . '" title = "' . get_the_title() . '">';
						echo '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
						echo '</a></div>';
					}
				} else {
					if ( ( $width_data < $width ) || ( $height_data < $height ) ) {
						return '<img src="' . $img_url[0] . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
					} else {
						$image_crop = thim_aq_resize( $img_url[0], $width, $height, true );

						return '<img src="' . $image_crop . '" alt= "' . get_the_title() . '" title = "' . get_the_title() . '" />';
					}
				}
			}
		}
	}
}

/**
 * @param $id
 * @param $size
 * @param $type : default is post
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_thumbnail' ) ) {
	function thim_get_thumbnail( $id, $size = 'thumbnail', $type = 'post', $link = true, $classes = '' ) {
		$width         = 0;
		$height        = 0;
		$attachment_id = $id;
		if ( $type === 'post' ) {
			$attachment_id = get_post_thumbnail_id( $id );
		}
		$src = wp_get_attachment_image_src( $attachment_id, 'full' );

		if ( $size != 'full' && ! in_array( $size, get_intermediate_image_sizes() ) ) {
			//custom size
			$thumbnail_size = explode( 'x', $size );
			$width          = $thumbnail_size[0];
			$height         = $thumbnail_size[1];
			$img_src        = thim_aq_resize( $src[0], $width, $height, true );
		} else if ( $size == 'full' ) {
			$img_src = $src[0];
			$width   = $src[1];
			$height  = $src[2];
		} else {
			$image_size = wp_get_attachment_image_src( $attachment_id, $size );
			$width      = $image_size[1];
			$height     = $image_size[2];
		}

		if ( empty( $img_src ) ) {
			$img_src = $src[0];
		}

		$html = '';
		$html .= '<img ' . image_hwstring( $width, $height ) . ' src="' . esc_attr( $img_src ) . '" alt="' . get_the_title( $id ) . '" class="' . $classes . '">';
		if ( $link ) {
			$html .= '<a href="' . esc_url( get_permalink( $id ) ) . '" class="img-link"></a>';
		}

		return $html;
	}
}

/**
 * @param      $id
 * @param      $size
 */
if ( ! function_exists( 'thim_thumbnail' ) ) {
	function thim_thumbnail( $id, $size, $type = 'post', $link = true, $classes = '' ) {
		echo thim_get_thumbnail( $id, $size, $type, $link, $classes );
	}
}

function thim_page_title( $output_value = null ) {

	global $wp_query;
	$GLOBALS['post']      = @$wp_query->post;
	$thim_heading_top_src = $custom_title = $custom_description = $text_color = $sub_color = $front_title = '';
	$main_bg_color        = get_theme_mod( 'page_title_background_color', 'rgba(0,0,0,0.6)' );
	$output_title         = $output_description = $output_overlay_css = $output_main_css = '';
	$main_bg_opacity      = '';

	$output = array(
		'show_text'       => get_theme_mod( 'page_title_show_text', true ),
		'title'           => '',
		'description'     => '',
		'overlay_css'     => '',
		'main_css'        => '',
		'show_title'      => true,
		'show_sub_title'  => true,
		'show_breadcrumb' => get_theme_mod( 'show_breadcrumb', true ),
		'layout'          => get_theme_mod( 'page_title_layout', 'layout-1' )
	);


	$cat_obj = $wp_query->get_queried_object();
	if ( isset( $cat_obj->term_id ) ) {
		$cat_ID = $cat_obj->term_id;
	} else {
		$cat_ID = "";
	}


	if ( get_theme_mod( 'page_title_custom_title' ) ) {
		$custom_title = get_theme_mod( 'page_title_custom_title' );
	}

	if ( get_theme_mod( 'page_title_custom_description' ) ) {
		$custom_description = get_theme_mod( 'page_title_custom_description' );
	}


	$thim_heading_top_src = THIM_URI . "assets/images/page-title/bg.jpg";
	if ( get_theme_mod( 'page_title_background_image' ) ) {
		$thim_heading_top_img = get_theme_mod( 'page_title_background_image' );
		$thim_heading_top_src = $thim_heading_top_img; // For the default value

		if ( is_numeric( $thim_heading_top_img ) ) {
			$thim_heading_top_attachment = wp_get_attachment_image_src( $thim_heading_top_img, 'full' );
			$thim_heading_top_src        = $thim_heading_top_attachment[0];
		}
	}

	//CUSTOM METABOX
	if ( is_page() || is_single() ) {
		$postid               = get_the_ID();
		$using_custom_heading = get_post_meta( $postid, 'thim_enable_custom_title', true );

		//	Customizer
		if ( is_singular( 'post' ) ) {
			$output['show_text']       = get_theme_mod( 'blog_single_pagetitle', false );
			$output['show_title']      = get_theme_mod( 'blog_single_pagetitle', false );
			$output['show_breadcrumb'] = get_theme_mod( 'blog_single_pagetitle', false );
		} elseif ( is_singular( 'lp_course' ) || is_singular( 'lp_collection' ) ) {
			$course = learn_press_get_the_course();
			$user   = learn_press_get_current_user();
			if ( $user->has_course_status( $course->id, array(
					'enrolled',
					'finished'
				) ) || ! $course->is_require_enrollment()
			) {
				$output['show_text']       = false;
				$output['show_title']      = false;
				$output['show_breadcrumb'] = false;
			}
		}

		if ( $using_custom_heading ) {
			$custom_title_hide_page_title  = get_post_meta( $postid, 'thim_group_custom_title_hide_page_title', true );
			$custom_title_hide_title       = get_post_meta( $postid, 'thim_group_custom_title_hide_title', true );
			$custom_title_hide_sub_title   = get_post_meta( $postid, 'thim_group_custom_title_hide_sub_title', true );
			$custom_title_hide_breadcrumbs = get_post_meta( $postid, 'thim_group_custom_title_hide_breadcrumbs', true );
			$custom_layout                 = get_post_meta( $postid, 'thim_group_custom_title_layout', true );

			if ( $custom_title_hide_page_title ) {
				$output['show_text'] = false;
			}
			if ( $custom_layout ) {
				$output['layout'] = $custom_layout;
			}
			if ( $custom_title_hide_title ) {
				$output['show_title'] = false;
			}
			if ( $custom_title_hide_sub_title ) {
				$output['show_sub_title'] = false;
			}
			if ( $custom_title_hide_breadcrumbs ) {
				$output['show_breadcrumb'] = false;
			}
		}
	} else {
		$postid               = $wp_query->get_queried_object_id();
		$using_custom_heading = get_post_meta( $postid, 'thim_enable_custom_title', true );

		//	Customizer
		if ( is_archive() ) {
			$output['show_title']      = get_theme_mod( 'blog_archive_pagetitle', true );
			$output['show_breadcrumb'] = get_theme_mod( 'blog_archive_pagetitle', true );
		}


		if ( $using_custom_heading ) {
			$array_title = get_post_meta( $postid, 'thim_group_custom_title', false );
			$array_bg    = get_post_meta( $postid, 'thim_group_custom_background', false );

			if ( isset( $array_title[0] ) ) {
				if ( isset( $array_title[0]['thim_hide_title'] ) ) {
					$output['show_text'] = false;
				}
				if ( isset( $array_title[0]['thim_custom_title'] ) ) {
					$custom_title = $array_title[0]['thim_custom_title'];
				}
				if ( isset( $array_title[0]['thim_custom_subtitle'] ) ) {
					$custom_description = $array_title[0]['thim_custom_subtitle'];
				}
				if ( isset( $array_title[0]['thim_color_title'] ) ) {
					$text_color_1 = $array_title[0]['thim_color_title'];
					if ( $text_color_1 ) {
						$text_color = $text_color_1;
					}
				}
				if ( isset( $array_title[0]['thim_color_subtitle'] ) ) {
					$sub_color_1 = $array_title[0]['thim_color_subtitle'];
					if ( $sub_color_1 ) {
						$sub_color = $sub_color_1;
					}
				}
				if ( isset( $array_title[0]['thim_hide_breadcrumbs'] ) ) {
					$output['show_breadcrumb'] = false;
				}
			}

			if ( isset( $array_bg[0]['thim_heading_image'] ) ) {
				$thim_heading_top_img        = $array_bg[0]['thim_heading_image'];
				$thim_heading_top_attachment = wp_get_attachment_image_src( $thim_heading_top_img[0], 'full' );
				$thim_heading_top_src        = $thim_heading_top_attachment[0];
			}
			if ( isset( $array_bg[0]['thim_heading_background'] ) ) {
				$main_bg_color = $array_bg[0]['thim_heading_background'];
			}

			if ( isset( $array_bg[0]['thim_heading_background_opacity'] ) ) {
				$main_bg_opacity = $array_bg[0]['thim_heading_background_opacity'];
			}

		}
	}

	// style css
	$c_css_style = $overlay_css_style = $title_css_style = $title_css = '';
	$c_css_style .= ( $thim_heading_top_src != '' ) ? 'background-image:url(' . $thim_heading_top_src . ');' : '';

	$title_css_style .= ( $text_color != '' ) ? 'color: ' . $text_color . ';' : '';
	$c_css_sub_color = ( $sub_color != '' ) ? 'style="color:' . $sub_color . '"' : '';

	$title_css       = ( $title_css_style != '' ) ? 'style="' . $title_css_style . '"' : '';
	$output_main_css = ( $c_css_style != '' ) ? 'style="' . $c_css_style . '"' : '';

	if ( $main_bg_color ) {
		$overlay_css_style .= 'background-color: ' . $main_bg_color . ';';
	}
	if ( $main_bg_opacity != '' ) {
		$overlay_css_style .= 'opacity: ' . $main_bg_opacity . ';';
	}

	$output_overlay_css = ( $overlay_css_style != '' ) ? 'style="' . $overlay_css_style . '"' : '';

	if ( is_single() ) {
		$typography = 'h1 ' . $title_css;
	} else {
		$typography = 'h1 ' . $title_css;
	}
	if ( ( get_post_type() == "product" ) ) {
		$output_title .= '<' . $typography . '>' . woocommerce_page_title( false );
		$output_title .= '</' . $typography . '>';
		$output_description .= $custom_description ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	} elseif ( ( is_category() || is_archive() || is_search() || is_404() ) ) {
		$output['show_title'] = true;
		$output['show_breadcrumb'] = true;
		$output_title .= '<' . $typography . '>';
		$output_title .= thim_archive_title();
		$output_title .= '</' . $typography . '>';
		if ( category_description( $cat_ID ) != '' ) {
		} else {
			$output_description .= $custom_description ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
		}
		if ( get_post_type() == "lp_collection" ) {
			$output['show_title']      = true;
			$output['show_breadcrumb'] = true;
			$output_title .= '<' . $typography . '>' . esc_html__( 'Collections', 'course-builder' );
			$output_title .= '</' . $typography . '>';
			$custom_description = get_the_excerpt();
		}
	} elseif ( is_page() || is_single() ) {
		if ( is_single() ) {
			if ( get_post_type() == "post" ) {
				if ( $custom_title ) {
					$single_title = $custom_title;
				} else {
					$single_title = esc_html__( 'Single Post', 'course-builder' );
				}
				$output_title .= '<' . $typography . '>' . $single_title;
				$output_title .= '</' . $typography . '>';
			}
			if ( get_post_type() == "our_team" ) {
				$output_title .= '<' . $typography . '>' . esc_html__( 'Our Team', 'course-builder' );
				$output_title .= '</' . $typography . '>';
			}
			if ( get_post_type() == "lp_course" || get_post_type() == "lp_collection" ) {
				$output_title .= '<' . $typography . '>' . get_the_title();
				$output_title .= '</' . $typography . '>';
				$custom_description = get_the_excerpt();
				if ( get_post_type() == "lp_course" ) {
					$single_layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );
					if ( $single_layout == 1 ) {
						$course = LP()->global['course'];
						if ( learn_press_is_enrolled_course() ) {
							return;
						}
						if ( $price = $course->get_price_html() ) {
							$custom_description .= '<div class="price">';
							$origin_price = $course->get_origin_price_html();

							if ( $course->get_sale_price() !== ''/* $price != $origin_price */ ) {
								$custom_description .= '<span class="course-origin-price">' . $origin_price . '</span>';
							}

							$free_course = ( $price === 'Free' ) ? ' free' : '';
							$custom_description .= '<span class="course-price' . $free_course . '">' . $price . '</span>';
							$custom_description .= '</div>';
						}
					}
				}

			}
			if ( get_post_type() == "tp_event" ) {
				$output_title .= '<' . $typography . '>' . get_the_title();
				$output_title .= '</' . $typography . '>';
			}
		} else {
			$output_title .= '<' . $typography . '>';
			$output_title .= ( $custom_title != '' ) ? $custom_title : get_the_title( get_the_ID() );
			$output_title .= '</' . $typography . '>';
		}
		$output_description .= $custom_description ? '<div class="banner-description" ' . $c_css_sub_color . '>' . $custom_description . '</div>' : '';
	} elseif ( is_front_page() || is_home() ) {
		$output_title .= '<h1>';
		$output_title .= ( $front_title != '' ) ? $front_title : esc_html__( 'Blog', 'course-builder' );
		$output_title .= '</h1>';
		$output_description .= $custom_description ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	} else {
		$output_title .= '<' . $typography . '>';
		$output_title .= ( $custom_title != '' ) ? $custom_title : get_the_title( get_the_ID() );
		$output_title .= '</' . $typography . '>';
		$output_description .= $custom_description ? '<div class="banner-description" ' . $c_css_sub_color . '><p>' . $custom_description . '</p></div>' : '';
	}


	$output['title']       = $output_title;
	$output['description'] = $output_description;
	$output['overlay_css'] = $output_overlay_css;
	$output['main_css']    = $output_main_css;

	if ( ( $output['show_text'] == false ) && ( $output_overlay_css == '' ) && ( $output_main_css == '' ) ) {
		$output['show_title'] = false;
	}

	if ( $output_value ) {
		return $output[ $output_value ];
	} else {
		return $output;
	}
}

/**
 * Check new version of LearnPress
 *
 * @return mixed
 */
if ( ! function_exists( 'thim_is_new_learnpress' ) ) {
	function thim_is_new_learnpress( $version ) {
		return version_compare( get_option( 'learnpress_version' ), $version, '>=' );
	}
}
if ( ! function_exists( 'thim_check_is_course' ) ) {
	function thim_check_is_course() {

		if ( function_exists( 'learn_press_is_courses' ) && learn_press_is_courses() ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'thim_check_is_course_taxonomy' ) ) {
	function thim_check_is_course_taxonomy() {

		if ( function_exists( 'learn_press_is_course_taxonomy' ) && learn_press_is_course_taxonomy() ) {
			return true;
		} else {
			return false;
		}
	}
}


//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter( 'pre_user_description', 'wp_filter_kses' );

//add sanitization for WordPress posts
remove_filter( 'pre_user_description', 'wp_filter_post_kses', 100 );

// Filter html tags biographical user Info
add_filter( 'insert_user_meta', function ( $meta, $user, $update ) {
	if ( ! empty( $_REQUEST['description'] ) && array_key_exists( 'description', $meta ) ) {
		$meta['description'] = preg_replace( '~</?(script|iframe|form)>~', '', $_REQUEST['description'] );
	}

	return $meta;
}, 10, 3 );


/**
 * Print ajax
 *
 * @return string
 */
add_action( 'wp_head', 'thim_lazy_ajax', 0, 0 );
function thim_lazy_ajax() {
	?>
	<script type="text/javascript">
		/* <![CDATA[ */
		var ajaxurl = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>";
		/* ]]> */
	</script>
	<?php
}


/**
 * Show entry format images, video, gallery, audio, etc.
 *
 * @return void
 */
if ( ! function_exists( 'thim_top_entry' ) ):
	function thim_top_entry( $size ) {
		$html = '';

		$style = isset( $_GET['style'] ) ? $_GET['style'] : get_theme_mod( 'archive_post_layout', 'list' );

		switch ( get_post_format() ) {
			case 'image':
				$image = thim_get_image( array(
					'size'     => $size,
					'format'   => 'src',
					'meta_key' => 'thim_image',
					'echo'     => false,
				) );

				if ( ! $image ) {
					break;
				}

				$html = sprintf( '<a class="post-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>', esc_url( get_permalink() ), esc_attr( the_title_attribute( 'echo=0' ) ), $image );
				break;
			case 'gallery':
				$images = thim_meta( 'thim_gallery', "type=image&single=false&size=$size" );
				$thumbs = thim_meta( 'thim_gallery', "type=image&single=false&size=thumbnail" );
				if ( empty( $images ) ) {
					break;
				}
				$html .= '<div class="flexslider">';
				$html .= '<ul class="slides">';
				foreach ( $images as $key => $image ) {
					if ( ! empty( $image['url'] ) ) {
						$html .= sprintf( '<li data-thumb="%s"><a href="%s" class="hover-gradient"><img src="%s" alt="gallery"></a></li>', $thumbs[ $key ]['url'], esc_url( get_permalink() ), esc_url( $image['url'] ) );
					}
				}
				$html .= '</ul>';
				$html .= '</div>';
				break;
			case 'audio':
				$audio = thim_meta( 'thim_audio' );
				if ( ! $audio ) {
					break;
				}
				// If URL: show oEmbed HTML or jPlayer
				if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
					//jsplayer
					wp_enqueue_style( 'thim-pixel-industry', THIM_CORE_ADMIN_URI . '/assets/js/jplayer/skin/pixel-industry/pixel-industry.css' );
					wp_enqueue_script( 'thim-jplayer', THIM_CORE_ADMIN_URI . '/assets/js/jplayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );

					// Try oEmbed first
					if ( $oembed = @wp_oembed_get( $audio ) ) {
						$html .= $oembed;
					} // Use jPlayer
					else {
						$id = uniqid();
						$html .= "<div data-player='$id' class='jp-jplayer' data-audio='$audio'></div>";
						$html .= thim_jplayer( $id );
					}
				} // If embed code: just display
				else {
					$html .= $audio;
				}
				break;
			case 'video':

				$video = thim_meta( 'thim_video' );
				if ( ! $video ) {
					break;
				}
				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video ) ) {
						$html .= $oembed;
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
				break;
			default:
				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
				if ( empty( $thumb ) ) {
					return;
				}

				if ( ! is_single() ) {
					switch ( $style ) {
						case 'grid' :
							$thumb = thim_get_thumbnail( get_the_ID(), '485x291', 'post', false );
							break;
						default:
							//list
							$thumb = thim_get_thumbnail( get_the_ID(), '1200x520', 'post', false );
							break;
					}
				}

				$html .= '<a class="post-image" href="' . esc_url( get_permalink() ) . '">';
				$html .= $thumb;
				$html .= '</a>';
		}
		if ( $html ) {
			echo "<div class='post-formats-wrapper'>$html</div>";
		}
	}
endif;
add_action( 'thim_top_entry', 'thim_top_entry' );


/**
 * Get post meta
 *
 * @param $key
 * @param $args
 * @param $post_id
 *
 * @return string
 * @return bool
 */
if ( ! function_exists( 'thim_meta' ) ) {
	function thim_meta( $key, $args = array(), $post_id = null ) {
		$post_id = empty( $post_id ) ? get_the_ID() : $post_id;

		$args = wp_parse_args( $args, array(
			'type' => 'text',
		) );

		// Image
		if ( in_array( $args['type'], array( 'image' ) ) ) {
			if ( isset( $args['single'] ) && $args['single'] == "false" ) {
				// Gallery
				$temp          = array();
				$data          = array();
				$attachment_id = get_post_meta( $post_id, $key, false );
				if ( ! $attachment_id ) {
					return $data;
				}

				if ( empty( $attachment_id ) ) {
					return $data;
				}
				foreach ( $attachment_id as $k => $v ) {
					$image_attributes = wp_get_attachment_image_src( $v, $args['size'] );
					$temp['url']      = $image_attributes[0];
					$data[]           = $temp;
				}

				return $data;
			} else {
				// Single Image
				$attachment_id    = get_post_meta( $post_id, $key, true );
				$image_attributes = wp_get_attachment_image_src( $attachment_id, $args['size'] );

				return $image_attributes;
			}
		}

		return get_post_meta( $post_id, $key, $args );
	}
}


/**
 * Get image features
 *
 * @param $args
 *
 * @return array|void
 */
if ( ! function_exists( 'thim_get_image' ) ) {
	function thim_get_image( $args = array() ) {
		$default = apply_filters( 'thim_get_image_default_args', array(
			'post_id'  => get_the_ID(),
			'size'     => 'thumbnail',
			'format'   => 'html', // html or src
			'attr'     => '',
			'meta_key' => '',
			'scan'     => true,
			'default'  => '',
			'echo'     => true,
		) );

		$args = wp_parse_args( $args, $default );

		if ( ! $args['post_id'] ) {
			$args['post_id'] = get_the_ID();
		}

		// Get image from cache
		$key         = md5( serialize( $args ) );
		$image_cache = wp_cache_get( $args['post_id'], 'thim_get_image' );

		if ( ! is_array( $image_cache ) ) {
			$image_cache = array();
		}

		if ( empty( $image_cache[ $key ] ) ) {
			// Get post thumbnail
			if ( has_post_thumbnail( $args['post_id'] ) ) {
				$id   = get_post_thumbnail_id();
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}

			// Get the first image in the custom field
			if ( ! isset( $html, $src ) && $args['meta_key'] ) {
				$id = get_post_meta( $args['post_id'], $args['meta_key'], true );

				// Check if this post has attached images
				if ( $id ) {
					$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
					list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
				}
			}

			// Get the first attached image
			if ( ! isset( $html, $src ) ) {
				$image_ids = array_keys( get_children( array(
					'post_parent'    => $args['post_id'],
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) ) );

				// Check if this post has attached images
				if ( ! empty( $image_ids ) ) {
					$id   = $image_ids[0];
					$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
					list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
				}
			}

			// Get the first image in the post content
			if ( ! isset( $html, $src ) && ( $args['scan'] ) ) {
				preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

				if ( ! empty( $matches ) ) {
					$html = $matches[0];
					$src  = $matches[1];
				}
			}

			// Use default when nothing found
			if ( ! isset( $html, $src ) && ! empty( $args['default'] ) ) {
				if ( is_array( $args['default'] ) ) {
					$html = @$args['html'];
					$src  = @$args['src'];
				} else {
					$html = $src = $args['default'];
				}
			}

			// Still no images found?
			if ( ! isset( $html, $src ) ) {
				return false;
			}

			$output = 'html' === strtolower( $args['format'] ) ? $html : $src;

			$image_cache[ $key ] = $output;
			wp_cache_set( $args['post_id'], $image_cache, 'thim_get_image' );
		} // If image already cached
		else {
			$output = $image_cache[ $key ];
		}

		$output = apply_filters( 'thim_get_image', $output, $args );

		if ( ! $args['echo'] ) {
			return $output;
		}

		echo ent2ncr( $output );
	}
}

//admin custom style
add_action( 'admin_enqueue_scripts', 'thim_admin_custom_styles' );
function thim_admin_custom_styles() {
	wp_enqueue_style( 'thim-admin-custom', get_template_directory_uri() . '/assets/css/admin.css', array(), true );
}

/**
 * Filter lost password link
 *
 * @param $url
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_lost_password_url' ) ) {
	function thim_get_lost_password_url() {
		$url = add_query_arg( 'action', 'lostpassword', thim_get_login_page_url() );

		return $url;
	}
}

/**
 * Get login page url
 *
 * @return false|string
 */
if ( ! function_exists( 'thim_get_login_page_url' ) ) {
	function thim_get_login_page_url() {
		if ( $page = get_option( 'thim_login_page' ) ) {
			return get_permalink( $page );
		} else {
			global $wpdb;
			$page = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT p.ID FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS pm ON p.ID = pm.post_id
			WHERE 	pm.meta_key = %s
			AND 	pm.meta_value = %s
			AND		p.post_type = %s
			AND		p.post_status = %s",
					'thim_login_page',
					'1',
					'page',
					'publish'
				)
			);
			if ( ! empty( $page[0] ) ) {
				return get_permalink( $page[0] );
			}
		}

		return wp_login_url();

	}
}

/**
 * Redirect to custom login page
 */
if ( ! function_exists( 'thim_login_failed' ) ) {
	function thim_login_failed() {
		wp_redirect( add_query_arg( 'result', 'failed', thim_get_login_page_url() ) );
		exit;
	}

	add_action( 'wp_login_failed', 'thim_login_failed', 1000 );
}

/**
 * Filter register link
 *
 * @param $register_url
 *
 * @return string|void
 */
if ( ! function_exists( 'thim_get_register_url' ) ) {
	function thim_get_register_url() {
		$url = add_query_arg( 'action', 'register', thim_get_login_page_url() );

		return $url;
	}
}

/**
 * Remove hook tp-event-auth
 */
if ( class_exists( 'TP_Event_Authentication' ) ) {
	if ( ! version_compare( get_option( 'event_auth_version' ), '1.0.3', '>=' ) ) {
		$auth = TP_Event_Authentication::getInstance()->auth;

		remove_action( 'login_form_login', array( $auth, 'redirect_to_login_page' ) );
		remove_action( 'login_form_register', array( $auth, 'login_form_register' ) );
		remove_action( 'login_form_lostpassword', array( $auth, 'redirect_to_lostpassword' ) );
		remove_action( 'login_form_rp', array( $auth, 'resetpass' ) );
		remove_action( 'login_form_resetpass', array( $auth, 'resetpass' ) );

		remove_action( 'wp_logout', array( $auth, 'wp_logout' ) );
		remove_filter( 'login_url', array( $auth, 'login_url' ) );
		remove_filter( 'login_redirect', array( $auth, 'login_redirect' ) );
	}
}
/**
 * Filter event login url
 */
add_filter( 'tp_event_login_url', 'thim_get_login_page_url' );
add_filter( 'event_auth_login_url', 'thim_get_login_page_url' );

if ( ! function_exists( 'thim_is_lp_profile_page' ) ) {
	function thim_is_lp_profile_page() {
		if ( class_exists( 'LearnPress' ) ) {
			return learn_press_is_profile();
		}

		return false;
	}
}

if ( ! function_exists( 'thim_is_lp_courses_page' ) ) {
	function thim_is_lp_courses_page() {
		if ( class_exists( 'LearnPress' ) ) {
			return learn_press_is_courses();
		}

		return false;
	}
}

/*
 * Hide/unhide advertisement in dashboard
 * */
if ( get_theme_mod( 'thim_learnpress_hidden_ads' ) ) {
	remove_action( 'admin_footer', 'learn_press_advertise_in_admin', - 10 );
}
