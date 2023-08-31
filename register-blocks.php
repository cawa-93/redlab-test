<?php

namespace Events_Plugin;

function create_block_events_block_init(): void {
	register_block_type( __DIR__ . '/build/loop' );
	register_block_type( __DIR__ . '/build/date-filter' );
	register_block_type( __DIR__ . '/build/location-filter' );
}

add_action( 'init', 'Events_Plugin\create_block_events_block_init' );
