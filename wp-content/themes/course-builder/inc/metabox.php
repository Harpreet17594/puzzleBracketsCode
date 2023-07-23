<?php

/**
 *
 * Home Settings
 *
 * @param $meta_boxes
 *
 * @return array
 */
function thim_metabox_home_settings( $meta_boxes ) {
	$prefix = 'thim_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'footer',
		'title'      => esc_html__( 'Home - Settings', 'course-builder' ),
		'post_types' => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'show'       => array(
			'template' => array( 'templates/home-page.php' ),
		),
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Footer Palette Colors', 'course-builder' ),
				'id'      => $prefix . 'footer_palette',
				'type'    => 'select',
				'options' => array(
					'default' => esc_html__( 'Default', 'course-builder' ),
					'light'   => esc_html__( 'Light', 'course-builder' ),
					'dark'    => esc_html__( 'Dark', 'course-builder' ),
				)
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_metabox_home_settings' );


/**
 *
 * Home Settings
 *
 * @param $meta_boxes
 *
 * @return array
 */
function thim_metabox_extra_class( $meta_boxes ) {
	$prefix = 'thim_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'extra',
		'title'      => esc_html__( 'Advanced Settings', 'course-builder' ),
		'post_types' => array( 'page' ),
		'context'    => 'side',
		'priority'   => 'low',
		'fields'     => array(
			array(
				'name' => esc_html__( 'Extra Class', 'course-builder' ),
				'id'   => $prefix . 'extra_class',
				'type' => 'text',
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'thim_metabox_extra_class' );


/**
 * Display Settings
 * Page
 * @author khoapq
 */
add_filter( 'thim_metabox_display_settings', 'thim_metabox_page_display_settings' );
function thim_metabox_page_display_settings( $metabox_ ) {
	$prefix = 'thim_';

	$metabox_ = array(
		'title'      => esc_attr__( 'Display settings', 'course-builder' ),
		'post_types' => array( 'page' ),
		'tabs'       => array(
			'page_title' => array(
				'label' => esc_attr__( 'Page Title', 'course-builder' ),
				'icon'  => 'dashicons-admin-appearance',
			),
			'layout'     => array(
				'label' => esc_attr__( 'Layout', 'course-builder' ),
				'icon'  => 'dashicons-align-left',
			),
		),
		'tab_style'  => 'box',

		'tab_wrapper' => true,
		'fields'      => array(
			/**
			 * Custom Settings
			 */
			array(
				'name' => esc_attr__( 'Custom Page Title', 'course-builder' ),
				'id'   => $prefix . 'enable_custom_title',
				'type' => 'checkbox',
				'std'  => false,
				'tab'  => 'title',
				'tab'  => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Hide Page Title', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_page_title',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_title', '=', false ),
				'tab'    => 'page_title',
			),

			array(
				'name'    => esc_attr__( 'Select Layout', 'course-builder' ),
				'id'      => $prefix . 'group_custom_title_layout',
				'type'    => 'image_select',
				'options' => array(
					'layout-1' => THIM_URI . 'assets/images/page-title/layouts/layout-1.jpg',
					'layout-2' => THIM_URI . 'assets/images/page-title/layouts/layout-2.jpg',
					'layout-3' => THIM_URI . 'assets/images/page-title/layouts/layout-3.jpg',
				),
				'tab'     => 'page_title',
				'hidden'  => array( $prefix . 'enable_custom_title', '=', false ),
				'std'     => 'layout-1',
			),

			array(
				'name'   => esc_attr__( 'Hide Title', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_title',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_title', '=', false ),
				'tab'    => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Hide Sub Title', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_sub_title',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_title', '=', false ),
				'tab'    => 'page_title',
			),

			array(
				'name'   => esc_attr__( 'Hide Breadcrumbs', 'course-builder' ),
				'id'     => $prefix . 'group_custom_title_hide_breadcrumbs',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_title', '=', false ),
				'tab'    => 'page_title',
			),

			/**
			 * Custom layout
			 */
			array(
				'name' => esc_attr__( 'Custom Layout', 'course-builder' ),
				'id'   => $prefix . 'enable_custom_layout',
				'type' => 'checkbox',
				'tab'  => 'layout',
				'std'  => false,
			),
			array(
				'name'    => esc_attr__( 'Select Layout', 'course-builder' ),
				'id'      => $prefix . 'custom_layout',
				'type'    => 'image_select',
				'options' => array(
					'sidebar-left'  => THIM_URI . 'assets/images/layout/sidebar-left.jpg',
					'no-sidebar'    => THIM_URI . 'assets/images/layout/body-full.jpg',
					'sidebar-right' => THIM_URI . 'assets/images/layout/sidebar-right.jpg',
					'full-sidebar'  => THIM_URI . 'assets/images/layout/body-left-right.jpg'
				),
				'tab'     => 'layout',
				'hidden'  => array( $prefix . 'enable_custom_layout', '=', false ),
				'std'     => 'sidebar-right',
			),
			array(
				'name'   => esc_attr__( 'No Padding', 'course-builder' ),
				'id'     => $prefix . 'no_padding_content',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'enable_custom_layout', '=', false ),
				'tab'    => 'layout',
			),
		),
	);

	return $metabox_;
}