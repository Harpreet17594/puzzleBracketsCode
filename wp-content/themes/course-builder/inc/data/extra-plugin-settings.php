<?php

/**
 * Import settings
 */
function thim_import_extra_plugin_settings( $settings ) {

	$settings[] = 'learn_press_generate_course_thumbnail';
	$settings[] = 'learn_press_single_course_image_size';
	$settings[] = 'learn_press_course_thumbnail_image_size';

	return $settings;
}

add_filter( 'thim_importer_basic_settings', 'thim_import_extra_plugin_settings' );