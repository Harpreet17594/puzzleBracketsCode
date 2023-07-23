<?php
/**
 * Header v2 Template
 *
 * @package Thim_Starter_Theme
 */
?>

<div class="header-wrapper">
	<div class="main-header container">
		<div class="menu-mobile-effect navbar-toggle" data-effect="mobile-effect">
			<div class="icon-wrap">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</div>
		</div>
		<div class="width-logo">
			<?php do_action( 'thim_header_logo' ); ?>
			<?php do_action( 'thim_header_sticky_logo' ); ?>
		</div>
		<div class="width-navigation">
			<?php get_template_part( 'templates/header/main-menu' ); ?>
			<?php if ( get_theme_mod( 'header_sidebar_right_display', true ) ) : ?>
				<div class="header-right">
					<?php dynamic_sidebar( 'header_right' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>