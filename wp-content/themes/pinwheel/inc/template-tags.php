<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pinwheel
 */



/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */

if ( ! function_exists( 'pinwheel_categorized_blog' ) ) :
function pinwheel_categorized_blog() {
	$all_the_cool_cats = get_transient( 'pinwheel_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pinwheel_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 || is_preview() ) {
		// This blog has more than 1 category so pinwheel_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pinwheel_categorized_blog should return false.
		return false;
	}
}

endif;

/**
 * Flush out the transients used in pinwheel_categorized_blog.
 */

if ( ! function_exists( 'pinwheel_category_transient_flusher' ) ) :
function pinwheel_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pinwheel_categories' );
}

endif;
add_action( 'edit_category', 'pinwheel_category_transient_flusher' );
add_action( 'save_post',     'pinwheel_category_transient_flusher' );
