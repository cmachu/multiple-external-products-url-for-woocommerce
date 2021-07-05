<form class="cart" action="<?php echo esc_url($url); ?>" method="get">
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <button type="submit"
            class="single_add_to_cart_button button alt"><?php echo esc_html($label); ?></button>

    <?php wc_query_string_form_fields($url); ?>

    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
</form>