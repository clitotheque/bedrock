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
        "name" => __("Resource types", "sage"),
        "singular_name" => __("Resource type", "sage"),
    );

    $args = array(
        "label" => __("Resource types", "sage"),
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

    /**
     * Taxonomy: Resource languages.
     */

    $labels = array(
        "name" => __( "Resource languages", "sage" ),
        "singular_name" => __( "Resource language", "sage" ),
    );

    $args = array(
        "label" => __( "Resource languages", "sage" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'res_lang', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "res_lang",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
        );
    register_taxonomy( "res_lang", array( "res" ), $args );
    
    return true;
}


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

    return true;
}

/**
 * Taxonomy terms
 *    Provided a map of lang => names,
 *    this function populates the terms
 *    adequatly for polylang use
 */
function get_or_new(
    $names,
    $slug,
    $description,
    $parents = null,
    $tax = 'res_types'
) {
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

function register_res_types()
{
    // Sanity check. Maybe move to get_or_new
    if (
        //is_plugin_active('polylang-pro/polylang.php')
        function_exists('pll_is_translated_taxonomy')
        && pll_is_translated_taxonomy('res_types')
    ) {

        $link = get_or_new(
            array(
                'en' => 'Link',
                'fr' => 'Lien'
            ),
            'link',
            'A Link-based resource.'
        );

        get_or_new(
            array(
                'en' => 'Site',
                'fr' => 'Site'
            ),
            'site',
            'A website resource',
            $link
        );

        get_or_new(
            array(
                'en' => 'Web article',
                'fr' => 'Article web'
            ),
            'web_article',
            'An online article',
            $link
        );

        $vid = get_or_new(
            array(
                'en' => 'Video',
                'fr' => 'Vidéo'
            ),
            'video',
            'A video resource',
            $link
        );

        get_or_new(
            array(
                'en' => 'Podcast',
                'fr' => 'Podcast'
            ),
            'podcast',
            '',
            $link
        );

        get_or_new(
            array(
                'en' => 'Scientific publication',
                'fr' => 'Article scientifique'
            ),
            'science_pub',
            '',
            $link
        );

        get_or_new(
            array(
                'en' => 'Youtube',
                'fr' => 'Youtube'
            ),
            'yt',
            'A Youtube-hosted video',
            $vid
        );


        get_or_new(
            array(
                'en' => 'Book',
                'fr' => 'Livre'
            ),
            'book',
            ''
        );

        get_or_new(
            array(
                'en' => 'Movie',
                'fr' => 'Film'
            ),
            'movie',
            ''
        );


        get_or_new(
            array(
                'en' => 'Featured content',
                'fr' => 'Contenu mis en avant'
            ),
            'featured',
            '',
            null,
            'category'
        );

        get_or_new(
            array(
                'en' => 'Clitoris',
                'fr' => 'Clitoris'
            ),
            'clito',
            '',
            null,
            'category'
        );

        return true;
    }

    return false;
}

function register_res_langs()
{
    if (
        //is_plugin_active('polylang-pro/polylang.php')
        function_exists('pll_is_translated_taxonomy')
        && pll_is_translated_taxonomy('res_lang')
    ) {

        get_or_new(
            array(
                'en' => 'English',
                'fr' => 'Anglais'
            ),
            'GB',
            '',
            null,
            'res_lang'
        );

        get_or_new(
            array(
                'en' => 'French',
                'fr' => 'Français'
            ),
            'FR',
            '',
            null,
            'res_lang'
        );

        get_or_new(
            array(
                'en' => 'Spanish',
                'fr' => 'Espagnol'
            ),
            'ES',
            '',
            null,
            'res_lang'
        );

        return true;
    }

    return false;
}

/**
 * Option to keep categories hierarchical
 */
add_filter('wp_terms_checklist_args', 'my_website_wp_terms_checklist_args', 1, 2);
function my_website_wp_terms_checklist_args($args, $post_id)
{
    $args['checked_ontop'] = false;

    return $args;
}

/**
 * Pages creation
 */
function add_search_page() 
{
    // Create post object
    $my_post = [
      'post_title'    => wp_strip_all_tags( 'Search' ),
      'post_content'  => 
        '[searchandfilter id="33"] [searchandfilter id="33" show="results"]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    ];

    // Insert the post into the database
    wp_insert_post( $my_post );

    return true;
}

function do_if_not_done( $flag, callable $function, $version = '1') {
    if($version !== get_option( $flag )) {
        if ($function()) {
            update_option( $flag, '1' );
        }
    }
}

/**
 * On activation (first init) work
 */
function prepare() {    
    do_if_not_done('stc_taxonomies_registered', 'cptui_register_my_taxes');
    do_if_not_done('stc_post_types_registered', 'cptui_register_my_cpts');
    do_if_not_done('ctq_types_registered', 'register_res_types');
    do_if_not_done('ctq_langs_registered', 'register_res_langs');
    do_if_not_done('ctq_add_search_page', 'add_search_page');
}

/**
 *  Register terms and create pages when plugin is used for the first time
 */ 
add_action('init', 'prepare');

