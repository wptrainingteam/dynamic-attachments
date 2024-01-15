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

// Enable attachment pages for testing purposes with new installs.
// Important! This should not be shipped with the theme.
add_filter( 'pre_option_wp_attachment_pages_enabled', '__return_true' );

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

	// Bail early if there's no post ID or not specifically viewing
	// the attachment page for this specific post.
	if (
		'core/post-content' !== $block['blockName']
		|| empty( $instance->context['postId'] )
		|| ! is_attachment( $instance->context['postId'] )
	) {
		return $block_content;
	}

	// Set up some default variables.
	$partials = [];
	$html     = '';

	// Checks if the attachment is one of supported types. If it is, add it
	// to the array of potential partial templates.
	foreach ( [ 'image', 'video', 'audio' ] as $type ) {
		if ( wp_attachment_is( $type, $instance->context['postId'] ) ) {
			$partials[] = "partials/attachment-media-{$type}.php";
			break;
		}
	}

	// Add fallback partial template.
	$partials[] = 'partials/attachment-media.php';

	// Enable output buffering to capture the output of the partial template.
	ob_start();

	// Find the attachment partial template and pass the post ID along as
	// an argument.
	locate_template( $partials, true, false, [
		'post_id' => $instance->context['postId']
	] );

	// Get the content of the buffer and disable it.
	$block_markup = ob_get_clean();

	// If there's no block markup, return the original block content.
	if ( ! $block_markup ) {
		return $block_content;
	}

	// Parse the block markup. Then, loop through the array of parsed blocks
	// and render them.
	foreach ( parse_blocks( $block_markup ) as $parsed_block ) {
		$html .= render_block( $parsed_block );
	}

	// Return the new html, prepending the original content.
	return $html . $block_content;
}
