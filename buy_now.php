<?php

defined( 'ABSPATH' ) or die( 'Checkout BMTMicro.com for more info!' );

function print_bmt_buy_now_button_for_product($product_id, $vendor_cid, $atts = array()) {
  $buynow = get_option('buyNowButtonName');
  if (!$buynow || ($buynow == '')) {
    $buynow = __("Buy Now", "wordpress-simple-paypal-shopping-cart");
  }

  $vendor_cid = get_option('vendorCid');

  $replacement .= wp_nonce_field('bmt_buynow', '_wpnonce', true, false);

    // This is for the 'Buy Now' option
  if (isset($atts['button_image']) && !empty($atts['button_image'])) {
    //Use the custom button image specified in the shortcode
    $replacement .= '<input type="image" src="' . $atts['button_image'] . '" class="bmt_buy_now_button" alt="' . (__("Buy Now", "wordpress-simple-paypal-shopping-cart")) . '"/>';
  } else if (isset($atts['button_text']) && !empty($atts['button_text'])) {
      //Use the custom button text specified in the shortcode
    $replacement .= '<input type="button" id="buybutton" class="bmt_buy_now_submit" name="bmt_buy_now_submit" onclick="bmt_checkout(' . $product_id . ', \'' . $vendor_cid .'\');" value="' . apply_filters('bmt_buy_now_submit_button_value', $atts['button_text'], $product_id) . '" />';
  } else {
    //Use the button text or image value from the settings
    if (preg_match("/http:/", $buynow) || preg_match("/https:/", $buynow)) {
        //Use the image as the add to cart button
        $replacement .= '<input type="image" src="' . $buynow . '" class="bmt_buy_now_button" alt="' . (__("Buy Now", "wordpress-simple-paypal-shopping-cart")) . '"/>';
    } else {
      //Use plain text add to cart button
      $replacement .= '<input type="button" id="buybutton" class="bmt_buy_now_submit" name="bmt_buy_now_submit" onclick="bmt_checkout(' . $product_id . ', \'' . $vendor_cid .'\');" value="' . apply_filters('bmt_buy_now_submit_button_value', $buynow, $product_id) . '" />';
    }
  }

  $replacement .= '</div>';
  return $replacement;
}
