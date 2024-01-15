<?php
// Get dynamic attachment data.
$caption = wp_get_attachment_caption( $args['post_id'] );
$image   = wp_get_attachment_image_src( $args['post_id'], 'large' );
$alt     = trim( strip_tags( get_post_meta( $args['post_id'], '_wp_attachment_image_alt', true ) ) );
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:image {"align":"wide","id":<?php echo absint( $args['post_id'] ); ?>,"sizeSlug":"large","linkDestination":"none"} -->
	<figure class="wp-block-image alignwide size-large">
		<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />

		<?php if ( $caption ) : ?>
			<figcaption class="wp-element-caption"><?php echo $caption; ?></figcaption>
		<?php endif ?>
	</figure>
	<!-- /wp:image -->

</div>
<!-- /wp:group -->
