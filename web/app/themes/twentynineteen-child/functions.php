<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

/**
 * TAXONOMIES
 */
function cptui_register_my_taxes()
{

	/**
	 * Taxonomy: Resource types.
	 */

	$labels = array(
		"name" => __("Resource types", "twenty-nineteen-child"),
		"singular_name" => __("Resource type", "twenty-nineteen-child"),
	);

	$args = array(
		"label" => __("Resource types", "twenty-nineteen-child"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array('slug' => 'res_types', 'with_front' => true,),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "res_types",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
	);
	register_taxonomy("res_types", array("res"), $args);
}
add_action('init', 'cptui_register_my_taxes');


/**
 * POST TYPES
 */
function cptui_register_my_cpts()
{

	/**
	 * Post Type: Resources.
	 */

	$labels = array(
		"name" => __("Resources", "twenty-nineteen-child"),
		"singular_name" => __("Resource", "twenty-nineteen-child"),
	);

	$args = array(
		"label" => __("Resources", "twenty-nineteen-child"),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array("slug" => "res", "with_front" => true),
		"query_var" => true,
		"menu_icon" => "dashicons-screenoptions",
		"supports" => array("title", "editor", "thumbnail"),
	);

	register_post_type("res", $args);

	/**
	 * Post Type: Creators.
	 */

	$labels = array(
		"name" => __("Creators", "twenty-nineteen-child"),
		"singular_name" => __("Creator", "twenty-nineteen-child"),
	);

	$args = array(
		"label" => __("Creators", "twenty-nineteen-child"),
		"labels" => $labels,
		"description" => "The resources\' creators",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array("slug" => "creator", "with_front" => true),
		"query_var" => true,
		"menu_icon" => "dashicons-groups",
		"supports" => array("title", "editor", "thumbnail"),
		"taxonomies" => array("post_tag"),
	);

	register_post_type("creator", $args);
}

add_action('init', 'cptui_register_my_cpts');

/**
 * Taxonomy term
 */
$ty_link = wp_insert_term(
	'Link', // the term
	'product', // the taxonomy
	array(
		'description' => 'A Link-based resource.',
		'slug' => 'link',
		//'parent'=> $parent_term['term_id']  // get numeric term id
	)
);

$ty_link = wp_insert_term(
	'Lien', // the term
	'res_types', // the taxonomy
	array(
		'description' => 'A Link-based resource.',
		'slug' => 'link-fr',
		//'parent'=> $parent_term['term_id']  // get numeric term id
	)
);
