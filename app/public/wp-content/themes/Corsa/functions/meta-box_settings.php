<?php

$prefix = 'us_';

$meta_boxes[] = array(
	'id' => 'portfolio_layout_settings',
	'title' => 'Portfolio Project Settings',
	'pages' => array('us_portfolio'),
	'context' => 'normal',
	'priority' => 'high',

	// List of meta fields
	'fields' => array (
		array(
			'name'		=> 'Fullwidth Content',
			'id'		=> $prefix . "preview_fullwidth",
			'type'		=> 'checkbox',
			'desc'		=> 'If you select this option, the portfolio item will only display the content of the WYSWYG editor.',

		),
		array(
			'name'		=> 'Custom Preview Image',
			'id'		=> $prefix . "preview_image",
			'type'		=> 'image_advanced',
			'max_file_uploads'	=> 1,

		),
//		array(
//			'name'		=> 'Preview Slider',
//			'id'		=> $prefix . "preview_slider",
//			'type'		=> 'image_advanced',
//			'max_file_uploads'	=> 30,
//
//		),
		array(
			'name'		=> 'Preview Video',
			'id'		=> $prefix . "preview_video",
			'type'		=> 'text',

		),
		array(
			'name'		=> 'Custom Project Link',
			'id'		=> $prefix . 'custom_link',
			'type'		=> 'text',
			'std'		=> '',
		),
		array(
			'name'		=> 'Custom Project Link Target',
			'id'		=> $prefix . "custom_link_blank",
			'type'		=> 'checkbox',
			'desc'		=> 'Open Custom Project Link in new Tab (Window)',

		),
		array(
			'name'		=> 'Additional CSS Class',
			'id'		=> $prefix . "additional_class",
			'type'		=> 'text',
			'desc'		=> 'You can apply additional styling to particular portfolio item using this class',
		),
	)

);

$meta_boxes[] = array(
	'id' => 'client_settings',
	'title' => 'Client Settings',
	'pages' => array('us_client'),
	'context' => 'normal',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			'name'		=> 'Client URL',
			'id'		=> $prefix . 'client_url',
			'type'		=> 'text',
			'std'		=> '',
		),
		array(
			'name'		=> 'Open URL in new Tab',
			'id'		=> $prefix . "client_new_tab",
			'type'		=> 'checkbox',
			'std'		=> false,
		),
	),
);

function us_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'us_register_meta_boxes' );
