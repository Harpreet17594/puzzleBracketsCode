<?php
/**
 * Section Blog General
 *
 * @package Hair_Salon
 */

thim_customizer()->add_section(
	array(
		'id'       => 'learnpress_general',
		'panel'    => 'learnpress',
		'title'    => esc_html__( 'Settings', 'course-builder' ),
		'priority' => 10,
	)
);

// Enable or disable Top Sidebar Archive
thim_customizer()->add_field(
	array(
		'id'      => 'learnpress_top_sidebar_archive_display',
		'type'    => 'switch',
		'label'   => esc_html__( 'Show Top Widget Area', 'course-builder' ),
		'tooltip' => esc_html__( 'Turn on to show Top Widget Area on LearnPress archive pages.', 'course-builder' ),
		'section' => 'learnpress_general',
		'default' => true,
		'choices' => array(
			true  => esc_html__( 'On', 'course-builder' ),
			false => esc_html__( 'Off', 'course-builder' ),
		),
	)
);

thim_customizer()->add_field( array(
	'label'   => esc_attr__( 'Page Style', 'course-builder' ),
	'id'      => 'learnpress_cate_style',
	'type'    => 'select',
	'section' => 'learnpress_general',
	'choices' => array(
		'grid' => esc_attr__( 'Grid', 'course-builder' ),
		'list' => esc_attr__( 'List', 'course-builder' ),
	),
	'default' => 'grid',
) );

thim_customizer()->add_field( array(
	'label'           => esc_attr__( 'Grid Columns', 'course-builder' ),
	'id'              => 'learnpress_cate_grid_column',
	'type'            => 'select',
	'section'         => 'learnpress_general',
	'choices'         => array(
		'2' => esc_attr__( '2', 'course-builder' ),
		'3' => esc_attr__( '3', 'course-builder' ),
		'4' => esc_attr__( '4', 'course-builder' )
	),
	'default'         => '3',
	'active_callback' => array(
		array(
			'setting'  => 'learnpress_cate_style',
			'operator' => '===',
			'value'    => 'grid',
		),
	),
) );
thim_customizer()->add_field( array(
	'label'   => esc_attr__( 'Collection Columns', 'course-builder' ),
	'id'      => 'learnpress_cate_collection_column',
	'type'    => 'select',
	'section' => 'learnpress_general',
	'choices' => array(
		'2' => esc_attr__( '2', 'course-builder' ),
		'3' => esc_attr__( '3', 'course-builder' ),
		'4' => esc_attr__( '4', 'course-builder' ),
	),
	'default' => '3',
) );

// Course Single Group
thim_customizer()->add_group( array(
	'id'       => 'learnpress_single_setting_group',
	'section'  => 'learnpress_general',
	'priority' => 20,
	'groups'   => array(
		array(
			'id'     => 'learnpress_single_page_group',
			'label'  => esc_html__( 'Single Course Style', 'course-builder' ),
			'fields' => array(
				array(
					'label'    => esc_attr__( 'Style', 'course-builder' ),
					'id'       => 'learnpress_single_course_style',
					'type'     => 'radio-image',
					'section'  => 'learnpress_general',
					'priority' => 5,
					'choices'  => array(
						"1" => THIM_URI . 'assets/images/single-course/style1.jpg',
						"2" => THIM_URI . 'assets/images/single-course/style2.jpg',
					),
					'default'  => '1',
				)
			),
		),
	)
) );
