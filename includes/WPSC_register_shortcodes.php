<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WPSC_register_shortcodes
 *
 * @author pedro
 */
class WPSC_register_shortcodes {
  function __construct() {
     add_action('init', array($this, 'wpsc_add_shortcodes'));
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
   * Shortcodes functions
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
}
