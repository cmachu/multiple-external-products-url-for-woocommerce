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
 * @subpackage Mepu_Woo/frontend
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Frontend
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
     * Render all buttons to external shops on product page
     * @since   1.0.0
     */
    public function render_mepu_buttons()
    {
        global $product;
        if ($product && ('external' == $product->get_type())) {
            $mepu_data = get_post_meta($product->get_id(), '_multiple_external_');
            if (is_array($mepu_data[0])) {
                foreach ($mepu_data[0] as $mepu_item) {
                    ?>
                    <form class="cart" action="<?php echo esc_url($mepu_item[0]); ?>" method="get">
                        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                        <button type="submit"
                                class="single_add_to_cart_button button alt"><?php echo esc_html($mepu_item[1]); ?></button>

                        <?php wc_query_string_form_fields($mepu_item[0]); ?>

                        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                    </form>
                    <?php
                }
            }
        }
    }

    /**
     * Add multiple external buttons to loop in category
     * @param $buttons
     * @param $product
     * @param $args
     * @return string
     * @since   1.1.0
     */
    public function render_mepu_buttons_loop($buttons, $product, $args = [])
    {
        if (get_post_meta($product->get_id(), '_external_show_in_cat', true) && ('external' == $product->get_type())) {
            $mepu_data = get_post_meta($product->get_id(), '_multiple_external_');
            if (is_array($mepu_data[0])) {
                foreach ($mepu_data[0] as $mepu_item) {
                    $buttons .= sprintf('<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                        esc_url($mepu_item[0]),
                        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                        esc_html($mepu_item[1]));
                }
            }
        }

        return $buttons;
    }

    /**
     * Adjust cart form details
     * @since   1.0.0
     */
    public function adjust_cart_form_details()
    {
        global $product;
        if ($product && $product->get_type() == 'external') {
            $mepu_data = get_post_meta($product->get_id(), '_external_target_blank', true);
            if ($mepu_data) {
                ?>
                <script>
                    if (jQuery('.cart')) {
                        jQuery('.cart').attr('target', '_blank');
                    }
                </script>
                <?php
            }
        }

    }

    /**
     * Adjust external product buttons on category loop
     * @param $args
     * @param $product
     * @return mixed
     * @since   1.1.0
     */
    public function adjust_cart_form_details_loop($args, $product)
    {
        if (isset($args['attributes'])) {
            if (get_post_meta($product->get_id(), '_external_show_in_cat', true) && get_post_meta($product->get_id(), '_external_target_blank', true)) {
                $args['attributes']['target'] = '_blank';
            }
        }

        return $args;
    }

}
