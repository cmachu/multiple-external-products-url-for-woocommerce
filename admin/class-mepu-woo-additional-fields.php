<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/additional-fields
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines extra fields for user create and update.
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/additional-fields
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Additional_Fields
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
     * Register all hooks for custom fields in product edit area for creation and updating
     *
     * @since    1.0.0
     */
    public function init_fields()
    {
        add_action('woocommerce_product_options_general_product_data', array($this, 'mepu_extra_fields'));
        add_action('woocommerce_process_product_meta', array($this, 'mepu_extra_fields_process'));

    }

    /**
     * Display extra fields clone container, display json array with multiple external details
     *
     * @since   1.0.0
     */
    function mepu_extra_fields()
    {
        global $post;

        $multiple_external_fields = get_post_meta($post->ID, '_multiple_external_');
        if (empty($multiple_external_fields) || !is_array($multiple_external_fields)) {
            $multiple_external_fields = array();
        }
        echo "<input type='hidden' value='" . json_encode($multiple_external_fields, JSON_HEX_APOS) . "' id='mepu-woo-data'>";

        ?>
        <div class="options_group show_if_external mepu-woo-cont" style="padding:0px 10px;">
            <h4><?php _e('Multiple external product URLs', 'mepu-woo'); ?> - <a href="#mepu-woo-data"
                                                                                class="mepu-woo-add"><?php _e('Add new', 'mepu-woo'); ?></a>
            </h4>
            <?php
            woocommerce_wp_checkbox(
                array(
                    'id' => '_external_target_blank',
                    'label' => __('Open in new tab', 'mepu-woo'),
                    'description' => __('Open external / affiliate URLs in new tab?', 'mepu-woo')
                )
            );

            woocommerce_wp_checkbox(
                array(
                    'id' => '_external_show_in_cat',
                    'label' => __('Category pages', 'mepu-woo'),
                    'description' => __('Show all external product buttons on category pages', 'mepu-woo')
                )
            );
            ?>
            <div class="hidden mepu-woo-only-for-clone" style="border-bottom:1px solid #efefef;">
                <h5><?php _e('## External / Affiliate product details', 'mepu-woo'); ?> - <a href="#mepu-woo-data"
                                                                                             class="mepu-woo-delete"><?php _e('Delete', 'mepu-woo'); ?></a>
                </h5>
                <?php
                woocommerce_wp_text_input(
                    array(
                        'id' => '_product_url_clone_[]',
                        'label' => __('Product URL ##', 'mepu-woo'),
                        'placeholder' => 'http://',
                    )
                );

                woocommerce_wp_text_input(
                    array(
                        'id' => '_button_text_clone_[]',
                        'label' => __('Button text ##', 'mepu-woo'),
                        'placeholder' => _x('Buy product', 'placeholder', 'mepu-woo'),
                    )
                );
                ?>
            </div>
        </div>
        <?php
    }


    /**
     * Update product meta "_multiple_external_" on save
     *
     * @param int $post_id - id of product
     * @return  mixed
     * @since   1.0.0
     *
     */
    function mepu_extra_fields_process($post_id)
    {
        $fine_array = array();

        if (!(isset($_POST['woocommerce_meta_nonce'], $_POST['_external_target_blank'], $_POST['_product_url_'], $_POST['_button_text_'])
            || wp_verify_nonce(sanitize_key($_POST['woocommerce_meta_nonce']), 'woocommerce_save_data'))) {
            return false;
        }

        for ($i = 0; $i < count($_POST['_product_url_']); $i++) {
            if (isset($_POST['_product_url_'][$i], $_POST['_button_text_'][$i])) {
                if (!empty($_POST['_product_url_'][$i]) && !empty($_POST['_button_text_'][$i])) {
                    array_push($fine_array, array($_POST['_product_url_'][$i], $_POST['_button_text_'][$i]));
                }
            }
        }

        update_post_meta(
            $post_id,
            '_multiple_external_',
            $fine_array
        );

        update_post_meta(
            $post_id,
            '_external_target_blank',
            esc_attr($_POST['_external_target_blank'])
        );

        update_post_meta(
            $post_id,
            '_external_show_in_cat',
            esc_attr($_POST['_external_show_in_cat'])
        );

    }

}
