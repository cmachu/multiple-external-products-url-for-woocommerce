=== Multiple external product URLs for WooCommerce ===
Contributors: cmachu
Author URI: https://cmachowski.com
Tags: woocommerce, external product, woo, external, product, product url, woocommerce external product, multiple external products,
Requires at least: 3.0.1
Tested up to: 5.7.2
Stable tag: 1.3.0
License: GPLv2 or late
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://paypal.me/cmachu

Plugins gives you ability to add multiple external product URLs on WooCommerce product edit page.

== Description ==

Plugin is extension for WooCommerce plugin.

Plugin allows you to create multiple External / Affiliate product URLs and buttons text.

Plugin creates extra fields on External / Affiliate product edit form, with repeater of multiple external URLs.
Also, plugin gives you ability to open external / affiliate URLs on new window.


Features:

*   Ability to create multiple buttons with external / affiliate URLs
*   Ability to open external / affiliate URLs in new window - configuration per product
*   Ability to display additional external / affiliate URLs on shop/category page - configuration per product
*   Ability to change additional button templates by hooks - `mepu_woo_product_page_template` and `mepu_woo_shop_page_template`

== Installation ==

1. Upload plugin `Multiple external product URLs for WooCommerce` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to sample External / Affiliate product page, and create multiple buttons!


== Changelog ==

= 1.3.0 =
* MAINTENANCE: Clean code, general refactoring
* ADD: Dummy Template system and ability to use own templates via filters
* ADD: Added filter `mepu_woo_product_page_template`
* ADD: Added filter `mepu_woo_shop_page_template`

= 1.2.0 =
* FIX: JS error on few WooCommerce versions
* FIX: PHP Fatal error on few WooCommerce versions

= 1.1.0 =
* ADD: Ability to switch on/off displaying additional external product buttons on category loops
* FIX: JS error with single quotes on button labels
* FIX: Common fixes


= 1.0.0 =
* Initial release

