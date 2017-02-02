<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
 <div class="singleprod__qty clearfix">
    <div class="singleprod__qty__minus">-</div>
    <div class="singleprod__qty__plus">+</div>
    <?php echo esc_attr_x( 'Qty:', 'Product quantity input tooltip', 'mnml-shop' ) ?> <span class="singleprod__qty__count" name="input-span"><?php echo esc_attr( $input_value ); ?></span>
    <input type="hidden" id="prod-qty" name="<?php echo esc_attr( $input_name ); ?>" value="1" />
</div>