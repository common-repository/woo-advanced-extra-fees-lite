<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://store.idomit.com/product/woocommerce-advanced-extra-fees/
 * @since             1.0.0
 * @package           Woocommerce_Advanced_Extra_Fees_Lite
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Advanced Extra Fees Lite
 * Plugin URI:        https://store.idomit.com/product/woocommerce-advanced-extra-fees/
 * Description:       WooCommerce Advanced Extra Fees is a valuable tool for store owners for creating and managing complex fee rules in their store without the help of a developer! This plugin lets users add/modify fees based on particular conditions.
 * Version:           1.2.9
 * Author:            IDOMIT
 * Author URI:        https://store.idomit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-advanced-extra-fees-lite
 * Domain Path:       /languages
 * WC tested up to:   7.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! function_exists( 'waef_fs' ) ) {
    // Create a helper function for easy SDK access.
    function waef_fs() {
        global $waef_fs;

        if ( ! isset( $waef_fs ) ) {
            // Activate multisite network integration.
            if ( ! defined( 'WP_FS__PRODUCT_8791_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_8791_MULTISITE', true );
            }

            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $waef_fs = fs_dynamic_init( array(
                'id'                  => '8791',
                'slug'                => 'woo-advanced-extra-fees-lite',
                'premium_slug'        => 'woocommerce-advanced-extra-fees',
                'type'                => 'plugin',
                'public_key'          => 'pk_9e2cdb2a2dcc0324313c11e5c598d',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'waef',
                    'first-path'     => 'admin.php?page=waef#tab-dashboard',
                    'contact'        => false,
                    'support'        => false,
                ),
                'is_premium_only'    => false,
            ) );
        }

        return $waef_fs;
    }

    // Init Freemius.
    waef_fs();
    // Signal that SDK was initiated.
    do_action( 'waef_fs_loaded' );
    waef_fs()->get_upgrade_url();
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOCOMMERCE_ADVANCED_EXTRA_FEES_LITE_VERSION', '1.2.9' );
define( 'WAEF_LITE_FEES_NAME', 'WooCommerce Advanced Extra Fees Lite');
define( 'WAEF_PLUGIN_ADMIN_PATH', plugin_dir_path( __FILE__ ) . 'admin/' );
define( 'WAEF_PLUGIN_ADMIN_URLPATH', plugin_dir_url( __FILE__ ) . 'admin/' );
if (!defined('WAEF_LITE_PLUGIN_BASENAME')) {
    define('WAEF_LITE_PLUGIN_BASENAME', plugin_basename(__FILE__));
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-lite-activator.php
 */
function activate_woocommerce_advanced_extra_fees_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite-activator.php';
	Woocommerce_Advanced_Extra_Fees_Lite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-advanced-extra-fees-lite-deactivator.php
 */
function deactivate_woocommerce_advanced_extra_fees_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite-deactivator.php';
	Woocommerce_Advanced_Extra_Fees_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_advanced_extra_fees_lite' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_advanced_extra_fees_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-advanced-extra-fees-lite.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_advanced_extra_fees_lite() {

	$plugin = new Woocommerce_Advanced_Extra_Fees_Lite();
	$plugin->run();

}
run_woocommerce_advanced_extra_fees_lite();
