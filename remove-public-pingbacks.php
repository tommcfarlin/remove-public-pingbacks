<?php
/**
 * Remove Public Pingbacks.
 *
 * This class will remove the count and listing of public-facing pingbacks from
 * your WordPress blog; however, if your blog or website renders a heading element
 * for the 'Trackbacks' and/or 'Pings' heading, then you can use the bundled
 * CSS to hide them.
 *
 * @package   Remove_Public_Pingbacks
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com/remove-public-pingbacks/
 * @copyright 2014 Tom McFarlin
 *
 * @wordpress-plugin
 * Plugin Name:       Remove Public Pingbacks
 * Plugin URI:        http://tommcfarlin.com/remove-public-pingbacks/
 * Description:       Removes the count and listing of pingbacks from the public-facing side of a WordPress siste.
 * Version:           1.0.0
 * Author:            Tom McFarlin
 * Author URI:        http://tommcfarlin.com/
 * Text Domain:       remove-public-pingbacks
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Includes the core class repsonsible for removing public pingbacks.
 */
require_once( plugin_dir_path( __FILE__ ) . 'class-remove-public-pingbacks.php' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function tm_run_remove_public_pingbacks() {
	Remove_Public_Pingbacks::run();
}
tm_run_remove_public_pingbacks();
