<?php

	defined( 'ABSPATH' ) or die( 'Checkout BMTMicro.com for more info!' );

	//Handle the admin dashboard main menu
	add_action('admin_menu', 'bmt_handle_admin_menu');

	// Handle the settings sidebar display
	function bmt_handle_admin_menu() {

		$menu_icon_url = 'dashicons-cart';

		add_menu_page(__('BMT Micro Cart', 'wordpress-simple-paypal-shopping-cart'), __('BMT Micro Cart', 'wordpress-simple-paypal-shopping-cart'), BMT_CART_MANAGEMENT_PERMISSION, BMT_CART_MAIN_MENU_SLUG , 'bmt_settings_interface', $menu_icon_url, 90);

    	add_submenu_page(BMT_CART_MAIN_MENU_SLUG, __('Settings', 'wordpress-simple-paypal-shopping-cart'),  __('Settings', 'wordpress-simple-paypal-shopping-cart'), BMT_CART_MANAGEMENT_PERMISSION, BMT_CART_MAIN_MENU_SLUG, 'bmt_settings_interface');

    	add_options_page(__("BMT Micro Cart", "wordpress-simple-paypal-shopping-cart"), __("BMT Micro Cart", "wordpress-simple-paypal-shopping-cart"), BMT_CART_MANAGEMENT_PERMISSION, 'wordpress-paypal-shopping-cart', 'bmt_settings_interface');

    	$menu_parent_slug = BMT_CART_MAIN_MENU_SLUG;
    	do_action('bmt_after_main_admin_menu', $menu_parent_slug);

	}

/*
 	* Main settings menu
 	* Only admin user with "manage_options" permission can access this menu page.
*/
 	function bmt_settings_interface() {

 		if (!current_user_can('manage_options')) {
 			wp_die('You do not have permission to access this settings page.');
 		}

 		if(isset($_POST['bmt_reset_logfile'])) {
	        // Reset the debug log file
	        if(bmt_reset_logfile()){
	            echo '<div id="message" class="updated fade"><p><strong>Debug log file has been reset!</strong></p></div>';
	        }
	        else{
	            echo '<div id="message" class="updated fade"><p><strong>Debug log file could not be reset!</strong></p></div>';
	        }
	    }

	    if(isset($_POST['info_update'])) {
	    	$nonce = $_REQUEST['_wpnonce'];
	    	if(!wp_verify_nonce($nonce, 'bmt_simple_cart_settings_update')) {
	    		wp_die('Error! Nonce Security Check Failed! Go back to settings menu and save the settings again.');
	    	}

	    	update_option('buyNowButtonName', sanitize_text_field($_POST["buyNowButtonName"]));

	    	update_option('addToCartButtonName', sanitize_text_field($_POST["addToCartButtonName"]));

				update_option('checkoutButtonName', sanitize_text_field($_POST["checkoutButtonName"]));

	    	update_option('vendorCid', sanitize_text_field($_POST["vendorCid"]));

	    	update_option('bmt_cart_title', sanitize_text_field($_POST["bmt_cart_title"]));

	    	update_option('bmt_disable_nonce_add_cart', (isset($_POST['bmt_disable_nonce_add_cart']) && $_POST['bmt_disable_nonce_add_cart']!='') ? 'checked="checked"':'' );

	    	echo '<div id="message" class="updated fade">';
	        echo '<p><strong>'.(__("Options Updated!", "wordpress-simple-paypal-shopping-cart")).'</strong></p></div>';
	    }

	    $buynow = get_option('buyNowButtonName');
	    if (empty($buynow)) $buynow = __("Buy Now");

			$checkout = get_option('checkoutButtonName');
	    if (empty($checkout)) $checkout = __("Checkout");

	    $addcart = get_option('addToCartButtonName');
	    if (empty($addcart)) $addcart = __("Add to Cart");

	    $vendor_cid = get_option('vendorCid');
	    if (empty($vendor_cid)) $vendor_cid = __("Enter Vendor ID #");

	    $title = get_option('bmt_cart_title');

 			echo '<div class="wrap"><div id="poststuff"><div id="post-body">';
    	echo '<h1>' . (__("BMT Micro Shopping Cart Settings", "wordpress-simple-paypal-shopping-cart")) . ' v'.BMT_CART_VERSION . '</h1>';

	    ?>

	<!-- top yellow box on settings page -->
	    <div class="bmt_yellow_box">
	        <p><?php _e("For more information about BMT Micro vendor features or to access your vendor account, please visit:", "wordpress-simple-paypal-shopping-cart"); ?><br />
	        <a href="https://www.bmtmicro.com/" target="_blank"><?php _e("BMT Micro, Inc.", "wordpress-simple-paypal-shopping-cart"); ?></a></p>
					<p><?php _e("For more information about the BMT Micro plugin, please visit:", "wordpress-simple-paypal-shopping-cart"); ?><br />
	        <a href="https://help.bmtmicro.com/plugin" target="_blank"><?php _e("BMT Micro Plugin", "wordpress-simple-paypal-shopping-cart"); ?></a></p>
					<p><?php _e("Having any plugin issues? Notice any bugs? Have an idea or feature we should consider adding? Send us an email so we can improve the plugin:", "wordpress-simple-paypal-shopping-cart"); ?><br />
					<a href="mailto:jeff@bmtmicro.com?subject=BMT%20Micro%20Wordpress%20Plugin">Email Us</a></p>
	    </div>

	<!-- ************ -->

	    <div class="postbox">
    		<h3 class="hndle"><label for="title"><?php _e("Quick Usage Guide", "wordpress-simple-paypal-shopping-cart"); ?></label></h3>
	    	<div class="inside">
	    		<p><strong><?php _e("Option 1) ","wordpress-paypal-shopping-cart"); ?></strong><?php _e("To add a 'Buy Now' button for a product, simply add the shortcode", "wordpress-simple-paypal-shopping-cart"); ?> [bmt_buy_now_button product_id="<?php _e("PRODUCT ID #", "wordpress-simple-paypal-shopping-cart"); ?>"] <?php _e("to a post or page next to the product. Replace PRODUCT-ID with the actual BMT Micro Product ID for your product. This option will go straight to the BMT checkout when the button is clicked.", "wordpress-simple-paypal-shopping-cart"); ?>
	    		</p><p><?php _e("Example 'Buy Now' button shortcode usage:", "wordpress-simple-paypal-shopping-cart");?> <p style="background-color: #DDDDDD; padding: 5px; display: inline;">[bmt_buy_now_button product_id="0000"]</p></p>

	    		<p><strong><?php _e("Option 2) ","wordpress-paypal-shopping-cart"); ?></strong><?php _e("To add an 'Add to Cart' button for your store or product, simply add the shortcode", "wordpress-simple-paypal-shopping-cart"); ?> [bmt_add_cart_button product_id="<?php _e("PRODUCT ID #", "wordpress-simple-paypal-shopping-cart"); ?>"] <?php _e("to a post or page next to the product. Replace PRODUCT ID with the actual BMT Micro Product ID for your product. This shortcode will send the product to the BMT server, populating the cart (quantities and discount codes are handled in the BMT Micro cart and products can also be deleted through there).", "wordpress-simple-paypal-shopping-cart"); ?>
	    		</p><p><?php _e("Example 'Add to Cart' button shortcode usage:", "wordpress-simple-paypal-shopping-cart");?> <p style="background-color: #DDDDDD; padding: 5px; display: inline;">[bmt_add_cart_button product_id="0000"]</p><p><?php _e("Then add this shortcode on the page to display the checkout button to route the customers to the BMT cart when they are ready to checkout:", "wordpress-simple-paypal-shopping-cart");?> <p style="background-color: #DDDDDD; padding: 5px; display: inline;">[bmt_checkout_button]</p></p>

					<p><strong><?php _e("Shopping Cart Display: ", "wordpress-paypal-shopping-cart");?></strong><?php _e("To display the shopping cart image with an updating number for the amount of items in the cart, use the shortcode:", "wordpress-paypal-shopping-cart"); ?> <p style="background-color: #DDDDDD; padding: 5px; display: inline;">[bmt_cart_show]</p></p>
    		</div>
    	</div>

    	<form method="post" action="">
    	<?php wp_nonce_field('bmt_simple_cart_settings_update'); ?>
    	<input type="hidden" name="info_update" id="info_update" value="true" />

    	<?php

    	echo '
    	<div class="postbox">
			<div class="inside">
				<table class="form-table">

				<tr valign="top">
					<th scope="row">'.(__("BMT Vendor ID", "wordpress-simple-paypal-shopping-cart")).'</th>
					<td><input type="text" name="vendorCid" value="'.esc_attr($vendor_cid).'" size="100" />
						<br />'.(__("Enter your BMT Vendor ID (CID). This will allow the checkout to show your custom cart through BMT Micro.", "wordpress-simple-paypal-shopping-cart")).'
						<br />
					</td>
				</tr>

					<tr valign="top">
					<th scope="row">'.(__("Buy Now Button text or Image", "wordpress-simple-paypal-shopping-cart")).'</th>
						<td><strong>'.(__(" This is only for vendors using 'Option 1' above. ", "wordpress-paypal-shopping-cart")).'</strong><br /><input type="text" name="buyNowButtonName" value="'.esc_attr($buynow).'" size="100" />
						<br />'.(__("To use a customized image as the button simply enter the URL of the image file (e.g.", "wordpress-simple-paypal-shopping-cart).")).' http://www.your-domain.com/wp-content/plugins/wordpress-paypal-shopping-cart/images/buy_now_button.png).
						<br />
						</td>
					</tr>

					<tr valign="top">
					<th scope="row">'.(__("Add to Cart Button text or Image", "wordpress-simple-paypal-shopping-cart")).'</th>
						<td><strong>'.(__(" This is only for vendors using 'Option 2' above. ", "wordpress-paypal-shopping-cart")).'</strong><br /><input type="text" name="addToCartButtonName" value="'.esc_attr($addcart).'" size="100" />
						<br />'.(__("To use a customized image as the button simply enter the URL of the image file (e.g.", "wordpress-simple-paypal-shopping-cart")).' http://www.your-domain.com/wp-content/plugins/wordpress-paypal-shopping-cart/images/buy_now_button.png).
						<br />
						</td>
					</tr>

					<tr valign="top">
					<th scope="row">'.(__("Checkout Button text or Image", "wordpress-simple-paypal-shopping-cart")).'</th>
						<td><strong>'.(__("This is only for vendors using 'Option 2' above. ", "wordpress-paypal-shopping-cart")).'</strong><br /><input type="text" name="checkoutButtonName" value="'.esc_attr($checkout).'" size="100" />
						<br />'.(__("To use a customized image as the checkout button simply enter the URL of the image file (e.g.", "wordpress-simple-paypal-shopping-cart).")).' http://www.your-domain.com/wp-content/plugins/wordpress-paypal-shopping-cart/images/buy_now_button.png).
						<br />
						</td>
					</tr>

					<tr valign="top">
					<th scope="row">'.(__("Create custom buttons", "wordpress-simple-paypal-shopping-cart")).'</th>
						<td>'.(__("To create your very own custom buttons, you can visit ", "wordpress-simple-paypal-shopping-cart")).'<a href="http://buttonoptimizer.com/" target="_blank">http://buttonoptimizer.com/</a>'.(__(" and download the images.", "wordpress-simple-paypal-shopping-cart")).'
						</td>
					</tr>

				</table>
			</div>
		</div>

		<div class="submit">
        	<input type="submit" class="button-primary" name="info_update" value="'.(__("Update Options &raquo;", "wordpress-simple-paypal-shopping-cart")).'" />
    	</div>
    	</form>

		</div></div>'; // These 2 closing div's close out #poststuff and #post-body
 	}
