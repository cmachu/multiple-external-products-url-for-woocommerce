<input type='hidden' value='<?php echo $data; ?>' id='mepu-woo-data'>
<div class="options_group show_if_external mepu-woo-cont" style="padding:0 10px;">
    <h4><?php _e('Multiple external product URLs', 'mepu-woo'); ?> - <a href="#mepu-woo-data"
                                                                        class="mepu-woo-add"><?php _e('Add new', 'mepu-woo'); ?></a>
    </h4>
    <?php
        woocommerce_wp_checkbox(
            [
                'id' => '_external_target_blank',
                'label' => __('Open in new tab', 'mepu-woo'),
                'description' => __('Open external / affiliate URLs in new tab?', 'mepu-woo')
            ]
        );

        woocommerce_wp_checkbox(
            [
                'id' => '_external_show_in_cat',
                'label' => __('Category pages', 'mepu-woo'),
                'description' => __('Show all external product buttons on category pages', 'mepu-woo')
            ]
        );
    ?>
    <div class="hidden mepu-woo-only-for-clone" style="border-bottom:1px solid #efefef;">
        <h5><?php _e('## External / Affiliate product details', 'mepu-woo'); ?> - <a href="#mepu-woo-data"
                                                                                     class="mepu-woo-delete"><?php _e('Delete', 'mepu-woo'); ?></a>
        </h5>
        <?php
            woocommerce_wp_text_input(
                [
                    'id' => '_product_url_clone_[]',
                    'label' => __('Product URL ##', 'mepu-woo'),
                    'placeholder' => 'http://',
                ]
            );

            woocommerce_wp_text_input(
                [
                    'id' => '_button_text_clone_[]',
                    'label' => __('Button text ##', 'mepu-woo'),
                    'placeholder' => _x('Buy product', 'placeholder', 'mepu-woo'),
                ]
            );
        ?>
    </div>
</div>