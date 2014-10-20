<?php
/**
 * Plugin Name: Door4 Admin Scheme
 * Plugin URI: http://door4.com
 * Description: WordPress colour scheme in Door4 Lime. Based on code by the WordPress Core Team.
 * Version: 1.0
 * Author: Dan Beckett
 * Author URI: http://github.com/danbeckett
 * Text Domain: door4_admin_scheme
 * License: GPL2
 */

class door4_admin_scheme {

	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_default_css' ) );
		add_action( 'admin_init', array( $this, 'add_colours' ) );

	}

	function add_colours() {
		$suffix = is_rtl() ? '-rtl' : '';
		wp_admin_css_color(
			'door4', __( 'Door4', 'door4_admin_scheme' ),
			plugins_url( 'style'.$suffix.'.css', __FILE__ ),
			array( '#B6D436', '#a1be29', '#56636C', '#000000' ), 
			array( 'base' => '#f1f2f3', 'focus' => '#fff', 'current' => '#fff' )
		);
	}

	/**
	 * Make sure core's default `colors.css` gets enqueued, since we can't
	 * @import it from a plugin stylesheet. Also force-load the default colors 
	 * on the profile screens, so the JS preview isn't broken-looking.
	 */ 

	function load_default_css() {

		global $wp_styles;

		$colour_scheme = get_user_option( 'admin_color' );

		$scheme_screens = apply_filters( 'acs_picker_allowed_pages', array( 'profile', 'profile-network' ) );
		if( 'door4' === $colour_scheme || in_array(get_current_screen()->base, $scheme_screens) ) {
			$wp_styles->registered['colors']->deps[] = 'colors-fresh';
		}
	}
}

global $door4_admin_scheme;
$door4_admin_scheme = new door4_admin_scheme; ?>