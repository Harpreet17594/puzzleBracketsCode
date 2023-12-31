<?php
/**
 * Section Copyright
 *
 * @package Thim_Starter_Theme
 */

thim_customizer()->add_section(
	array(
		'id'       => 'copyright',
		'title'    => esc_html__( 'Copyright', 'course-builder' ),
		'panel'    => 'footer',
		'priority' => 50,
	)
);

// Enable Copyright Text
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'copyright_bar',
		'label'    => esc_html__( 'Show Copyright Text', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to show copyright text.', 'course-builder' ),
		'section'  => 'copyright',
		'default'  => true,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Enable Copyright Menu
thim_customizer()->add_field(
	array(
		'type'     => 'switch',
		'id'       => 'copyright_menu',
		'label'    => esc_html__( 'Show Copyright Menu', 'course-builder' ),
		'tooltip'  => esc_html__( 'Turn on to show menu copyright.', 'course-builder' ),
		'section'  => 'copyright',
		'default'  => false,
		'priority' => 12,
		'choices'  => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

// Enter Text For Copyright
$link = 'http://thimpress.com';

thim_customizer()->add_field(
	array(
		'type'      => 'textarea',
		'id'        => 'copyright_text',
		'label'     => esc_html__( 'Copyright Text', 'course-builder' ),
		'tooltip'   => esc_html__( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'course-builder' ),
		'section'   => 'copyright',
		'default'   => sprintf( 'Course Builder 2017. Powered by <a href="%s">ThimPress.</a>', esc_url( $link ) ),
		'priority'  => 100,
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.copyright-text',
				'function' => 'html',
			),
		)
	)
);