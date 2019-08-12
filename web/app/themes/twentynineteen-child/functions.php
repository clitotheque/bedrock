<?php


add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

/**
 * Activate should-be-here plugins
 * TODO better way ?
 */
function activate_mandatory_plugins()
{
	//activate_plugin("polylang/polylang.php");
	//activate_plugin("disable-gutenberg/disable-gutenberg.php");
	//activate_plugin("advanced-custom-fields/acf.php");
}
add_action('after_setup_theme', 'activate_mandatory_plugins');
