<?php

/**
 * Front-end features of the plugin - display multiple external product url on shop/category/product-page
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/frontend
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Frontend
{
    /**
     * Render multiple external product buttons on product page
     *
     * @since   1.0.0
     */
    public function render_mepu_buttons()
    {
        global $product;

        if (!Mepu_Woo_Datastore::isExternal($product)) {
            return;
        }

        $mepu_data = Mepu_Woo_Datastore::get($product);
        if ($mepu_data === null) {
            return;
        }

        foreach ($mepu_data[0] as $mepu_item) {
            $dataPack = [
                'url' => $mepu_item[0],
                'label' => $mepu_item[1]
            ];

            echo apply_filters(
                'mepu_woo_product_page_template',
                Mepu_Woo_Template::get("frontend/templates/product-page-template.php", $dataPack),
                $dataPack
            );
        }

        return;
    }

    /**
     * Render multiple external buttons to loop in category / shop
     *
     * @param $buttons
     * @param $product
     * @param $args
     * @return string
     * @since   1.1.0
     */
    public function render_mepu_buttons_loop($buttons, $product, $args = [])
    {
        if (!Mepu_Woo_Datastore::isExternal($product)) {
            return $buttons;
        }

        if (!Mepu_Woo_Datastore::isOnCategory($product)) {
            return $buttons;
        }

        $mepu_data = Mepu_Woo_Datastore::get($product);
        if ($mepu_data === null) {
            return $buttons;
        }

        $shopPageButtonTemplate = apply_filters(
            'mepu_woo_shop_page_template',
            Mepu_Woo_Template::get('frontend/templates/shop-page-template.php')
        );

        foreach ($mepu_data[0] as $mepu_item) {
            $buttons .= sprintf(
                $shopPageButtonTemplate,
                esc_url($mepu_item[0]),
                esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                esc_html($mepu_item[1]));
        }

        return $buttons;
    }

    /**
     * Adjust cart form details - ability to open in new tab/window
     *
     * @since   1.0.0
     */
    public function adjust_cart_form_details()
    {
        global $product;
        if (Mepu_Woo_Datastore::isExternal($product) && Mepu_Woo_Datastore::isTargetBlank($product)) {
            Mepu_Woo_Template::render('frontend/templates/script-target-blank.php');
        }
    }

    /**
     * Adjust external product buttons on category loop - ability to open in new tab/window
     *
     * @param $args
     * @param $product
     * @return mixed
     * @since   1.1.0
     */
    public function adjust_cart_form_details_loop($args, $product)
    {
        if (!Mepu_Woo_Datastore::isExternal($product)) {
            return $args;
        }

        if (!isset($args['attributes'])) {
            return $args;
        }

        if (Mepu_Woo_Datastore::isTargetBlank($product) && Mepu_Woo_Datastore::isOnCategory($product)) {
            $args['attributes']['target'] = '_blank';
        }

        return $args;
    }
}
