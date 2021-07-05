<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo
{
    /**
     * Defines all plugin dependency files
     *
     * @since 1.3.0
     * @var array
     */
    protected $dependencies = [
        //helpers files
        'helpers/class-mepu-woo-datastore.php',
        'helpers/class-mepu-woo-template.php',

        //core files
        'includes/class-mepu-woo-loader.php',
        'includes/class-mepu-woo-i18n.php',

        //admin dependecy files
        'admin/class-mepu-woo-admin.php',
        'admin/class-mepu-woo-additional-fields.php',

        //frontend dependency files
        'frontend/class-mepu-woo-frontend.php',
    ];

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since 1.0.0
     * @var Mepu_Woo_Loader $loader
     */
    protected $loader;

    /**
     * Define the core functionality of the plugin.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->load_dependencies();
        $this->set_locale();

        $this->define_admin_hooks();
        $this->define_frontend_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     */
    private function load_dependencies()
    {
        foreach($this->dependencies as $dependency){
            require_once MEPU_WOO_PLUGIN_DIR . $dependency;
        }

        $this->loader = new Mepu_Woo_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @since    1.0.0
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
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Mepu_Woo_Admin();
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $plugin_admin_additional_fields = new Mepu_Woo_Additional_Fields();
        $this->loader->add_action('woocommerce_product_options_general_product_data', $plugin_admin_additional_fields, 'mepu_extra_fields');
        $this->loader->add_action('woocommerce_process_product_meta', $plugin_admin_additional_fields, 'mepu_extra_fields_process');
    }

    /**
     * Register all of the hooks related to the frontend functionality of the plugin.
     *
     * @since    1.0.0
     */
    private function define_frontend_hooks()
    {
        $plugin = new Mepu_Woo_Frontend();
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
}
