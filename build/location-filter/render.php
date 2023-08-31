<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

namespace Events_Plugin;

$locations = get_terms( [
	'taxonomy'   => 'location',
	'hide_empty' => true,
] )
?>
<select aria-label="<?= __( 'Filter events by location', 'events' ) ?>" <?php echo get_block_wrapper_attributes(); ?>>
	<option
		disabled
		value=""
		<?php selected( '', isset( $_GET['location'] ) ? $_GET['location'] : '' ) ?>
	>
		<?= __( 'Filter events by location', 'events' ) ?>
	</option>

	<?php foreach ( $locations as $location ) : ?>
		<option
			value="<?= $location->slug ?>"
			<?php selected( $location->slug, isset( $_GET['location'] ) ? $_GET['location'] : '' ) ?>
		>
			<?= $location->name ?>
		</option>
	<?php endforeach; ?>
</select>
