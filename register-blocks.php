<?php

namespace Events_Plugin;
use DateTime;
use WP_Query;

function create_block_events_block_init(): void {
	register_block_type( __DIR__ . '/build/loop' );
	register_block_type( __DIR__ . '/build/date-filter', [
		'render_callback' => 'Events_Plugin\render_date_filter_block'
	] );
}
add_action( 'init', 'Events_Plugin\create_block_events_block_init' );


function render_date_filter_block(): string {
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
