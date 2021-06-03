<?php

	/*
	Plugin Name: BMT Micro Shopping Cart
	Version: 1.1.0
	Plugin URI: https://www.help.bmtmicro.com/plugin
	Author: BMT Micro, Inc.
	Author URI: https://www.bmtmicro.com/
	Description: Shopping cart plugin for BMT Micro vendors
	Text Domain: BMT Micro, Inc. Shopping Cart Plugin for BMT Micro Vendors!
	Domain Path: /languages/
	*/

	//Slug - bmt

	defined( 'ABSPATH' ) or die( 'Checkout BMTMicro.com for more info!' );

	// add_action('init', 'start_session', 1);
	//
	// if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
	// 	if (session_status() == PHP_SESSION_NONE) {
	// 		session_start();
	// 	}
	// } else {
	// 	if (session_id() == '') {
	// 		session_start();
	// 	}
	// }

	define('BMT_CART_VERSION', '1.1.0');
	define('BMT_CART_FOLDER', dirname(plugin_basename(__FILE__)));
	define('BMT_CART_PATH', plugin_dir_path(__FILE__));
	define('BMT_CART_URL', plugins_url('', __FILE__));
	define('BMT_CART_CURRENCY_SYMBOL', get_option('cart_currency_symbol'));
	define('BMT_CART_SITE_URL', site_url());
	// define('BMT_WP_CART_URL', 'https://secure.bmtmicro.com/cart?CID=2/WP');
	define('BMT_URL', 'https://secure.bmtmicro.com/cart');

	if (!defined('BMT_CART_MANAGEMENT_PERMISSION')) {//This will allow the user to define custom capability for this constant in wp-config file
		define('BMT_CART_MANAGEMENT_PERMISSION', 'manage_options');
	}

	define('BMT_CART_MAIN_MENU_SLUG', 'bmt-menu-main');

	// loading language files
	//Set up localization. First loaded overrides strings present in later loaded file
	$locale = apply_filters('plugin_locale', get_locale(), 'wordpress-simple-paypal-shopping-cart');
	load_textdomain('wordpress-simple-paypal-shopping-cart', WP_LANG_DIR . "/wordpress-simple-paypal-shopping-cart-$locale.mo");
	load_plugin_textdomain('wordpress-simple-paypal-shopping-cart', false, BMT_CART_FOLDER . '/languages');

	include_once('bmt_cart_menu_main.php');
	include_once('bmt_cart_shortcodes.php');
	include_once('add_cart.php');
	include_once('buy_now.php');
	include_once('checkout.php');

	function bmt_admin_side_styles() {
		wp_enqueue_style('bmt-admin-style', BMT_CART_URL . '/css/bmt-admin-styles.css', array(), BMT_CART_VERSION);
	}

	function bmt_front_side_enqueue_scripts() {
		wp_enqueue_style('bmt-style', BMT_CART_URL . '/css/bmt_shopping_cart_style.css', array(), BMT_CART_VERSION);
	}

	register_activation_hook(__FILE__, 'bmt_plugin_install');

	if (!is_admin()) {
	    add_filter('widget_text', 'do_shortcode');
	}

	add_filter('show_admin_bar', '__return_true');

	add_action('template_redirect', 'add_my_script');

	function add_my_script() {
		wp_enqueue_script('my-script', plugins_url('js/submit.js', __FILE__), array('jquery'), '1.0', true);
	}

	add_action('wp_head', 'insert_header_elements');
	function insert_header_elements(){
		echo '<script src="https://secure.bmtmicro.com/bmt_cart_wp.js"></script>';
		// echo '<script src="https://secure.bmtmicro.com/bmt_cart_debug.js"></script>';
		echo '<link rel="stylesheet" href="https://secure.bmtmicro.com/bmt_cart.css" />';
	}

	add_action('wp_enqueue_scripts', 'bmt_front_side_enqueue_scripts');
	add_action('admin_print_styles', 'bmt_admin_side_styles');
