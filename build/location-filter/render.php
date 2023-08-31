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
		value=""
		<?php selected( '', isset( $_GET['location'] ) ? $_GET['location'] : '' ) ?>
	>
		<?= __( 'Any', 'events' ) ?>
	</option>

	<?php foreach ( $locations as $location ) : ?>
		<option
			data-term-id="<?= $location->term_id ?>"
			value="<?= $location->slug ?>"
			<?php selected( $location->slug, isset( $_GET['location'] ) ? $_GET['location'] : '' ) ?>
		>
			<?= $location->name ?>
		</option>
	<?php endforeach; ?>
</select>
