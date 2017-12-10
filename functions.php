<?php

add_action( 'after_setup_theme', 'yourtheme_setup' );
 
function yourtheme_setup() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
}
function theme_styles() { 
	wp_enqueue_style( 'bootsrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/css/bootstrap.min.css' );
	wp_enqueue_style( 'responsiveslides-css', get_template_directory_uri() . '/bower_components/ResponsiveSlides/responsiveslides.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/bower_components/font-awesome/css/font-awesome.min.css' );
  wp_enqueue_style( 'eonasdan-bootstrap', get_template_directory_uri() . '/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/css/layout.css' );
	wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/bower_components/jquery/dist/jquery.min.js');
	wp_enqueue_script( 'bootsrap-js', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js');
	wp_enqueue_script( 'responsiveslides-js', get_template_directory_uri() . '/bower_components/ResponsiveSlides/responsiveslides.min.js');
  wp_enqueue_script( 'moment-js', get_template_directory_uri() . '/bower_components/moment/min/moment.min.js');
  wp_enqueue_script( 'eonasdan-bootstrap-js', get_template_directory_uri() . '/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
}

add_action('wp_enqueue_scripts', 'theme_styles');
add_action('init', 'slideshow_register');
add_action('woocommerce_after_order_notes', 'delivery_date');
 
function delivery_date($checkout)
{
  echo '<div id="delivery_date"><h2>' . __('Delivery Date') . '</h2>';
  woocommerce_form_field('delivery_date', array(
    'type' => 'text',
    'id'=>'datetimepicker4',
    'class' => array(
      'my-field-class form-row-wide input-text woocommerce-billing-fields'
    ) ,
    'label' => __('Delivery Date') ,
    'placeholder' => __('Delivery Date') ,
    'required' => true,
  ) , $checkout->get_value('delivery_date'));
  echo '</div>';
}
add_action('woocommerce_checkout_update_order_meta', 'customise_checkout_field_update_order_meta');


function customise_checkout_field_update_order_meta($order_id)
{
  if (!empty($_POST['delivery_date'])) {
    update_post_meta($order_id, 'delivery_date', sanitize_text_field($_POST['delivery_date']));
  }
}
add_action('woocommerce_checkout_process', 'customise_checkout_field_process');
 
function customise_checkout_field_process()
{
  // if the field is set, if not then show an error message.
  if (!$_POST['delivery_date']) wc_add_notice(__('Please enter value.') , 'error');
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Delivery Date').':</strong> <br/>' . get_post_meta( $order->id, 'delivery_date', true ) . '</p>';
}
add_action('woocommerce_email_customer_details','add_custom_checkout_field_to_emails_notifications', 25, 4 );
function add_custom_checkout_field_to_emails_notifications( $order, $sent_to_admin, $plain_text, $email ) {

    $output = '';
    $billing_field_testing = get_post_meta( $order->id, 'delivery_date', true );

    if ( !empty($billing_field_testing) )
        $output .= '<div><strong>' . __( "Delivery Date :", "woocommerce" ) . '</strong> <span class="text">' . $billing_field_testing . '</span></div>';

    echo $output;
}
 /**
 * Display Custom Billing fields in the Order details area in Woocommerce->orders
  * */
 add_action('woocommerce_admin_order_data_after_billing_address', 'my_custom_billing_fields_display_admin_order_meta', 10, 1);

function my_custom_billing_fields_display_admin_order_meta($order) {
echo '<p><strong>' . __('Delivery Date') . ':</strong><br> ' . get_post_meta($order->id, 'delivery_date', true) . '</p>';
 }
function slideshow_register() {

    $labels = array(
        'name' => _x('Slideshow', 'post type general name'),
        'singular_name' => _x('Slideshow Item', 'post type singular name'),
        'add_new' => _x('Add New', 'slideshow item'),
        'add_new_item' => __('Add New Slideshow Item'),
        'edit_item' => __('Edit Slideshow Item'),
        'new_item' => __('New Slideshow Item'),
        'view_item' => __('View Slideshow Item'),
        'search_items' => __('Search Slideshow'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail','excerpt'),
        'rewrite' => array('slug' => 'slideshow', 'with_front' => FALSE)
      ); 

    register_post_type( 'slideshow' , $args );
}

/**
 * Add the field to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
  $keys[] = 'My Field';
  return $keys;
}
add_action("admin_init", "admin_init");

function admin_init(){
  add_meta_box("url-meta", "Slider Options", "url_meta", "slideshow", "side", "low");
}

function url_meta(){
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
  <label>URL:</label>
  <input name="url" value="<?php echo $url; ?>" /><br />
  <input type="checkbox" name="url_open"<?php if($url_open == "on"): echo " checked"; endif ?>>URL open in new window?<br />
  <?php
}

add_action('save_post', 'save_details');
function save_details(){
  global $post;

  if( $post->post_type == "slideshow" ) {
      if(!isset($_POST["url"])):
         return $post;
      endif;
      if($_POST["url_open"] == "on") {
        $url_open_checked = "on";
      } else {
        $url_open_checked = "off";
      }
      update_post_meta($post->ID, "url", $_POST["url"]);
      update_post_meta($post->ID, "url_open", $url_open_checked);
  }

}

function wp_rpt_activation_hook() {
    if(function_exists('add_theme_support')) {
        add_theme_support( 'post-thumbnails', array( 'slideshow' ) ); // Add it for posts
    }
    add_image_size('slider', 554, 414, true);
}
add_action('after_setup_theme', 'wp_rpt_activation_hook');

// Array of custom image sizes to add
$my_image_sizes = array(
    array( 'name'=>'slider', 'width'=>554, 'height'=>414, 'crop'=>true ),
);
function wc_ninja_change_flat_rates_cost( $rates, $package ) {
	// Make sure flat rate is available
	if ( isset( $rates['flat_rate'] ) ) {
		// Set the cost to $100
		$rates['flat_rate']->cost = 10055;
	}

	return $rates;
}

add_filter( 'woocommerce_package_rates', 'wc_ninja_change_flat_rates_cost', 10, 2 );

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
add_theme_support('woocommerce');