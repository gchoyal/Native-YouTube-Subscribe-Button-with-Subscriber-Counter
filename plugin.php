<?php 
/**
Plugin Name: Native YouTube Subscribe Button with Subscriber Counter
Plugin URI: https://wordpress.org/plugins/choyal-subscription-popup/
Description: Native YouTube Subscribe Button with Subscriber Counter plugin provide shortcode to place YouTube native style subscribe button in website with autoupdate subscriber counter inside button And AutoSubscribe to channel directly from your website. Use Shortcode [nysb-youtube-btn id="UCrdpnS5Uz2MijaX9-5vJR4g"] (Replace my channel id to your channel ID) to show Youtube Subscribe button.
Author: Girdhari choyal
Version: 1.0
Author URI: https://www.ninjatechnician.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function nysb_shortcode_youtube_subscribe_btn( $attr ){
	
	$nysbId = sanitize_text_field( $attr['id'] );
	
	if( isset( $nysbId ) && $nysbId!='' ){
	
		$subscriberData = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=statistics&id=". $nysbId ."&key=AIzaSyCLCC30vgv3jTDQ1OQ637aKLRuTnWNBmp4" );
		$data = json_decode($subscriberData, true);
		$stats_data = $data['items'][0]['statistics']['subscriberCount'];
		$html = '<a class="nysb-youtube-subscribe-button" style="visibility: visible; background-color: rgb(255, 0, 2);border-radius: 5px;padding: 10px 25px;margin: 10px 0;display: inline-block;color: white;font-weight: bold;" target="_blank" href="https://www.youtube.com/channel/'. $nysbId .'?sub_confirmation=1" ><span>SUBSCRIBE <span class="youtube-sub-count">'. nysb_number_format_short($stats_data) .'</span></span></a>';
		return $html;
		
	}else{
	
		$html = '<p>Please enter YouTube channel ID(Found in YouTube channel URL) in Youtube Subscribe Button Shortcode.</p>';
		
	}
	
}
add_shortcode('nysb-youtube-btn', 'nysb_shortcode_youtube_subscribe_btn');

function nysb_number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }

    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
	
}