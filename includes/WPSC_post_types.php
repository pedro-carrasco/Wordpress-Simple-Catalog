<?php

/**
 * Register the post types, only Products post
 *
 * @author pedro
 * 
 */
class WPSC_post_types {

  function __construct() {
    add_action('init', array($this, 'wpsc_register_post_types'), 6);
  }

  /**
   * Register post types
   * */
  function wpsc_register_post_types() {
    $labels = array(
      'name' => __('Catalog Products', 'wp_simple_catalog'),
      'singular_name' => __('Catalog Product', 'wp_simple_catalog'),
      'search_items' => __('Search Catalog Product', 'wp_simple_catalog'),
      'all_items' => __('All Catalog Products', 'wp_simple_catalog'),
      'edit_item' => __('Edit Catalog Product', 'wp_simple_catalog'),
      'update_item' => __('Update Catalog Product', 'wp_simple_catalog'),
      'add_new_item' => __('Add New Catalog Product', 'wp_simple_catalog'),
      'new_item_name' => __('New Catalog Product Name', 'wp_simple_catalog'),
      'menu_name' => __('Catalog Product', 'wp_simple_catalog'),
    );
    
    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'catalog-products'),      
    );
    
    register_post_type('wpsc_product', $args);
  }

}

new WPSC_post_types();
