<?php

	defined( 'ABSPATH' ) or die( 'Checkout BMTMicro.com for more info!' );

	add_shortcode('bmt_buy_now_button', 'bmt_buy_now_button_handler');
	add_shortcode('bmt_add_cart_button', 'bmt_add_cart_button_handler');
	add_shortcode('bmt_checkout_button', 'bmt_checkout_handler');
	add_shortcode('bmt_cart_show', 'bmt_cart_show_handler');

	function bmt_buy_now_button_handler($atts) {
		extract(shortcode_atts(array(
			'product_id' => '',
		), $atts));

		if(empty($product_id)){
			return '<div style="color:red;">'.(__("Error! You must add the Product ID in the shortcode.", "wordpress-simple-paypal-shopping-cart")).'</div>';
		}

		return print_bmt_buy_now_button_for_product($product_id, $atts);
	}

	function bmt_add_cart_button_handler($atts) {
		extract(shortcode_atts(array(
			'product_id' => '',
		), $atts));

		if(empty($product_id)){
			return '<div style="color:red;">'.(__("Error! You must enter the Product ID in the shortcode.", "wordpress-simple-paypal-shopping-cart")).'</div>';
		}

		return print_bmt_add_cart_button_for_product($product_id, $atts);
	}

	function bmt_cart_show_handler($atts) {
		return '<iframe id="bmt_cart_iconframe" name="bmt_cart_iconframe" width="70" height="70"></iframe>';
	}
