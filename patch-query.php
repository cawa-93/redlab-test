<?php

namespace Events_Plugin;


use WP_Query;

//function show_future_events_publicly( WP_Query $query ): void {
//	if ( ! is_admin() && $query->get( 'post_type' ) === 'event' && empty( $query->get( 'post_status' ) ) ) {
//		$query->set( 'post_status', [ 'publish', 'future' ] );
//	}
//}
//
//add_action( 'pre_get_posts', 'Events_Plugin\show_future_events_publicly' );


function filter_events_by_date( array $query ): array {
	if ( ! is_admin() && $query['post_type'] === 'event' && isset( $_GET['date_query'] ) ) {

		$checkedValues = json_decode( urldecode( $_GET['date_query'] ), true );
		$date_query    = [ 'relation' => 'OR' ];

		foreach ( $checkedValues as $year => $months ) {
			$date_query[] = [
				'year'  => $year,
				'month' => $months,
				'compare' => 'IN',
			];
		}

		$query['date_query'] = $date_query;
	}

	return $query;
}

add_action( 'query_loop_block_query_vars', 'Events_Plugin\filter_events_by_date');
function filter_events_by_location( array $query ): array {
	if ( ! is_admin() && $query['post_type'] === 'event' && isset( $_GET['location'] ) ) {
		$query['location'] = $_GET['location'];
	}

	return $query;
}

add_action( 'query_loop_block_query_vars', 'Events_Plugin\filter_events_by_location');
