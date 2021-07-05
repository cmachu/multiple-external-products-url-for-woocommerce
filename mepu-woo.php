<?php

/**
 * @link              http://cmachowski.com
 * @since             1.0.0
 * @package           Mepu_Woo
 *
 * @wordpress-plugin
 * Plugin Name:       Multiple external product URLs for WooCommerce
 * Description:       Plugins gives you ability to add multiple external product URLs on WooCommerce product edit page.
 * Version:           1.1.1
 * Author:            Paweł Ćmachowski
 * Author URI:        http://cmachowski.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mepu-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('MEPU_WOO_VERSION', '1.2.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mepu-woo-activator.php
 */
function mepu_woo_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-mepu-woo-activator.php';
    Mepu_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mepu-woo-deactivator.php
 */
function mepu_woo_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-mepu-woo-deactivator.php';
    Mepu_Woo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'mepu_woo_activate');
register_deactivation_hook(__FILE__, 'mepu_woo_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-mepu-woo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function mepu_woo_run()
{
    $plugin = new Mepu_Woo();
    $plugin->run();
}

mepu_woo_run();
