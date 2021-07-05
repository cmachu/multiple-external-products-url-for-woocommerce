<?php

/**
 * Fired during plugin deactivation.
 *
 * @link       http://cmachowski.com
 * @since      1.0.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/includes
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Deactivator
{
    /**
     * Remove all post_meta related to plugin
     *
     * @since    1.3.0
     */
    public static function deactivate()
    {
        // TODO - Should we really do this?
        //delete_post_meta_by_key('_multiple_external_');
        //delete_post_meta_by_key('_external_target_blank');
        //delete_post_meta_by_key('_external_show_in_cat');
    }
}
