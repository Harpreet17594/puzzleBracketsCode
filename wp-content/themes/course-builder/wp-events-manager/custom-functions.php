<?php


/**
 * Add navigation
 */
add_action( 'tp_event_after_event_loop', 'thim_paging_nav' );

/**
 * Add sidebar
 */
add_action( 'widgets_init', 'thim_event_widgets_init' );
function thim_event_widgets_init() {
	register_sidebar( array(
		'name'          => esc_attr__( 'Events - Sidebar', 'course-builder' ),
		'id'            => 'sidebar_events',
		'description'   => esc_attr__( 'Sidebar of Events', 'course-builder' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}