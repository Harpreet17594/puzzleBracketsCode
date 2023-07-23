<?php
/**
 * Template for printing js templates
 *
 * @package LearnPress/Templates
 * @author  ThimPress
 * @version 2.1.5
 */
if ( learn_press_is_course() ) {
	$course = learn_press_get_course( get_the_ID() );
	$user   = learn_press_get_current_user();

	$thim_popup_logo_src = THIM_URI . "assets/images/logo-2.png";
	?>
	<script type="text/template" id="learn-press-template-curriculum-popup">
		<div id="course-curriculum-popup" class="sidebar-hide">
			<div id="popup-header">
				<div class="icon-toggle-curriculum open" onclick="toggle_curiculum_sidebar();"></div>
				<div class="thim-sc-course-search">
					<form role="search" method="get" action="<?php echo site_url( '/' ); ?>">
						<input type="text" value="" name="s" placeholder="<?php esc_attr_e( 'What do you want to learn today?', 'course-builder' ) ?>" class="form-control courses-search-input" autocomplete="off">
						<input type="hidden" value="course" name="ref">
						<button type="submit"><i class="ion-android-search"></i></button>
						<span class="widget-search-close"></span>
					</form>
					<ul class="courses-list-search list-unstyled"></ul>
				</div>
				<!--				<a class="popup-logo" href="--><?php //echo esc_url( home_url( '/' ) ) ?><!--" title="--><?php //echo esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) ?><!--" rel="home">-->
				<!--					<img class="logo" src="--><?php //echo esc_url( $thim_popup_logo_src ) ?><!--" alt="--><?php //echo esc_attr( get_bloginfo( 'name', 'display' ) ) ?><!--" />-->
				<!--				</a>-->
				<div class="popup-logo thim-logo">
					<?php do_action( 'thim_popup_logo' ); ?>
				</div>
				<a class="popup-close"><i class="ion-ios-close-empty"></i></a>
			</div>
			<div id="popup-main">
				<div id="popup-content">
					<div id="popup-content-inner">
					</div>
				</div>
			</div>
			<div id="popup-sidebar">
				<?php

				$args = wp_parse_args( $args, apply_filters( 'learn_press_breadcrumb_defaults', array(
					'delimiter'   => ' <span class="delimiter">/</span> ',
					'wrap_before' => '<nav class="thim-font-heading learn-press-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
					'wrap_after'  => '</nav>',
					'before'      => '',
					'after'       => '',
				) ) );

				$breadcrumbs = new LP_Breadcrumb();


				$args['breadcrumb'] = $breadcrumbs->generate();

				learn_press_get_template( 'global/breadcrumb.php', $args );

				?>
			</div>
		</div>
	</script>

<?php } ?>

<script type="text/template" id="learn-press-template-course-prev-item">
	<div class="course-content-lesson-nav course-item-prev prev-item">
		<a class="footer-control prev-item button-load-item" data-id="{{data.id}}" href="{{data.url}}">{{data.title}}</a>
	</div>
</script>

<script type="text/template" id="learn-press-template-course-next-item">
	<div class="course-content-lesson-nav course-item-next next-item">
		<a class="footer-control next-item button-load-item" data-id="{{data.id}}" href="{{data.url}}">{{data.title}}</a>
	</div>
</script>

<script type="text/template" id="learn-press-template-block-content">
	<div id="learn-press-block-content" class="popup-block-content">
		<?php thim_loading_icon() ?>
	</div>
</script>