<?php
/**
 * Page Title Bar
 */
$page_title      = thim_page_title();
$show_title      = $page_title['show_title'];
$show_sub_title  = $page_title['show_sub_title'];
$show_text       = $page_title['show_text'];
$title           = $page_title['title'];
$description     = $page_title['description'];
$main_css        = $page_title['main_css'];
$overlay_css     = $page_title['overlay_css'];
$show_breadcrumb = $page_title['show_breadcrumb'];

$courses_layout = '';
$top_widgetarea = isset( $_GET['top_widgetarea'] ) ? $_GET['top_widgetarea'] : get_theme_mod( 'learnpress_top_sidebar_archive_display', true );
if ( ( $top_widgetarea === '1' || $top_widgetarea === 'true' ) && ! is_single() ) {
	if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
		$courses_layout = 'breadcrumb-plus';
	}
}
?>

<?php if ( $show_text ) : ?>
	<div class="main-top" <?php echo ent2ncr( $main_css ); ?>>
		<span class="overlay-top-header" <?php echo ent2ncr( $overlay_css ); ?>></span>
		<div class="content container">
			<div class="row">
				<?php if ( $show_title ) : ?>
					<div class="text-title col-md-6">
						<?php echo ent2ncr( $title ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $show_sub_title ) : ?>
					<div class="text-description col-md-6">
						<?php echo ent2ncr( $description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- .main-top -->
<?php endif; ?>

<?php if ( $show_breadcrumb ) : ?>
	<?php if ( ! is_front_page() || ! is_home() ) : ?>
		<div class="breadcrumb-content <?php echo esc_attr( $courses_layout ); ?>">
			<div class="breadcrumbs-wrapper container">
				<?php
				if ( is_singular( 'lp_course' ) ) {
					$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );
					if ( $layout == 1 ) {
						learn_press_get_template( 'single-course/buttons.php' );
					}
				} else {
					if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || get_post_type() == 'lp_collection' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
						thim_learnpress_breadcrumb();
					} elseif ( get_post_type() == 'product' ) {
						woocommerce_breadcrumb();
					} else {
						thim_breadcrumbs();
					}
				}
				?>
			</div><!-- .breadcrumbs-wrapper -->
		</div><!-- .breadcrumb-content -->
	<?php endif; ?>
<?php endif;
