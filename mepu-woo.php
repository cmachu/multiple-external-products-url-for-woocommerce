<?php
/**
 * @link              http://cmachowski.com
 * @since             1.0.0
 * @package           Mepu_Woo
 *
 * @wordpress-plugin
 * Plugin Name:       Multiple external product URLs for WooCommerce
 * Description:       Plugins gives you ability to add multiple external product URLs on WooCommerce product edit page.
 * Version:           1.3.0
 * Author:            Paweł Ćmachowski
 * Author URI:        https://cmachowski.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mepu-woo
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Plugin CONST values
 */
define('MEPU_WOO_VERSION', '1.3.0');
define('MEPU_WOO_SLUG', 'mepu-woo');
define('MEPU_WOO_DIR_NAME', 'multiple-external-product-urls-for-woocommerce');
define('MEPU_WOO_PLUGIN_DIR', plugin_dir_path(dirname(__FILE__)) . MEPU_WOO_DIR_NAME . '/');
define('MEPU_WOO_PLUGIN_URL', plugin_dir_url(dirname(__FILE__)) . MEPU_WOO_DIR_NAME . '/');


/**
 * The code that runs during plugin activation.
 */
register_activation_hook(__FILE__, 'mepu_woo_activate');
function mepu_woo_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-mepu-woo-activator.php';
    Mepu_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
register_deactivation_hook(__FILE__, 'mepu_woo_deactivate');
function mepu_woo_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-mepu-woo-deactivator.php';
    Mepu_Woo_Deactivator::deactivate();
}

/**
 * Execution of the plugin.
 * @since    1.0.0
 */
require plugin_dir_path(__FILE__) . 'includes/class-mepu-woo.php';
function mepu_woo_run()
{
    $plugin = new Mepu_Woo();
    $plugin->run();
}
mepu_woo_run();
