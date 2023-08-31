<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

namespace Events_Plugin;
use DateTime;
use WP_Query;

$args = array(
	'post_type'      => 'event',  // Change to your custom post type if needed
	'posts_per_page' => - 1, // Retrieve all posts
	'orderby'        => 'date',    // Order by date
	'order'          => 'DESC',      // Sort in descending order
);

$query = new WP_Query( $args );

// Initialize an array to store the years
$available_years = [];

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

if ( count( $available_years ) === 0 ) {
	return;
}

$checkedValues = isset( $_GET['date_query'] ) ? json_decode( urldecode( $_GET['date_query'] ), true ) : [];

?>
<ul <?php echo get_block_wrapper_attributes(); ?>>
	<?php foreach ( $available_years as $year => $months ) : ?>
		<li>
			<label>
				<input
					data-filter-type="year"
					type="checkbox"
					value="<?= $year ?>"
					<?php checked( isset( $checkedValues[ $year ] ) ) ?>
				/>
				<?= $year ?>
			</label>
			<ul>
				<?php foreach ( $months as $month ) : ?>
					<li>
						<label>
							<input
								data-filter-type="month"
								data-filter-year="<?= $year ?>"
								value="<?= $month ?>"
								type="checkbox"
								<?php checked( isset( $checkedValues[ $year ] ) && in_array( $month, $checkedValues[ $year ] ) ) ?>
							/>
							<?= DateTime::createFromFormat( '!m', $month )->format( 'F' ) ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>
