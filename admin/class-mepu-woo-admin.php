<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/admin
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Admin
{
    /**
     * Register the JavaScript for the admin area.
     *
     * @since   1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            MEPU_WOO_SLUG,
            MEPU_WOO_PLUGIN_URL . 'admin/js/mepu-woo-admin.js',
            ['jquery'],
            MEPU_WOO_VERSION
        );
    }
}
