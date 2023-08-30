<?php
/**
 * Plugin Name:       Events
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       events
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_events_block_init() {
	register_block_type( __DIR__ . '/build/loop' );
	register_block_type( __DIR__ . '/build/date-filter', [
		'render_callback' => 'render_date_filter_block'
	] );
}

function render_date_filter_block() {
	$args = array(
		'post_type'      => 'event',  // Change to your custom post type if needed
		'posts_per_page' => - 1, // Retrieve all posts
		'orderby'        => 'date',    // Order by date
		'order'          => 'DESC',      // Sort in descending order
	);


	$query = new WP_Query( $args );

// Initialize an array to store the years
	$available_years = [];

// Loop through the posts and extract the years
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_year  = get_the_date( 'Y' );
			$post_month = get_the_date( 'n' );

			if ( empty( $available_years[ $post_year ] ) ) {
				$available_years[ $post_year ] = [];
			}

			if ( ! in_array( $post_month, $available_years[ $post_year ] ) ) {
				$available_years[ $post_year ][] = $post_month;
			}
		}
		wp_reset_postdata(); // Reset the post data
	}


	$checkedValues = isset( $_GET['date_query'] ) ? json_decode( urldecode( $_GET['date_query'] ), true ) : [];
	$output        = '';

	foreach ( $available_years as $year => $months ) {

		$months_html = array_reduce( $months, function ( string $str, string $m ) use ( $checkedValues, $year ) {
			$is_checked = isset( $checkedValues[ $year ] ) && in_array( $m, $checkedValues[ $year ] );

			return $str . sprintf( '<li><label><input data-filter-type="month" data-filter-year="%2$s" value="%3$s" type="checkbox" %4$s />%1$s</label></li>', DateTime::createFromFormat( '!m', $m )->format( 'F' ), $year, $m, $is_checked ? 'checked' : '' );
		}, '' );


		$is_checked = isset( $checkedValues[ $year ] );
		$output     .= sprintf( '<li><label><input data-filter-type="year" type="checkbox" value="%1$s" %2$s />%1$s</label><ul>%3$s</ul></li>', $year, $is_checked ? 'checked' : '', $months_html );
	}

	$wrapper_attributes = get_block_wrapper_attributes();

	return sprintf( '<ul %1$s>%2$s</ul>', $wrapper_attributes, $output );
}

add_action( 'init', 'create_block_events_block_init' );


function register_events_post_type() {

	$labels = array(
		'name'                  => _x( 'Events', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Event', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Events', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Event', 'textdomain' ),
		'new_item'              => __( 'New Event', 'textdomain' ),
		'edit_item'             => __( 'Edit Event', 'textdomain' ),
		'view_item'             => __( 'View Event', 'textdomain' ),
		'all_items'             => __( 'All Events', 'textdomain' ),
		'search_items'          => __( 'Search Events', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Events:', 'textdomain' ),
		'not_found'             => __( 'No Events found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No Events found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into Event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);


	register_post_type( 'event', [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' ),
		'show_in_rest'       => true,
	] );
}

add_action( 'init', 'register_events_post_type' );


function show_future_events_publicly( WP_Query $query ): void {
	if ( ! is_admin() && $query->get( 'post_type' ) === 'event' && empty( $query->get( 'post_status' ) ) ) {
		$query->set( 'post_status', [ 'publish', 'future' ] );
	}
}

add_action( 'pre_get_posts', 'show_future_events_publicly' );


function filter_events_by_date( array $query ) {
	if ( ! is_admin() && $query['post_type'] === 'event' && isset( $_GET['date_query'] ) ) {

		$checkedValues = json_decode( urldecode( $_GET['date_query'] ), true );
		$date_query    = [ 'relation' => 'OR' ];

		foreach ( $checkedValues as $year => $months ) {
			foreach ( $months as $month ) {
				$date_query[] = [
					'year'  => intval( $year ),
					'month' => intval( $month ),
				];
			}
		}

		$query['date_query'] = $date_query;
	}

	return $query;
}

add_action( 'query_loop_block_query_vars', 'filter_events_by_date', 10, 3 );
