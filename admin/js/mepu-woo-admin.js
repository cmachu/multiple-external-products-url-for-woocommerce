(function ($) {
    'use strict';

    $('#woocommerce-product-data').ready(function (event) {

        if ($('.mepu-woo-cont').length === 0) {
            return false;
        }

        let woo_data = $.parseJSON($('#mepu-woo-data').val());
        if (woo_data === '' && woo_data[0] === undefined) {
            return false;
        }

        for (let i = 0; i < data[0].length; i++) {
            mepu_woo_clone_block(i, data[0][i]);
        }

        $('.mepu-woo-add').bind('click', function () {
            mepu_woo_clone_block($('.mepu-woo-cont-item').length, ['', '']);
        });

    });

    function mepu_woo_clone_block(i, data) {
        let new_block = $('.mepu-woo-only-for-clone').clone();
        new_block.removeClass('hidden').removeClass('mepu-woo-only-for-clone').addClass('mepu-woo-cont-item');
        new_block.find('h5').html(new_block.find('h5').html().replace('##', '#' + (i + 1)));

        new_block.find('label').each(function () {
            $(this).html($(this).html().replace('##', '#' + (i + 1))); // replace all numbering
        });

        new_block.find('input').each(function (item, index) {
            $(this).val(data[index]);
            if ($(this).attr('id') === '_product_url_clone_[]') {
                $(this).attr('id', '_product_url_[]');
                $(this).attr('name', '_product_url_[]');
            }

            if ($(this).attr('id') === '_button_text_clone_[]') {
                $(this).attr('id', '_button_text_[]');
                $(this).attr('name', '_button_text_[]');
            }
        });

        $('.mepu-woo-cont').append(new_block);
        mepu_bind_block_actions();
    }

    function mepu_bind_block_actions() {
        $(".mepu-woo-delete").on('click', function () {
            $(this).closest('.mepu-woo-cont-item').remove();
        });
    }

})(jQuery);