<?php

defined( 'ABSPATH' ) or die( 'Checkout BMTMicro.com for more info!' );

function print_bmt_add_cart_button_for_product($product_id, $atts = array()) {
  $addcart = get_option('addToCartButtonName');
  if(!$addcart || ($addcart == '')) {
    $addcart = __("Add to Cart", "wordpress-simple-paypal-shopping-cart");
  }

  $vendor_cid = get_option('vendorCid');

  $replacement = '<div class="bmt_add_cart_button_wrapper">';

  $replacement .= wp_nonce_field('bmt_addcart', '_wpnonce', true, false);

  // This is for the 'Add to Cart' option
  if (isset($atts['button_image']) && !empty($atts['button_image'])) {
    //Use the custom button image specified in the shortcode
    $replacement .= '<input type="image" src="' . $atts['button_image'] . '" class="bmt_add_cart_button" alt="' . (__("Add to Cart", "wordpress-simple-paypal-shopping-cart")) . '"/>';
  } else if (isset($atts['button_text']) && !empty($atts['button_text'])) {
    //Use the custom button text specified in the shortcode
    $replacement .= '<input type="button" id="buybutton" class="bmt_add_cart_submit" onclick="bmt_addtocart(' . $product_id . ', \'' . $vendor_cid .'\', false);" name="bmt_add_cart_submit" value="' . apply_filters('bmt_add_cart_submit_button_value', $atts['button_text'], $product_id) . '" />';
  } else {
    //Use the button text or image value from the settings
    if (preg_match("/http:/", $addcart) || preg_match("/https:/", $addcart)) {
      //Use the image as the add to cart button
      $replacement .= '<input type="image" src="' . $addcart . '" class="bmt_add_cart_button" alt="' . (__("Add to Cart", "wordpress-simple-paypal-shopping-cart")) . '"/>';
    } else {
      //Use plain text add to cart button
      $replacement .= '<input type="button" id="buybutton" class="bmt_add_cart_submit" name="bmt_add_cart_submit" onclick="bmt_addtocart(' . $product_id . ', \'' . $vendor_cid .'\', false);" value="' . apply_filters('bmt_add_cart_submit_button_value', $addcart, $product_id) . '" />';
    }
  }

  $replacement .= '</div>';
  return $replacement;
}

function print_bmt_add_show_cart_button_for_product($product_id, $atts = array()) {
  $addcart = get_option('addToCartButtonName');
  if(!$addcart || ($addcart == '')) {
    $addcart = __("Add to Cart", "wordpress-simple-paypal-shopping-cart");
  }

  $vendor_cid = get_option('vendorCid');

  $replacement = '<div class="bmt_add_cart_button_wrapper">';

  $replacement .= wp_nonce_field('bmt_addcart', '_wpnonce', true, false);

  // This is for the 'Add to Cart' option
  if (isset($atts['button_image']) && !empty($atts['button_image'])) {
    //Use the custom button image specified in the shortcode
    $replacement .= '<input type="image" src="' . $atts['button_image'] . '" class="bmt_add_cart_button" alt="' . (__("Add to Cart", "wordpress-simple-paypal-shopping-cart")) . '"/>';
  } else if (isset($atts['button_text']) && !empty($atts['button_text'])) {
    //Use the custom button text specified in the shortcode
    $replacement .= '<input type="button" id="buybutton" class="bmt_add_show_cart_submit" onclick="bmt_addtocart(' . $product_id . ', \'' . $vendor_cid .'\', true);" name="bmt_add_show_cart_submit" value="' . apply_filters('bmt_add_cart_submit_button_value', $atts['button_text'], $product_id) . '" />';
  } else {
    //Use the button text or image value from the settings
    if (preg_match("/http:/", $addcart) || preg_match("/https:/", $addcart)) {
      //Use the image as the add to cart button
      $replacement .= '<input type="image" src="' . $addcart . '" class="bmt_add_cart_button" alt="' . (__("Add to Cart", "wordpress-simple-paypal-shopping-cart")) . '"/>';
    } else {
      //Use plain text add to cart button
      $replacement .= '<input type="button" id="buybutton" class="bmt_add_show_cart_submit" name="bmt_add_show_cart_submit" onclick="bmt_addtocart(' . $product_id . ', \'' . $vendor_cid .'\', true);" value="' . apply_filters('bmt_add_cart_submit_button_value', $addcart, $product_id) . '" />';
    }
  }

  $replacement .= '</div>';
  return $replacement;
}
