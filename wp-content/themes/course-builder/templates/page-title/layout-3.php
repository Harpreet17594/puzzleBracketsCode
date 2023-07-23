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

?>

<?php if ( $show_breadcrumb ) : ?>
	<?php if ( ! is_front_page() || ! is_home() ) : ?>
		<div class="breadcrumb-content">
			<div class="breadcrumbs-wrapper container">
				<?php
				if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
					thim_learnpress_breadcrumb();
				} elseif ( get_post_type() == 'product' ) {
					woocommerce_breadcrumb();
				} else {
					thim_breadcrumbs();
				}
				?>
			</div><!-- .breadcrumbs-wrapper -->
		</div><!-- .breadcrumb-content -->
	<?php endif; ?>
<?php endif; ?>

<?php if ( $show_text ) : ?>
	<div class="main-top" <?php echo ent2ncr( $main_css ); ?>>
		<span class="overlay-top-header" <?php echo ent2ncr( $overlay_css ); ?>></span>
		<div class="content container">
			<?php if ( $show_title ) : ?>
				<div class="text-title">
					<?php echo ent2ncr( $title ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $show_sub_title ) : ?>
				<div class="text-description">
					<?php echo ent2ncr( $description ); ?>
				</div>
			<?php endif; ?>
			<?php
			if ( is_singular( 'lp_course' ) ) {
				$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : get_theme_mod( 'learnpress_single_course_style', 1 );
				if ( $layout == 1 ) {
					learn_press_get_template( 'single-course/buttons.php' );
				}
			}
			?>
		</div>
	</div><!-- .main-top -->
<?php endif; ?>


