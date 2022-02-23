<?php

	/*
	Plugin Name: BMT Micro Shopping Cart
	Version: 2.0.1
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

	define('BMT_CART_VERSION', '2.0.1');
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

	add_action('wp_default_scripts', function ($scripts) {
	$setScripts = function($scripts, $handle, $src, $deps = [], $ver = false, $in_footer = false) {
		$script = $scripts->query( $handle, 'registered' );

		if ( $script ) {
			// If already added
			$script->src  = $src;
			$script->deps = $deps;
			$script->ver  = $ver;
			$script->args = $in_footer;

			unset( $script->extra['group'] );

			if ( $in_footer ) {
				$script->add_data( 'group', 1 );
			}
		} else {
			// Add the script
			if ( $in_footer ) {
				$scripts->add( $handle, $src, $deps, $ver, 1 );
			} else {
				$scripts->add( $handle, $src, $deps, $ver );
			}
		}
	};

	$assets_url = $assets_url = plugins_url( 'js/', __FILE__  );

	$setScripts( $scripts, 'jquery-migrate', $assets_url . 'jquery-migrate/jquery-migrate-1.4.1-wp.js', array(), '1.4.1-wp' );
	$setScripts( $scripts, 'jquery-core', $assets_url . 'jquery/jquery-1.12.4-wp.js', array(), '1.12.4-wp' );
	$setScripts( $scripts, 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '1.12.4-wp' );
	$setScripts( $scripts, 'jquery-ui-core', $assets_url . 'jquery-ui/core.min.js', array( 'jquery' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-core', $assets_url . 'jquery-ui/effect.min.js', array( 'jquery' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-blind', $assets_url . 'jquery-ui/effect-blind.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-bounce', $assets_url . 'jquery-ui/effect-bounce.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-clip', $assets_url . 'jquery-ui/effect-clip.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-drop', $assets_url . 'jquery-ui/effect-drop.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-explode', $assets_url . 'jquery-ui/effect-explode.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-fade', $assets_url . 'jquery-ui/effect-fade.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-fold', $assets_url . 'jquery-ui/effect-fold.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-highlight', $assets_url . 'jquery-ui/effect-highlight.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-puff', $assets_url . 'jquery-ui/effect-puff.min.js', array( 'jquery-effects-core', 'jquery-effects-scale' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-pulsate', $assets_url . 'jquery-ui/effect-pulsate.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-scale', $assets_url . 'jquery-ui/effect-scale.min.js', array( 'jquery-effects-core', 'jquery-effects-size' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-shake', $assets_url . 'jquery-ui/effect-shake.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-size', $assets_url . 'jquery-ui/effect-size.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-slide', $assets_url . 'jquery-ui/effect-slide.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-effects-transfer', $assets_url . 'jquery-ui/effect-transfer.min.js', array( 'jquery-effects-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-accordion', $assets_url . 'jquery-ui/accordion.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-autocomplete', $assets_url . 'jquery-ui/autocomplete.min.js', array( 'jquery-ui-menu', 'wp-a11y' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-button', $assets_url . 'jquery-ui/button.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-datepicker', $assets_url . 'jquery-ui/datepicker.min.js', array( 'jquery-ui-core' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-dialog', $assets_url . 'jquery-ui/dialog.min.js', array( 'jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-button', 'jquery-ui-position' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-draggable', $assets_url . 'jquery-ui/draggable.min.js', array( 'jquery-ui-mouse' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-droppable', $assets_url . 'jquery-ui/droppable.min.js', array( 'jquery-ui-draggable' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-menu', $assets_url . 'jquery-ui/menu.min.js', array( 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-mouse', $assets_url . 'jquery-ui/mouse.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-position', $assets_url . 'jquery-ui/position.min.js', array( 'jquery' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-progressbar', $assets_url . 'jquery-ui/progressbar.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-resizable', $assets_url . 'jquery-ui/resizable.min.js', array( 'jquery-ui-mouse' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-selectable', $assets_url . 'jquery-ui/selectable.min.js', array( 'jquery-ui-mouse' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-selectmenu', $assets_url . 'jquery-ui/selectmenu.min.js', array( 'jquery-ui-menu' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-slider', $assets_url . 'jquery-ui/slider.min.js', array( 'jquery-ui-mouse' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-sortable', $assets_url . 'jquery-ui/sortable.min.js', array( 'jquery-ui-mouse' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-spinner', $assets_url . 'jquery-ui/spinner.min.js', array( 'jquery-ui-button' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-tabs', $assets_url . 'jquery-ui/tabs.min.js', array( 'jquery-ui-core', 'jquery-ui-widget' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-tooltip', $assets_url . 'jquery-ui/tooltip.min.js', array( 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-ui-widget', $assets_url . 'jquery-ui/widget.min.js', array( 'jquery' ), '1.11.4-wp', 1 );
	$setScripts( $scripts, 'jquery-touch-punch', false, array( 'jquery-ui-widget', 'jquery-ui-mouse' ), '0.2.2', 1 );
	}, -10);
