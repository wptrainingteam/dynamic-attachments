<?php
// Get dynamic attachment data.
$url = wp_get_attachment_url( get_the_ID() );
?>
<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:file {"id":<?php echo absint( get_the_ID() ); ?>,"href":"<?php echo esc_url( $url ); ?>"} -->
	<div class="wp-block-file">
		<a href="<?php echo esc_url( $url ); ?>"><?php the_title(); ?></a>
		<a href="<?php echo esc_url( $url ) ?>" class="wp-block-file__button wp-element-button" download><?php esc_html_e( 'Download', 'x3p0-ideas' ); ?></a>
	</div>
	<!-- /wp:file -->

</div>
<!-- /wp:group -->
