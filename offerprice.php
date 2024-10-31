<?php
/*
Plugin Name: Offer Price
Plugin URI: http://www.offerpricewidget.com/wordpress_plugin
Description: Sell any product or service? Collect price offers! To get started: 1) Activate plugin, 2) <a href="http://www.offerpricewidget.com/users/sign_up">Sign up and generate WordPress shortcode</a>, and 3) Paste the shortcode to your page or post.
Version: 1.0
Author: Sergey Kravchenko
Author URI: http://www.offerpricewidget.com
License: GNU GPL2
*/

class OfferPrice
{
	function shortcode($atts)
	{
		$a = shortcode_atts(array(
			'api_key' => '0',
			'item_name' => 'Your product name',
			'item_uid'=> '',
			'price' => 0,
			'currency' => 'USD',
			'curr_symbol_first' => true,
			'curr_symbol' => '$',
			'lang' => 'eng',
			), $atts );

		return '<a href="#" onclick="return ofp_click(\''.$a['api_key'].'\', \''.
			$a['item_name'].'\', \''.$a['item_uid'].'\', '.$a['price'].', \''.
			$a['currency'].'\', '.$a['curr_symbol_first'].', \''.$a['curr_symbol'].
			'\', \''.$a['lang'].'\', \'wordpress\');">Offer fair price</a>';
	}

	function conditionally_add_scripts_and_styles($posts){
		if (empty($posts)) return $posts;
	 
		$shortcode_found = false; 
		foreach ($posts as $post) {
			if (stripos($post->post_content, '[offerprice') === false) {
				$shortcode_found = false;
			}
			else
			{
				$shortcode_found = true;
				break;
			}
		}
	 
		if ($shortcode_found) {
			//wp_enqueue_script('offerprice-script', 'http://localhost:3000/assets/widget.js');
			wp_enqueue_script('offerprice-script', 'http://www.offerpricewidget.com/assets/widget.js');
		}
	 
		return $posts;
	}	
}

add_shortcode('offerprice', array('OfferPrice', 'shortcode'));
add_filter('the_posts', array('OfferPrice', 'conditionally_add_scripts_and_styles')); 
?>