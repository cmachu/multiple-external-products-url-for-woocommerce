<?php

/**
 * Class that define extra fields for WooCommerce external product metabox in wp-admin
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/admin
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Additional_Fields
{
    /**
     * Display extra fields container for clone, display serialized json array with label/url details
     *
     * @since   1.0.0
     */
    public function mepu_extra_fields()
    {
        global $post;

        $data = Mepu_Woo_Datastore::getJSON($post);
        Mepu_Woo_Template::render(
            'admin/templates/woocommerce-external-fields.php',
            [
                'data' => $data
            ]
        );
    }

    /**
     * Update product meta on save / update
     *
     * @param int $post_id - id of product
     * @return  bool
     * @since   1.0.0
     */
    public function mepu_extra_fields_process($post_id)
    {
        if (!isset($_POST['woocommerce_meta_nonce'], $_POST['_external_target_blank'], $_POST['_external_show_in_cat'])) {
            return false;
        }

        if (!wp_verify_nonce(sanitize_key($_POST['woocommerce_meta_nonce']), 'woocommerce_save_data')) {
            return false;
        }

        if (isset($_POST['_product_url_'], $_POST['_button_text_'])
            && is_array($_POST['_product_url_'])
            && is_array($_POST['_button_text_'])) {

            $updateData = [];
            for ($i = 0; $i < count($_POST['_product_url_']); $i++) {
                if (!isset($_POST['_product_url_'][$i]) || !isset($_POST['_button_text_'][$i])) {
                    continue;
                }

                array_push(
                    $updateData,
                    [
                        sanitize_text_field($_POST['_product_url_'][$i]),
                        sanitize_text_field($_POST['_button_text_'][$i])
                    ]
                );
            }

            Mepu_Woo_Datastore::setData($post_id, $updateData);
        }

        Mepu_Woo_Datastore::setTargetValue($post_id, $_POST['_external_target_blank']);
        Mepu_Woo_Datastore::setCategoryVisibility($post_id, $_POST['_external_show_in_cat']);

        return true;
    }
}
