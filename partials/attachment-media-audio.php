<?php
// Get dynamic attachment data.
$caption = wp_get_attachment_caption( $args['post_id'] );
$src     = wp_get_attachment_url( $args['post_id'] );
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:audio {"id":<?php echo absint( $args['post_id'] ); ?>} -->
	<figure class="wp-block-audio">
		<audio controls src="<?php echo esc_url( $src ); ?>"></audio>

		<?php if ( $caption ) : ?>
			<figcaption class="wp-element-caption"><?php echo $caption; ?></figcaption>
		<?php endif ?>
	</figure>
	<!-- /wp:audio -->

</div>
<!-- /wp:group -->
