<?php

/**
 * Description of WPSC_taxonomies_fields
 *
 * @author pedro
 * 
 * Extra fields for the Category taxonomy. This include the image field.
 */
class WPSC_taxonomies_fields {

  /**
   * Constructor
   */
  public function __construct() {
    add_action('init', array($this, 'wpsc_register_taxonomies'), 7);
    add_action('wpsc_category_add_form_fields', array($this, 'add_category_fields'));
    add_action('wpsc_category_edit_form_fields', array($this, 'edit_category_fields'), 10);

    add_action('edit_wpsc_category', array($this, 'save_category_fields'), 10, 2);
    add_action('created_wpsc_category', array($this, 'save_category_fields'), 10, 2);

    add_action('admin_enqueue_scripts', array($this, 'load_wp_media_files'));
  }

  /**
   * Register taxonomies
   * */
  function wpsc_register_taxonomies() {
    global $wpdb;
    
    $labels = array(
      'name' => _x('Category', 'wp_simple_catalog'),
      'singular_name' => _x('Category', 'wp_simple_catalog'),
      'search_items' => __('Search Categories', 'wp_simple_catalog'),
      'all_items' => __('All Categories', 'wp_simple_catalog'),
      'parent_item' => __('Parent Category', 'wp_simple_catalog'),
      'parent_item_colon' => __('Parent Category:', 'wp_simple_catalog'),
      'edit_item' => __('Edit Category', 'wp_simple_catalog'),
      'update_item' => __('Update Category', 'wp_simple_catalog'),
      'add_new_item' => __('Add New Category', 'wp_simple_catalog'),
      'new_item_name' => __('New Category Name', 'wp_simple_catalog'),
      'menu_name' => __('Category', 'wp_simple_catalog'),
    );

    $args = array(
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'course'),
    );

    register_taxonomy('wpsc_category', 'wpsc_product', $args);
    
    $wpdb->wpsc_categorymeta = $wpdb->prefix."wpsc_categorymeta";
  }

  /**
   * Category thumbnail fields.
   */
  public function add_category_fields() {
    ?>
    <div class="form-field">
      <label><?php _e('Thumbnail', 'wp-simple-catalog'); ?></label>
      <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wpsc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
      <div style="line-height: 60px;">
        <input type="hidden" id="product_cat_thumbnail_id" name="product_cat_thumbnail_id" />
        <button type="button" class="upload_image_button button"><?php _e('Upload/Add image', 'wp-simple-catalog'); ?></button>
        <button type="button" class="remove_image_button button"><?php _e('Remove image', 'wp-simple-catalog'); ?></button>
      </div>
      <script type="text/javascript">

        // Only show the "remove image" button when needed
        if (!jQuery('#product_cat_thumbnail_id').val()) {
          jQuery('.remove_image_button').hide();
        }

        // Uploading files
        var file_frame;

        jQuery(document).on('click', '.upload_image_button', function (event) {

          event.preventDefault();

          // If the media frame already exists, reopen it.
          if (file_frame) {
            file_frame.open();
            return;
          }

          // Create the media frame.
          file_frame = wp.media.frames.downloadable_file = wp.media({
            title: '<?php _e("Choose an image", "wp-simple-catalog"); ?>',
            button: {
              text: '<?php _e("Use image", "wp-simple-catalog"); ?>'
            },
            multiple: false
          });

          // When an image is selected, run a callback.
          file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();

            jQuery('#product_cat_thumbnail_id').val(attachment.id);
            jQuery('#product_cat_thumbnail img').attr('src', attachment.sizes.thumbnail.url);
            jQuery('.remove_image_button').show();
          });

          // Finally, open the modal.
          file_frame.open();
        });

        jQuery(document).on('click', '.remove_image_button', function () {
          jQuery('#product_cat_thumbnail img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
          jQuery('#product_cat_thumbnail_id').val('');
          jQuery('.remove_image_button').hide();
          return false;
        });

      </script>
      <div class="clear"></div>
    </div>  
    <?php
  }

  /**
   * Edit category thumbnail field.
   *
   * @param mixed $term Term (category) being edited
   */
  public function edit_category_fields($term) {
    print_r($term);
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_metadata('wpsc_category', $t_id, 0, true);
    echo "<br/>Term meta";
    print_r($term_meta);
    $thumbnail_id = $term_meta['thumbnail_id'][0];

    if ($thumbnail_id) {
      $image = wp_get_attachment_thumb_url($thumbnail_id);
    } else {
      $image = wpsc_placeholder_img_src();
    }
    ?>
    <tr class="form-field">
      <th scope="row" valign="top"><label><?php _e('Thumbnail', 'wp-simple-catalog'); ?></label></th>
      <td>
        <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
        <div style="line-height: 60px;">
          <input type="hidden" id="product_cat_thumbnail_id" name="product_cat_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
          <button type="button" class="upload_image_button button"><?php _e('Upload/Add image', 'wp-simple-catalog'); ?></button>
          <button type="button" class="remove_image_button button"><?php _e('Remove image', 'wp-simple-catalog'); ?></button>
        </div>
        <script type="text/javascript">

          // Only show the "remove image" button when needed
          if ('0' === jQuery('#product_cat_thumbnail_id').val()) {
            jQuery('.remove_image_button').hide();
          }

          // Uploading files
          var file_frame;

          jQuery(document).on('click', '.upload_image_button', function (event) {

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (file_frame) {
              file_frame.open();
              return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.downloadable_file = wp.media({
              title: '<?php _e("Choose an image", "wp-simple-catalog"); ?>',
              button: {
                text: '<?php _e("Use image", "wp-simple-catalog"); ?>'
              },
              multiple: false
            });

            // When an image is selected, run a callback.
            file_frame.on('select', function () {
              var attachment = file_frame.state().get('selection').first().toJSON();

              jQuery('#product_cat_thumbnail_id').val(attachment.id);
              jQuery('#product_cat_thumbnail img').attr('src', attachment.sizes.thumbnail.url);
              jQuery('.remove_image_button').show();
            });

            // Finally, open the modal.
            file_frame.open();
          });

          jQuery(document).on('click', '.remove_image_button', function () {
            jQuery('#product_cat_thumbnail img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
            jQuery('#product_cat_thumbnail_id').val('');
            jQuery('.remove_image_button').hide();
            return false;
          });

        </script>
        <div class="clear"></div>
      </td>
    </tr>
    <?php
  }

  /**
   * Save category thumnail field.
   * 
   * @param miexed $term Term (category) being saved
   */
  public function save_category_fields($term_id, $tt_id = '', $taxonomy = '') {
    if (isset($_POST['product_cat_thumbnail_id'])) {
      update_metadata('wpsc_category', $term_id, 'thumbnail_id', absint($_POST['product_cat_thumbnail_id']), '');
      return true;
    }
    return false;
  }

  function load_wp_media_files() {
    wp_enqueue_media();
  }

}

new WPSC_taxonomies_fields();
