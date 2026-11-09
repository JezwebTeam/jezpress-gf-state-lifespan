<?php
/**
 * Plugin Name: JezPress GF State Lifespan
 * Description: Stops real enquiries from cached pages being filed as spam. Gravity Forms 3.1.1+ rejects a form whose hidden state is older than 2 days; pages here can be served from cache for up to 30 days. Raises the limit to 32 days.
 * Version:     1.0.0
 * Author:      JezPress
 * Author URI:  https://jezpress.com/
 * License:     GPL-2.0-or-later
 * Text Domain: jezpress-gf-state-lifespan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 32 days outlives Rocket's 30-day edge cache. The honeypot field and Turnstile still apply.
// GF requires an int here (is_stale falls back to 2 days otherwise).

// Existing sites already have the same fix as an mu-plugin. mu-plugins load before regular
// plugins, so if it's there, do nothing and let it handle the filter.
if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/jezweb-gf-state-lifespan.php' ) ) {
	return;
}

if ( ! function_exists( 'jezpress_gf_state_lifespan' ) ) {
	/**
	 * Form state lifespan for Gravity Forms, in seconds.
	 *
	 * @return int
	 */
	function jezpress_gf_state_lifespan() {
		return 32 * DAY_IN_SECONDS;
	}
}

add_filter( 'gform_state_lifespan', 'jezpress_gf_state_lifespan' );
