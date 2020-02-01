<?php
namespace Clito;

class Init
{
    /**
     * TAXONOMIES
     */
    public static function register_my_taxes()
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
    public static function register_my_cpts()
    {
        /**
         * Post Type: Resources.
         */

        $labels = array(
            "name" => __("Resources", "sage"),
            "singular_name" => __("Resource", "sage"),
        );

        $args = array(
            "label" => __("Resources", "sage"),
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
            "name" => __("Creators", "sage"),
            "singular_name" => __("Creator", "sage"),
        );

        $args = array(
            "label" => __("Creators", "sage"),
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
    private static function get_or_new(
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

    public static function register_res_types()
    {
        // Sanity check. Maybe move to get_or_new
        if (
            //is_plugin_active('polylang-pro/polylang.php')
            function_exists('pll_is_translated_taxonomy')
            && pll_is_translated_taxonomy('res_types')
        ) {

            $link = Init::get_or_new(
                array(
                    'en' => 'Link',
                    'fr' => 'Lien'
                ),
                'link',
                'A Link-based resource.'
            );

            Init::get_or_new(
                array(
                    'en' => 'Site',
                    'fr' => 'Site'
                ),
                'site',
                'A website resource',
                $link
            );

            Init::get_or_new(
                array(
                    'en' => 'Web article',
                    'fr' => 'Article web'
                ),
                'web_article',
                'An online article',
                $link
            );

            $vid = Init::get_or_new(
                array(
                    'en' => 'Video',
                    'fr' => 'Vidéo'
                ),
                'video',
                'A video resource',
                $link
            );

            Init::get_or_new(
                array(
                    'en' => 'Podcast',
                    'fr' => 'Podcast'
                ),
                'podcast',
                '',
                $link
            );

            Init::get_or_new(
                array(
                    'en' => 'Scientific publication',
                    'fr' => 'Article scientifique'
                ),
                'science_pub',
                '',
                $link
            );

            Init::get_or_new(
                array(
                    'en' => 'Youtube',
                    'fr' => 'Youtube'
                ),
                'yt',
                'A Youtube-hosted video',
                $vid
            );


            Init::get_or_new(
                array(
                    'en' => 'Book',
                    'fr' => 'Livre'
                ),
                'book',
                ''
            );

            Init::get_or_new(
                array(
                    'en' => 'Movie',
                    'fr' => 'Film'
                ),
                'movie',
                ''
            );


            Init::get_or_new(
                array(
                    'en' => 'Featured content',
                    'fr' => 'Contenu mis en avant'
                ),
                'featured',
                '',
                null,
                'category'
            );

            Init::get_or_new(
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

    public static function register_res_langs()
    {
        if (
            //is_plugin_active('polylang-pro/polylang.php')
            function_exists('pll_is_translated_taxonomy')
            && pll_is_translated_taxonomy('res_lang')
        ) {

            Init::get_or_new(
                array(
                    'en' => 'English',
                    'fr' => 'Anglais'
                ),
                'GB',
                '',
                null,
                'res_lang'
            );

            Init::get_or_new(
                array(
                    'en' => 'French',
                    'fr' => 'Français'
                ),
                'FR',
                '',
                null,
                'res_lang'
            );

            Init::get_or_new(
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
     * Pages creation
     */
    public static function add_search_page()
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
}
