	<?php if ( class_exists( 'WooCommerce' ) ) {  ?>
	<div id="cart-panel" class="cart-panel">

		<!-- cart panel Header -->
		<div class="cart-panel__header">
			Your Cart
			<a href="#" class="cart-panel__close">&nbsp;</a>
		</div>
		
		<!-- List of Items -->
		<ul class="cart-panel__items">
		<?php

		function mnml_cart_panel(){
			$currency = '';
		    global $woocommerce;
		    $mnml_items = $woocommerce->cart->get_cart();

	        foreach($mnml_items as $mnml_item => $mnml_item_values) { 
	            $_product = $mnml_item_values['data']->post;
	            $getProductDetail = wc_get_product( $mnml_item_values['product_id'] );
				$price = get_post_meta($mnml_item_values['product_id'] , '_price', true);
				$currency_symbol = get_woocommerce_currency_symbol( $currency );
	    	?>
		    <li class="cart-panel__item clearfix">
				<a href="<?php echo $woocommerce->cart->get_remove_url($mnml_item);?>" class="cart-panel__item__remove"></a>
				<div class="cart-panel__item__thumbnail"><?php echo $getProductDetail->get_image(); ?></div>
				<div class="cart-panel__item__data">
					<div class="cart-panel__item__title"><?php echo $_product->post_title; ?></div>
					<div class="cart-panel__item__price"><?php echo $currency_symbol.$price; ?></div>
					<div class="cart-panel__item__quantity"><?php  echo esc_html__('Quantity:','mnml-shop').$mnml_item_values['quantity'];?></div>
				</div>
			</li>

	    <?php
			}
		?>
		</ul>

		<!-- cart total -->
		<div class="cart-panel__total clearfix">
			<span class="cart-panel__total__label"><?php esc_html_e('Subtotal','mnml-shop'); ?></span>
			<span class="cart-panel__total__price"><?php echo WC()->cart->get_cart_total(); ?></span>
		</div>
<?php
	}
	mnml_cart_panel();
?>

		<!-- links -->
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart-panel__button btn button--block button--outline button--3 button-hover--3 button-hover--fill"><?php esc_html_e('View Cart','mnml-shop'); ?></a>
		<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="cart-panel__button btn button--block button-hover--fill button-hover--2"><?php esc_html_e('Checkout','mnml-shop'); ?></a>

	</div>

	<?php } ?>