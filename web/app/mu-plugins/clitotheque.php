<?php
/*
Plugin Name:  Clithothèque
Plugin URI:   https://clitotheque.org
Description:  Custom post types for the Clitothèque website
Version:      1.0.0
Author:       Ulysse Gérard
Author URI:   https://u31.fr
License:      MIT License
*/

/**
 * Detect plugin. For use on Front End only.
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

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
        "taxonomies" => array("category", "post_tag", "res_types"),
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
 * Taxonomy terms
 */
function get_or_new(
    $names,
    $slug,
    $description,
    $parents = null,
    $tax = 'res_types'
) {
    // Provided a map of lang => names,
    // this function populates the terms
    // adequatly for polylang use
    $langs = array();
    $results = array();
    array_walk(
        $names,
        // 'use' needed for closure
        function ($name, $lang)
        use ($slug, $description, $tax, $parents, &$langs, &$results) {
            if ($lang != 'en') $slug = $slug . '-' . $lang;

            $res = term_exists($slug, $tax);

            if (is_null($res)) {
                // If term is not registered, do it

                // Does it have a parent ?
                $pid = 0;
                if (!is_null($parents)) {
                    $pid = $parents[$lang];
                }
                $res = wp_insert_term(
                    $name, // the term
                    $tax, // the taxonomy
                    array(
                        'description' => $description,
                        'slug' => $slug,
                        'parent' => $pid
                    )
                );
                pll_set_term_language($res['term_id'], $lang);
            }

            $langs[$lang] = $res['term_id'];
            $results[$lang] = $res['term_id'];
        }
    );

    pll_save_term_translations($langs);

    // We return new-terms-ids to chain creations
    // of hierarchical taxonomies
    return $results;
}

function register_terms()
{

    $link = get_or_new(
        array(
            'en' => 'Link',
            'fr' => 'Lien'
        ),
        'link',
        'A Link-based resource.'
    );

    $vid = get_or_new(
        array(
            'en' => 'Video',
            'fr' => 'Vidéo'
        ),
        'video',
        'A video ressource',
        $link
    );

    get_or_new(
        array(
            'en' => 'Youtube',
            'fr' => 'Youtube'
        ),
        'yt',
        'A Youtube hosted video',
        $vid
    );
}

if (
    is_plugin_active('polylang-pro/polylang.php')
) {
    //plugin is activated
    add_action('init', 'register_terms');
}
