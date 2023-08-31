<?php
/**
 * Plugin Name:       Events
 * Description:       Adds events post_type and events block.
 * Requires at least: 6.1
 * Requires PHP:      8.1
 * Version:           0.1.0
 * Author:            Alex Kozack
 * License:           MIT
 * Text Domain:       events
 */

namespace Events_Plugin;

use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once dirname( __FILE__ ) . '/register-event-type.php';
require_once dirname( __FILE__ ) . '/register-blocks.php';
require_once dirname( __FILE__ ) . '/patch-query.php';
