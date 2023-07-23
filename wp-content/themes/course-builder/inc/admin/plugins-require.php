<?php

function thim_get_all_plugins_require( $plugins ) {
	return array(
		array(
			'name'     => 'LearnPress',
			'slug'     => 'learnpress',
			'required' => true,
		),
		array(
			'name'     => 'Thim Course Builder',
			'slug'     => 'thim-course-builder',
			'premium'  => true,
			'required' => true,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-certificates.png',
		),
		array(
			'name'     => 'Learnpress Certificates',
			'slug'     => 'learnpress-certificates',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-certificates.png',
		),
		array(
			'name'     => 'LearnPress Co-Instructors',
			'slug'     => 'learnpress-co-instructor',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-co-instructor.png',
		),
		array(
			'name'     => 'LearnPress Collections',
			'slug'     => 'learnpress-collections',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-collections.png',
		),
		array(
			'name'     => 'LearnPress - Paid Membership Pro Integration',
			'slug'     => 'learnpress-paid-membership-pro',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-paid-membership-pro.png',
		),
		array(
			'name'     => 'LearnPress Course Review',
			'slug'     => 'learnpress-course-review',
			'required' => false,
		),
		array(
			'name'     => 'LearnPress - WooCommerce Payment Methods Integration',
			'slug'     => 'learnpress-woo-payment',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-woo-payment.png',
		),
		array(
			'name'     => 'LearnPress - Announcements',
			'slug'     => 'learnpress-announcements',
			'premium'  => true,
			'required' => false,
			'icon'     => 'https://plugins.thimpress.com/downloads/images/learnpress-announcements.png',
		),
		array(
			'name'     => 'WPBakery Visual Composer',
			'slug'     => 'js_composer',
			'premium'  => true,
			'required' => true,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'WP Events Manager',
			'slug'     => 'wp-events-manager',
			'required' => false,
		),
		array(
			'name'     => 'Paid Memberships Pro',
			'slug'     => 'paid-memberships-pro',
			'required' => false,
		),
		array(
			'name'     => 'WordPress Social Login',
			'slug'     => 'wordpress-social-login',
			'required' => false,
		),
		array(
			'name'     => 'Widget Logic',
			'slug'     => 'widget-logic',
			'required' => false,
		),
		array(
			'name'     => 'MailChimp for WordPress',
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
	);
}

add_action( 'thim_core_get_all_plugins_require', 'thim_get_all_plugins_require' );

function thim_get_core_require() {
	$thim_core = array(
		'name'    => 'Thim Core',
		'slug'    => 'thim-core',
		'version' => '1.0.6.1',
		'source'  => 'https://foobla.bitbucket.io/thim-core/dist/thim-core.zip',
	);

	return $thim_core;
}


function thim_envato_item_id() {
	return '20370918';
}

add_filter( 'thim_envato_item_id', 'thim_envato_item_id' );