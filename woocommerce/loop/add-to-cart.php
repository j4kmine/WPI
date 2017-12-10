<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<hr/>
<p><?php echo $product->short_description; ?></p>
<?php if ( $price_html = $product->get_price_html() ) : ?>
	<p class="price-slides price_detail"><?php echo $price_html; ?></p>
<?php endif; ?>
<?php 
echo '<div class="cart-btn btn ">';
echo '<a class="qv-button button-1 button-round button-medium" href="'.esc_url( get_permalink()).'"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;</a>';

$button_action = $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '';
$supports = $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '';
$class = 'fg-button button-3 button-round button-medium product_type_' . $product->product_type .' '. $button_action .' '. $supports;

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		esc_html( $product->add_to_cart_text() )
	),
$product );
echo '</div>';




	