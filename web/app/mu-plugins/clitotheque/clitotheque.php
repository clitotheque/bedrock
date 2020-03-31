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

require_once 'include/init.php';
require_once 'include/initACF.php';

/**
 * Detect plugin. For use on Front End only.
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

/**
 * Option to keep categories hierarchical
 */
add_filter('wp_terms_checklist_args', 'my_website_wp_terms_checklist_args', 1, 2);
function my_website_wp_terms_checklist_args($args, $post_id)
{
    $args['checked_ontop'] = false;

    return $args;
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
function clito_prepare() {
    Clito\Init::register_my_taxes();
    Clito\Init::register_my_cpts();
    do_if_not_done('ctq_types_registered', 'Clito\Init::register_res_types');
    do_if_not_done('ctq_langs_registered', 'Clito\Init::register_res_langs');
    //do_if_not_done('ctq_add_search_page', 'Clito\Init::add_search_page');

}

/**
 *  Register terms and create pages when plugin is used for the first time
 */
add_action('init', 'clito_prepare');
add_action('acf/init', 'Clito\InitACF::go');
