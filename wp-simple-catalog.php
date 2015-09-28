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

include_once('includes/WPSC_taxonomies_fields.php');    

class WP_Simple_Catalog {

  function __construct() {
    $this->includes();        

    add_action('admin_menu', array($this, 'wpsc_add_menu'));    
    
    register_activation_hook(__FILE__, array($this, 'wpsc_install'));
    register_deactivation_hook(__FILE__, array($this, 'wpsc_uninstall'));
  }
  
  /**
   * Includes
   */
  function includes() {
    include_once('includes/WPSC_functions.php');
    include_once('includes/WPSC_post_types.php');
    include_once('includes/WPSC_taxonomies_fields.php');
    include_once('includes/WPSC_register_shortcodes.php');
  }

  /**
   * Loading of menu in Dashboard
   * */
  function wpsc_add_menu() {
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
    global $wpdb;
    $collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}
    
    $sql = "CREATE TABLE {$wpdb->prefix}wpsc_categorymeta (
      meta_id bigint(20) NOT NULL auto_increment,
      wpsc_category_id bigint(20) NOT NULL,
      meta_key varchar(255) NULL,
      meta_value longtext NULL,
      PRIMARY KEY  (meta_id),
      KEY wpsc_category_id (wpsc_category_id),
      KEY meta_key (meta_key)
      ) $collate; ";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );    
    dbDelta($sql);
  }

  /*
   * Actions perform on de-activation of plugin
   */

  function wpsc_uninstall() {
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpsc_categorymeta" );    
  }

}

new WP_Simple_Catalog();