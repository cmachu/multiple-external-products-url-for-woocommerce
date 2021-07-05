<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/admin
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;


    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since   1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mepu-woo-admin.js', array('jquery'), $this->version, false);
    }

}
