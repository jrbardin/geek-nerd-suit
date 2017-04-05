<?php
add_action( 'init', 'create_post_types' );
function create_post_types() {
	global $smof_data;

	register_post_type( 'us_main_page_section', array(
		'labels' => array(
			'name' => 'Page Sections',
			'singular_name' => 'Page Section',
			'add_new' => 'Add Page Section',
		),
		'public' => TRUE,
		'show_ui' => TRUE,
		'query_var' => TRUE,
		'has_archive' => TRUE,
		'rewrite' => TRUE,
		'supports' => array( 'title', 'editor', 'revisions' ),
		'show_in_nav_menus' => TRUE,
		'can_export' => TRUE,
		'hierarchical' => FALSE,
		'exclude_from_search' => TRUE,
		'map_meta_cap' => TRUE,
		'menu_icon' => 'dashicons-admin-page',
	) );

	// Portfolio post type
	register_post_type( 'us_portfolio', array(
		'labels' => array(
			'name' => 'Portfolio Items',
			'singular_name' => 'Portfolio Item',
			'add_new' => 'Add Portfolio Item',
		),
		'public' => TRUE,
		'has_archive' => TRUE,
		'rewrite' => TRUE,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'can_export' => TRUE,
		'hierarchical' => FALSE,
		'exclude_from_search' => TRUE,
		'map_meta_cap' => TRUE,
		'menu_icon' => 'dashicons-images-alt',
	) );

	// Clients post type
	register_post_type( 'us_client', array(
		'labels' => array(
			'name' => 'Clients Logos',
			'singular_name' => 'Client Logo',
			'add_new' => 'Add Client Logo',
		),
		'public' => TRUE,
		'publicly_queryable' => FALSE,
		'has_archive' => TRUE,
		'supports' => array( 'title', 'thumbnail' ),
		'can_export' => TRUE,
		'map_meta_cap' => TRUE,
		'menu_icon' => 'dashicons-awards',
	) );
}

// Portfolio categories
register_taxonomy( 'us_portfolio_category', array( 'us_portfolio' ), array(
	'hierarchical' => TRUE,
	'label' => 'Portfolio Categories',
	'singular_label' => 'Portfolio Category',
	'rewrite' => TRUE
) );

