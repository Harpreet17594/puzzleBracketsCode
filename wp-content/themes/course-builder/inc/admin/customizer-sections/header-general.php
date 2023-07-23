<?php
/**
 * Section Header Layout
 *
 * @package Thim_Starter_Theme
 */

thim_customizer()->add_section(
	array(
		'id'       => 'header_layout',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'panel'    => 'header',
		'priority' => 20,
	)
);

// Select Blog Archive Layout
thim_customizer()->add_field(
	array(
		'id'       => 'header_template',
		'type'     => 'radio-image',
		'label'    => esc_html__( 'Header Layout', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows select layout for header.', 'course-builder' ),
		'section'  => 'header_layout',
		'priority' => 1,
		'default'  => 'layout-1',
		'choices'  => array(
			'layout-1' => THIM_URI . 'assets/images/header-layout/layout-1.jpg',
			'layout-2' => THIM_URI . 'assets/images/header-layout/layout-2.jpg',
		),
	)
);


thim_customizer()->add_field( array(
	'type'     => 'palette',
	'id'       => 'header_palette',
	'label'    => esc_html__( 'Palette', 'course-builder' ),
	'section'  => 'header_layout',
	'default'  => 'light',
	'priority' => 2,
	'choices'  => array(
		'white'       => array(
			'#FFF',
			'#202121',
			'#888888',
			'#18c1f0',
		),
		'transparent' => array(
			'transparent',
			'#FFFFFF',
			'#9c9c9c',
			'#202121',
		),
		'custom'      => array(
			esc_html__( 'Custom', 'course-builder' )
		),
	),
) );

// Select Header Position
thim_customizer()->add_field(
	array(
		'id'              => 'header_position',
		'type'            => 'select',
		'label'           => esc_html__( 'Header Positions', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you can select position layout for header layout.', 'course-builder' ),
		'section'         => 'header_layout',
		'priority'        => 3,
		'multiple'        => 0,
		'default'         => 'default',
		'choices'         => array(
			'default' => esc_html__( 'Default', 'course-builder' ),
			'overlay' => esc_html__( 'Overlay', 'course-builder' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);

// Enable or disable header right
thim_customizer()->add_field(
	array(
		'id'       => 'header_sidebar_right_display',
		'type'     => 'switch',
		'label'    => esc_html__( 'Show Header Right', 'course-builder' ),
		'tooltip'  => esc_html__( 'Allows you to enable or disable Header right.', 'course-builder' ),
		'section'  => 'header_layout',
		'default'  => true,
		'priority' => 4,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Enable or disable menu right
thim_customizer()->add_field(
	array(
		'id'              => 'menu_right_display',
		'type'            => 'switch',
		'label'           => esc_html__( 'Show Search', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you to enable or disable Search form.', 'course-builder' ),
		'section'         => 'header_layout',
		'default'         => true,
		'priority'        => 5,
		'choices'         => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_template',
				'operator' => '==',
				'value'    => 'layout-1',
			),
		),
	)
);


// Background Header
thim_customizer()->add_field(
	array(
		'id'              => 'header_background_color',
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'course-builder' ),
		'tooltip'         => esc_html__( 'Allows you can choose background color for your header. ', 'course-builder' ),
		'section'         => 'header_layout',
		'default'         => '#ffffff',
		'priority'        => 6,
		'alpha'           => true,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'choice'   => 'color',
				'element'  => 'body #masthead.site-header',
				'property' => 'background-color',
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_palette',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	)
);