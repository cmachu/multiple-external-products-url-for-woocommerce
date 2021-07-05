<?php

/**
 * Class for db data manipulation
 *
 * @link       http://cmachowski.com
 * @since      1.3.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/helpers
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Datastore
{
    /**
     * Set post_meta with main data pack(url + label)
     *
     * @param $post_id
     * @param $data
     * @return bool|int
     * @since   1.3.0
     */
    public static function setData($post_id, $data)
    {
        return update_post_meta(
            $post_id,
            '_multiple_external_',
            $data
        );
    }

    /**
     * Set post_meta with visibility in category
     *
     * @param $post_id
     * @param $value
     * @return bool|int
     * @since   1.3.0
     */
    public static function setCategoryVisibility($post_id, $value)
    {
        return update_post_meta(
            $post_id,
            '_external_show_in_cat',
            $value === 'true' ? 'true' : 'false'
        );
    }

    /**
     * Set post_meta with href target value(_blank or not)
     *
     * @param $post_id
     * @param $value
     * @return bool|int
     * @since   1.3.0
     */
    public static function setTargetValue($post_id, $value)
    {
        return update_post_meta(
            $post_id,
            '_external_target_blank',
            $value === 'true' ? 'true' : 'false'
        );
    }

    /**
     * Check that object(WooCommerce Product is external)
     *
     * @param $object
     * @return bool
     * @since   1.3.0
     */
    public static function isExternal($object)
    {
        return (method_exists($object, 'get_type') && $object->get_type() === 'external');
    }

    /**
     * Check that object(WooCommerce product) should display multiple external URL's on category/shop pages
     *
     * @param $object
     * @return mixed
     * @since   1.3.0
     */
    public static function isOnCategory($object)
    {
        return get_post_meta(self::resolveID($object), '_external_show_in_cat', true);
    }

    /**
     * Check that object(WooCommerce product) should open multiple external URL's on new tabs/windows
     *
     * @param $object
     * @return mixed
     * @since   1.3.0
     */
    public static function isTargetBlank($object)
    {
        return get_post_meta(self::resolveID($object), '_external_target_blank', true);
    }

    /**
     * Get main pack(url+label) data
     *
     * @param $object
     * @return mixed|null
     * @since   1.3.0
     */
    public static function get($object)
    {
        $data = get_post_meta(self::resolveID($object), '_multiple_external_');
        if (!is_array($data) || !isset($data[0])) {
            return null;
        }

        return $data;
    }

    /**
     * Get JSON encoded details for JS
     *
     * @param $object
     * @return false|string
     * @since   1.3.0
     */
    public static function getJSON($object)
    {
        $data = self::get($object);
        if ($data === null) {
            return json_encode([], JSON_HEX_APOS);
        }

        return json_encode($data, JSON_HEX_APOS);
    }

    /**
     * Resolve object ID - from post(native WP object) or product(WooCommerce Object)
     *
     * @param $object
     * @return int|null
     * @since   1.3.0
     */
    private static function resolveID($object)
    {
        if (method_exists($object, 'get_id')) {
            return (int)$object->get_id();
        }

        if (property_exists($object, 'ID')) {
            return (int)$object->ID;
        }

        if (key_exists('ID', (array)$object)) {
            return (int)((array)$object)['ID'];
        }

        return null;
    }
}