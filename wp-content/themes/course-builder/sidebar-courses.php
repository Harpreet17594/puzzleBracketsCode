<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package thim
 */
if ( ! is_active_sidebar( 'sidebar_courses' ) ) {
	return;
}
$wrapper_layout = 'sidebar-left';
if ( get_theme_mod( 'learnpress_archive_layout' ) != '' ) {
	$wrapper_layout = get_theme_mod( 'learnpress_archive_layout' );
}

// Get class layout
$sidebar_class_col = 'flex-last';
if ( $wrapper_layout == 'sidebar-left' ) {
	$sidebar_class_col = "flex-first";
}
if ( $wrapper_layout == 'sidebar-right' ) {
	$sidebar_class_col = 'flex-last';
}
?>
<?php if ( $wrapper_layout != 'full-sidebar' ) { ?>
	<aside id="secondary" class="sidebar-courses widget-area col-md-3 sticky-sidebar <?php echo esc_attr( $sidebar_class_col ); ?>">
		<?php if ( ! dynamic_sidebar( 'sidebar_courses' ) ) :
			dynamic_sidebar( 'sidebar_courses' );
		endif; // end sidebar widget area ?>
	</aside><!-- #secondary -->
<?php } ?>