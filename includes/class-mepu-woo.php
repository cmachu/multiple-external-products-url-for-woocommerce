<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Mepu_Woo_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('MEPU_WOO_VERSION')) {
            $this->version = MEPU_WOO_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'mepu-woo';

        $this->load_dependencies();
        $this->set_locale();

        $this->define_admin_hooks();
        $this->define_frontend_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Mepu_Woo_Loader. Orchestrates the hooks of the plugin.
     * - Mepu_Woo_i18n. Defines internationalization functionality.
     * - Mepu_Woo_Admin. Defines all hooks for the admin area.
     * - Mepu_Woo_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mepu-woo-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-mepu-woo-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-mepu-woo-admin.php';

        /**
         * The class responsible for defining all additional fields for user in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-mepu-woo-additional-fields.php';
        /**
         * The class responsible for defining all front-end features
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'frontend/class-mepu-woo-frontend.php';

        $this->loader = new Mepu_Woo_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Mepu_Woo_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Mepu_Woo_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Mepu_Woo_Admin($this->get_plugin_name(), $this->get_version());
        $plugin_admin_additional_fields = new Mepu_Woo_Additional_Fields($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $plugin_admin_additional_fields->init_fields();
    }

    /**
     * Register all of the hooks related to the frontend functionality of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_frontend_hooks()
    {
        $plugin = new Mepu_Woo_Frontend($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('woocommerce_after_add_to_cart_form', $plugin, 'render_mepu_buttons');
        $this->loader->add_action('woocommerce_after_add_to_cart_form', $plugin, 'adjust_cart_form_details');

        $this->loader->add_filter('woocommerce_loop_add_to_cart_link', $plugin, 'render_mepu_buttons_loop', 10, 3);
        $this->loader->add_filter('woocommerce_loop_add_to_cart_args', $plugin, 'adjust_cart_form_details_loop', 10, 3);
    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Mepu_Woo_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
