<?php
// Get dynamic attachment data.
$caption = wp_get_attachment_caption( $args['post_id'] );
$src     = wp_get_attachment_url( $args['post_id'] );
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:video {"align":"wide"} -->
	<figure class="wp-block-video alignwide">
		<video controls muted src="<?php echo esc_url( $src ); ?>"></video>

		<?php if ( $caption ) : ?>
			<figcaption class="wp-element-caption"><?php echo $caption; ?></figcaption>
		<?php endif ?>
	</figure>
	<!-- /wp:video -->

</div>
<!-- /wp:group -->
