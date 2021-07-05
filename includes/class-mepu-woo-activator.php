<?php

/**
 * Fired during plugin activation.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

class Mepu_Woo_Activator
{
    /**
     * Fires, when plugin is installed
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        if (!is_plugin_active("woocommerce/woocommerce.php")) {
            die(__('Please install and activate WooCommerce plugin first.', 'mepu-woo'));
        }
    }
}
