<?php

/*
  Plugin Name: WP Simple Catalog
  Description: Simple catalog with a plugin that make blocks in a wordpress page.
  Version:     1.0
  Author:      Pedro A. Carrasco Ponce
  Author URI:  http://www.pecasoft.net/
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
defined('ABSPATH') or die('Is not allowed to access this file');

class WP_Simple_Catalog {

  function __construct() {
    add_action('init', array($this, 'wpsc_register_taxonomies'));
    add_action('init', array($this, 'wpsc_register_post_types'));
    add_action('init', array($this, 'wpsc_add_shortcodes'));

    add_action('admin_menu', array($this, 'wpsc_add_menu'));

    register_activation_hook(__FILE__, array($this, 'wpsc_install'));
    register_deactivation_hook(__FILE__, array($this, 'wpsc_uninstall'));
  }

  /**
   * Register taxonomies
   * */
  function wpsc_register_taxonomies() {
    $labels = array(
      'name' => _x('Category', 'category general name'),
      'singular_name' => _x('Category', 'taxonomy singular name'),
      'search_items' => __('Search Categories'),
      'all_items' => __('All Categories'),
      'parent_item' => __('Parent Category'),
      'parent_item_colon' => __('Parent Category:'),
      'edit_item' => __('Edit Category'),
      'update_item' => __('Update Category'),
      'add_new_item' => __('Add New Category'),
      'new_item_name' => __('New Category Name'),
      'menu_name' => __('Category'),
    );
    
    $args = array(
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'course'),
    );
    
    register_taxonomy('wpsc_category', array('wpsc_product'), $args);
  }

  /**
   * Register post types
   * */
  function wpsc_register_post_types() {
    register_post_type('wpsc_product', array(
      'labels' => array(
        'name' => __('Products'),
        'singular_name' => __('Product')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'catalog-products'),
      )
    );
  }

  /**
   * Loading shortcodes
   * */
  function wpsc_add_shortcodes() {
    add_shortcode('wpsc_show_all_categories', array($this, 'wpsc_show_all_categories'));
    add_shortcode('wpsc_show_products', array($this, 'wpsc_show_products'));
    add_shortcode('wpsc_show_category', array($this, 'wpsc_show_category'));
    add_shortcode('wpsc_show_product', array($this, 'wpsc_show_product'));
  }

  /**
   * Shortcodes function_exists
   * */
  function wpsc_show_all_categories() {
    echo('Show all categories');
  }

  function wpsc_show_products($atts) {
    $category_id = $atts['id'];
    echo('Show all products from: ' . $category_id);
  }

  function wpsc_show_category($atts) {
    $category_id = $atts['id'];
    echo('Show category: ' . $category_id);
  }

  function wpsc_show_product($atts) {
    $product_id = $atts['id'];
    echo('Show product: ' . $product_id);
  }

  /**
   * Loading of menu in Dashboard
   * */
  function wpsc_add_menu() {

    add_menu_page(__('Simple Catalog', 'simple caltalog'), __('Simple Catalog', 'simple catalog'), 'simple_catalog', 'simple-catalog-menu', null, null, '58.2134');

    add_submenu_page('simple-catalog-menu', __('Settings', 'settings'), __('Settings', 'settings'), 'manage_options', 'simple-catalog-settings-page', array($this, 'wpsc_page_settings'));

    add_submenu_page('simple-catalog-menu', __('Manage products', 'manage products'), __('Manage products', 'manage products'), 'manage_options', 'simple-catalog-products-page', array($this, 'wpsc_page_products'));

    add_submenu_page('simple-catalog-menu', __('Manage categories', 'manage categories'), __('Manage categories', 'manage categories'), 'manage_options', 'simple-catalog-categories-page', array($this, 'wpsc_page_categories'));
  }

  /*
   * Actions perform on loading of menu pages
   */

  function wpsc_page_settings() {
    echo 'Settings page';
  }

  function wpsc_page_categories() {
    echo 'Categories page';
  }

  function wpsc_page_products() {
    echo 'Products page';
  }

  /*
   * Actions perform on activation of plugin
   */

  function wpsc_install() {
    
  }

  /*
   * Actions perform on de-activation of plugin
   */

  function wpa_uninstall() {
    
  }

}

new WP_Simple_Catalog();
