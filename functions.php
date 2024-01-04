<?php
/**
 * Theme functions file, which is auto-loaded by WordPress. Use this file to
 * load additional PHP files and bootstrap the theme.
 *
 * @author    Your Name <youremail@domain.tld>
 * @copyright Copyright (c) 2023, Your Name
 * @link      https://yourwebsite.tld
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// This is not needed if your theme has a `templates/attachment.html` file.
// WordPress will automatically remove it.
remove_filter( 'the_content', 'prepend_attachment' );

// Filter render block.
add_filter( 'render_block', 'themeslug_render_block', 10, 3 );

/**
 * Filters the post content block when viewing single attachment views
 * and returns block-based media content.
 *
 * @since 1.0.0
 */
function themeslug_render_block( $block_content, $block, $instance ) {

	// Bail early if not `core/post-content` block or there's no post ID.
	if ( 'core/post-content' !== $block['blockName'] || empty( $instance->context['postId'] ) ) {
		return $block_content;
	}

	// Get the post object.
	$post = get_post( $instance->context['postId'] );

	// Bail if we don't have a post object or are not specifically viewing
	// the attachment page for this specific post.
	if ( ! $post instanceof WP_Post || ! is_attachment( $post->ID ) ) {
		return $block_content;
	}

	// Set up some default variables.
	$partials = [];
	$html     = '';

	// Checks if the attachment is one of supported types and sets
	// the filename based on that type.
	foreach ( [ 'image', 'video', 'audio'] as $type ) {
		if ( wp_attachment_is( $type, $post ) ) {
			$partials[] = "partials/attachment-media-{$type}.php";
			break;
		}
	}

	// Add fallback partial template.
	$partials[] = 'partials/attachment-media.php';

	// Gets a partial (essentially a dynamic pattern) based on the
	// attachment type. Must be valid block content.
	ob_start();
	locate_template( $partials, true, false );
	$media = ob_get_clean();

	// Parse and render the blocks.
	foreach ( parse_blocks( $media ) as $media_block ) {
		$html .= render_block( $media_block );
	}

	return $html . $block_content;
}
