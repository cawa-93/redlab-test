<?php

namespace Events_Plugin;


function register_location_taxonomy(): void {

	$labels = array(
		'name'                  => __( 'Locations', 'events' ),
		'singular_name'         => __( 'Location', 'events' ),
		'menu_name'             => __( 'Locations', 'events' ),
		'name_admin_bar'        => __( 'Location', 'events' ),
		'add_new'               => __( 'Add New', 'events' ),
		'add_new_item'          => __( 'Add New Location', 'events' ),
		'new_item'              => __( 'New Location', 'events' ),
		'edit_item'             => __( 'Edit Location', 'events' ),
		'view_item'             => __( 'View Location', 'events' ),
		'all_items'             => __( 'All Locations', 'events' ),
		'search_items'          => __( 'Search Locations', 'events' ),
		'parent_item_colon'     => __( 'Parent Locations:', 'events' ),
		'not_found'             => __( 'No Locations found.', 'events' ),
		'not_found_in_trash'    => __( 'No Locations found in Trash.', 'events' ),
		'featured_image'        => __( 'Location Cover Image', 'events' ),
		'set_featured_image'    => __( 'Set cover image', 'events' ),
		'remove_featured_image' => __( 'Remove cover image', 'events' ),
		'use_featured_image'    => __( 'Use as cover image', 'events' ),
		'archives'              => __( 'Location archives', 'events' ),
		'insert_into_item'      => __( /** @lang text */ 'Insert into Location', 'events' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Location', 'events' ),
		'filter_items_list'     => __( 'Filter Locations list', 'events' ),
		'items_list_navigation' => __( 'Locations list navigation', 'events' ),
		'items_list'            => __( 'Locations list', 'events' ),
	);


	register_taxonomy( 'location', 'event', [
		'labels'       => $labels,
		'public'       => true,
		'show_in_rest'       => true,
		'default_term' => [
			'name' => 'Remote',
			'slug' => 'remote',
		]
	] );
}

add_action( 'init', 'Events_Plugin\register_location_taxonomy', 9 );

function register_events_post_type(): void {

	$labels = array(
		'name'                  => __( 'Events', 'events' ),
		'singular_name'         => __( 'Event', 'events' ),
		'menu_name'             => __( 'Events', 'events' ),
		'name_admin_bar'        => __( 'Event', 'events' ),
		'add_new'               => __( 'Add New', 'events' ),
		'add_new_item'          => __( 'Add New Event', 'events' ),
		'new_item'              => __( 'New Event', 'events' ),
		'edit_item'             => __( 'Edit Event', 'events' ),
		'view_item'             => __( 'View Event', 'events' ),
		'all_items'             => __( 'All Events', 'events' ),
		'search_items'          => __( 'Search Events', 'events' ),
		'parent_item_colon'     => __( 'Parent Events:', 'events' ),
		'not_found'             => __( 'No Events found.', 'events' ),
		'not_found_in_trash'    => __( 'No Events found in Trash.', 'events' ),
		'featured_image'        => __( 'Event Cover Image', 'events' ),
		'set_featured_image'    => __( 'Set cover image', 'events' ),
		'remove_featured_image' => __( 'Remove cover image', 'events' ),
		'use_featured_image'    => __( 'Use as cover image', 'events' ),
		'archives'              => __( 'Event archives', 'events' ),
		'insert_into_item'      => __( /** @lang text */ 'Insert into Event', 'events' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Event', 'events' ),
		'filter_items_list'     => __( 'Filter Events list', 'events' ),
		'items_list_navigation' => __( 'Events list navigation', 'events' ),
		'items_list'            => __( 'Events list', 'events' ),
	);


	register_post_type( 'event', [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' ),
		'show_in_rest'       => true,
		'taxonomies'         => [ 'location' ]
	] );
}

add_action( 'init', 'Events_Plugin\register_events_post_type' );
