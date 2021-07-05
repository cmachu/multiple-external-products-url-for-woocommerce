<?php

/**
 * Class for template manipulation
 *
 * @link       http://cmachowski.com
 * @since      1.3.0
 *
 * @package    Mepu_Woo
 * @subpackage Mepu_Woo/helpers
 * @author     Paweł Ćmachowski <pawel.cmachowski@gmail.com>
 */
class Mepu_Woo_Template
{
    /**
     * Echo rendered template
     *
     * @param $filePath
     * @param array $variables
     * @since   1.3.0
     */
    public static function render($filePath, $variables = [])
    {
        echo self::get($filePath, $variables);
    }

    /**
     * Get template file contents
     *
     * @param $filePath
     * @param array $variables
     * @return false|string|null
     * @since   1.3.0
     */
    public static function get($filePath, $variables = [])
    {
        $filePath = MEPU_WOO_PLUGIN_DIR. $filePath;
        $output = NULL;
        if (!file_exists($filePath)) {
            echo "Cant find view file";
        }

        extract($variables);
        ob_start();
            include $filePath;
        $output = ob_get_clean();
        return $output;
    }
}